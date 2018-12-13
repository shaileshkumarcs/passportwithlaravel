<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
        	'v_first_name' => 'Super',
        	'v_first_name' => 'Admin',
        	'v_admin' => 'superadmin@gmail.com',
        	'v_phone' => '9939744337',
        	'login_id' => 1
        ]);

        DB::table('logins')->insert([
        	'v_admin' => 'superadmin@gmail.com',
        	'v_phone' => '9939744337',
        	'password' => bcrypt('r1234567'),
        ]);

        DB::table('roles_logins')->insert([
        	'role_id' => '1',
        	'login_id' => '1',
        ]);
    }
}
