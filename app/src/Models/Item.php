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

/*	public function title(){
		return $this->title;
	}

	public function description(){
		return $this->description;
	}

	public function price(){
		return $this->price;
	}

	public function url(){
		return $this->url;
	}

	public function contribution(){
		return $this->current_contribution;
	}

	public function reserved(){
		return $this->is_reserved;
	}*/

//	public function group(){
//		return $this->belongsTo('\App\Models\Group', 'group_id');
//	}
}