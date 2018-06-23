<?php

namespace SMG\Model;

use LaravelBook\Ardent\Ardent;

abstract class SMGModel extends Ardent
{
    //checks if the item being fetched is owned by the logged in user
    public function isMine()
    {
        if (\Auth::guest()) {
            return false;
        }

        //check the class, if its a User class we just need to check the id otherwise it'll be user_id
        if (get_class($this) == 'User') {
            $userid = $this->id;
        } else {
            $userid = $this->user_id;
        }

        if (\Auth::user()->id == $userid) {
            return true;
        }

        return false;
    }

    public function scopeGetMine($query)
    {
        if (\Auth::guest()) {
            return false;
        }

        return $query->where('user_id', \Auth::user()->id);
    }
}
