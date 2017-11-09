<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

/**
* The item model
*/
class Item extends Model
{
	protected $primarykey = 'id';
	protected $table = 'item';
	public $timestamps = false;

	public function lists(){
		return $this->belongsTo('\App\Models\Lists', 'lists_id');
	}

	public function images(){
		return $this->hasMany('\App\Models\Image');
	}
}