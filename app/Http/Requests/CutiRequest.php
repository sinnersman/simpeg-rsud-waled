<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CutiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:today|after_or_equal:start_date',
            'reason' => 'required|string',
            'leave_type' => 'required|string|in:LEAVE_TP_01,LEAVE_TP_02,LEAVE_TP_03,LEAVE_TP_04,LEAVE_TP_05',
        ];
    }
}
