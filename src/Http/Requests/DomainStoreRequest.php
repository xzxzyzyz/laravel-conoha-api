<?php

namespace Xzxzyzyz\ConohaAPI\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DomainStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'domain_name' => [
                'required',
                'regex:/^([a-z0-9][a-z0-9_-]*(\.[a-z0-9][a-z0-9-]*)+)$/'
            ]
        ];
    }
}
