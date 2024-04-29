<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Article
 *
 * @property int $id ID
 * @property int $category_id ID категории
 * @property string $slug ЧПУ
 * @property string $title Название
 * @property string $content Текст
 * @property string $thumbnail Изображение
 * @property int $views Просмотры
 * @property bool $is_active Активность
 * @property \Illuminate\Support\Carbon|null $created_at Дата создания
 * @property \Illuminate\Support\Carbon|null $updated_at Дата обновления
 *
 * @property-read \App\Models\Category $category Категории
 * @property-read \App\Models\Tag $tags Тэги
 *
 * @mixin Builder
 * @package App\Models
 */
class Article extends BaseModel
{
    use Sluggable;

    protected $fillable = [
        'category_id',
        'title',
        'content',
        'thumbnail',
        'views',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

}
