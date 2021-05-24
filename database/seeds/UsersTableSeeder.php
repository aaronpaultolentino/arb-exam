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
    		'name' => 'Admin User',
    		'email' => 'admin@arb.com',
            'role_id' => 1,
    		'password' => bcrypt('123123123'),
    	]);
        
        User::create([
            'name' => 'Normal User',
            'email' => 'user@arb.com',
            'role_id' => 2,
            'password' => bcrypt('123123123'),
        ]);
    }
}
