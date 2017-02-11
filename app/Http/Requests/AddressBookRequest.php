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
            'id' => 'numeric',
            'name_kana' => 'required',
            'name' => 'required',
            'tel1' => 'required|numeric',
            'tel2' => 'numeric',
            'tel3' => 'numeric',
            'email' => 'email',
        ];
    }

    // カスタムメッセージを設定
    public function messages() {
        return [
            'name.required' => '名前は必ず入力して下さい。',
            'name_kana.required' => '名前(カナ)は必ず入力して下さい。',
            'tel1.required' => '電話番号1は必ず入力して下さい。',
            'tel1.numeric' => '電話番号1は半角数字で入力してください。',
            'tel2.numeric' => '電話番号2は半角数字で入力してください。',
            'tel3.numeric' => '電話番号3は半角数字で入力してください。',
            'email.email' => 'メールアドレスはメールアドレスの形式で入力してください。',
        ];
    }

}
