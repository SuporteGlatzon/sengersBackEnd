<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        Log::info('Validando ProfileRequest', $this->all());

        if (is_array($this->curriculum)) {
            $this->merge([
                'curriculum' => null
            ]);
        }
    }

    public function rules(): array
    {
        \Illuminate\Support\Facades\Log::info('Validando ProfileRequest', $this->all());

        if ($this->has('curriculum') && is_array($this->file('curriculum'))) {
            $this->merge(['curriculum' => null]);
        }

        return [
            'name' => 'required',
            'cpf' => 'nullable|cpf',
            'link_site' => 'nullable',
            'link_instagram' => 'nullable',
            'link_twitter' => 'nullable',
            'link_linkedin' => 'nullable',
            'senge_associate' => 'nullable|boolean',
            'curriculum' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'banner_profile' => 'nullable|file'
        ];
    }
}
