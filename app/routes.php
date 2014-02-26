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

Route::get('/test', function()
{
	return View::make('test');
});

Route::get('/', function()
{
	
	if(Auth::check())
		return Redirect::to('/dashboard');
	return View::make('static.homepage');
});


Route::get('register', array('before' => 'guest', function(){
	return View::make('static.register');

}));

Route::get('login', array('before' => 'guest', function(){
	return View::make('static.login');

}));

Route::post('register',  array(
	'before' => 'guest',
	'uses' => 'UserController@store',
	'as' => 'user.add'

));

Route::post('login', array(
	'before' => 'guest',
	'uses' => 'UserController@login',
	'as' => 'login'
));

Route::get('logout', function(){

	Auth::logout();
	return Redirect::to('/');

});

Route::get('unverified-email', function(){

	return View::make('static.unverified-email');
});


Route::get('edit-email-pass', array(
	'before' => 'auth',
	'as' => 'users.edit-email-pass',
	function(){

	return View::make('users.email-pass');

}));

Route::get('resend-activation', array(
	'before' => 'unconfirmed',
	'as' => 'users.resend-activation',
	function(){

		return View::make('users.resend-activation');
	}
));


Route::get('resend-activation-now', array(
	'before' => 'unconfirmed',
	function(){

		//send email
		$email = Auth::user()->email;
		$username = Auth::user()->username;

		Mail::queue('emails.welcome', array('code' => Auth::user()->confirmation_code, 'id' => Auth::user()->id), function($message) use($email, $username){

			$message->to($email, $username)->subject('Welcome to SMG! Please verify your e-mail address');
		});
		return Redirect::to('dashboard')->withMessage('Confirmation email has been sent to <strong>'.$email.'</strong>.');
	}
));

Route::get('profile-picture', array(
	'before' => 'confirmed',
	'as' => 'profile-picture',
	'uses' => 'UserController@getProfilePicture',
));


Route::post('profile-picture', array(
	'before' => 'confirmed',
	'uses' => 'UserController@postProfilePicture',

));


Route::get('dashboard', array('before' => 'auth', function(){

	return View::make('users.dashboard');
}));

Route::get('edit-profile', array('before' => 'auth', function(){

	return View::make('users.edit-profile');
}));


Route::get('users/validate/{id}/{code}', array(
	'uses' => 'UserController@validate',
))->where(array('id' => '[0-9]+', 'code' => '[a-zA-Z0-9]+'));

Route::put('users/changepass', array(
	'before' => 'auth',
	'uses' => 'UserController@changepass',
	'as' => 'users.changepass'
));
Route::resource('users', 'UserController');

Route::get('users/{username}/collections', array(

	'uses' => 'UserController@showCollections',
	'as' => 'users.showCollections'
	
))->where(array('username' => '[a-zA-Z0-9_-]+'));


Route::get('users/addfavorite/{photoid}', array(

	'before' => 'auth',
	'uses' => 'UserController@addfavorite'

))->where(array('photoid' => '[0-9]+'));
Route::get('users/delfavorite/{photoid}', array(

	'before' => 'auth',
	'uses' => 'UserController@delfavorite'

))->where(array('photoid' => '[0-9]+'));


Route::post('my-collections/store', array(
	'before' => 'confirmed',
	'as' => 'my-collections/store',
	'uses' => 'MyCollectionController@store',
	
));

Route::post('my-collections/add-photos', array(
	'before' => 'confirmed',
	'as' => 'my-collections/add-photos',
	'uses' => 'MyCollectionController@addPhotos'
));
Route::resource('my-collections', 'MyCollectionController');

Route::get('my-uploads/process/{process_group}', array(
	'before' => 'auth',
	'as' => 'my-uploads/process',
	'uses' => 'MyUploadController@process'
));
Route::post('my-uploads/process', array(
	'before' => 'auth',
	'as' => 'my-uploads/process',
	'uses' => 'MyUploadController@process_save'
));

Route::resource('my-uploads', 'MyUploadController');
Route::post('my-uploads/store', array(
	'before' => 'confirmed',
	'as' => 'my-uploads/store',
	'uses' => 'MyUploadController@store'
));
Route::delete('my-uploads/destroy/{filename}/{batch}', array(
	'before' => 'confirmed',
	'as' => 'my-uploads/destroy',
	'uses' => 'MyUploadController@destroy'
));
//Route::resource('photos', 'PhotoController');
Route::get('photos/delete/{id}', array(
	'before' => 'auth',
	'as' => 'photos/destroy',
	'uses' => 'PhotoController@destroy'
));

Route::get('photos/edit/{id}', array(
	'before' => 'auth',
	'as' => 'photos/edit',
	'uses' => 'PhotoController@edit'
));

Route::patch('photos/update/{id}', array(
	'before' => 'auth',
	'as' => 'photos/update',
	'uses' => 'PhotoController@update'
));


Route::get('photos/groupdelete/{str}', array(
	'before' => 'auth',
	'as' => 'photos/groupdelete',
	'uses' => 'PhotoController@groupdelete'
))->where(array('str' => '[0-9\,]+'));



Route::get('/{photo_path}', array(
	'as' => 'photos.show',
	'uses' => 'PhotoController@show'
))->where(array('photo_path' => '[a-zA-Z0-9]{20,}'));


Route::post('photocomments/create', array(
	'before' => 'auth',
	'as' => 'photocomments/create',
	'uses' => 'PhotoCommentsController@create'
));

Route::get('collections/{id}-{slug}', array(
	'as' => 'collections.show',
	'uses' => 'CollectionController@show'
))->where(array('id' => '[0-9]+'));

Route::get('collections/edit/{id}', array(
	'as' => 'collections.edit',
	'uses' => 'CollectionController@edit'

))->where(array('id' => '[0-9]+'));

Route::post('collections/edit/{id}', array(
	'as' => 'collections.update',
	'uses' => 'CollectionController@update'
))->where(array('id' => '[0-9]+'));

Route::get('collections/{id}/manage', array(
	'as' => 'collections.manage',
	'uses' => 'CollectionController@manage'
))->where(array('id' => '[0-9]+'));

Route::post('collections/{id}/saveorder', array(
	'as' => 'collections.saveorder',
	'uses' => 'CollectionController@saveorder'
))->where(array('id' => '[0-9]+'));

Route::get('collections/edit/{collection_id}/remove/{photo_id}', array(
	'as' => 'collections.removephoto',
	'uses' => 'CollectionController@removephoto'
))->where(array('collection_id' => '[0-9]+', 'photo_id' => '[0-9]+'));

Route::get('api/getphotos/{userid}/{count}/{skip}', array(
	'uses' => 'ApiController@getphotos'
))->where(array('userid' => '[0-9]+', 'count' => '[0-9]+', 'skip' => '[0-9]+'));
