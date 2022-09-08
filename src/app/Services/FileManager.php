<?php

namespace App\Services;

use Appwrite\ClamAV\Network;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileManager
{
    public function __construct(
        private Network $network,
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
        $fileName = basename($filePath);
        Storage::disk('shared_volume')->put("${fileName}", );

        Log::info("ping => " . ($this->network->ping() ? "pong" : "no reply"));

        return $this->network->fileScan('/shared_volume/' . $fileName);
    }
}
