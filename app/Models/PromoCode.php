<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const TYPE_SELECT = [
        'fixed'      => 'Fixed',
        'percentage' => 'Percentage',
    ];

    public $table = 'promo_codes';

    protected $dates = [
        'expires_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'enabled',
        'code',
        'type',
        'discount',
        'expires_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getExpiresAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setExpiresAtAttribute($value)
    {
        $this->attributes['expires_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
