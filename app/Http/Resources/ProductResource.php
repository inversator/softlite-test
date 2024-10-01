<?php

namespace App\Http\Resources;

use App\Enums\ProductStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read  CategoryResource $category
 * @property-read CountryResource $country
 * @property-read UserResource $user
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->whenNotNull($this->description),
            'user' => new UserResource($this->whenLoaded('user')),
            'category' => $this->whenLoaded('category', fn() => $this->category->name),
            'country' => $this->whenLoaded('country', fn() => $this->country->name),
            'status' => ProductStatus::tryFrom($this->status)->description() ?? 'unknown',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
