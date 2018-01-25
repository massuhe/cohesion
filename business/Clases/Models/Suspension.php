<?php
namespace Business\Clases\Models;

use Illuminate\Database\Eloquent\Model;

class Suspension extends Model
{
    protected $table = 'suspensiones';
    public $timestamps = false;

    public function clase()
    {
        return $this->belongsTo('Business\Clases\Models\Clase');
    }
}