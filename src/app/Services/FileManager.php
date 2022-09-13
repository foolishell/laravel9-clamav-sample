<?php

namespace App\Services;

use App\Exceptions\ClamavLostConnectionException;
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
        try {
            $this->scanner->ping();
        } catch (\RuntimeException $e) {
            throw new ClamavLostConnectionException(
                $e->getMessage(), 
                config('filesystems.securities.clamav.host'), 
                config('filesystems.securities.clamav.port'),
            );
        }
        return $this->scanner->scan($filePath);
    }
}
