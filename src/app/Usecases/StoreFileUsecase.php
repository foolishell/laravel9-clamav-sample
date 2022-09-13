<?php

namespace App\Usecases;

use App\Exceptions\UnsafeFileDetectedException;
use App\Services\FileManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StoreFileUsecase
{
    public function __construct(
        private FileManager $fileManager,
    ) {
    }

    public function exec(string $filePath)
    {
        if (!$this->fileManager->isSecureFile($filePath)) {
            throw new UnsafeFileDetectedException($filePath);
        }

        $storage = Storage::putFile('safe_files', $filePath);
        Log::info($storage);
    }
}
