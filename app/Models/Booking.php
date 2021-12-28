<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'bookings';

    protected $dates = [
        'booking_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'customer_id',
        'provider_id',
        'service_id',
        'status_id',
        'promo_code_id',
        'booking_at',
        'notes',
        'latitude',
        'longitude',
        'address_name',
        'address_details',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function extras()
    {
        return $this->belongsToMany(ServiceExtra::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function scopeByKey($query, $key)
    {
        return $query->where('key', $key);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->whereHas('status', function (Builder $query) use ($status) {
            $query->where('key', $status);
        });
    }

    public function scopeByStatusArray($query, $statusArray)
    {
        return $query->whereHas('status', function (Builder $query) use ($statusArray) {
            $query->whereIn('key', $statusArray);
        });
    }

    public function scopeByCategoryArray($query, $categoryArray)
    {
        return $query->whereHas('service.category', function (Builder $query) use ($categoryArray) {
            $query->whereIn('key', $categoryArray);
        });
    }

    public function promo_code()
    {
        return $this->belongsTo(PromoCode::class, 'promo_code_id');
    }

    public function getTaxAttribute(): float
    {
        $isTaxEnabled = PaymentSetting::firstOrFail()->tax_enabled;
        $taxAmount = 0;
        if ($isTaxEnabled) {
            $taxPercentage = PaymentSetting::firstOrFail()->tax_percentage;
            $taxAmount = $this->service->price * ($taxPercentage / 100);
        }

        return $taxAmount;
    }

    public function getSubTotalAttribute(): float
    {
        return $this->service->price + $this->tax;
    }

    public function getDiscountAttribute(): float
    {
        if (!$this->promo_code) return 0;

        if ($this->promo_code->type == 'fixed')
            return $this->promo_code->discount;
        elseif ($this->promo_code->type == 'percentage')
            return $this->subTotal * ($this->promo_code->discount / 100);
        else
            return 0;
    }

    public function getTotalAttribute(): float
    {
        return $this->subTotal - $this->discount;
    }

    public function getBookingAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

//    public function setBookingAtAttribute($value)
//    {
//        $this->attributes['booking_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
//    }

    public function getCommissionAttribute()
    {
        $serviceCommission = $this->service->commission;

        if (!$serviceCommission) return 0;

        if ($serviceCommission->type == 'fixed') {
            return $serviceCommission->value;
        } elseif ($serviceCommission->type == 'percentage') {
            return ($serviceCommission->value / 100) * $this->total;
        } else {
            return 0;
        }
    }

    /**
     * Update the booking status to done and calculate the earnings
     * Should be called when payment is done, or if provider confirmed cash payment
     */
    public function markAsDone()
    {
        $done = Status::byKey(Status::DONE)->firstOrFail();

        // Calculate commission and earnings for admin and provider
        $provider = $this->provider;
        $provider->providerEarning()->updateOrCreate(
            ['provider_id' => $provider->id],
            [
                'bookings_count' => ($provider->providerEarning->bookings_count ?? 0) + 1,
                'total_earning' => ($provider->providerEarning->total_earning ?? 0) + $this->total,
                'admin_earning' => ($provider->providerEarning->admin_earning ?? 0) + $this->commission,
                'provider_earning' => ($provider->providerEarning->provider_earning ?? 0) + $this->total - $this->commission,
                'total_tax' => ($provider->providerEarning->total_tax ?? 0) + $this->tax
            ]
        );

        $this->status()
            ->associate($done)
            ->update();
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
