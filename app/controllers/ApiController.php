<?php


class ApiController extends \BaseController {

	public function getphotos($user_id, $count = 16, $skip = 0) {


		$photos = Photo::select(array('file_path', 'file_name', 'description', 'views'))->where('user_id', $user_id)->take($count)->skip($skip)->orderBy('created_at', 'DESC')->get();

		return View::make('api.getphotos')->withPhotos($photos);
	}


	public function getphoto($photo_id, $response = "json") {

		$photo = Photo::findOrFail($photo_id);
	


		if($response == "json")
			return Response::json($photo);

		return View::make('api.getphoto')->withPhoto($photo);
	}


	public function getcomments($photo_id, $response = "json") {

		$photo = Photo::findOrFail($photo_id);

		if($response == "json")
			return Response::json($photo->comments);
		else
			return View::make('api.getcomments')->withPhoto($photo);

	}
}
?>