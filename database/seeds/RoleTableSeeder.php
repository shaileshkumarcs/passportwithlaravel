<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
        	'v_name' => 'User'
        ]);

        DB::table('roles')->insert([
        	'v_name' => 'Vendor'
        ]);

        DB::table('roles')->insert([
        	'v_name' => 'Admin'
        ]);

        DB::table('roles')->insert([
        	'v_name' => 'SuperAdmin'
        ]);
    }
}
