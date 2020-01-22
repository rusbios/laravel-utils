<?php

return [
    'title' => config('app.name'),
    'description' => null,
    'keywords' => null,
    'image' => null,
    'url' => config('add.url'),
    'type' => \RusBios\LUtils\Head::DEFAULT_TYPE,
    'robots' => \RusBios\LUtils\Head::ROBOTS_NOINDEX,
];
