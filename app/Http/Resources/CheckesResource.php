<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CheckesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
        [
            'id' => $this[0]['id'],
            'user_id' => $this[0]['user_id'],
            'mall_id' => $this[0]['mall_id'],
            'bonus_id' => $this[0]['bonus_id'],
            'check_sum' => $this[0]['check_sum'],
            'status' => $this[0]['status'],
            'check_data_end' => $this[0]['check_data_end'],
            'check_data_start' => $this[0]['check_data'],
            'created_at' => $this[0]['created_at'],
            'updated_at' => $this[0]['updated_at'],
            ];
    }
}
