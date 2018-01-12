<?php

namespace Business\Clases\Helpers;

class SuspenderHelper
{
    /**
     * Convierte el set de parámetros pasados como argumento en una expresión para utilizar en el where de la consulta
     * para la suspensión de clases en un rango de horarios.
     */
    public function getSuspensionWhereQuery($setParametros)
    {
        $actividadesString =  join(',', $setParametros['actividades']);
        $query = "actividad_id in ($actividadesString)";
        if(isset($setParametros['dias']) && sizeof($setParametros['dias']) > 0) {
            $queryDias = $this->getQueryDias($setParametros['dias']);
            $query .= " AND ($queryDias)";
        }
        return $query;
    }

    private function getQueryDias($dias)
    {
        $query = '';
        forEach($dias as $i => $d) {
            $query .= $i === 0 ? '' : ' OR';
            $queryDia = $this->getQueryDia($d);
            $query .= " ($queryDia)";
        }
        return $query;
    }

    private function getQueryDia($dia)
    {
        $diaSemanaString = join(',', $this->addComillas($dia['diaSemana']));
        $query = "dia_semana in ($diaSemanaString)";
        if(isset($dia['rangosHorarios']) && sizeof($dia['rangosHorarios']) > 0) {
            $queryRangosHorarios = $this->getQueryRangosHorarios($dia['rangosHorarios']);
            $query .= " AND ($queryRangosHorarios)";
        }
        return $query;
    }

    private function getQueryRangosHorarios($rangosHorarios)
    {
        $query = '';
        forEach($rangosHorarios as $i => $rh) {
            $query .= $i === 0 ? '' : ' OR';
            $queryRangoHorario = $this->getQueryRangoHorario($rh);
            $query .= " ($queryRangoHorario)";
        }
        return $query;
    }

    private function getQueryRangoHorario($rangoHorario)
    {
        $horaDesde = $rangoHorario['horaDesde'];
        $horaHasta = $rangoHorario['horaHasta'];
        return "hora_inicio >= '$horaDesde' AND hora_fin <= '$horaHasta'";
    }

    private function addComillas($array)
    {
        return collect($array)->map(function ($a){return "'$a'";})->toArray();
    }

}