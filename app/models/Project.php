<?php

use LaravelBook\Ardent\Ardent;

class Project extends Ardent {




	protected $fillable = array('title','user_id','photo_id','description','scale');
	protected $guarded = array('id');

	public static $rules = array(
	  'title' => 'required|between:2,20',
	  'user_id' => 'required',
	  'scale' => 'required|regex:/^([0-9]+)\/([0-9\.]+)$/'
	);	


	
	public function user() 
	{
		return $this->belongsTo('User');
	
	}
	public function photos(){
		return $this->hasMany('Photo');
	}
	
}