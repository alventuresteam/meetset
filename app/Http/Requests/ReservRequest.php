<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservRequest extends FormRequest
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
            'start_date' => ['required','date_format:Y-m-d'],
            'start_time' => ['required','date_format:H:i'],
            'end_time' => ['required','date_format:H:i'],
            'room_id' =>  ['required','exists:rooms,id'],
            'organizer_name' => ['required','max:255'],
            'emails' => ['required','array'],
            'emails.*' => ['email'],
            'title' => ['required','max:255'],
            'comment' => ['string','nullable'],
        ];
    }
}
