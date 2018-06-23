<?php

namespace SMG\Storage\Repositories;

use Illuminate\Support\ServiceProvider;

class PhotoStorageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('SMG\Storage\Repositories\StorageRepositoryInterface', 'SMG\Storage\Repositories\DiskStorageRepository');
    }
}
