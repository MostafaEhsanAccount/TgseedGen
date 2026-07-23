<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\ValidatesLeadFields;
use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    use ValidatesLeadFields;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->leadRules();
    }
}
