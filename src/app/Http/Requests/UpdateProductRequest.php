<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => ['required','mimes:png,jpeg'],
            'season_id' => 'nullable|exists:seasons,id', 
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください。',
            'description.required' => '商品説明を入力してください。',
            'description.max' => '120文字以内で入力してください。',
            'image.required' => '商品画像を登録してください。',
            'image.mimes' => '画像は「.png」または「.jpeg」形式でアップロードしてください。',
        ];
    }
}
