<?php

use SMG\Model\SMGModel;

class PhotoComment extends SMGModel {

	
	protected $table = 'photocomments';
	
	public static $rules = array(
	  'user_id' => 'required',
	  'photo_id' => 'required',
	  'content' => 'min:5|required',

	);	


	
	public function user() 
	{
		return $this->belongsTo('User');
	
	}
	public function photos(){
		return $this->belongsTo('Photo');
	}

	
}