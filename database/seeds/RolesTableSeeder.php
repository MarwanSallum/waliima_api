<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::create([
            'name' => 'super_admin',
            'display_name' => 'super admin',
            'description' => 'can do anything in system',
        ]);

        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'admin',
            'description' => 'can do specific tasks',
        ]);
    }
}
