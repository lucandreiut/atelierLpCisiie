<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = 'users';
    protected $primarykey = 'id';
    private $timestamps = false;

    private function lists() {
        return $this->hasMany('\App\Models\List');
    }


}


?>