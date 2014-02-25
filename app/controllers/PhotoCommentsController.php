<?php


class PhotoCommentsController extends \BaseController {



	public function create() {

		$photo = Photo::find(Input::get('photo_id'));
		if(!$photo)
			return App::abort(404);

		$comment = new PhotoComment;
		$comment->content = Input::get('content');
		$comment->user_id = Auth::user()->id;
		
		if(!$photo->comments()->save($comment))
			return Redirect::back()->withErrors($comment->errors());
		return Redirect::back()->withMessage('Comment posted.');

	}
}