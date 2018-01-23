<?php

namespace Xzxzyzyz\ConohaAPI\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailStoreRequest extends FormRequest
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
        // @see https://www.conoha.jp/docs/paas-mail-create-email.html ※パスワードについて
        return [
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*?[!#$%&?=+\-_\{\}\[\]^~:;\(\).,\/|\\*@])[a-zA-Z0-9!#$%&?=+\-_\{\}\[\]^~:;\(\).,\/|\\*@]*$/',
                'between:8,100'
            ]
        ];
    }
}
