<?php

namespace App\Http\Requests\ASanchez85\Roles;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|string|max:255',
            'slug'          => 'required|string|unique:roles,slug,' . $this->role,
            'description'   => 'required|string|max:500',
            'permissions'   => 'required|array',
        ];
    }
}
