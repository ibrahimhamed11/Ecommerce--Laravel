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
        'created_at', // Note: 'created_at' and 'updated_at' are automatically managed by Eloquent
        'status',
    ];

    protected $casts = [
        'products' => 'json', // Assuming 'products' is a JSON field
    ];

    // Define relationships if applicable
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
