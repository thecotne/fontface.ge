<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Font extends Model {

	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $fillable = array('fontFamily');
}
