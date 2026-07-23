<?php

namespace App\Http\Requests\Concerns;

use Illuminate\Validation\Rule;

trait ValidatesLeadFields
{
    /**
     * @return array<string, mixed>
     */
    protected function leadRules(): array
    {
        $tenantId = $this->user()->tenant_id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'pipeline_stage_id' => [
                'required',
                Rule::exists('pipeline_stages', 'id')->where('tenant_id', $tenantId),
            ],
            'assigned_user_id' => [
                'nullable',
                Rule::exists('users', 'id')->where('tenant_id', $tenantId),
            ],
            'tags' => ['nullable', 'array'],
            'tags.*' => [
                Rule::exists('tags', 'id')->where('tenant_id', $tenantId),
            ],
        ];
    }
}
