<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\EventRequest;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'last',
        'username',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'phone_verified',
        'term_box_check',
        'role',
        'phone',
        'is_active',
        'parent_user_id',
        'account_owner_id',
    ];
    
    public const ROLE_MEMBER = 0;
    public const ROLE_ADMIN  = 1;
    public const ROLE_SUBMEMBER = 2;
    public const ROLE_SUBSUBMEMBER = 3;
    public const ROLE_SUBADMIN = 4;


    public function getIsAdminAttribute()
    {
        return $this->role === self::ROLE_ADMIN;
    }
        public function getIsMemberAttribute(): bool
    {
        return $this->role === self::ROLE_MEMBER;
    }
        public function getIsSubMemberAttribute(): bool
    {
        return $this->role === self::ROLE_SUBMEMBER;
    }
        public function getIsSubSubMemberAttribute(): bool
    {
        return $this->role === self::ROLE_SUBSUBMEMBER;
    }
            public function getIsSubAdmin(): bool
    {
        return $this->role === self::ROLE_SUBADMIN;
    }


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
    public function userprofile(){
        return $this->hasOne(UserProfile::class);
    }

    public function application(){
        return $this->hasOne(Application::class,'user_id');
    }

    
    public function subscription(){
        return $this->hasMany(Subscription::class,'user_id');
    }
    
    // public function hasActiveSubscription()
    // {
    //     return $this->subscription()->active()->first();
    // }

    public function tradeSectors()
    {
        return $this->belongsToMany(TradeSector::class, 'member_trade_sector');
    }
    public function productCategories()
    {
        return $this->belongsToMany(ProductCategory::class, 'category_member');
    }

    public function productSubCategories()
    {
        return $this->belongsToMany(ProductSubCategory::class, 'member_product_sub_category');
    }
    public function temperatures()
    {
        return $this->belongsToMany(Temperature::class, 'member_temperature');
    }
    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_member');
    }
    public function companylinks()
    {
        return $this->hasOne(CompanyLink::class, 'user_id');
    }
    public function companycontacts(){
        return $this->hasMany(MemberCompanyContact::class, 'user_id');
    }
    public function mainPointOfContact(){
        return $this->hasOne(PointOfContact::class, 'user_id')->where('is_primary', 1);
    }
    public function pointOfContact(){
        return $this->hasMany(PointOfContact::class, 'user_id')->where('is_primary', 0);
    }
    public function appearance(){
        return $this->hasOne(Appearance::class, 'user_id');
    }
        public function eventRequests()
    {
        return $this->hasMany(EventRequest::class, 'user_id');
    }

    public function parentUser()
    {
        return $this->belongsTo(self::class, 'parent_user_id');
    }

    public function childUsers()
    {
        return $this->hasMany(self::class, 'parent_user_id');
    }

    public function accountOwner()
    {
        return $this->belongsTo(self::class, 'account_owner_id');
    }

    public function isAccountOwner(): bool
    {
        return $this->role === 'member' || (int) $this->role === self::ROLE_MEMBER;
    }

    public function isSubMemberUser(): bool
    {
        return (int) $this->role === self::ROLE_SUBMEMBER;
    }

    public function isSubSubMemberUser(): bool
    {
        return (int) $this->role === self::ROLE_SUBSUBMEMBER;
    }

    public function isDashboardSubUser(): bool
    {
        return $this->isSubMemberUser() || $this->isSubSubMemberUser();
    }

    public function canAccessMemberDashboard(): bool
    {
        return $this->isAccountOwner() || $this->isDashboardSubUser();
    }

    /** Member and user (sub-member) can open the Users section; sub-subuser cannot. */
    public function canManageUsers(): bool
    {
        return $this->isAccountOwner() || $this->isSubMemberUser();
    }

    public function getAccountMember(): self
    {
        if ($this->isAccountOwner()) {
            return $this;
        }

        if ($this->account_owner_id) {
            return self::query()->find($this->account_owner_id) ?? $this;
        }

        return $this->parentUser?->getAccountMember() ?? $this;
    }

    public function resolveAccountOwnerId(): int
    {
        return $this->getAccountMember()->id;
    }

    public function roleForNewChild(): int
    {
        if ($this->isAccountOwner()) {
            return self::ROLE_SUBMEMBER;
        }

        if ($this->isSubMemberUser()) {
            return self::ROLE_SUBSUBMEMBER;
        }

        throw new \InvalidArgumentException('This account type cannot create users.');
    }

    public function manageableUsersQuery()
    {
        if ($this->isAccountOwner()) {
            return self::query()
                ->where('account_owner_id', $this->id)
                ->where('id', '!=', $this->id)
                ->orderByDesc('created_at');
        }

        if ($this->isSubMemberUser()) {
            return self::query()
                ->where('parent_user_id', $this->id)
                ->where('role', self::ROLE_SUBSUBMEMBER)
                ->orderByDesc('created_at');
        }

        return self::query()->whereRaw('0 = 1');
    }

    public function canDeleteUser(self $target): bool
    {
        if ($target->id === $this->id) {
            return true;
        }

        if ($this->isAccountOwner()) {
            return (int) $target->account_owner_id === $this->id
                && $target->isDashboardSubUser();
        }

        return (int) $target->parent_user_id === $this->id
            && (int) $target->role === self::ROLE_SUBSUBMEMBER;
    }

    public function canCreateUsers(): bool
    {
        return $this->canManageUsers();
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true); 
    }
}
