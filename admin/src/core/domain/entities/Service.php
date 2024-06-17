<?php

namespace admin\core\domain\entities;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'service';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function entrees()
    {
        return $this->belongsToMany('admin\core\domain\entities\Entree', 'entree2service', 'id_service', 'id_entree');
    }
}