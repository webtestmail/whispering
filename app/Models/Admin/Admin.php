<?php

namespace App\Models\Admin;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'google_id',
        'phone',
        'phone_verified',
        'term_box_check',
        'role',
        'image',
        'is_active'
    ];

  
    public const ROLE_ADMIN  = 1;
    public const ROLE_HR = 3;
    public const ROLE_SUBADMIN = 4;
    public const ROLE_BRANDMANAGER = 5;
    public const ROLE_INFLUENCERMANAGER = 6;


    public function getIsAdminAttribute(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }
               public function getIsSubAdmin(): bool
    {
        return $this->role === self::ROLE_SUBADMIN;
    }
            public function getIsHr(): bool
    {
        return $this->role === self::ROLE_HR;
    }
            public function getIsBrandManager(): bool
    {
        return $this->role === self::ROLE_BRANDMANAGER;
    }
            public function getIsInfluencerManager(): bool
    {
        return $this->role === self::ROLE_INFLUENCERMANAGER;
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
