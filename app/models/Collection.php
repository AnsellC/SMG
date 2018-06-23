<?php

use SMG\Model\SMGModel;

class Collection extends SMGModel
{
    protected $fillable = ['title', 'description'];
    protected $guarded = ['id'];

    public static $rules = [
      'title'       => 'required|between:2,50',
      'user_id'     => 'required',
      'description' => 'required:between:5,2000',
    ];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function photos()
    {
        return $this->belongsToMany('Photo')->withPivot('order')->orderBy('collection_photo.order', 'ASC');
    }

    public function getPhotosByOrder($statement = 'COUNT(likes.id) AS likes, photos.file_path, photos.file_name, photos.id, collection_photo.order, photos.views, photos.created_at')
    {
        return DB::table('collections')
                        ->join('collection_photo', 'collection_photo.collection_id', '=', 'collections.id')
                        ->join('photos', 'collection_photo.photo_id', '=', 'photos.id')
                        ->leftJoin('likes', 'likes.photo_id', '=', 'photos.id')
                        ->orderBy('collection_photo.order', 'ASC')
                        ->select(DB::raw($statement))
                        ->where('collections.id', $this->id)
                        ->get();
    }
}
