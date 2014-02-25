<?php namespace SMG\Storage;

use SMG\Exceptions\StorageException;
use SMG\Storage\Repositories\StorageRepositoryInterface as StorageRepoInterface;

class StorageService {
	
	protected $storageRepo;
	protected $allowed_types = array('image/jpeg','image/gif','image/png'); //allowed mime types
	protected $max_size = 5242880; // max file size
	protected $max_long = 3000; //max dimension of long edge

	function __construct(StorageRepoInterface $storageRepo)
	{

		$this->storageRepo = $storageRepo;
	}

	public function save($inputfile, $profilepic = false) {

		$imageinfo = getimagesize($inputfile->getRealPath());
		$type = $imageinfo['mime'];
		$width = $imageinfo[0];
		$height = $imageinfo[1];

		$file_path = str_random(20);

		if($profilepic)
			$file_path .= "_" . $profilepic;


		if($inputfile->getSize() > $this->max_size)
			return false;	
		

		if(!in_array(strtolower($type), $this->allowed_types)) 
			return false;
		
		if($width > $this->max_long OR $height > $this->max_long)
			return false;

		if(!$this->storageRepo->save($inputfile, $file_path))
			return false;

		return $file_path;
		
	}

	//creates a photo, specified by size using original.jpg
	public function createPhoto($file_path, $dimensions) {

		return $this->storageRepo->createPhoto($file_path, $dimensions);
	}

	public function delete($file_path) {

		return $this->storageRepo->delete($file_path);
	}

	public function getPhoto($file_path, $file_name = "original") {

		return $this->storageRepo->getPhoto($file_path, $file_name);
	}
}