<?php

namespace App\Http\Resources\ASanchez85\Roles;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'slug'          => $this->slug,
            'description'   => $this->description,
            'special'       => $this->special,
            'created_at'    => $this->created_at->format('d-M-Y'),
            'updated_at'    => $this->updated_at->format('d-M-Y'),
            'permissions'   => (is_null($this->permissions)) ? null : $this->permissions,
        ];
    }
}
