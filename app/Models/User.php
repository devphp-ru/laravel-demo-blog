<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int $id ID
 * @property string $name Имя
 * @property string $email Email
 * @property string $email_verified_at Подтверждение email
 * @property string $password Пароль
 * @property string $remember_token Токен
 * @property string $is_banned Бан
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

}
