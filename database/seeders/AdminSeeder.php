<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tokosaya.id'],   // dicari berdasarkan ini
            [
                'name'     => 'Rizki Suputra',
                'password' => Hash::make('123456'),
                'role'     => 'admin',
            ]
        );
    }
}
