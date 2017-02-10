<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddressBookRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required',
            'name_kana' => 'required',
            'tel1' => 'required',
        ];
    }

    //カスタムメッセージを設定
    public function messages() {
        return [
        'name.required' => '名前は必ず入力して下さい。',
        'name_kana.required' => '名前(カナ)は必ず入力して下さい。',
        'tel1.required' => '電話番号1は必ず入力して下さい。',
        ];
    }

}
