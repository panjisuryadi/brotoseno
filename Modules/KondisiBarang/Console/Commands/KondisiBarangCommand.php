<?php

namespace Modules\KondisiBarang\Console\Commands;

use Illuminate\Console\Command;

class KondisiBarangCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:KondisiBarangCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'KondisiBarang Command description';

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
