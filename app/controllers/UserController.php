<?php


class UserController extends \BaseController
{
    /**
     * Store/save a new user account.
     *
     * @return view
     */
    public function store()
    {
        $user = new User(Input::all());
        $user->username = Input::get('username'); //not fillable
        $user->email = Input::get('email'); //not fillable
        $user->confirmed = 0;
        $user->confirmation_code = str_random(20);

        $user::$rules['password'] = 'required|min:5|confirmed';
        $user::$rules['password_confirmation'] = 'required';

        if (!$user->save()) {
            return Redirect::route('user.add')->withInput()->withErrors($user->errors());
        } else {

            //send email
            Mail::queue('emails.welcome', ['code' => $user->confirmation_code, 'id' => $user->id], function ($message) {
                $message->to(Input::get('email'), Input::get('username'))->subject('Welcome to SMG! Please verify your e-mail address');
            });
            if (Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('password')])) {
                return View::make('static.register-success');
            }
        }
    }

    /**
     * Adds a photo to the currently logged in user's favorite.
     *
     * @return json status
     */
    public function addfavorite($photo_id)
    {
        $photo = Photo::findOrFail($photo_id);

        $likers = $photo->likers()->lists('user_id');

        if (!in_array(Auth::user()->id, $likers)) {
            $photo->likers()->attach(Auth::user()->id);

            return Response::json(['msg' => 'success']);
        }

        return Response::json(['msg' => 'fail']);
    }

    /**
     * Delete a photo from the logged in user's favorite.
     *
     * @return json status
     */
    public function delfavorite($photo_id)
    {
        $photo = Photo::findOrFail($photo_id);

        $likers = $photo->likers()->lists('user_id');

        if (in_array(Auth::user()->id, $likers)) {
            $photo->likers()->detach(Auth::user()->id);

            return Response::json(['msg' => 'success']);
        }

        return Response::json(['msg' => 'fail']);
    }

    /**
     * Login method for the user.
     *
     * @return redirect
     */
    public function login()
    {
        $email = Input::get('email');
        $password = Input::get('password');
        $remember = Input::get('remember');

        if ($remember == '1') {
            $remember = true;
        } else {
            $remember = false;
        }

        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            return Redirect::intended('/dashboard');
        }

        return Redirect::back()->withMsg('Incorrect Username/Password.');
    }

    /**
     * Display a user's profile.
     *
     * @param string $username
     *
     * @return view
     */
    public function show($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            App::abort(404);
        }
        $user->increment('profile_views');
        //laravel can't orderBy when in relationship mode
        $photos = Photo::where('user_id', $user->id)->where('private', 0)->orderBy('created_at', 'DESC')->with('likers')->take(9)->get();
        $collections = Collection::where('user_id', $user->id)->orderBy('created_at', 'DESC')->with('photos')->get();

        return View::make('users.show')->with('user', $user)->withPhotos($photos)->withCollections($collections);
    }

    /**
     * Show a user's collection.
     *
     * @param string $username
     *
     * @return view
     */
    public function showCollections($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            App::abort(404);
        }
        $user->increment('profile_views');
        $collections = Collection::where('user_id', $user->id)->orderBy('created_at', 'DESC')->with('photos')->get();

        return View::make('users.show-collections')->with('user', $user)->withCollections($collections);
    }

    /**
     * Update-save a user's profile.
     *
     * @param int $id
     *
     * @return redirect
     */
    public function update($id)
    {
        $user = User::findOrFail($id);

        if (!$user->isMine()) {
            App::error(403);
        }

        $user->fill(Input::all());

        $method = Input::get('m');
        if ($method == '/account/edit-profile') {
            if ($user->showfullname !== '1') {
                $user->showfullname = '0';
            }
            if ($user->show_location !== '1') {
                $user->show_location = '0';
            }
        }
        if ($method == 'change-email-settings') {
            if ($user->email_notification_comment !== '1') {
                $user->email_notification_comment = '0';
            }
            if ($user->email_notification_pm !== '1') {
                $user->email_notification_pm = '0';
            }
            if ($user->email_notification_like !== '1') {
                $user->email_notification_like = '0';
            }
        }

        if ($method == '/account/email-pass') {
            $newemail = Input::get('email');

            if (Auth::user()->email != $newemail) {
                $user->confirmed = 0;
                $user->confirmation_code = str_random(20);
                $user->email = $newemail;
                $emailchanged = true;
            } else {
                return Redirect::to($method);
            }
        }

        if (!$user->updateUniques()) {
            return Redirect::to($method)->withInput()->withErrors($user->errors());
        } else {
            if ($method == 'edit-email-pass' and isset($emailchanged)) {
                Mail::queue('emails.changeemail', ['code' => $user->confirmation_code, 'id' => Auth::user()->id, 'username' => Auth::user()->username], function ($message) use ($newemail) {
                    $message->to($newemail, Auth::user()->username)->subject('Confirm your new e-mail address');
                });

                return Redirect::route('users.edit-email-pass')->withMessage('E-mail address changed. An email has been dispatched to <strong>'.Input::get('email').'</strong>. Please verify your new email address.');
            }

            //hack for redirect
            if ($method == 'change-email-settings') {
                $method = '/account/email-pass';
            }

            return Redirect::to($method)->withMessage('Profile successfully updated!');
        }
    }

    /**
     * Save the profilepicture
     * POST.
     *
     * @return view/redirect
     */
    public function saveProfilePicture()
    {
        if (Input::hasFile('profile_photo')) {
            $photo = Input::File('profile_photo');
            $allowed = ['image/jpeg', 'image/gif', 'image/png'];
            $maxsize = 5242880;
            $maxlong = 1920;

            $imageinfo = getimagesize($photo->getRealPath());
            $type = $imageinfo['mime'];
            $width = $imageinfo[0];
            $height = $imageinfo[1];

            if ($photo->getSize() > $maxsize) {
                $errors[] = 'File is too large. Maximum file size is 5MB.';
            }

            if (!in_array(strtolower($type), $allowed)) {
                $errors[] = 'File is of invalid type. Must be JPG, PNG or GIF';
            }

            if ($width > $maxlong or $height > $maxlong) {
                $errors[] = 'Image dimensions must not exceed 1920 pixels on the longest side. Your image is <strong>'.$width.'x'.$height.' pixels</strong>';
            }

            if (!empty($errors)) {
                return View::make('users.profile-picture')->with('user', Auth::user())->withErrors($errors);
            } else {
                $user = User::find(Auth::user()->id);
                $user->updateProfilePic($photo);
                $user->updateUniques();

                return Redirect::back()->with('user', Auth::user())->withMessage('Photo successfully uploaded!');
            }
        }

        return View::make('users.profile-picture')->with('user', Auth::user());
    }

    /**
     * Save the new user password.
     *
     * @return
     */
    public function changepass()
    {
        $password = Input::get('current_password');

        if (Auth::attempt(['email' => Auth::user()->email, 'password' => $password])) {
            $user = User::find(Auth::user()->id);
            $user->password = Input::get('password');
            $user->password_confirmation = Input::get('password_confirmation');

            $user::$rules['password'] = (Input::get('password')) ? 'required|min:5|confirmed' : '';
            $user::$rules['password_confirmation'] = (Input::get('password_confirmation')) ? 'required' : '';

            if (!$user->updateUniques()) {
                return Redirect::to('/account/email-pass')->withInput()->withErrors($user->errors());
            } else {
                return Redirect::to('/account/email-pass')->withMessage('Your password has been successfully changed.');
            }
        } else {
            return Redirect::to('/account/email-pass')->withErrors(['Incorrect Password']);
        }
    }

    /**
     * validate the user's email.
     *
     * @return
     */
    public function validate($id, $code)
    {
        $user = User::find($id);
        if (!$user->exists()) {
            return View::make('static.activation-fail');
        } elseif ($user->confirmation_code != $code) {
            return View::make('static.activation-fail');
        } else {
            $user->confirmed = '1';
            $user->confirmation_code = '';

            if ($user->updateUniques()) {
                return View::make('static.activation-success');
            }
        }
    }

    /**
     * Resend's the activation code.
     *
     * @return
     */
    public function resendActivation()
    {
        $email = Auth::user()->email;
        $username = Auth::user()->username;

        Mail::queue('emails.welcome', ['code' => Auth::user()->confirmation_code, 'id' => Auth::user()->id], function ($message) use ($email, $username) {
            $message->to($email, $username)->subject('Welcome to SMG! Please verify your e-mail address');
        });

        return Redirect::to('dashboard')->withMessage('Confirmation email has been sent to <strong>'.$email.'</strong>.');
    }

    /**
     * Follow a user.
     *
     * @return view
     */
    public function follow($username)
    {
        if (Auth::guest()) {
            return Response::json([
                'status'	=> 'fail',
                'msg'		  => 'Please login to follow '.$username,
            ]);
        }

        $user = User::where('username', $username)->firstOrFail();
        $followers = $user->followers()->lists('followerid');

        if ($user->id == Auth::user()->id) {
            return Response::json([
                'status'	=> 'fail',
                'msg'		  => 'You can\'t follow yourself lol...',
            ]);
        }

        if (!in_array(Auth::user()->id, $followers)) {
            $user->followers()->attach(Auth::user()->id);

            return Response::json([
                'status' 	=> 'success',
                'msg'		   => 'You are now following '.$user->username,
            ]);
        }
        $user->followers()->detach(Auth::user()->id);

        return Response::json([
            'status'		=> 'warn',
            'msg'			  => 'You have unfollowed '.$user->username,
        ]);
    }

    /**
     * Display followers of a user.
     *
     * @return
     */
    public function followers($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return View::make('users.followers')->withUser($user);
    }
}
