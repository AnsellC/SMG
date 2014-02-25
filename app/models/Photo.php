<?php

use SMG\Model\SMGModel;

class Photo extends SMGModel {



	public $autoPurgeRedundantAttributes = true;
	protected $fillable = array('user_id','project_id','description','file_name','file_type','file_path', 'process_group', 'file_size');
	protected $guarded = array('id');

	public static $rules = array(
	  'user_id' => 'required',
	  'project_id' => 'integer',
	  'file_name' => 'required',
	  'file_type' => 'required',
	  'file_path' => 'required',
	  'process_group' => 'required',
	  'file_size' => 'required',
	);	


	
	public function user() 
	{
		return $this->belongsTo('User');
	
	}
	public function collections(){
		return $this->belongsToMany('Collection')->withPivot('order')->orderBy('collection_photo.order', 'ASC');
	}

	public function likers() {

		return $this->belongsToMany('User', 'likes', 'photo_id', 'user_id');
	}

	public function comments() {

		return $this->hasMany('PhotoComment');
	}

	public function iLike() {

		if(Auth::guest())
			return false;

		$likers = $this->likers()->lists('user_id');

		if(in_array(Auth::user()->id, $likers))
			return true;

		return false;
	}
	
}