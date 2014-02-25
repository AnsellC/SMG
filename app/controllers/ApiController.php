<?php


class ApiController extends \BaseController {

	public function getphotos($user_id, $count = 16, $skip = 0) {


		$photos = Photo::select(array('file_path', 'file_name', 'description', 'views'))->where('user_id', $user_id)->take($count)->skip($skip)->orderBy('created_at', 'DESC')->get();

		return View::make('api.getphotos')->withPhotos($photos);
	}
	
}
?>