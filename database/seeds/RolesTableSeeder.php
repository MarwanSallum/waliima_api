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
            'description' => 'Can do anything in system',
        ]);

        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'admin',
            'description' => 'Can do specific tasks',
        ]);

        $slaughterhouse = Role::create([
            'name' => 'slaughterhouse',
            'display_name' => 'slaughterhouse',
            'description' => 'Responsible for receiving and preparing the order',
        ]);

        $delivery_boy = Role::create([
            'name' => 'delivery_boy',
            'display_name' => 'delivery boy',
            'description' => 'Specialist in delivering the order to the application user',
        ]);

        $user = Role::create([
            'name' => 'user',
            'display_name' => 'user',
            'description' => 'Customer that using the app',
        ]);
    }
}
