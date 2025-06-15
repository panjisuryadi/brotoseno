<?php

namespace Modules\KondisiPembelian\Console\Commands;

use Illuminate\Console\Command;

class KondisiPembelianCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:KondisiPembelianCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'KondisiPembelian Command description';

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
