<?php

namespace Modules\Accessory\Console\Commands;

use Illuminate\Console\Command;

class AccessoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:AccessoryCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Accessory Command description';

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
