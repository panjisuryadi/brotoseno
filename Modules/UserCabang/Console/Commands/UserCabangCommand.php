<?php

namespace Modules\UserCabang\Console\Commands;

use Illuminate\Console\Command;

class UserCabangCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UserCabangCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'UserCabang Command description';

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
