<?php

namespace RusBios\LUtils\Controllers;

use RusBios\LUtils\Models\User;

class UserAdminController extends BaseAdminController
{
    const URI = 'user';
    const ENTITY_NAME = User::class;
}
