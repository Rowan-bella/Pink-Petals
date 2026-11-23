<?php
namespace App\Http\Requests;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
    public function messages(): array
{
    return [
        'name.required' => 'Please enter a flower name.',
        'name.string' => 'Please enter a valid flower name.',
        'name.max' => 'Flower name must not exceed 255 characters.',

        'category_id.required' => 'Please select a category.',
        'category_id.exists' => 'Please select a valid category.',

        'description.string' => 'Please enter a valid description.',

        'price.required' => 'Please enter a price.',
        'price.numeric' => 'Please enter a valid number for price.',
        'price.min' => 'Price must be at least 0.',
        'price.max' => 'Price is too high.',

        'stock.required' => 'Please enter stock quantity.',
        'stock.integer' => 'Please enter a whole number for stock.',
        'stock.min' => 'Stock must be at least 0.',

        'image.image' => 'Please upload a valid image file.',
        'image.mimes' => 'Please upload a JPG, JPEG, PNG, or WEBP image.',
        'image.max' => 'Please upload an image smaller than 2MB.',
    ];
}
}
