<?php

namespace App\Http\Resources\ASanchez85\Roles;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($roles){
                return [
                    'name'          => $roles->name,
                    'slug'          => $roles->slug,
                    'description'   => $roles->description,
                    'special'       => $roles->special,
                    'created_at'    => $roles->created_at,
                    'updated_at'    => $roles->updated_at,
                    'created_at'    => $roles->created_at->format('d-M-Y'),
                    'updated_at'    => $roles->updated_at->format('d-M-Y'),
                ];
            })
        ];
    }
}
