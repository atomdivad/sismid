<?php

namespace SisMid\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RevisaoVerificar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revisao:verificar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica e cancela os PIDs enviados para revisão com mais de 30 dias';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('pid_revisao')
            ->where('created_at', '<', Carbon::now()->subDays(31))
            ->where('submetido', 0)
            ->where('valido', 1)
            ->update(['valido' => 0]);
        $this->info('Verificação concluída!');
    }
}
