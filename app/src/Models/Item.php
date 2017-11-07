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

	public function list(){
		return $this->belongsTo('\App\Models\Lists', 'list_id');
	}
}