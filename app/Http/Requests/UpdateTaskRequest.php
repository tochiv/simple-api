<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'name' => 'required|string|max:255',
            'count' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages() : array
    {
        return [
            'name.required' => 'Название задачи обязательно.',
            'name.string' => 'Название должно быть строкой.',
            'name.max' => 'Название не должно превышать 255 символов.',
            'name.unique' => 'Название задачи уже существует.',

            'count.required' => 'Количество задач обязательно.',
            'count.integer' => 'Количество должно быть числом.',
            'count.min' => 'Минимальное количество задач — 1.',
        ];
    }
}
