<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;
    use HasFactory;

    // Predefined keys
    const NEW = 'new';
    const ACCEPTED = 'accepted';
    const ON_THE_WAY = 'on_the_way';
    const ARRIVED = 'arrived';
    const IN_PROGRESS = 'in_progress';
    const PENDING_APPROVAL = 'pending_approval';
    const PENDING_PAYMENT = 'pending_payment';
    const CANCELED = 'canceled';
    const DONE = 'done';
    const REVIEWED = 'reviewed';

    public $table = 'statuses';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'key',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeByKey($query, $key)
    {
        return $query->where('key', $key);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
