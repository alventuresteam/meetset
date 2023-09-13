<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $contacts = $this->contacts ? $this->contacts->map((fn($item) => [
            'name' => $item->name,
            'surname' => $item->surname,
            'email' => $item->email,
        ])) : null;
        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'organizer_name' => $this->organizer_name,
            'emails' => $this->emails,
            'title' => $this->title,
            'contacts' => $contacts
        ];
    }
}
