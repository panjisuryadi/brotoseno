<?php

namespace Modules\Produksi\Console\Commands;

use Illuminate\Console\Command;

class ProduksiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ProduksiCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Produksi Command description';

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
