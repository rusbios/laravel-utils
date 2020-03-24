<?php

namespace RusBios\LUtils\Controllers;

use RusBios\LUtils\Models\Article;

class ArticleAdminController extends BaseAdminController
{
    const URI = 'article';
    const ENTITY_NAME = Article::class;
}
