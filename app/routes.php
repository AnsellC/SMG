<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
use Illuminate\Database\Eloquent\ModelNotFoundException;

App::error(function (ModelNotFoundException $e) {
    return View::make('error.missing', 404);
});

Route::get('/', function () {
    if (Auth::check()) {
        return Redirect::to('/dashboard');
    }

    return View::make('static.homepage');
});

//static page for displaying messages
Route::get('unverified-email', function () {
    return View::make('static.unverified-email');
});

Route::get('about', function () {
    return View::make('static.about');
});
Route::get('contact', function () {
    return View::make('static.contact');
});

Route::get('browse', function () {
    $photos = Photo::orderBy('created_at', 'DESC')->paginate(16);

    return View::make('static.browse')->withPhotos($photos);
});

Route::post('contact', [
    'as'	=> 'contact',
    function () {
        $validator = Validator::make(
            Input::all(),
            [
                'name'		  => 'required|min:5',
                'email'		 => 'email|required',
                'message'	=> 'required|min:5',
            ]
        );

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }

        Mail::queue('emails.contact', ['name' => Input::get('name'), 'msg' => Input::get('message'), 'email' => Input::get('email'), 'ip' => $_SERVER['REMOTE_ADDR']], function ($message) {
            $message->to('ansellcruz@gmail.com', 'Ansell Cruz')->subject('New feedback message from SMG');
        });

        return Redirect::back()->withMessage('Thanks for your email!');
    },
]);

/*
|--------------------------------------------------------------------------
| User routes
|--------------------------------------------------------------------------
|
| Routes mostly associated with user-related model/actions
|
|
*/

Route::get('register', [
    'before' 	=> 'guest',
    function () {
        return View::make('users.register');
    },
]);

Route::get('logout', function () {
    Auth::logout();

    return Redirect::to('/');
});

Route::get('login', ['before' => 'guest', function () {
    return View::make('users.login');
}]);

Route::post('register', [
    'before' 	=> 'guest',
    'uses' 		 => 'UserController@store',
    'as'		    => 'user.add',
]);

Route::post('login', [
    'before' 	=> 'guest',
    'uses' 		 => 'UserController@login',
    'as' 		   => 'login',
]);

Route::get('account/email-pass', [
    'before' 	=> 'auth',
    function () {
        return View::make('users.email-pass');
    },
]);

Route::get('account/resend-activation', [
    'before' 	=> 'unconfirmed',
    function () {
        return View::make('users.resend-activation');
    },
]);

Route::get('account/resend-activation-now', [
    'before'	=> 'unconfirmed',
    'uses'		 => 'UserController@resendActivation',
]);

Route::get('account/profile-picture', [
    'before' 	=> 'confirmed',
    function () {
        return View::make('users.profile-picture')->with('user', Auth::user());
    },
]);

Route::post('account/profile-picture', [
    'before' 	=> 'confirmed',
    'uses' 		 => 'UserController@saveProfilePicture',
    'as'		    => 'account.saveProfilePicture',

]);

Route::get('dashboard', [
    'before' 	=> 'auth',
    function () {
        return View::make('users.dashboard');
    },
]);

Route::get('account/edit-profile', [
    'before'	=> 'auth',
    function () {
        return View::make('users.edit-profile');
    },
]);

Route::put('users/update/{id}', [
    'before'	=> 'owner',
    'uses'		 => 'UserController@update',
    'as'		   => 'users.update',
])->where(['id' => '[0-9]+']);

Route::get('users/validate/{id}/{code}', [
    'uses' 		=> 'UserController@validate',
])->where(['id' => '[0-9]+', 'code' => '[a-zA-Z0-9]+']);

Route::put('account/changepass', [
    'before' 	=> 'auth',
    'uses' 		 => 'UserController@changepass',
    'as'		    => 'account.changepass',
]);

Route::get('users/{username}', [
    'uses'		=> 'UserController@show',
]);
Route::get('users/{username}/collections', [

    'uses' 		=> 'UserController@showCollections',
    'as' 		  => 'users.showCollections',

])->where(['username' => '[a-zA-Z0-9_-]+']);

Route::get('users/addfavorite/{photoid}', [

    'before' 	=> 'auth',
    'uses' 		 => 'UserController@addfavorite',

])->where(['photoid' => '[0-9]+']);

Route::get('users/delfavorite/{photoid}', [

    'before' 	=> 'auth',
    'uses' 		 => 'UserController@delfavorite',

])->where(['photoid' => '[0-9]+']);

Route::get('users/{username}/followers', [

    'uses'		=> 'UserController@followers',

])->where(['username' => '[a-zA-Z0-9]+']);

/*
|--------------------------------------------------------------------------
| my-uploads
|--------------------------------------------------------------------------
|
|
|
|
*/

Route::get('my-uploads/process/{process_group}', [
    'before' 	=> 'auth',
    'as' 		   => 'my-uploads/process',
    'uses' 		 => 'MyUploadController@process',
]);
Route::post('my-uploads/process', [
    'before' 	=> 'auth',
    'as' 		   => 'my-uploads/process',
    'uses' 		 => 'MyUploadController@process_save',
]);

Route::post('my-uploads/store', [
    'before' 	=> 'confirmed',
    'as' 		   => 'my-uploads/store',
    'uses' 		 => 'MyUploadController@store',
]);
Route::delete('my-uploads/destroy/{filename}/{batch}', [
    'before' 	=> 'confirmed',
    'as' 		   => 'my-uploads/destroy',
    'uses' 		 => 'MyUploadController@destroy',
]);

