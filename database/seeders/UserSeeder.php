<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => " pharmacies",
            'username' => " pharmacies",
            'email' => "pharmacies@admin.com",
            'password' => Hash::make('pharmacies'),
            'role'=>"admin",
            'Status'=>'مفعل',
            'com_code'=>11,
            'added_by'=>0,
        ]);
        $user->assignRole('admin');
    }
    }

