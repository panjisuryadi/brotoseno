<?php

namespace Modules\KaratBerlian\Console\Commands;

use Illuminate\Console\Command;

class KaratBerlianCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:KaratBerlianCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'KaratBerlian Command description';

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
