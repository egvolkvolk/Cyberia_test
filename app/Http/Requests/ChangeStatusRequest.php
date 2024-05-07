<?php

namespace App\Http\Requests;

use App\Entities\Enum\StatusParameters\Parameters;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeStatusRequest extends FormRequest
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
            'status' => [Rule::enum(Parameters::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'status' => 'Невозможно изменить на введенный статус!'
        ];
    }
}
