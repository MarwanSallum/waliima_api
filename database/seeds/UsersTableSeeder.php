<?php

use App\Models\User;
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
        $user = User::create([
            'name' => 'Marwan Salloum',
            'email' => 'masalloum2091@gmail.com',
            'password' => bcrypt('mero1064'),
            'mobile' => '0544075175',
        ]);

        $user -> attachRole('super_admin');
    }
}
