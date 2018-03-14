<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Business\Finanzas\Helpers\CuotasGenerator;
use Carbon\Carbon;

class GenerarCuotas extends Command
{
    private $classGenerator;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cuotas:generar {mes=0} {anio=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera las cuotas de todos los alumnos activos para el mes y año seleccionado 
                              (o para el mes y año actual en caso de que no se haya especificado)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CuotasGenerator $cg)
    {
        parent::__construct();
        $this->cuotasGenerator = $cg;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $mes = intval($this->argument('mes'));
        $anio = intval($this->argument('anio'));
        if (!$mes || !$anio) {
            $now = Carbon::now();
            $mes = $now->month;
            $anio = $now->year;
        }
        $this->cuotasGenerator->generate($mes, $anio);
        echo "Las cutoas del $mes/$anio se generaron correctamente";
    }
}
