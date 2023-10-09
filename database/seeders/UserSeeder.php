<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::truncate(); 
           $users = [ 
            [ 
              'name' => 'Admin',
              'email' => 'admin@triplefast.com',
              'password' => 'admin@123',
              'user_type' => 'admin',
            ]
          ];

          foreach($users as $user)
          {
            \App\Models\User::create([
               'name' => $user['name'],
               'email' => $user['email'],
               'user_type' => 'admin',
               'password' => Hash::make($user['password'])
             ]);
           }
    }
}
