<?php

namespace App\Domain\Tracking\Requests;

use App\Support\FormRequest;

class CreateTrackingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
             'tracking_number' => ['required', 'unique:trackings,tracking_number','min:7','max:34'],
        ];
    }
}
