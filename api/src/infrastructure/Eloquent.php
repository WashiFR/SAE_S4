<?php

namespace api\infrastructure;

use Illuminate\Database\Capsule\Manager as DB;

class Eloquent
{
    public static function init(String $path) : void
    {
        $db = new DB();
        $db->addConnection(parse_ini_file($path));
        $db->setAsGlobal();
        $db->bootEloquent();
    }
}