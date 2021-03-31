<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementRequest extends FormRequest
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
            'title' => 'string',
            'image' => 'required|image|mimes:jpg,png',
            'email' => 'string|email',
            'mobile' => 'required',
            'amount' => 'required|numeric',
            'advertis_from' => 'required',
            'advertis_to' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.string' => 'العنوان يتكون من أحرف فقط',
            'image.required' => 'يجب إرفاق صورة للإعلان',
            'image.image' => 'يجب أن يكون المرفق صورة',
            'image.mimes' => 'الصيغ المسموح بها jpg, png',
            'email.required' => 'يجب إضافة البريد الإلكتروني للمعلن',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'mobile.required' => 'يجب إضافة رقم هاتف المعلن',
            'amount.required' => 'يجب تحديد سعر الإعلان',
            'amount.numeric' => 'السعر يتكون من أرقام فقط',
            'advertis_from.required' => 'يجب تحديد فترة بداية الإعلان',
            'advertis_to.required' => 'يجب تحديد فترة نهاية الإعلان',
        ];
    }
}
