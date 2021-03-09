<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class AddProductsRequest extends FormRequest
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
            'cartKey' => 'required',
            'productID' => 'required',
            'quantity' => 'required|numeric|min:1|max:10',
        ];
    }

    public function messages()
    {
        return [
            'cartKey.required' => 'مفتاح التعريف للسلة إلزامي',
            'productID.required' => 'رمز تعريف المنتج إلزامي',
            'quantity.required' => 'لابد من تحديد كمية',
            'quantity.numeric' => 'يتكون حقل الكمية من أرقام فقط',
            'quantity.min' => 'أقل كمية هي 1',
            'quantity.max' => 'أقصى كمية هي 10',
        ];
    }
}
