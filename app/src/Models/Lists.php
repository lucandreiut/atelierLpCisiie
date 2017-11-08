<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model 
{
    protected $table = "list";
    protected $primarykey = "id";

    public $timestamps = false;

    public function user() 
    {
        return $this->belongsTo('\App\Models\Users', 'users_id');
    }
}