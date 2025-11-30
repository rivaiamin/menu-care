<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JournalRequest extends FormRequest
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
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string', 'min:10'],
            'mood' => ['required', 'integer', Rule::in([1, 2, 3, 4, 5])],
            'date' => ['nullable', 'date', 'before_or_equal:today'],
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
            'content.required' => 'Konten jurnal harus diisi.',
            'content.min' => 'Konten jurnal minimal harus 10 karakter.',
            'mood.required' => 'Mood harus dipilih.',
            'mood.in' => 'Mood harus antara 1-5.',
            'date.before_or_equal' => 'Tanggal tidak boleh lebih dari hari ini.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Set default date to today if not provided
        if (! $this->has('date')) {
            $this->merge([
                'date' => now()->toDateString(),
            ]);
        }
    }
}

