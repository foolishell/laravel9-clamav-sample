<?php

namespace App\Services;

use Appwrite\ClamAV\Network;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Niisan\ClamAV\Scanner;
use Niisan\ClamAV\Scanners\RemoteScanner;

class FileManager
{
    public function __construct(
        private Scanner $scanner,
    ) {
    }

    /**
     * 指定のパスのファイルが安全かClamAVを用いて検証する。
     *
     * @param string $filePath ファイルパス
     * @return boolean
     */
    public function isSecureFile(string $filePath)
    {
        return $this->scanner->scan($filePath);
    }
}
