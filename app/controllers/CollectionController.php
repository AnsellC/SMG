<?php


class CollectionController extends \BaseController {

 

	public function show($id) {

		$collection = Collection::find($id);

		if(!$collection)
			App::abort(404);
		$collection->increment('views');
		return View::make('collections.show')->withCollection($collection);
	}

	public function removephoto($id, $photo_id) {

		$collection = Collection::find($id);
		if(!$collection)
			App::abort(404);
		if(!$collection->isMine())
			App::abort(403);

		$photo = Photo::find($photo_id);
		if(!$photo)
			App::abort(404);

		$collection->photos()->detach($photo_id);

		if(Request::ajax())
			return Response::json(array('msg' => 'Photo has been removed from this collection.'));

		return Redirect::back()->withMessage('Photo has been removed from this collection.');
	}

	public function saveorder($id) {

		//check if mine
		$collection = Collection::find($id);
		if(!$collection->isMine())
			App::abort(500);

		foreach(Input::get('photo-item') AS $order => $photo_id)
		{
			DB::table('collection_photo')
				->where('photo_id', $photo_id)
				->where('collection_id', $collection->id)
				->update(array('order' => $order));

		}

		$collection->touch();
		echo "Display order has been saved.";

	}

	public function manage($id) {

		$collection = Collection::find($id);


		if(!$collection)
			App::abort(404);

		if(!$collection->isMine())
			App::abort(500);

		//rebuild query


						
		return View::make('collections.manage-photos')->withCollection($collection);

	}

	public function edit($id) {

		$collection = Collection::find($id);
		if(!$collection)
			App::abort(404);

		if(!$collection->isMine())
			App::abort(500);
		return View::make('collections.edit')->withCollection($collection);
	}

	public function update($id) {

		$collection = Collection::find($id);
		if(!$collection)
			App::abort(404);

		if(!$collection->isMine())
			App::abort(500);

		$collection->title = Input::get('title');
		$collection->description = Input::get('description');

		if(!$collection->save())

			return Redirect::back()->withErrors($collection->errors());

		return Redirect::to('my-collections')->withMessage("Collection details updated.");

	}
}
?>