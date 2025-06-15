<?php

namespace Modules\DataSale\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Modules\DataSale\Models\DataSale;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GetDataSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nolate:datasales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Data Sales from Nolate API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $token = config('datasale.sales_api.token');
        $baseUrl = config('datasale.sales_api.base_url');
    
        $response = Http::withHeaders(['token' => $token])->get($baseUrl.'/api/sales');
    
        if($response->successful()) {
            $sales_list = $response->json();
    
            if(isset($sales_list['data']) && is_array($sales_list['data'])) {
                foreach($sales_list['data'] as $sales){
                    DataSale::updateOrCreate(
                        ['id' => $sales['id']], 
                        [
                            'name' => $sales['first_name'] . ' ' . $sales['last_name'], 
                            'address' => $sales['address'], 
                            'phone' => $sales['contact_no'], 
                            'created_at' => $sales['created_at'], 
                            'updated_at' => $sales['updated_at']
                        ]
                    );
                }
            }
        } 
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
