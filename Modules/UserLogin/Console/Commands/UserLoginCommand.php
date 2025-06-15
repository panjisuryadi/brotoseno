<?php

namespace Modules\UserLogin\Console\Commands;

use Illuminate\Console\Command;

class UserLoginCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UserLoginCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'UserLogin Command description';

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
