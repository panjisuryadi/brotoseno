<?php

namespace Modules\GoldCategory\Console\Commands;

use Illuminate\Console\Command;

class GoldCategoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GoldCategoryCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'GoldCategory Command description';

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
