<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreFileTest extends TestCase
{
    const TEST_FILES_PATH = __DIR__ . '/tmp_test_files';
    const COMMAND = 'my:store-file';

    public function setup(): void
    {
        parent::setUp();
        Log::spy();
    }

    /**
     * @return void
     */
    public function test_正常なファイルが保存されること()
    {     
        $str = 'this is a safe test file.';
        $tmp = tempnam(self::TEST_FILES_PATH, 'safe');
        file_put_contents($tmp, $str);

        Storage::shouldReceive('putFile')
            ->once()
            ->with('safe_files', $tmp);

        $this->artisan(self::COMMAND, [
            'file_path' => $tmp,
        ])->assertExitCode(0);

        unlink($tmp); // ファイルの削除
    }

    /**
     * @return void
     */
    public function test_不正なファイルが検出されること()
    {
        // 全文字列を記載すると、GitHub に怒られるので、分割する
        $str1 = 'X5O!P%@AP[4\PZX54(P^)7CC)7}$EICAR';
        $str2 = '-STANDARD-ANTIVIRUS-TEST-FILE!$H+H*';
        $tmp = tempnam('/tmp', 'unsafe');
        file_put_contents($tmp, $str1.$str2);

        Storage::shouldReceive('putFile')
            ->never();

        $this->artisan(self::COMMAND, [
            'file_path' => $tmp,
        ])->assertExitCode(1);

        unlink($tmp); // ファイルの削除
    }
}
