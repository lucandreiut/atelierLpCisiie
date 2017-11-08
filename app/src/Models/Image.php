<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

/**
* The item model
*/
class Image extends Model
{
	protected $primarykey = 'id';
	protected $table = 'image';
	public $timestamps = false;
	protected $fillable = ['url'];

	public function item(){
		return $this->belongsTo('\App\Models\Item', 'item_id');
	}
}