<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
          'vkontakte_logged_in_at' => $this->vkontakte_logged_in_at,
          'vkontakte_registered_at' => $this->vkontakte_registered_at,
            'google_logged_in_at' => $this->google_logged_in_at,
            'google_registered_at' => $this->google_registered_at,
        ];
    }
}
