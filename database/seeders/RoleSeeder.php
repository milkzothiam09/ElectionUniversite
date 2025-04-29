<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
                // Rôles pour le garde `api'
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
        Role::firstOrCreate(['name' => 'per', 'guard_name' => 'api']);
        Role::firstOrCreate(['name' => 'pats', 'guard_name' => 'api']);


                // Rôles pour le garde `web`
        Role::firstOrcreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrcreate(['name' => 'per', 'guard_name' => 'web']);
        Role::firstOrcreate(['name' => 'pats', 'guard_name' => 'web']);
        
    }

   
}