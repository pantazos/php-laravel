<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    use HasFactory;
    use HasApiTokens;

    public $table = 'users';

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'uid',
        'fcm_token',
        'email_verified_at',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('key', ROLE::ADMIN)->exists();
    }

    public function getIsCustomerAttribute()
    {
        return $this->roles()->where('key', ROLE::CUSTOMER)->exists();
    }

    public function getIsProviderAttribute()
    {
        return $this->roles()->where('key', ROLE::PROVIDER)->exists();
    }

    public function providerEarning()
    {
        return $this->hasOne(Earning::class, 'provider_id', 'id');
    }

    public function providerPayouts()
    {
        return $this->hasMany(Payout::class, 'provider_id', 'id');
    }

    public function getAvailablePayoutAttribute()
    {
        return ($this->providerEarning->provider_earning ?? 0) - $this->providerPayouts->sum('amount');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id', 'id');
    }

    public function notificationTokens()
    {
        return $this->hasMany(NotificationToken::class, 'user_id', 'id');
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

//    public function setEmailVerifiedAtAttribute($value)
//    {
//        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
//    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class,
            'category_user',
            'provider_id',
            'category_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Booking::class, 'provider_id');
    }

    public function scopeCustomer($query)
    {
        return $query->whereHas('roles', function (Builder $query) {
            $query->where('key', Role::CUSTOMER);
        });
    }

    public function scopeProvider($query)
    {
        return $query->whereHas('roles', function (Builder $query) {
            $query->where('key', Role::PROVIDER);
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
