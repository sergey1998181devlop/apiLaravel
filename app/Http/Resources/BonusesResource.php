<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BonusesResource extends JsonResource
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
            'id' => $this[0]['id'],
            'bonus_transaction' => $this[0]['bonus_transaction'],
            'bonus_date' => $this[0]['bonus_date'],
            'bonus_id' => $this[0]['bonus_id'],
            'bonus_type' => $this[0]['bonus_type'],
            'user_id' => $this[0]['user_id'],
            'bonus_description' => $this[0]['bonus_description'],
            'payment_status' => $this[0]['payment_status'],
         ];
    }
}
