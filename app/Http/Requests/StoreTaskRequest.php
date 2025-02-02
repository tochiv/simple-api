<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tasks' => 'required|array|min:1',
            'tasks.*.name' => 'required|string|max:255|unique:tasks,name',
            'tasks.*.count' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'tasks.required' => 'Список задач обязателен.',
            'tasks.array' => 'Поле tasks должно быть массивом.',
            'tasks.min' => 'Необходимо передать хотя бы одну задачу.',

            'tasks.*.name.required' => 'Название задачи обязательно.',
            'tasks.*.name.string' => 'Название должно быть строкой.',
            'tasks.*.name.max' => 'Название не должно превышать 255 символов.',
            'tasks.*.name.unique' => 'Название задачи уже существует.',

            'tasks.*.count.required' => 'Количество задач обязательно.',
            'tasks.*.count.integer' => 'Количество должно быть числом.',
            'tasks.*.count.min' => 'Минимальное количество задач — 1.',
        ];
    }
}
