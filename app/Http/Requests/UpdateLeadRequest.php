<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\ValidatesLeadFields;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadRequest extends FormRequest
{
    use ValidatesLeadFields;

    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('lead'));
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->leadRules();
    }
}
