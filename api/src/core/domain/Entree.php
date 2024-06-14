<?php

namespace admin\core\domain;

use Illuminate\Database\Eloquent\Model;

class Entree extends Model
{
    protected $table = 'entree';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function services()
    {
        return $this->belongsToMany('admin\core\domain\Service', 'entree2service', 'id_entree', 'id_service');
    }

    public function departements()
    {
        return $this->belongsToMany('admin\core\domain\Departement', 'entree2departement', 'id_entree', 'id_departement');
    }
}