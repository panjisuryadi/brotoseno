<?php

namespace Modules\PenentuanHarga\Console\Commands;

use Illuminate\Console\Command;

class PenentuanHargaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PenentuanHargaCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PenentuanHarga Command description';

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
