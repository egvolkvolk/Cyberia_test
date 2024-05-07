<?php

namespace App\Http\Requests;

use App\Entities\Enum\SortParameters\OrderParameters;
use App\Entities\Enum\StatusParameters\Parameters;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderFilterRequest extends FormRequest
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
            'sum' => 'integer',
            'created_at' => 'date',
            'limit' => 'nullable',
            'page' => 'nullable',
            'sort' => [Rule::enum(OrderParameters::class)],
        ];
    }
    public function messages(): array
    {
        return [
            'sum.integer' => 'Параметр сортировки должен быть числом',
            'price.integer' => 'Параметр сортировки должен быть числом',
            'sort' => 'Неверный параметр для сортировки',
            'status' => 'Неверный параметр для фильтрации по полю СТАТУС ЗАКАЗА',

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

