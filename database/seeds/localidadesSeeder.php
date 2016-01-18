<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class localidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('localidades')->insert(['idLocalidade ' => 1, 'localidade' => 'Capital Federal']);
        DB::table('localidades')->insert(['idLocalidade ' => 2, 'localidade' => 'Capital']);
        DB::table('localidades')->insert(['idLocalidade ' => 3, 'localidade' => 'Cidade']);
        DB::table('localidades')->insert(['idLocalidade ' => 4, 'localidade' => 'Município']);
        DB::table('localidades')->insert(['idLocalidade ' => 5, 'localidade' => 'Distrito']);
        DB::table('localidades')->insert(['idLocalidade ' => 6, 'localidade' => 'Vilas']);
        DB::table('localidades')->insert(['idLocalidade ' => 7, 'localidade' => 'Áreas Especiais']);
    }
}
