<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class LoginDTO extends DataTransferObject
{
    public string $email;
    public string $password;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest($request): self
    {
        return new self([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);
    }
}
