<?php

namespace App\Http\Requests;

use App\Entities\Enum\SortParameters\ProductParameters;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
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
            'category_id' => 'integer',
            'name' => 'string',
            'price' => 'integer',
            'limit' => 'nullable',
            'page' => 'nullable',
            'sort' => [Rule::enum(ProductParameters::class)],
        ];
    }
    public function messages(): array
    {
        return [
            'category_id.integer' => 'Параметр сортировки должен быть числом',
            'name.string' => 'Параметр сортировки должен быть строкой',
            'price.integer' => 'Параметр сортировки должен быть числом',
            'sort' => 'Неверный параметр для сортировки',

        ];
    }

    public function getLimit()
    {
        return $this->input('limit') ?? 10;
    }
    public function getPage()
    {
        return $this->input('page') ?? 1;
    }

}

