<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => ['string', 'required'],
            'activated' => ['boolean'],
            'value'=> ['required', 'numeric']
        ];
    }
}
