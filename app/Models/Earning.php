<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Earning extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'earnings';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'provider_id',
        'bookings_count',
        'total_earning',
        'admin_earning',
        'provider_earning',
        'total_tax',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
