<?php

namespace App\Http\FormValidations\Auth;

use App\Http\FormValidations\FormValidation;

class LoginFormValidation extends FormValidation
{
    /**
     * Rules for user login
     * @return string[] [Array]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }
}
