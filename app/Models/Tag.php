<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * Class Tag
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $content
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Tag create($value)
 *
 * @mixin Builder
 * @package App\Models
 */
class Tag extends BaseModel
{
    use Sluggable;

    protected $fillable = [
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

}
