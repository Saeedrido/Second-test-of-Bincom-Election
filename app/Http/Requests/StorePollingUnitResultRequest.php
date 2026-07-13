<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePollingUnitResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'state_id' => 'required|integer|exists:states,state_id',
            'lga_id' => 'required|integer|exists:lga,uniqueid',
            'ward_id' => 'required|integer|exists:ward,uniqueid',
            'polling_unit_uniqueid' => 'required|integer|exists:polling_unit,uniqueid',
            'results' => 'required|array|min:1',
            'results.*.party_abbreviation' => 'required|string|max:50|exists:party,partyid',
            'results.*.party_score' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'state_id.required' => 'Please select a state.',
            'state_id.exists' => 'The selected state is invalid.',
            'lga_id.required' => 'Please select a Local Government Area.',
            'lga_id.exists' => 'The selected LGA is invalid.',
            'ward_id.required' => 'Please select a ward.',
            'ward_id.exists' => 'The selected ward is invalid.',
            'polling_unit_uniqueid.required' => 'Please select a polling unit.',
            'polling_unit_uniqueid.exists' => 'The selected polling unit is invalid.',
            'results.required' => 'Please provide results for at least one party.',
            'results.min' => 'Please provide results for at least one party.',
            'results.*.party_abbreviation.required' => 'Party abbreviation is required for each entry.',
            'results.*.party_score.required' => 'Party score is required for each entry.',
            'results.*.party_score.integer' => 'Party score must be a whole number.',
            'results.*.party_score.min' => 'Party score cannot be negative.',
        ];
    }
}
