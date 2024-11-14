<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Aldi',
                'email' => 'aldi@gmail.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Nanda',
                'email' => 'nanda@gmail.com',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($users as $user) {
            $user = User::create($user);
            $user->assignRole('presiden');
        }
    }
}
