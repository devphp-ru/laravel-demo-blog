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
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property string $is_banned
 * @property Carbon|null $created_at
 * @property Carbon|null $update_at
 *
 * @property-read Article $articles
 * @property-read ArticleComment $articleComments
 *
 * @method static Builder|User get()
 * @method static Builder|User find($value)
 * @method static Builder|User create($value)
 *
 * @mixin Builder
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_banned',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_banned' => 'boolean',
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function articleComments(): HasMany
    {
        return $this->hasMany(ArticleComment::class);
    }

}
