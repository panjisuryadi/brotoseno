<?php

namespace Modules\JenisPerhiasan\Console\Commands;

use Illuminate\Console\Command;

class JenisPerhiasanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:JenisPerhiasanCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'JenisPerhiasan Command description';

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
