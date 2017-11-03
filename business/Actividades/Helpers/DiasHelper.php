<?php

namespace Business\Actividades\Helpers;

use Illuminate\Support\Collection;
use Business\Actividades\Factories\DiaHorarioFactory;
use Business\Actividades\Factories\RangoHorarioFactory;

class DiasHelper {

    private $diaHorarioFactory;
    private $rangoHorarioFactory;

    public function __construct(DiaHorarioFactory $dhf, RangoHorarioFactory $rhf)
    {
        $this->diaHorarioFactory = $dhf;
        $this->rangoHorarioFactory = $rhf;
    }

    // public function divideDias($diasActuales, $diasNuevos) {
    //     $diasEditar = collect([]);
    //     $diasAgregar = collect([]);
    //     forEach($diasNuevos as $dia) {
    //         $a = $diasActuales->first(function($v, $k) use ($dia){
    //             return $v->dia_semana === $dia->dia_semana;
    //         });
    //         if($a !== null) {
    //             $diasEditar->push($a);
    //         } else {
    //             $diasAgregar->push($dia);
    //         }
    //     }
    //     $diasConcat = $diasAgregar->concat($diasEditar);
    //     $diasBorrar = $diasActuales->filter(function($v, $k) use ($diasConcat){
    //         return $diasConcat->first(function($v1, $k1) use ($v) {
    //             return $v1->dia_semana === $v->dia_semana;
    //         }) === null;
    //     });
    //     return [
    //         'diasAgregar' => $diasAgregar,
    //         'diasEditar' => $diasEditar,
    //         'diasBorrar' => $diasBorrar
    //     ];
    // }
    public function generateDiasHorarios($diasHorariosJSON)
    {
        $diasHorarios = [];
        forEach($diasHorariosJSON as $diaHorario) {
            $horarios = [];
            $dh = $this->diaHorarioFactory->createDiaHorario($diaHorario);
            forEach($diaHorario['horarios'] as $horario) {
                $h = $this->rangoHorarioFactory->createRangoHorario($horario);
                $horarios[] = $h;
            }
            $dh->horarios = $horarios;
            $diasHorarios[] = $dh;
        }
        return $diasHorarios;
    }
}