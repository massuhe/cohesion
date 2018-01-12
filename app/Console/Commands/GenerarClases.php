<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Business\Shared\Helpers\ClasesGenerator;

class GenerarClases extends Command
{
    private $classGenerator;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clases:generar {semanas=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera las clases especificas para la semana que se obtiene como resultado
                       de sumar la cantidad de semanas especificadas como parametro (por defecto 2) a la semana actual';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ClasesGenerator $cg)
    {
        parent::__construct();
        $this->classGenerator = $cg;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $semanas = intval($this->argument('semanas'));
        if($semanas < 0) {
            throw new \Exception('El número de semanas no puede ser negativo');
        }
        $this->classGenerator->generate($semanas);
    }
}
