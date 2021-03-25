<?php

use App\Models\Admin;
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
        $admin = Admin::create([
            'name' => 'Marwan Salloum',
            'email' => 'masalloum2091@gmail.com',
            'mobile' => '0544075175',
            'password' => bcrypt('mero1064'),
        ]);

        $admin -> attachRole('super_admin');
    }
}
