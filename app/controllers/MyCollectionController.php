<?php

class MyCollectionController extends BaseController {

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

		$collection = Collection::getMine()->with('photos')->get();
		return View::make('my-collections.index')->with('collections', $collection);
        
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
       return View::make('my-collections.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$collection = new Collection(Input::all());
		$collection->user_id = Auth::user()->id;
		
		if (!$collection->save())
		{

			return Redirect::to('/my-collections/create')->withInput()->withErrors($collection->errors());	

		} else {

			return Redirect::to('/my-collections')->withMessage('Collection created successfully!');
			
		}
	}


	public function edit($id)
	{
        //return View::make('albums.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function addPhotos() {

		$collection = Collection::find(Input::get('collection_id'));

		if(count($collection) == 0)
			return false;

		
		if($collection->isMine())
		{
			$photos = explode(",", Input::get('photoarray'));
			
			$photos_attached = $collection->photos()->lists('photo_id');


			foreach($photos AS $photo => $id) {
				//$collection->photos()->save($id);
				
				if( !in_array($id, $photos_attached) ) {

					$this_photo = Photo::find($id);

					if(!empty($this_photo))
					{
						if($this_photo->allow_collect == 0 AND $this_photo->user_id == Auth::user()->id)

							$this_photo->collections()->attach($collection->id);

						elseif($this_photo->allow_collect == 1)

							$this_photo->collections()->attach($collection->id);
					}	
						
				}
				elseif(count($photos) == 1)
				{
					return Redirect::to('/my-uploads')->withMessage('This photo already exist in '.$collection->title);
		
				}
				
			}
			
			$collection->touch();
			if(count($photos) == 1)
				return Redirect::back()->withMessage('Photos added to '.$collection->title);
			return Redirect::to('/my-uploads')->withMessage('Photos added to '.$collection->title);
		}

		

	}


	

}
