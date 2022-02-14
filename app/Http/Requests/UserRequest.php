<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'role_id' =>['numeric','required'],
            'royalty_points'=>['numeric'],
            'is_member' =>['boolean']
        ];
    }
}
