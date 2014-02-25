<?php


class UserController extends \BaseController {

	
 public function __construct()
    {
        $this->beforeFilter('auth', array('except' => array('show','login','store','validate')));
        $this->beforeFilter('owner', array('on' => array('update','changepass')));
        $this->beforeFilter('confirmed', array('on' => array('postProfilePicture','getProfilePicture'))); //doesnt seem to work
    }

	public function store()
	{

		$user = new User(Input::all());
		$user->username = Input::get('username'); //not fillable
		$user->email = Input::get('email'); //not fillable
		$user->confirmed = 0;
		$user->confirmation_code = str_random(20);
		
   		$user::$rules['password'] = "required|min:5|confirmed";
   		$user::$rules['password_confirmation'] = "required";
		
		if (!$user->save())
		{

			return Redirect::route('user.add')->withInput()->withErrors($user->errors());	

		} else {

			//send email
			Mail::queue('emails.welcome', array('code' => $user->confirmation_code, 'id' => $user->id), function($message){

				$message->to(Input::get('email'), Input::get('username'))->subject('Welcome to SMG! Please verify your e-mail address');
			});
			if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'))))

				return View::make('static.register-success');
			
		}
	}

	public function addfavorite($photo_id) {

		$photo = Photo::find($photo_id);
		if(count($photo) == 0 OR $photo == null)
			App::abort(404);

		$likers = $photo->likers()->lists('user_id');
		
		if(!in_array(Auth::user()->id, $likers))
		{
			$photo->likers()->attach(Auth::user()->id);
			return Response::json(array('msg' => 'success'));
		}
		return Response::json(array('msg' => 'fail'));

	}


	public function delfavorite($photo_id) {

		$photo = Photo::find($photo_id);
		if(count($photo) == 0 OR $photo == null)
			App::abort(404);

		$likers = $photo->likers()->lists('user_id');
		
		if(in_array(Auth::user()->id, $likers))
		{
			$photo->likers()->detach(Auth::user()->id);
			return Response::json(array('msg' => 'success'));
		}
		return Response::json(array('msg' => 'fail'));

	}


	public function login()
	{

		$email = Input::get('email');
		$password = Input::get('password');
		$remember = Input::get('remember');

		if($remember == '1') 
			$remember = true;
		else
			$remember = false;

		if (Auth::attempt(array('email' => $email, 'password' => $password), $remember))
		
    		return Redirect::intended('/dashboard');
		
		return Redirect::back()->withMsg('Incorrect Username/Password.');
		

	}

	public function show($username)
	{
		
		$user = User::where('username', $username)->first();
		if(!$user)
			App::abort(404);
		$user->increment('profile_views');	
		//laravel can't orderBy when in relationship mode
		$photos = Photo::where('user_id', $user->id)->where('private', 0)->orderBy('created_at', 'DESC')->with('likers')->take(9)->get();
		$collections = Collection::where('user_id', $user->id)->orderBy('created_at', 'DESC')->with('photos')->get();

		
		return View::make('users.show')->with('user', $user)->withPhotos($photos)->withCollections($collections);
	}

	public function showCollections($username) {

		$user = User::where('username', $username)->first();

		if(!$user)
			App::abort(404);
		$user->increment('profile_views');
		$collections = Collection::where('user_id', $user->id)->orderBy('created_at', 'DESC')->with('photos')->get();
		return View::make('users.show-collections')->with('user', $user)->withCollections($collections);


	}
	public function edit($id)
	{
		//
	}


