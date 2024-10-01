<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductDTO extends DataTransferObject
{
    public string $name;
    public ?string $description;
    public int $category_id;
    public int $country_id;
    public int $user_id;
    public int $status;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest($request): self
    {
        return new self([
            'name' => $request->input('name'),
            'description' => $request->input('description', ''),
            'category_id' => $request->input('category_id'),
            'country_id' => $request->input('country_id'),
            'user_id' => auth()->user()->id,
            'status' => $request->input('status', 0),
        ]);
    }
}
