<?php

namespace Business\Novedades\Models;

use Illuminate\Database\Eloquent\Model;

class Novedad extends Model
{
    protected $table = 'novedades';
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['updated_at', 'created_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['updated_at'];

}