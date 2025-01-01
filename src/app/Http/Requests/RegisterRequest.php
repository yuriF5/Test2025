<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required','max:255'],
            'description' => ['required,max:120'],
            'image' => ['required','mimes:png,jpeg'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '季節を選択してください。',
            'description.required' => '商品説明を入力してください。',
            'description.max' => '120文字以内で入力してください。',
            'image.required' => '商品画像を登録してください。',
            'image.mimes' => '画像は「.png」または「.jpeg」形式でアップロードしてください。',
        ];
    }
}
