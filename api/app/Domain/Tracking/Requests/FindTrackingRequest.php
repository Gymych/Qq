<?php

namespace App\Domain\Tracking\Requests;

use App\Domain\Tracking\Models\Tracking;
use App\Support\FormRequest;
use Illuminate\Validation\Rule;

class FindTrackingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tracking_number' => ['required','min:7','max:34', Rule::exists(Tracking::getTableName(), 'tracking_number')]
        ];
    }
}
