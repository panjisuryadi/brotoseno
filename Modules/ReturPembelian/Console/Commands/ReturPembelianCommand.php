<?php

namespace Modules\ReturPembelian\Console\Commands;

use Illuminate\Console\Command;

class ReturPembelianCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ReturPembelianCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ReturPembelian Command description';

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