Route::get('my-uploads/create', [
    'before'	=> 'confirmed',
    'uses'		 => 'MyUploadController@create',

]);

Route::get('my-uploads', [
    'before'	=> 'confirmed',
    'uses'		 => 'MyUploadController@index',
]);

/*
|--------------------------------------------------------------------------
| my-collections
|--------------------------------------------------------------------------
|
|
|
|
*/

Route::post('my-collections/add-photos', [
    'before' 	=> 'confirmed',
    'as' 		   => 'my-collections/add-photos',
    'uses' 		 => 'MyCollectionController@addPhotos',
]);
Route::post('my-collections/store', [
    'before' 	=> 'confirmed',
    'as' 		   => 'my-collections/store',
    'uses' 		 => 'MyCollectionController@store',

]);

Route::get('my-collections/create', [
    'before'	=> 'confirmed',
    'uses'		 => 'MyCollectionController@create',
]);

Route::get('my-collections', [
    'before'	=> 'auth',
    'uses'		 => 'MyCollectionController@index',
]);

/*
|--------------------------------------------------------------------------
| photos
|--------------------------------------------------------------------------
|
|
|
|
*/
Route::get('photos/delete/{id}', [
    'before' 	=> 'auth',
    'as' 		   => 'photos/destroy',
    'uses' 		 => 'PhotoController@destroy',
]);

Route::get('photos/edit/{id}', [
    'before' 	=> 'auth',
    'as' 		   => 'photos/edit',
    'uses' 		 => 'PhotoController@edit',
]);

Route::patch('photos/update/{id}', [
    'before' 	=> 'auth',
    'as' 		   => 'photos/update',
    'uses' 		 => 'PhotoController@update',
]);

Route::get('photos/groupdelete/{str}', [
    'before' 	=> 'auth',
    'as' 		   => 'photos/groupdelete',
    'uses' 		 => 'PhotoController@groupdelete',
])->where(['str' => '[0-9\,]+']);

Route::get('/{photo_path}', [
    'as' 		  => 'photos.show',
    'uses' 		=> 'PhotoController@show',
])->where(['photo_path' => '[a-zA-Z0-9]{20,}']);

/*
|--------------------------------------------------------------------------
| photocomments
|--------------------------------------------------------------------------
|
|
|
|
*/
Route::post('photocomments/create', [
    'before' 	=> 'auth',
    'as' 		   => 'photocomments/create',
    'uses' 		 => 'PhotoCommentsController@create',
]);

/*
|--------------------------------------------------------------------------
| collections
|--------------------------------------------------------------------------
|
|
|
|
*/
Route::get('collections/{id}-{slug}', [
    'as' 		  => 'collections.show',
    'uses' 		=> 'CollectionController@show',
])->where(['id' => '[0-9]+']);

Route::get('collections/edit/{id}', [
    'before' 	=> 'auth',
    'as' 		   => 'collections.edit',
    'uses' 		 => 'CollectionController@edit',

])->where(['id' => '[0-9]+']);

Route::post('collections/edit/{id}', [
    'before' 	=> 'auth',
    'as' 		   => 'collections.update',
    'uses' 		 => 'CollectionController@update',
])->where(['id' => '[0-9]+']);

Route::get('collections/{id}/manage', [
    'before' 	=> 'auth',
    'as' 		   => 'collections.manage',
    'uses' 		 => 'CollectionController@manage',
])->where(['id' => '[0-9]+']);

Route::post('collections/{id}/saveorder', [
    'before' 	=> 'auth',
    'as' 		   => 'collections.saveorder',
    'uses' 		 => 'CollectionController@saveorder',
])->where(['id' => '[0-9]+']);

Route::get('collections/edit/{collection_id}/remove/{photo_id}', [
    'before' 	=> 'auth',
    'as' 		   => 'collections.removephoto',
    'uses' 		 => 'CollectionController@removephoto',
])->where(['collection_id' => '[0-9]+', 'photo_id' => '[0-9]+']);

Route::get('collections/delete/{id}', [
    'before' 	=> 'auth',
    'as' 		   => 'collections.delete',
    'uses' 		 => 'CollectionController@delete',
])->where(['id' => '[0-9]+']);

/*
|--------------------------------------------------------------------------
| API
|--------------------------------------------------------------------------
|
|
|
|
*/

Route::get('api/getphotos/{userid}/{count}/{skip}', [
    'uses' 		=> 'ApiController@getphotos',
])->where(['userid' => '[0-9]+', 'count' => '[0-9]+', 'skip' => '[0-9]+']);

Route::get('api/getphoto/{id}/{response}', [
    'uses' 		=> 'ApiController@getphoto',
])->where(['id' => '[0-9]+', 'response' => 'html|json']);

Route::get('api/getcomments/{id}/{response}', [
    'uses'		=> 'ApiController@getcomments',
])->where(['id' => '[0-9]+', 'response' => 'html|json']);

/*
|--------------------------------------------------------------------------
| follow
|--------------------------------------------------------------------------
|
|
|
|
*/

Route::get('follow/{username}', [
    'before'	=> 'auth',
    'uses'		 => 'UserController@follow',

])->where(['username' => '[a-zA-Z0-9]+']);
