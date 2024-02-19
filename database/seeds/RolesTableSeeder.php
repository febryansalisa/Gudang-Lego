<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //membuat role
        Role::create(['name'=>'SUPERADMIN', 'guard_name'=>'web', 'is_holding'=>0, 'is_admincomp'=>0]);
        Role::create(['name'=>'READER', 'guard_name'=>'web', 'is_holding'=>0, 'is_admincomp'=>0]);
        Role::create(['name'=>'ADMIN', 'guard_name'=>'web', 'is_holding'=>0, 'is_admincomp'=>0]);       
        Role::create(['name'=>'Staff Gudang', 'guard_name'=>'web', 'is_holding'=>0, 'is_admincomp'=>0]);

        $this->command->info("Role Seeder Success !");
    }
}
