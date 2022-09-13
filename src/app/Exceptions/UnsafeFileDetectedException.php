<?php

namespace App\Exceptions;

use RuntimeException;

class UnsafeFileDetectedException extends RuntimeException
{
    public function __construct(
        private string $filePath,
    )
    {
        $this->message = "危険性のあるファイルが検出されました。";
    }
    
    /**
     * 例外のコンテキスト情報を取得
     *
     * @return array
     */
    public function context()
    {
        return [
            'file_path' => $this->host,
        ];
    }
}
