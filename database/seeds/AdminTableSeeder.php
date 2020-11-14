<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
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
            'password' => bcrypt('mero1064'),
            'mobile' => '0544075175',
        ]);

        $admin -> attachRole('super_admin');
    }
}
