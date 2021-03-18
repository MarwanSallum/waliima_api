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
            'mobile' => '0544075175',
        ]);

        $user -> attachRole('super_admin');
    }
}
