<?php

namespace Modules\DataSale\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DataSalesResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'target' => $this->target,
            'insentif' => DataSalesInsentifResource::collection($this->insentif)
        ];
    }
}
