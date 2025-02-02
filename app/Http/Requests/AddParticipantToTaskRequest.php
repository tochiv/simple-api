<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddParticipantToTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ids' => 'required|array|min:1',
            'ids.*.id' => 'required|integer|exists:participants,id',
        ];
    }

    public function messages(): array
    {
        return [
            'ids.required' => 'Список Ids обязателен.',
            'ids.array' => 'Поле Ids должно быть массивом.',
            'ids.min' => 'Необходимо передать хотя бы одну задачу.',

            'ids.*.id.required' => 'Id обязательно.',
            'ids.*.id.integer' => 'Id должно быть числом.',
        ];
    }
}