	public function update($id)
	{
		$user = User::find($id);

		$user->fill(Input::all());
		
		$method = Input::get('m');
		if($method == "edit-profile")
		{

			if($user->showfullname !== "1")
				$user->showfullname = "0";
			if($user->show_location !== "1")
				$user->show_location = "0";

		}
		if($method == "change-email-settings") {

			if($user->email_notification_comment !== "1")
				$user->email_notification_comment = "0";
			if($user->email_notification_pm !== "1")
				$user->email_notification_pm = "0";
			if($user->email_notification_like !== "1")
				$user->email_notification_like = "0";


		}

		if($method == "edit-email-pass"){

			$newemail = Input::get('email');
			

			if(Auth::user()->email != $newemail) {


				$user->confirmed = 0;
				$user->confirmation_code = str_random(20);
				$user->email = $newemail;
				$emailchanged = true;

			} else {

				return Redirect::to($method);
			}
		}

		if (!$user->updateUniques())
		{

			return Redirect::to($method)->withInput()->withErrors($user->errors());	

		} else {

			if($method == "edit-email-pass" AND isset($emailchanged)) {


					Mail::queue('emails.changeemail', array('code' => $user->confirmation_code, 'id' => Auth::user()->id, 'username' => Auth::user()->username), function($message) use($newemail){

						$message->to($newemail, Auth::user()->username)->subject('Confirm your new e-mail address');
					});
					
					return Redirect::route('users.edit-email-pass')->withMessage('E-mail address changed. An email has been dispatched to <strong>'.Input::get('email').'</strong>. Please verify your new email address.');



			}

			//hack for redirect
			if($method == "change-email-settings")
				$method = "edit-email-pass";


			return Redirect::to($method)->withMessage('Profile successfully updated!');
			
		}		
	}

	public function getProfilePicture() {


		Return View::make('users.profile-picture')->with('user', Auth::user());

	}

	public function postProfilePicture()
	{

		if(Input::hasFile('profile_photo'))
		{
			$photo = Input::File('profile_photo');
			$allowed = array('image/jpeg','image/gif','image/png');
			$maxsize = 5242880;
			$maxlong = 1920;



			$imageinfo = getimagesize($photo->getRealPath());
			$type = $imageinfo['mime'];
			$width = $imageinfo[0];
			$height = $imageinfo[1];
			

			if($photo->getSize() > $maxsize)
				
				$errors[] = "File is too large. Maximum file size is 5MB.";

			if(!in_array(strtolower($type), $allowed)) 

				$errors[] = "File is of invalid type. Must be JPG, PNG or GIF";

			if($width > $maxlong OR $height > $maxlong)

				$errors[] = "Image dimensions must not exceed 1920 pixels on the longest side. Your image is <strong>".$width."x".$height." pixels</strong>";


			if(!empty($errors))
				
				Return View::make('users.profile-picture')->with('user', Auth::user())->withErrors($errors);
			
			else
			{
				$user = User::find(Auth::user()->id);
				$user->updateProfilePic($photo);
				$user->updateUniques();
				

				Return Redirect::route('profile-picture')->with('user', Auth::user())->withMessage("Photo successfully uploaded!");
			}

		}
		
		

		Return View::make('users.profile-picture')->with('user', Auth::user());

	}


	public function changepass() 
	{

			$password = Input::get('current_password');

			if (Auth::attempt(array('email' => Auth::user()->email, 'password' => $password))){

				$user = User::find(Auth::user()->id);
				$user->password = Input::get('password');
				$user->password_confirmation = Input::get('password_confirmation');

   				$user::$rules['password'] = (Input::get('password')) ? 'required|min:5|confirmed' : '';
  		 		$user::$rules['password_confirmation'] = (Input::get('password_confirmation')) ? 'required' : '';

				if (!$user->updateUniques())
				{

					return Redirect::route('users.edit-email-pass')->withInput()->withErrors($user->errors());	

				} else {


					return Redirect::route('users.edit-email-pass')->withMessage('Your password has been successfully changed.');

					
				}  	
				

			} else {


				return Redirect::to('edit-email-pass')->withErrors(array('Incorrect Password'));
			}

	}


	public function destroy($id)
	{
		//
	}

	//validates the user's email address.
	public function validate($id, $code)
	{
		$user = User::find($id);
		if(!$user->exists())
			return View::make('static.activation-fail');

		elseif($user->confirmation_code != $code)
			return View::make('static.activation-fail');

		else
		{

			$user->confirmed = '1';
			$user->confirmation_code = "";

			if($user->updateUniques())
				return View::make('static.activation-success');

		}

	}

}