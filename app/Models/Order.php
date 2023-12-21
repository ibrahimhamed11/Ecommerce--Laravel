<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'products',
        'total_price',
        'address',
        'user_name',
        'user_email',
        'user_phone',
        'status',
    ];

    protected $casts = [
        'products' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}