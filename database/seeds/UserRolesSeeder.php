<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \SisMid\Models\Usuario::create([
            'nome' => 'Admin',
            'sobrenome' => 'Admin',
            'email' => 'admin@localhost.com',
            'password' => bcrypt('admin')
        ]);

        $today = \Carbon\Carbon::now();
        DB::table('roles')->insert(['id' => 1, 'name' => 'admin', 'created_at' => $today, 'updated_at' => $today]);
        DB::table('roles')->insert(['id' => 2, 'name' => 'A2','created_at' => $today, 'updated_at' => $today]);

        DB::table('role_user')->insert(['role_id' => 1, 'user_id' => 1]);
    }
}