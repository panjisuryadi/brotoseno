<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\People\Entities\Customer;

class SalesGold extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomor',
        'customer',
        'products',
        'services',
        'total',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Customer::class, 'customer', 'id'); // assuming 'user' is the foreign key in hargas table
    }
}
