<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'              => 'Usuario de Prueba',
            'email'             => 'tests@admin.com',
            'email_verified_at' => now(),
            'password'          => 'password', // password
        ])->assignRoles('root');
    }
}
