<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddNewProductRequest extends FormRequest
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
            'title' => 'required|string'.$this->id,
            'description' => 'string|max:255',
            'image' => 'required|image|mimes:jpg,png'.$this->id,
            'price' => 'required|numeric'.$this->id,
            'weight' => 'numeric',
            'inStock' => 'required|numeric'.$this->id,
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'عنوان المنتج مطلوب',
            'title.string' => 'عنوان المنتج يتكون من حروف فقط',
            'description.string' => 'الوصف يتكون من حروف فقط',
            'image.required' => 'يجب إرفاق صورة للمنتج',
            'image.image' => 'يجب أن يكون المرفق من نوع صورة',
            'image.mimes' => 'الصيغ المسموح بها jpg - png',
            'price.required' => 'يجب تحديد سعر للمنتج',
            'price.numeric' => 'السعر يتكون من أرقام فقط',
            'weight.numeric' => 'الوزن يتكون من أرقام فقط',
            'inStock.required' => 'الكمية المتاحة مطلوبة',
            'inStock.numeric' => 'الكمية تتكون من أرقام فقط',
        ];
    }
}
