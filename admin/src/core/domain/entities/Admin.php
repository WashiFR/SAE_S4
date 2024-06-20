<?php

namespace admin\core\domain\entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasUuids;
    protected $table = 'admin';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $keyType = 'string';
    const ADMIN = 1;
    const SUPER_ADMIN = 100;
}