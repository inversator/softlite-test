<?php

namespace App\Http\Requests;

use App\DTO\LoginDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @property string $username
 * @property string $email
 * @property string $password
 */
class AuthRequest extends FormRequest
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
            'username' => ['required_without:email', 'string'],
            'email' => ['required_without:username', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * @throws UnknownProperties
     */
    public function toDTO(): LoginDTO
    {
        return LoginDTO::fromRequest($this);
    }
}
