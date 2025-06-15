<?php

namespace Modules\Cabang\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Modules\Cabang\Models\Cabang;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GetDataCabang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nolate:cabang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Data Cabang from Nolate API';

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
        $token = config('cabang.cabang_api.token');
        $baseUrl = config('cabang.cabang_api.base_url');
    
        $response = Http::withHeaders(['token' => $token])->get($baseUrl.'/api/departments',['ids'=>[2,3]]);
    
        if($response->successful()) {
            $cabang_list = $response->json();
    
            if(isset($cabang_list['data']) && is_array($cabang_list['data'])) {
                foreach($cabang_list['data'] as $cabang){
                    Cabang::updateOrCreate(
                        ['id' => $cabang['id']], 
                        [
                            'name' => $cabang['department_name'], 
                            'created_at' => $cabang['created_at'], 
                            'updated_at' => $cabang['updated_at']
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
