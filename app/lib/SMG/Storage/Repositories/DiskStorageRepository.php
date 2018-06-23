<?php

namespace SMG\Storage\Repositories;

class DiskStorageRepository implements StorageRepositoryInterface
{
    protected $uploads_path; //directory to save to
    protected $url_path;
    public $errormsg;

    public function __construct()
    {
        $this->uploads_path = public_path().'/uploads/user_assets';
        $this->url_path = '/uploads/user_assets';
    }

    public function save($inputfile, $file_path)
    {
        if (!file_exists($this->uploads_path.'/'.$file_path)) {
            mkdir($this->uploads_path.'/'.$file_path);
        }

        try {
            \Image::make($inputfile->getRealPath())->save($this->uploads_path.'/'.$file_path.'/original.jpg', 100);
        } catch (ImageNotWritableException $e) {
            return false;
        }

        return true;
    }

    public function delete($file_path)
    {
        $dirPath = $this->uploads_path.'/'.$file_path;

        if (file_exists($dirPath)) {
            if ($handle = opendir($dirPath)) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != '.' and $entry != '..') {
                        unlink($dirPath.'/'.$entry);
                    }
                }
            }
            rmdir($dirPath);
        }
    }

    public function createPhoto($file_path, $dimensions)
    {

        //
        return $this->getPhoto($file_path, $dimensions);
    }

    public function getPhoto($file_path, $file_name)
    {

        //check if file exists
        if (file_exists($this->uploads_path.'/'.$file_path.'/'.$file_name.'.jpg')) {
            return $this->url_path.'/'.$file_path.'/'.$file_name.'.jpg';
        }

        //if we came to this point, original.jpg doesnt exist
        if ($file_name == 'original') {
            \Log::warning($file_path.'/'.$file_name.".jpg doesn't exist.");
            die($file_path.'/'.$file_name.".jpg doesn't exist.");
        }

        //if file doesnt exist, create a new one based from original.jpg
        //check if file_name is a dimension

        //return WxH
        if (preg_match('/([0-9]+)x([0-9]+)/i', $file_name, $matches)) {
            if (!empty($matches[1])) {
                $width = $matches[1];
            } else {
                $width = null;
            }
            if (!empty($matches[2])) {
                $height = $matches[2];
            } else {
                $height = null;
            }
            if ($width == null or $height == null) {
                return false;
            }

            $imageinfo = getimagesize($this->uploads_path.'/'.$file_path.'/original.jpg');
            $image_width = $imageinfo[0];
            $image_height = $imageinfo[1];
            //if image is a square, crop it

            if ($width == $height) {

                //crop by shortest side
                $crop = ($image_width < $image_height) ? $image_width : $image_height;

                \Image::make($this->uploads_path.'/'.$file_path.'/original.jpg')->crop($crop, $crop)->resize($width, $height)->save($this->uploads_path.'/'.$file_path.'/'.$width.'x'.$height.'.jpg', 100);
            } else {
                //take shortest side
                $bywidth = ($image_width < $image_height) ? true : false;

                if (!$bywidth) {
                    \Image::make($this->uploads_path.'/'.$file_path.'/original.jpg')->resize($width, null, true)->crop($width, $height)->save($this->uploads_path.'/'.$file_path.'/'.$width.'x'.$height.'.jpg', 100);
                } else {
                    \Image::make($this->uploads_path.'/'.$file_path.'/original.jpg')->resize(null, $height, true)->crop($width, $height)->save($this->uploads_path.'/'.$file_path.'/'.$width.'x'.$height.'.jpg', 100);
                }
            }

            return $this->url_path.'/'.$file_path.'/'.$file_name.'.jpg';
        } elseif (preg_match('/(w|h)([0-9]+)/i', $file_name, $matches)) {
            $dimension = $matches[2];
            if (empty($dimension)) {
                return false;
            }

            $method = $matches[1];
            if (empty($method)) {
                return false;
            }

            if ($method == 'w') {
                \Image::make($this->uploads_path.'/'.$file_path.'/original.jpg')->resize($dimension, null, true)->save($this->uploads_path.'/'.$file_path.'/w'.$dimension.'.jpg', 100);

                return $this->url_path.'/'.$file_path.'/w'.$dimension.'.jpg';
            }

            if ($method == 'h') {
                \Image::make($this->uploads_path.'/'.$file_path.'/original.jpg')->resize(null, $dimension, true)->save($this->uploads_path.'/'.$file_path.'/h'.$dimension.'.jpg', 100);

                return $this->url_path.'/'.$file_path.'/h'.$dimension.'.jpg';
            }
        }
    }
}
