<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'name' => 'required',
            'adress' => 'required',
            'credit_card_number' => 'required',
            'expiration_year' => 'required',
            'expiration_month' => 'required',
            'cvc' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cartKey.required' => 'مفتاح التعريف للسلة مطلوب',
            'name.required' => 'إسم حامل البطاقة مطلوب',
            'credit_card_number.required' => 'رقم البطاقة مطلوب',
            'expiration_year.required' => 'سنة إنتهاء البطاقة مطلوب',
            'expiration_month.required' => 'شهر إنتهاء البطاقة مطلوب',
            'cvc.required' => 'رقم الأمان الخاص بالبطاقة مطلوب',
        ];
    }
}
