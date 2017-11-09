<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

/**
* The item model
*/
class Contributor extends Model
{
	protected $primarykey = 'id';
	protected $table = 'contributor';
	public $timestamps = false;

	public function item(){
		return $this->haOne('\App\Models\Item', 'item_id');
	}
}