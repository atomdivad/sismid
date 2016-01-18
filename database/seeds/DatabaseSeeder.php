<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

         $this->call(UserRolesSeeder::class);
         $this->call(NaturezasJuridicasSeeder::class);
         $this->call(IniciativaFormSeeder::class);
         $this->call(SismidDadosSeeder::class);
         $this->call(dimensoesSeeder::class);
         $this->call(servicosSeeder::class);
         $this->call(pidTiposSeeder::class);
         $this->call(telefoneTiposSeeder::class);
         $this->call(localizacoesSeeder::class);
         $this->call(localidadesSeeder::class);
         $this->call(ufSeeder::class);
         $this->call(cidadesSeeder::class);

        Model::reguard();
    }
}