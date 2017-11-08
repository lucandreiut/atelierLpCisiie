<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Users extends Model {

    protected $table = 'users';
    protected $primarykey = 'id';
    public $timestamps = false;

    public function lists() {
        return $this->hasMany('\App\Models\Lists');
    }


}


?>