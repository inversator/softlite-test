<?php

namespace App\Models;

use App\Events\ProductDeleted;
use App\Events\ProductSaved;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Product
 *
 * @package App\Models
 *
 * @property string $name Unique name
 * @property string|null $description
 * @property int $status Product status (0 - default, use ProductStatus enum)
 *
 * @property int $user_id
 * @property int $category_id
 * @property int $country_id
 *
 * @property-read int $id
 * @property-read Carbon $created_at
 * @property-read Carbon|null $updated_at
 * @property-read Carbon|null $deleted_at
 *
 * @property-read User $user
 * @property-read Category $category
 * @property-read Country $country
 *
 * @mixin Builder
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',

        'user_id',
        'category_id',
        'country_id',

        'deleted_at',
        'update_at',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'saving' => ProductSaved::class,
        'deleting' => ProductDeleted::class
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
