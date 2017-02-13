<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddressBookGroupRequest extends Request {

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
            'type' => 'required',
            'parent_groupid' => 'required',
            'group_name' => 'required',
        ];
    }

    // カスタムメッセージを設定
    public function messages() {
        return [
            'type.required' => '電話帳種別は必ず選択して下さい。',
            'parent_groupid.required' => '親グループは必ず選択して下さい。',
            'group_name.required' => '名前は必ず入力して下さい。',
        ];
    }

}
