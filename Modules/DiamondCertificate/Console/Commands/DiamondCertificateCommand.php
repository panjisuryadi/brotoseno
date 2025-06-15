<?php

namespace Modules\DiamondCertificate\Console\Commands;

use Illuminate\Console\Command;

class DiamondCertificateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DiamondCertificateCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DiamondCertificate Command description';

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
