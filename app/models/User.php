<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\UserInterface;
use SMG\Model\SMGModel;

class User extends SMGModel implements UserInterface, RemindableInterface
{
    public $autoPurgeRedundantAttributes = true;
    public static $passwordAttributes = ['password'];
    public $autoHashPasswordAttributes = true;
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = array('password');

    protected $fillable = [
        'password_confirmation',
        'password',
        'country',
        'website',
        'facebook',
        'twitter',
        'fullname',
        'specialty',
        'country',
        'showfullname',
        'show_location',
        'email_notification_comment',
        'email_notification_pm',
        'email_notification_like',
    ];

    protected $guarded = ['id', 'password', 'isstaff'];

    public static $rules = [
      'username'                   => 'required|between:3,20|unique:users|alpha_dash',
      'email'                      => 'required|email|unique:users',
      'fullname'                   => 'between:5,50',
      'country'                    => 'between:3,50',
      'specialty'                  => 'in:Armor,Aircraft,Warships,Diorama,Landscapes,Railroad,Automotive,Sci-Fi Miniatures,Wargaming,Toy Modeling',
      'website'                    => 'url',
      'facebook'                   => 'url',
      'twitter'                    => 'url',
      'showfullname'               => 'in:1,0',
      'show_location'              => 'in:1,0',
      'email_notification_comment' => 'in:1,0',
      'email_notification_like'    => 'in:1,0',
      'email_notification_pm'      => 'in:1,0',

    ];

    /*  public function beforeSave() {
        // if there's a new password, hash it
        if($this->isDirty('password')) {
          $this->password = Hash::make($this->password);
        }

        return true;
        //or don't return nothing, since only a boolean false will halt the operation
      }
      */

    public function projects()
    {
        return $this->hasMany('Project');
    }

    public function photos()
    {
        return $this->hasMany('Photo');
    }

    public function follow()
    {
        return $this->belongsToMany('User', 'user_follows', 'followerid', 'userid');
    }

    public function followers()
    {
        return $this->belongsToMany('User', 'user_follows', 'userid', 'followerid');
    }

    public function collections()
    {
        return $this->hasMany('Collection');
    }

    public function likes()
    {
        return $this->belongsToMany('Photo', 'likes', 'user_id', 'photo_id');
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public function iFollow($user_id)
    {
        if (Auth::guest()) {
            return false;
        }

        $following = Auth::user()->follow()->lists('userid');
        if (in_array($user_id, $following)) {
            return true;
        }

        return false;
    }

    public function getUploads()
    {
        return $this->photos()->getQuery()->orderBy('created_at', 'DESC')->get();
    }

    private function uploadProfilePic($photo, $filename)
    {

    //	Storage::save($photo);
        $dir = public_path().'/uploads/user_assets/'.$filename;
        if (!file_exists($dir)) {
            mkdir($dir);
        }

        //conver to jpg
        Image::make($photo->getRealPath())->save($dir.'/original.jpg', 100);

        $imageinfo = getimagesize($photo->getRealPath());
        $width = $imageinfo[0];
        $height = $imageinfo[1];
        $crop = ($width < $height) ? $width : $height;

        Image::make($photo->getRealPath())->crop($crop, $crop)->resize(40, 40)->save($dir.'/40x40.jpg', 100);
    }

    private function deleteProfilePic()
    {
        $dirPath = public_path().'/uploads/user_assets/'.$this->profile_picture_name;

        if (is_dir($dirPath)) {
            if ($handle = opendir($dirPath)) {

                /* This is the correct way to loop over the directory. */
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != '.' and $entry != '..') {
                        unlink($dirPath.'/'.$entry);
                    }
                }
            }
            rmdir($dirPath);
        }
    }

    public function updateProfilePic($photo)
    {
        if (!empty($this->profile_picture_name)) {
            $this->deleteProfilePic();
        }

        $filename = str_random(20).'_'.$this->id;
        $this->uploadProfilePic($photo, $filename);

        $this->profile_picture_ext = $photo->getClientOriginalExtension();
        $this->profile_picture_filename = $photo->getClientOriginalName();
        $this->profile_picture_size = $photo->getSize();
        $this->profile_picture_name = $filename;
    }

    public function getProfilePic($size = 'original')
    {
        if ($this->id != 0 or $this->id != null) {
            if (!empty($this->profile_picture_name)) {

                //return  "http://smg.com/uploads/user_photos/" . $this->profile_picture_name . "/" . $size . ".jpg";
                return Storage::getPhoto($this->profile_picture_name, $size);
            } else {
                return '/img/avatar/1.png';
            }
        } else {
            return false;
        }
    }
}
