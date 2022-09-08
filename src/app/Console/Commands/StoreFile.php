<?php

namespace App\Console\Commands;

use App\Usecases\StoreFileUsecase;
use Illuminate\Console\Command;

class StoreFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'my:store-file {file_path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ファイルをストレージに保存する';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(StoreFileUsecase $usecase)
    {
        $filePath = $this->argument('file_path');
        if (!file_exists($filePath)) {
            $this->error('ファイルが存在しません。');
            return 1;
        }
        
        try {
            $usecase->exec($filePath);
            return 0;
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }
    }
}
