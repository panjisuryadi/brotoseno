<?php

namespace Modules\ProdukModel\Console\Commands;

use Illuminate\Console\Command;

class ProdukModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ProdukModelCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ProdukModel Command description';

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
