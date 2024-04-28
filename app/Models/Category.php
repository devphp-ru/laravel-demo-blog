<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Category
 *
 * @property int $id ID
 * @property int $parent_id ID родителя
 * @property string $slug ЧПУ
 * @property string $name Название
 * @property string $content Описание
 * @property bool $is_active Активность
 * @property \Illuminate\Support\Carbon|null $created_at Дата создания
 * @property \Illuminate\Support\Carbon|null $update_at Дата обновления
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
