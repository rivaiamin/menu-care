<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'answers' => ['required', 'array', 'size:10'],
            'answers.1' => ['required', 'integer', Rule::in([0, 1, 2, 3, 4])],
            'answers.2' => ['required', 'integer', Rule::in([0, 1, 2, 3, 4])],
            'answers.3' => ['required', 'integer', Rule::in([0, 1, 2, 3, 4])],
            'answers.4' => ['required', 'integer', Rule::in([0, 1, 2, 3, 4])],
            'answers.5' => ['required', 'integer', Rule::in([0, 1, 2, 3, 4])],
            'answers.6' => ['required', 'integer', Rule::in([0, 1, 2, 3, 4])],
            'answers.7' => ['required', 'integer', Rule::in([0, 1, 2, 3, 4])],
            'answers.8' => ['required', 'integer', Rule::in([0, 1, 2, 3, 4])],
            'answers.9' => ['required', 'integer', Rule::in([0, 1, 2, 3, 4])],
            'answers.10' => ['required', 'integer', Rule::in([0, 1, 2, 3, 4])],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'answers.required' => 'Anda harus menjawab semua pertanyaan.',
            'answers.size' => 'Anda harus menjawab semua 10 pertanyaan.',
            'answers.*.required' => 'Pertanyaan ini harus dijawab.',
            'answers.*.integer' => 'Jawaban harus berupa angka.',
            'answers.*.in' => 'Jawaban tidak valid. Pilih antara 0-4.',
        ];
    }
}

