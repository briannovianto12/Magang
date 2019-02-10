<?php

namespace Bromo\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MsisdnPost extends FormRequest
{
    public function rules()
    {
        return [
            'msisdn' => 'required|min:11|max:13',
        ];
    }

    public function messages()
    {
        return [
            'required' => trans('theme::validation.msisdn.required'),
            'min' => trans('theme::validation.msisdn.minlength'),
            'max' => trans('theme::validation.msisdn.maxlength')
        ];
    }
}