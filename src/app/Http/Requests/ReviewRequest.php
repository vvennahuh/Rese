<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'rating' => 'required',
            'comment' => 'max:500',
            'image' => 'file|mimes:jpeg,png'//
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => '評価数を選択してください',
            'comment.max' => '500字以内で入力してください',
            'image.file' => '有効なファイルをアップロードしてください',
            'image.mimes' => 'アップロード可能なファイル形式は、jpeg,png のみです'
        ];
    }
}
