<?php

namespace Modules\KodeTransaksi\Console\Commands;

use Illuminate\Console\Command;

class KodeTransaksiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:KodeTransaksiCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'KodeTransaksi Command description';

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
