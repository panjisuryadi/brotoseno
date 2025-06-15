<?php

namespace Modules\PenerimaanBarangDP\Console\Commands;

use Illuminate\Console\Command;

class PenerimaanBarangDPCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PenerimaanBarangDPCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PenerimaanBarangDP Command description';

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
