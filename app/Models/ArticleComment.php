<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ArticleComment
 *
 * @property int $id ID
 * @property int $parent_id ID родителя
 * @property int $article_id
 * @property string $username Имя
 * @property string $email Email
 * @property string $comment Комментарий
 * @property bool $is_active Активность
 * @property \Illuminate\Support\Carbon|null $created_at Дата создания
 * @property \Illuminate\Support\Carbon|null $updated_at Дата обновления
 *
 * @property-read \App\Models\ArticleComment $comments Вложенные комментарии
 * @property-read \App\Models\Article $article Статья
 *
 * @mixin Builder
 * @package App\Models
 */
class ArticleComment extends BaseModel
{
    protected $fillable = [
        'parent_id',
        'article_id',
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
