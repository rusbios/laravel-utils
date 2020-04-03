<?php

namespace RusBios\LUtils\Controllers;

use Illuminate\Http\Request;
use RusBios\LUtils\Models\User;
use RusBios\LUtils\Services\Table;

class UserAdminController extends BaseAdminController
{
    const URI = 'user';
    const ENTITY_NAME = User::class;
    const MENU_NAME = 'Пользователи';
    const MENU_DESCRIPTION = 'Менеджер статей';
    const MENU_ORDER = 3;

    public function index(Request $request)
    {
        return $this->getTable($request, [
            'name' => 'Имя',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'role' => 'Роль',
            'created_at' => 'Дата регистрации',
        ], [
            'phone' => function (string $keyName, array $row) {
                if (!$row['phone']) return '';
                $user = User::find($row[$keyName]);
                return $user->phone . ($user->phone_verified_at ? ' <i class="fas fa-check text-success"></i>' : '');
            },
            'created_at' => function (string $keyName, array $row) {
                return Table::dateFormat(new \DateTime($row['created_at']));
            }
        ]);
    }
}
