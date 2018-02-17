<?php

namespace Business\Inventario\Models;

use Illuminate\Database\Eloquent\Model;

class ItemInventario extends Model {

    protected $table = 'items_inventario';

    protected $fillable = ['image_path'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

}