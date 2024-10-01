<?php

namespace App\Http\Requests;

use App\DTO\ProductDTO;
use App\Enums\ProductStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($this->route('product'))],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'country_id' => ['required', 'exists:countries,id'],
            'status' => ['required', 'integer', Rule::enum(ProductStatus::class)],
        ];
    }

    /**
     * @throws UnknownProperties
     */
    public function toDTO(): ProductDTO
    {
        return ProductDTO::fromRequest($this);
    }
}
