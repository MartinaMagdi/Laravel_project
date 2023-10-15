<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => "required|min:2",
            'price' => "required|min:1",
            'category_id' => "required",
            'image' => "required|mimes:png,jpg,jpeg"
        ];
    }

    function messages() {
        return [
            'name.required' => "Product name is required.",
            'name.min' => "Product name must more than 1 character.",
            'price.required' => "Product price is required.",
            'price.min' => "The minimum of price is 1",
            'category_id.required' => "Product category is required.",
            'image.required' => "Product image is required.",
            'image.mimes' => 'Product image must be an image with type "png, jpg or jpeg"'
        ];
    }
}
