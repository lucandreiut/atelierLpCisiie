<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

/**
* The item model
*/
class Item extends Model
{
	private $primarykey = 'id';
	private $table = 'item';
	private $timestamps = false;

	public function list(){
		return $this->belongsTo('\App\Models\Lists', 'list_id');
	}
}
