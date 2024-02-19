<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = [
            ['username' => 'admin','first_name'=> 'joko' ,'last_name'=>'sumsal', 'email' => 'admin@company.com', 'password' => Hash::make('admin')],
            ['username' => 'admin2','first_name'=> 'joni' ,'last_name'=>'sumsel', 'email' => 'admin2@company.com', 'password' => Hash::make('admin2')],
            ['username' => 'developer','first_name'=> 'jombie' ,'last_name'=>'kaltim', 'email' => 'developer@company.com', 'password' => Hash::make('developer')],
            ['username' => 'view', 'first_name'=> 'samsul' ,'last_name'=>'joyoboyo','email' => 'view@company.com', 'password' => Hash::make('view')],
            ['username' => '2145616','first_name'=> 'Sofian' ,'last_name'=>'Arifianto','email' => '2145616@company.com', 'password' => Hash::make('drone2023')],
            ['username' => '2166542','first_name'=> 'Yazid ' ,'last_name'=>'Mahfudzi', 'email' => '2166542@company.com', 'password' => Hash::make('drone2023')],
         

        ];

        User::insert($users);
        $this->command->info('User Seeders SuccessFullt');

    }
}
