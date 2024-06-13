<?php

namespace api\core\domain;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $table = 'departement';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function entrees()
    {
        return $this->belongsToMany('api\core\domain\Entree', 'entree2departement', 'id_departement', 'id_entree');
    }
}