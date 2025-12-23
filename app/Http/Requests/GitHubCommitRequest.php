<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GitHubCommitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'since' => ['nullable', 'date_format:Y-m-d'],
            'until' => ['nullable', 'date_format:Y-m-d'],
        ];
    }

    public function messages(): array
    {
        return [
            'since.date' => 'The "since" parameter must be a valid date.',
            'until.date' => 'The "until" parameter must be a valid date.',
        ];
    }

    public function validatedData(): array
    {
        return [
            'since' => $this->input('since'),
            'until' => $this->input('until'),
        ];
    }
}
