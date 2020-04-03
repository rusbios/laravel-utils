<?php

namespace RusBios\LUtils\Controllers;

use Illuminate\Http\Request;
use RusBios\LUtils\Models\Article;

class ArticleAdminController extends BaseAdminController
{
    const URI = 'article';
    const ENTITY_NAME = Article::class;
    const MENU_NAME = 'Статьи';
    const MENU_DESCRIPTION = 'Менеджер статей';
    const MENU_ORDER = 4;

    public function index(Request $request)
    {
        return $this->getTable($request, [
            'title' => 'Заголовок',
            'description' => 'Описание',
            'disabled' => 'Активность',
            'uri' => 'URI',
            'created_at' => 'Дата создания',
        ]);
    }
}
