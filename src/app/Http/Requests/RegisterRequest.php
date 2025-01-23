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
            'name' => 'required|string|max:255', // 商品名
            'price' => 'required|numeric|between:0,10000', // 値段
            'season_id' => 'required|array|min:1', // 季節
            'season_id.*' => 'exists:seasons,id', // 季節IDが正しいことを確認
            'description' => 'required|string|max:120', // 商品説明
            'image' => 'required|image|mimes:jpeg,png|max:2048', // 商品画像
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.between' => '0~10000円以内で入力してください',
            'season_id.required' => '季節を選択してください',
            'season_id.array' => '季節の選択が正しくありません',
            'season_id.min' => '季節を選択してください',
            'season_id.*.exists' => '選択した季節が存在しません',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'image.required' => '商品画像を登録してください',
            'image.image' => '「.png」または「.jpeg」形式でアップロードしてください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'image.max' => '商品画像は2MB以内でアップロードしてください',
        ];
    }
}
