<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
<<<<<<< HEAD
        return false;
=======
        return true;
>>>>>>> repoB/main
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
<<<<<<< HEAD
            //
=======
                'room_id' => ['sometimes', 'required', 'numeric'],
                'guestNumber' => ['sometimes', 'required', 'numeric'],
                'start_date' => ['sometimes', 'required', 'date'],
                'end_date' => ['sometimes', 'required', 'date'],
>>>>>>> repoB/main
        ];
    }
}
