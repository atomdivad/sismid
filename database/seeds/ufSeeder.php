<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ufSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('uf')->insert(['idUf' => 11, 'uf' => 'RO']);
        DB::table('uf')->insert(['idUf' => 12, 'uf' => 'AC']);
        DB::table('uf')->insert(['idUf' => 13, 'uf' => 'AM']);
        DB::table('uf')->insert(['idUf' => 14, 'uf' => 'RR']);
        DB::table('uf')->insert(['idUf' => 15, 'uf' => 'PA']);
        DB::table('uf')->insert(['idUf' => 16, 'uf' => 'AP']);
        DB::table('uf')->insert(['idUf' => 17, 'uf' => 'TO']);
        DB::table('uf')->insert(['idUf' => 21, 'uf' => 'MA']);
        DB::table('uf')->insert(['idUf' => 22, 'uf' => 'PI']);
        DB::table('uf')->insert(['idUf' => 23, 'uf' => 'CE']);
        DB::table('uf')->insert(['idUf' => 24, 'uf' => 'RN']);
        DB::table('uf')->insert(['idUf' => 25, 'uf' => 'PB']);
        DB::table('uf')->insert(['idUf' => 26, 'uf' => 'PE']);
        DB::table('uf')->insert(['idUf' => 27, 'uf' => 'AL']);
        DB::table('uf')->insert(['idUf' => 28, 'uf' => 'SE']);
        DB::table('uf')->insert(['idUf' => 29, 'uf' => 'BA']);
        DB::table('uf')->insert(['idUf' => 31, 'uf' => 'MG']);
        DB::table('uf')->insert(['idUf' => 32, 'uf' => 'ES']);
        DB::table('uf')->insert(['idUf' => 33, 'uf' => 'RJ']);
        DB::table('uf')->insert(['idUf' => 35, 'uf' => 'SP']);
        DB::table('uf')->insert(['idUf' => 41, 'uf' => 'PR']);
        DB::table('uf')->insert(['idUf' => 42, 'uf' => 'SC']);
        DB::table('uf')->insert(['idUf' => 43, 'uf' => 'RS']);
        DB::table('uf')->insert(['idUf' => 50, 'uf' => 'MS']);
        DB::table('uf')->insert(['idUf' => 51, 'uf' => 'MT']);
        DB::table('uf')->insert(['idUf' => 52, 'uf' => 'GO']);
        DB::table('uf')->insert(['idUf' => 53, 'uf' => 'DF']);
    }
}
