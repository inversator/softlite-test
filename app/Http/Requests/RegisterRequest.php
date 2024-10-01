<?php

namespace App\Http\Requests;

use App\DTO\RegisterDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @property mixed $email
 * @property mixed $username
 * @property mixed $password
 */
class RegisterRequest extends FormRequest
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
            'username' => ['required', 'string', 'unique:users,name'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }


    /**
     * @throws UnknownProperties
     */
    public function toDTO(): RegisterDTO
    {
        return RegisterDTO::fromRequest($this);
    }
}
