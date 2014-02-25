<?php namespace SMG\Storage;


use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider {
	


	public function register() {


		$this->app->bind('Storage', 'SMG\Storage\StorageService');

		
	}
}