<?php

class MyUploadController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

 	public function __construct()
    {

        $this->beforeFilter('confirmed');
    }

	public function index()
	{

		$photos = Photo::getMine()->orderBy('created_at', 'DESC')->get();
		$collections = Collection::getMine()->get();
		return View::make('my-uploads.index')->with('photos', $photos)->withCollections($collections);
        
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
			
       return View::make('my-uploads.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
		if(Input::hasFile('file'))
		{
			$inputfile = Input::file('file');

			$uploaded_file = Storage::save($inputfile);
			
			if(!$uploaded_file)
				return Response::json('File is not allowed.', 400);


			//create small thumbnails and pass it on the job queue
			Queue::push(function($job) use ($uploaded_file) {

				Storage::createPhoto($uploaded_file, "256x144");
				Storage::createPhoto($uploaded_file, "384x216");
				Storage::createPhoto($uploaded_file, "40x40");
				Storage::createPhoto($uploaded_file, "1035x640");
				$job->delete();
				
			});

			//if photo was successfully saved into the filesystem, insert into DB
			$photo = new \Photo;
			$photo->user_id = \Auth::user()->id;
			$photo->file_name = $inputfile->getClientOriginalName();
			$photo->file_size = $inputfile->getSize();
			$photo->file_type = $inputfile->getClientOriginalExtension();
			$photo->file_path = $uploaded_file;
			$photo->process_group = \Input::get('batch');

			if(!$photo->save())
				return Response::json(implode("", $photo->errors()->all(':message')));
			
			return Response::json('success', 200);

			
		} else
			return Response::json('No file uploaded.', 400);
	}


	public function destroy($filename, $batch = null)
	{
		


		if($batch == null)
		{
			$photo = Photo::where('file_name', '=', $filename)->where('user_id', '=', Auth::user()->id)->first();

			Photo::where('file_name', '=', $filename)->where('user_id', '=', Auth::user()->id)->delete();

		} else {
			$photo = Photo::where('file_name', '=', $filename)->where('process_group', '=', $batch)->where('user_id', '=', Auth::user()->id)->first();
			Photo::where('file_name', '=', $filename)->where('process_group', '=', $batch)->where('user_id', '=', Auth::user()->id)->delete();

		}

		Storage::delete($photo->file_path);
		
		
	}




	public function process($process_group) {

		$photos = Photo::where('process_group', '=', $process_group)->where('user_id', Auth::user()->id)->get();

		if(count($photos) == 0)
			return Redirect::back()->withErrors('Nothing to process. All uploaded files failed.');

		

		$process_group = $photos[0]->process_group;

		

		return View::make('my-uploads/process')->with('photos', $photos)->with('process_group', $process_group);

	}

	public function process_save() {

		foreach(Input::get('id') AS $var => $val) {

			$photo = Photo::find($val);
			if($photo->user_id == Auth::user()->id) {


				$photo->file_name = Input::get('file_name_' . $val);
				$photo->description = Input::get('description_' . $val);
				$photo->allow_collect = Input::get('allow_collect_' . $val);
				$photo->private = Input::get('private_' . $val);

				if($photo->allow_collect !== "1")
					$photo->allow_collect = "0";

				if($photo->private !== "1")
					$photo->private = "0";

				$photo->save();

			}

		}

		return Redirect::to('my-uploads')->withMessage('Photos successfully edited');

	}
	

}
