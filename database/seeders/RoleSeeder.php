<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['id'=>'1','name' => 'isAdmin']);
        $role = Role::create(['id'=>'2','name' => 'isTranslater']);
        $role = Role::create(['id'=>'3','name' => 'isEmailVerified']);
        $role = Role::create(['id'=>'4','name' => 'isVerified']);
    }
}
