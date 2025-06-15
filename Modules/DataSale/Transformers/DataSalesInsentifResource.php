<?php

namespace Modules\DataSale\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DataSalesInsentifResource extends JsonResource
{
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'nominal' => $this->nominal,
            'periode' => $this->date
        ];
    }
}
