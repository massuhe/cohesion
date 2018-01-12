<?php
use Business\Clases\Models\ClaseEspecifica;
use Business\Clases\Models\Clase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ClaseEspecificaTableSeeder extends Seeder
{
    private $addDays = [
        'Lunes' => 0,
        'Martes' => 1,
        'Miercoles' => 2,
        'Jueves' => 3,
        'Viernes' => 4,
        'Sabado' => 5
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
                'descripcion_clase' => $clase->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        DB::table('clases_especificas')->insert($clasesEspecificas);
    }
}
