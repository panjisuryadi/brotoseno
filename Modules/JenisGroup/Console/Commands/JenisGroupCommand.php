<?php

namespace Modules\JenisGroup\Console\Commands;

use Illuminate\Console\Command;

class JenisGroupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:JenisGroupCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'JenisGroup Command description';

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
