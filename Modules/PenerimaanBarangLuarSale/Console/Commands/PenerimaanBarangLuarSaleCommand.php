<?php

namespace Modules\PenerimaanBarangLuarSale\Console\Commands;

use Illuminate\Console\Command;

class PenerimaanBarangLuarSaleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PenerimaanBarangLuarSaleCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PenerimaanBarangLuarSale Command description';

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
