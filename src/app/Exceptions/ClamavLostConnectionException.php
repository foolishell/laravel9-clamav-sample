<?php

namespace App\Exceptions;

use RuntimeException;

class ClamavLostConnectionException extends RuntimeException
{
    public function __construct(
        private string $detail,
        private string $host,
        private int $port,
    )
    {
        $this->message = "ClamAV への接続に失敗しました。";
    }

    /**
     * 例外のコンテキスト情報を取得
     *
     * @return array
     */
    public function context()
    {
        return [
            'detail' => $this->detail,
            'host' => $this->host,
            'port' => $this->port,
        ];
    }
}
