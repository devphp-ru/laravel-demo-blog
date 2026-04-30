<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class Article
 *
 * @property int $id
 * @property $user_id
 * @property $admin_id
 * @property int $category_id
 * @property string $slug
 * @property string $title
 * @property string $content
 * @property string $thumbnail
 * @property int $views
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Category $category
 * @property-read Tag $tags
 * @property-read ArticleComment $comments
 *
 * @method static Builder|Article create($value)
 *
 * @mixin Builder
 * @package App\Models
 */
class Article extends BaseModel
{
    use Sluggable;

    protected $fillable = [
        'user_id',
        'admin_id',
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

    public function comments(): HasMany
    {
        return $this->hasMany(ArticleComment::class);
    }

}
