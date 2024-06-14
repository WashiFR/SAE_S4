<?php

namespace api\core\domain;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'departement';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function entrees()
    {
        return $this->belongsToMany('api\core\domain\Entree', 'entree2service', 'id_service', 'id_entree');
    }
}