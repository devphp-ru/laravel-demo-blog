<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Class Category
 *
 * @property int $id
 * @property int $parent_id
 * @property string $slug
 * @property string $name
 * @property string $content
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $update_at
 *
 * @method static Builder|Category create($value)
 *
 * @mixin Builder
 * @package App\Models
 */
class Category extends BaseModel
{
    use Sluggable;

    protected $fillable = [
        'parent_id',
        'name',
        'content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function parent(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

}
