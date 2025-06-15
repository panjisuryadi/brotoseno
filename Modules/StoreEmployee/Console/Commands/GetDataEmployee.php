<?php

namespace Modules\StoreEmployee\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Modules\Cabang\Models\Cabang;
use Modules\StoreEmployee\Models\StoreEmployee;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GetDataEmployee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nolate:employee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Data Employee from Nolate API';

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
        $token = config('storeemployee.employee_api.token');
        $baseUrl = config('storeemployee.employee_api.base_url');
    
        $departmentIds = Cabang::where(function($query){ $query->where('name','like','%simpur%')->orWhere('name','like','%pasar tugu%'); })->pluck('id')->toArray();

        $queryParameters = [
            'department_ids' => $departmentIds,
        ];

        $response = Http::withHeaders(['token' => $token])->get($baseUrl.'/api/employees', $queryParameters);
    
        if($response->successful()) {
            $employee_list = $response->json();
    
            if(isset($employee_list['data']) && is_array($employee_list['data'])) {
                foreach($employee_list['data'] as $employee){
                    StoreEmployee::updateOrCreate(
                        ['id' => $employee['id']], 
                        [
                            'name' => $employee['first_name'] . ' ' . $employee['last_name'], 
                            'cabang_id' => $employee['department_id'], 
                            'created_at' => $employee['created_at'], 
                            'updated_at' => $employee['updated_at']
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
