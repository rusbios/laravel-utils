<?php

namespace RusBios\LUtils\Services;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use IntlDateFormatter;

class Table
{
    /** @var Request */
    protected $request;

    /** @var array[] */
    protected $headers;

    /** @var array[] */
    protected $rows;

    /** @var int|null */
    protected $allRow;

    /** @var int */
    protected $offset;

    /** @var int */
    protected $limit;

    /** @var Model */
    protected $builder;

    /** @var array */
    protected $buttons = [];

    /**
     * Table constructor.
     * @param Request $request
     * @param int $limit
     * @param int $offset
     * @param string $defaultDirection
     */
    public function __construct(Request $request, int $limit = 50)
    {
        $this->request = $request;
        $this->limit = $limit;
    }

    /**
     * @param Builder $builder
     * @param string[]|null $headers
     * @param array|null $mutation
     * @return Table
     */
    public function setBuilder(Builder $builder, array $headers = [], array $mutation = [])
    {
        $this->builder = clone $builder->getModel();

        if (!$headers && $builder->first()) {
            foreach ($builder->first()->attributesToArray() as $key => $value) {
                if ($this->builder->getKeyName() !== $key) $headers[$key] = $key;
            }
        }

        $this->setHeaders($this->builder->getKeyName(), $headers);

        foreach ($this->getOrders() as $key => $direction) {
            if ($direction) $builder->orderBy($key, $direction);
        }

        foreach ($this->request->get('search', []) as $key => $search) {
            if ($search) $builder->where($key, 'like', $search . '%');
        }

        $this->allRow = $builder->count();

        $builder->limit($this->request->get('limit', $this->limit))
            ->offset($this->request->get('offset', 0));

        $head = $headers ? array_merge(array_keys($headers), [$this->builder->getKeyName()]) : '*';
        foreach ($builder->get($head) as $item) {
            $row = $item->toArray();
            foreach ($mutation as $key => $mutate) {
                if (array_key_exists($key, $row)) $row[$key] = $mutate($this->builder->getKeyName(), $row);
            }
            unset($row[$this->builder->getKeyName()]);
            $this->addRow($item->getKey(), $row);
        }
        return $this;
    }

    /**
     * @param string $linkPattern
     * @param string|null $title
     * @param string|null $icon
     * @param string|null $color
     * @return Table
     */
    public function addButton($linkPattern, $title = null, $icon = null, $color = null)
    {
        $this->buttons[] = [
            'link_pattern' => $linkPattern,
            'title' => $title ?: 'Перейти',
            'icon' => $icon,
            'color' => $color ?: 'info',
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * @param string $primaryKey
     * @param string[] $headers
     * @return Table
     */
    public function setHeaders($primaryKey, array $headers)
    {
        $this->headers[] = [
            'key' => $primaryKey,
            'name' => '#',
        ];

        foreach ($headers as $key => $title) {
            $this->headers[] = [
                'key' => $key,
                'name' => $title ?: $key,
            ];
        }

        return $this;
    }

    /**
     * @return array[]
     */
    public function getHeaders()
    {
        $headers = [];
        $orders = $this->getOrders();
        $casts = $this->builder->getCasts();
        $search = $this->request->get('search', []);

        foreach ($this->headers as $header) {
            switch (Arr::get($casts, $header['key'])) {
                case 'int':
                    $header['from'] = 'number';
                    break;

                case 'datetime':
                    $header['from'] = 'datetime-local';
                    break;

                case 'date':
                    $header['from'] = 'date';
                    break;

                case 'bool':
                    $header['from'] = null;
                    break;

                default:
                    $header['from'] = 'text';
            }

            $header['order'] = Arr::get($orders, $header['key']);
            $header['search'] = Arr::get($search, $header['key']);
            $headers[] = $header;
        }

        return $headers;
    }

    /**
     * @return array
     */
    protected function getOrders()
    {
        $orders = [];
        foreach ($this->request->get('order', []) as $name => $direction) {
            $orders[$name] = $direction;
        }
        return $orders;
    }

    /**
     * @param mixed $key
     * @param array $row
     * @return Table
     */
    public function addRow($key, array $row)
    {
        $this->rows[$key] = $row;
        return $this;
    }

    /**
     * @return array[]
     */
    public function getRows()
    {
        return $this->rows ?: [];
    }

    /**
     * @return array
     */
    public function getPagination()
    {
        $lists = (int) ceil($this->getAllCount() / $this->limit);
        $list = $this->request->get('list', 1);
        if ($lists < 2) return [];

        $pagination = [
            'left' => $list > 1 ? $this->getUrl(['list' => ($list - 1)]) : null,
            'right' => $list < $lists ? $this->getUrl(['list' => ($list + 1)]) : null,
            'list' => $list,
        ];

        for ($n = max(1, $list - 2); $n <= min($lists, $list + 2); ++$n) {
            $pagination['lists'][$n] = $this->getUrl(['list' => $n]);
        }

        return $pagination;
    }

    /**
     * @param array $params
     * @return string
     */
    public function getUrl(array $params = [])
    {
        $params['order'] = array_merge($this->request->get('order', []), Arr::get($params, 'order', []));
        $params['search'] = array_merge($this->request->get('search', []), Arr::get($params, 'search', []));
        $params['list'] = Arr::exists($params, 'list') ? $params['list'] : null;

        return $this->request->url() . '?' . http_build_query($params);
    }

    /**
     * @return int|null
     */
    public function getAllCount()
    {
        return $this->allRow;
    }

    /**
     * @param DateTime $date
     * @param string|null $format
     * @return string
     */
    public static function dateFormat(DateTime $date, string $format = 'd MMMM YYYY в HH:mm'): string
    {
        $formatter = new IntlDateFormatter('ru_RU', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
        $formatter->setPattern($format);

        return $formatter->format($date);
    }
}
