<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Tag
 *
 * @property int $id ID
 * @property string $slug ЧПУ
 * @property string $name Название
 * @property string $content Описание
 * @property bool $is_active Активность
 * @property \Illuminate\Support\Carbon|null $created_at Дата создания
 * @property \Illuminate\Support\Carbon|null $updated_at Дата обновления
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
