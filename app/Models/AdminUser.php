<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class AdminUser
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property bool $is_banned
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Article $articles
 * @property-read ArticleComment $articleComments
 *
 * @method static Builder|AdminUser get()
 * @method static Builder|AdminUser find($value)
 * @method static Builder|AdminUser create($value)
 *
 * @mixin Builder
 * @package App\Models
 */
class AdminUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'is_banned'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_banned' => 'boolean',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'admin_id');
    }

    public function articleComments(): HasMany
    {
        return $this->hasMany(ArticleComment::class, 'admin_id');
    }

}
