<?php
namespace App\Http\Requests;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($this->route('id')),
            ],
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
    public function messages(): array
{
    return [
        'name.required' => 'Please enter a category name.',
        'name.string' => 'Please enter a valid category name.',
        'name.max' => 'Category name must not exceed 255 characters.',
        'name.unique' => 'This category name already exists.',
        'description.string' => 'Please enter a valid description.',
        'image.image' => 'Please upload a valid image file.',
        'image.mimes' => 'Please upload a JPG, JPEG, PNG, or WEBP image.',
        'image.max' => 'Please upload an image smaller than 2MB.',
    ];
}
}
