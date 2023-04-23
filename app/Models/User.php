<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'code',
        'password_code',
        'role',
        'about_me',
        'language',
        'availability',
        'age',
        'location',
        'experience',
        'avatar',
        'designation',
        'status',
        'profile',
        'account_status',
        'email_status',
        'c_name',
        'c_email',
        'c_position',
        'c_phone',
        'c_about_us',
        'c_image',
        'c_website',
        'c_revenue',
        'c_location',
        'remember_token',
        'wa_no'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
