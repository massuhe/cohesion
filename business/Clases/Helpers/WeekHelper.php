<?php

namespace Business\Clases\Helpers;

use Illuminate\Support\Carbon;

class WeekHelper
{
    public function getFirstDayOfWeek($week)
    {
        $week = $week instanceof Carbon ? $week : Carbon::createFromFormat('m-d-Y', $week)->setTime(0,0,0);
        return $week->dayOfWeek == Carbon::MONDAY ? $week->copy() : $week->copy()->previous(Carbon::MONDAY);
    }

    public function getLastDayOfWeek($week)
    {
        $week = $week instanceof Carbon ? $week : Carbon::createFromFormat('m-d-Y', $week)->setTime(0,0,0);
        return $week->copy()->next(Carbon::SATURDAY)->setTime(23,59,59);
    }
}