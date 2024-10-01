<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class RegisterDTO extends DataTransferObject
{
    public string $name;
    public string $email;
    public string $password;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest($request): self
    {
        return new self([
            'name' => $request->username ?? $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
    }
}
