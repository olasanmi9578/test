<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name'          => 'Root',
            'slug'          => 'root',
            'description'   => 'Super Administrador',
            'special'       => 'all-access',
        ]);

        Role::create([
            'name'          => 'Restringido',
            'slug'          => 'restringido',
            'description'   => 'Usuario con acceso restringido',
            'special'       => 'no-access',
        ]);
    }
}
