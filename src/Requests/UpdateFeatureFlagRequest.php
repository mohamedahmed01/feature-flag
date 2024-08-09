<?php

namespace Mohamedahmed01\FeatureFlag\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeatureFlagRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'enabled' => 'boolean',
            'audience' => 'nullable|array',
            'percentage' => 'numeric|min:0|max:100',
            'finish_date' => 'nullable|date',
        ];
    }
}
