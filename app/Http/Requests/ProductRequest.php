<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => ['string', 'required'],
            'quantity' => ['numeric', 'required'],
            'price'=> ['required', 'string']
        ];
    }
}
