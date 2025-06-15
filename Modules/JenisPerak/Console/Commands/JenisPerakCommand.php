<?php

namespace Modules\JenisPerak\Console\Commands;

use Illuminate\Console\Command;

class JenisPerakCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:JenisPerakCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'JenisPerak Command description';

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
