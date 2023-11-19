<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('rooms','name')->ignore($this->id, 'id'), 'max:255'],
            'capacity' => ['required','int'],
            'address' => ['required','max:255'],
            'floor' => ['required','int', 'min:1','max:25'],
            'image' => ['sometimes']
        ];
    }
}
