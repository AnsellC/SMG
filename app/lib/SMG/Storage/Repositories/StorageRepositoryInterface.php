<?php

namespace SMG\Storage\Repositories;

interface StorageRepositoryInterface
{
    public function save($inputfile, $file_path);
}
