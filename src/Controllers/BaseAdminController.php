<?php

namespace RusBios\LUtils\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use RusBios\LUtils\Services\Head;
use RusBios\LUtils\Services\Menu;
use RusBios\LUtils\Services\Table;

abstract class BaseAdminController extends Controller
{
    const LIMIT = 100;

    /** @var array */
    const ROUTES = [
        [
            'match' => ['get'],
            'uri' => null,
            'method' => 'index',
        ],
        [
            'match' => ['get'],
            'uri' => '{id}',
            'method' => 'show',
        ],
        [
            'match' => ['post'],
            'uri' => 'search',
            'method' => 'showList',
        ],
        [
            'match' => ['post'],
            'uri' => null,
            'method' => 'store',
        ],
        [
            'match' => ['put'],
            'uri' => '{id}',
            'method' => 'update',
        ],
        [
            'match' => ['delete'],
            'uri' => '{id}',
            'method' => 'destroy',
        ],
        [
            'match' => ['get'],
            'uri' => 'edit/{id?}',
            'method' => 'showEdit',
        ]
    ];

    /** @var string */
    const URI = 'entity';

    /** @var string */
    const ENTITY_NAME = 'EntityModel';

    /** @var string */
    const MENU_NAME = '';

    /** @var string */
    const MENU_DESCRIPTION = '';

    /** @var null|int */
    const MENU_ORDER = null;

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        return $this->getTable($request);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id)
    {
        return response()->json([
            'entity' => $this->getModel($id),
            'get' => $request->all(),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function showList(Request $request)
    {
        $entity = $this->getModel();
        $builder = $entity::query();

        foreach ($request->get('filters', []) as $name => $value) {
            $builder->where($name, $value)->whereNotNull($name);
        }

        $builder->offset($request->get('offset', 0))
            ->limit($request->get('limit', static::LIMIT));

        return response()->json([
            'count' => $builder->count(),
            'items' => $builder->get()->all(),
            'offset' => $builder->offset,
            'limit' => $builder->limit,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $entity = $this->getModel();
        $entity->fill($request->all());
        $entity->save();

        return \request()->json($entity);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $entity = $this->getModel($id);
        $entity->fill($request->all());
        $entity->save();

        return \request()->json($entity);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $entity = $this->getModel($id);
        $entity->delete();

        return \request()->json($entity);
    }

    /**
     * @param int|null $id
     * @return Factory|View
     */
    public function showEdit(int $id = null)
    {
        return view(sprintf('rb_admin::%s.edit', static::URI), [
            'entity' => $this->getModel($id),
            'url_save' => route(sprintf('admin-%s-update', static::URI), $id),
            'title' => sprintf('Редактор %s', static::MENU_NAME),
        ]);
    }

    /**
     * @param Request $request
     * @param array|null $heater
     * @param array|null $mutation
     * @param array $buttons
     * @return Factory|View
     */
    protected function getTable(Request $request, array $heater = [], array $mutation = [], array $buttons = [])
    {
        Head::setTitle(sprintf('%s - %s', static::MENU_NAME, AdminController::MENU_NAME));
        Head::setDescription(static::MENU_DESCRIPTION);

        $table = (new Table($request))->setBuilder((static::ENTITY_NAME)::query(), $heater, $mutation);
        foreach ($buttons as $button) {
            if (Arr::exists($button, 'link_pattern')) {
                $table->addButton(
                    Arr::get($button, 'link_pattern'),
                    Arr::get($button, 'title'),
                    Arr::get($button, 'icon'),
                    Arr::get($button, 'color')
                );
            }
        }

        return view(sprintf('rb_admin::%s.index', static::URI), ['table' => $table]);
    }

    /**
     * @param int|null $id
     * @return Model
     */
    protected function getModel($id = null)
    {
        return (static::ENTITY_NAME)::findOrNew($id);
    }

    /**
     * base load routers
     */
    static function route()
    {
        app()->make(Menu::class)->add(
            sprintf('%s/%s', env('RB_BASE_URI_ADMIN', 'admin'), static::URI),
            static::MENU_NAME,
            static::MENU_DESCRIPTION,
            static::MENU_ORDER,
        );

        foreach (static::ROUTES as $route) {
            Route::match($route['match'], join('/', array_filter([
                env('RB_BASE_URI_ADMIN', 'admin'),
                static::URI,
                $route['uri'],
            ])), sprintf('%s@%s', static::class, $route['method']))
                //->middleware(['rb_admin'])
                ->name(join('-', [
                'admin',
                static::URI,
                $route['method']
            ]));
        }
    }
}
