<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class ArticleComment
 *
 * @property int $id
 * @property int $parent_id
 * @property int $article_id
 * @property int $user_id
 * @property string $username
 * @property string $email
 * @property string $comment
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read ArticleComment $comments
 * @property-read Article $article
 *
 * @method static Builder|ArticleComment find($value)
 *
 * @mixin Builder
 * @package App\Models
 */
class ArticleComment extends BaseModel
{
    protected $fillable = [
        'parent_id',
        'article_id',
        'user_id',
        'username',
        'email',
        'comment',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(ArticleComment::class, 'parent_id');
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

}
