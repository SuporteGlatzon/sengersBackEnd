<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, LogsActivity;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'avatar',
        'state_id',
        'city_id',
        'phone',
        'address',
        'complement',
        'banner_profile',
        'senge_associate',
        'active',
        'description',
        'full_description',
        'link_site',
        'link_instagram',
        'link_twitter',
        'link_linkedin',
        'curriculum',
        'cpf',
        'code_crea',
        'user_type'
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
        'password' => 'hashed',
        'senge_associate' => 'boolean',
        'active' => 'boolean',
    ];

    protected $rules = [
        'email' => 'unique:users,email,NULL,id,deleted_at,NULL',
    ];

    protected $attributes = [
        'user_type' => 'user',
    ];

    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->active && $this->user_type === 'user' && in_array($this->role_id, [Role::ADMIN, Role::SUPERADMIN, Role::CLIENT]);
    }

    public function canFullPermission(): bool
    {
        return in_array($this->role_id, [Role::ADMIN, Role::SUPERADMIN, Role::CLIENT]);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('user')
            ->logAll()
            ->dontLogIfAttributesChangedOnly(['updated_at']);
    }

    public function getAuthPassword()
    {
        return $this->password ?? ''; // Allow login without a password
    }
}
