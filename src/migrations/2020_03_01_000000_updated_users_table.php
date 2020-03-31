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

        if (env('ADMIN_EMAIL')) {
            $admin = User::firstOrCreate([
                'email' => env('ADMIN_EMAIL')
            ], [
                'name' => env('ADMIN_NAME', 'Admin'),
                'password' => Hash::make('admin'),
            ]);
            $admin->role = User::ROLE_ADMIN;
            if (env('ADMIN_PASSWORD')) $admin->password = Hash::make(env('ADMIN_PASSWORD'));
            $admin->save();
        }
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
