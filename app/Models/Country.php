<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Country
 *
 * @package App\Models
 *
 * @property string $name Unique name
 *
 * @property-read int $id
 * @property-read Carbon $created_at
 * @property-read Carbon|null $updated_at
 *
 * @mixin Builder
 */
class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
