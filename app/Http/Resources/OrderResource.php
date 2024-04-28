<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'contact_name' => $this->contact_name,
            'contact_phone' => $this->contact_phone,
            'start_rent_date' => $this->start_rent_date,
            'total_rent_days' => $this->total_rent_days,
            'bus_id' => $this->bus_id,
            'driver_id' => $this->driver_id,
            'bus' => new BusResource($this->bus),
            'driver' => new BusResource($this->driver)
        ];
    }
}
