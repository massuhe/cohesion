<?php
use Business\Clases\Models\ClaseEspecifica;
use Business\Clases\Models\Clase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ClaseEspecificaTableSeeder extends Seeder
{
    private $addDays = [
        'lunes' => 0,
        'martes' => 1,
        'miercoles' => 2,
        'jueves' => 3,
        'viernes' => 4,
        'sabado' => 5
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clases = Clase::where('actividad_id', 1)->get();
        $clasesEspecificas = [];
        $today = Carbon::now()->startOfWeek();
        foreach($clases as $clase) {
            $clasesEspecificas[] = [
                'fecha' => $today->copy()->addDays($this->addDays[$clase->dia_semana]),
                'suspendida' => false,
                'descripcion_clase' => $clase->id
            ];
        }
        DB::table('clases_especificas')->insert($clasesEspecificas);
    }
}
