<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

/**
* The item model
*/
class Message extends Model
{
	protected $primarykey = 'id';
	protected $table = 'global_message';
	public $timestamps = false;

	public function list(){
		return $this->belongsTo('\App\Models\Lists', 'list_id');
	}

}