<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use RusBios\LUtils\Models\User;

class UpdatedUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('phone')->unique()->nullable();
            $table->dateTime('phone_verified_at')->nullable();
            $table->enum('role', User::ROLES)->default(User::ROLE_DEFAULT);
            $table->softDeletes();
        });

        $admin = User::firstOrCreate([
            'email' => env('ADMIN_EMAIL', 'info@rusbios.ru')
        ]);
        if (!$admin->name) $admin->name = 'Admin';
        if (env('ADMIN_PASSWORD')) $admin->password = Hash::make(env('ADMIN_PASSWORD'));
        if (!$admin->password) throw new Exception('empty admin password');
        $admin->role = User::ROLE_ADMIN;
        $admin->save();
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'phone_verified_at',
                'role',
            ]);
            $table->dropSoftDeletes();
        });
    }
}
