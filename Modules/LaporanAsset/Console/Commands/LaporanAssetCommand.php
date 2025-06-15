<?php

namespace Modules\LaporanAsset\Console\Commands;

use Illuminate\Console\Command;

class LaporanAssetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LaporanAssetCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'LaporanAsset Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
