<?php

namespace Modules\KeluarMasuk\Console\Commands;

use Illuminate\Console\Command;

class KeluarMasukCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:KeluarMasukCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'KeluarMasuk Command description';

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
