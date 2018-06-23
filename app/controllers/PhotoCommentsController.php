<?php


class PhotoCommentsController extends \BaseController
{
    public function create()
    {
        $photo = Photo::findOrFail(Input::get('photo_id'));

        $comment = new PhotoComment();
        $comment->content = Input::get('content');
        $comment->user_id = Auth::user()->id;

        if (Request::ajax()) {
            if (!$photo->comments()->save($comment)) {
                return Response::json($comment->errors());
            }

            return Response::json(['status' => 'success', 'msg' => 'Comment posted', 'photo_id' => $photo->id]);
        } else {
            if (!$photo->comments()->save($comment)) {
                return Redirect::back()->withErrors($comment->errors());
            }

            return Redirect::back()->withMessage('Comment posted.');
        }
    }
}
