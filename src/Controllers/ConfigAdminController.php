<?php

namespace RusBios\LUtils\Controllers;

use RusBios\LUtils\Models\Config;

class ConfigAdminController extends BaseAdminController
{
    const URI = 'config';
    const ENTITY_NAME = Config::class;
}
