<?php

namespace Modules\PenerimaanBarangLuar\Console\Commands;

use Illuminate\Console\Command;

class PenerimaanBarangLuarCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PenerimaanBarangLuarCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PenerimaanBarangLuar Command description';

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
