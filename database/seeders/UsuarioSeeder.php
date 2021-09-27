<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Wagner',
            'email' => 'wagner@email.com',
            'password' => Hash::make('12345678'),
            'url' => 'http://wagner.com.bo',
            'created_at'=> date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s'),           

        ]);
        DB::table('users')->insert([
            'name' => 'Rodrigo',
            'email' => 'rodrigo@email.com',
            'password' => Hash::make('12345678'),
            'url' => 'http://rodrigo.com.bo',
            'created_at'=> date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s'),           

        ]);
    }
}
