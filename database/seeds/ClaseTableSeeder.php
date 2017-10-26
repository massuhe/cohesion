<?php
use Business\Clases\Models\Clase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ClaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $diasSemana = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];
        $clases = [];
        foreach ($diasSemana as $diaSemana) {
            $hora = Carbon::parse('08:00');
            for ($i = $hora; $i < Carbon::parse('22:00'); $i = $i->addMinutes(60)) {
                $clases[] = [
                    'dia_semana' => $diaSemana,
                    'hora_inicio' => $i->copy(),
                    'hora_fin' => $i->copy()->addMinutes(60),
                    'actividad_id' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
        }
        DB::table('clases')->insert($clases);
    }
}
