<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Business\Rutinas\Helpers\NuevaRutinaNotifier;
use Business\Clases\Helpers\AlumnoInasistenteNotifier;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        \App\Console\Commands\GenerarClases::class,
        \App\Console\Commands\BorrarClases::class,
        \App\Console\Commands\GenerarCuotas::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Se programa la generación de clases para todos los domingos a las 15
        $schedule->command('clases:generar 1')
          ->timezone('America/Argentina/Buenos_Aires')
          ->weeklyOn(6, '15:00');

        // Se programa la generación de cuotas para el primer día de cada mes a la 1
        $schedule->command('cuotas:generar')
          ->timezone('America/Argentina/Buenos_Aires')
          ->monthlyOn(1, '01:00');

        // Se programa el checkeo de si se tiene que crear nuevas rutinas para todos los días a las 8
        $schedule->call(function () {
          $nuevaRutinaNotifier = app('Business\Rutinas\Helpers\NuevaRutinaNotifier');
          $nuevaRutinaNotifier->notifyNuevaRutina(); 
        })->timezone('America/Argentina/Buenos_Aires')
          ->dailyAt('08:00');
        
        // Se programa el checkeo de si existen alumnos con 3 inasistencias seguidas para todos los días a las 22
        $schedule->call(function () { 
            $alumnoInasistenteNotifier = app('Business\Clases\Helpers\AlumnoInasistenteNotifier');
            $alumnoInasistenteNotifier->notifyAlumnoInasistente(); 
        })->timezone('America/Argentina/Buenos_Aires')
          ->dailyAt('22:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
