<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'remember_token' => null,
            ],
            [
                'id'             => 2,
                'name'           => 'Analyst',
                'email'          => 'analyst@analyst.com',
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'remember_token' => null,
            ],
            [
                'id'             => 3,
                'name'           => 'CFO',
                'email'          => 'cfo@cfo.com',
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
