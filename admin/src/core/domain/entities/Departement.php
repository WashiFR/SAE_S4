<?php

namespace admin\core\domain\entities;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $table = 'departement';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function entrees()
    {
        return $this->belongsToMany('admin\core\domain\entities\Entree', 'entree2departement', 'id_departement', 'id_entree');
    }
}