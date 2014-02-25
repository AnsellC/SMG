<?php


class PhotoController extends \BaseController {

	
 public function __construct()
    {
 	
 	}

	public function store()
	{

	
	}

	
	public function show($file_path)
	{
		//
		$photo = Photo::where('file_path', '=', $file_path)->first();

		if(count($photo) == 0)
			App::abort(404);

		if(!Auth::guest())
		{
			$likers = $photo->likers()->lists('user_id');
			
			if(in_array(Auth::user()->id, $likers))
				return View::make('photos.show')->withPhoto($photo)->withLiked(true);
				
			
			
		}
		//increment views
		$photo->increment('views');
		return View::make('photos.show')->withPhoto($photo);
	}


	public function edit($id)
	{

		$photo = Photo::find($id);
		if(!$photo)
				App::abort(404);

		if($photo->user->id != Auth::user()->id)
			App::abort(500);
		
		return View::make('photos.edit')->withPhoto($photo);

	}


	public function update($id)
	{
		$photo = Photo::find($id);
		if(!$photo)
			return App::abort(404);

		if($photo->user_id != Auth::user()->id)
			return App::abort(500);

		$photo->file_name = Input::get('file_name');
		$photo->description = Input::get('description');
		$photo->allow_collect = Input::get('allow_collect');
		$photo->private = Input::get('private');
		if($photo->allow_collect !== "1")
				$photo->allow_collect = "0";
		if($photo->private !== "1")
				$photo->private = "0";

		if(!$photo->save())
			return Redirect::back()->withInput()->withErrors($photo->errors());

		return Redirect::back()->withMessage('Photo information successfully saved. <a href="/'. $photo->file_path .'"> View photo.');


	}

	public function destroy($id)
	{
		$photo = Photo::find($id);
		if($photo->user_id == Auth::user()->id)
		{
			$photopath = $photo->file_path;
			if($photo->delete())
			{
				//delete physical file
				$file_save_path = __DIR__ . '/../../public/uploads/user_assets';
				$dirPath = $file_save_path . '/' . $photopath;

				if(file_exists($dirPath)){

					if ($handle = opendir($dirPath)) {


					   
					    while (false !== ($entry = readdir($handle))) {
					       if($entry != "." AND $entry != "..")
					      	 unlink($dirPath . '/' . $entry);
					    }

					}
				    rmdir($dirPath);

				}
				return Response::json('success', 200);
				
			}
			else
				return Response::json('fail', 400);
		}
		else
			return Response::json('fail', 400);
	}


	public function groupdelete($strarr) {

		$ids = explode(",",$strarr);
		$photos = Photo::getMine()->whereIn('id', $ids)->get();
		foreach($photos AS $photo)
		{

			Storage::delete($photo->file_path);
		}

		Photo::getMine()->whereIn('id', $ids)->delete();
		return Response::json('success', 200);
	}

}