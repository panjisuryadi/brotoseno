<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\People\Entities\Customer;

class Cicil extends Model
{
    use HasFactory;
    protected $table    = 'cicils';
    protected $fillable = [
        'sales_gold_id',
        'customer_id',
        'total_trx',
        'paid',
        'sisa',
        'install',
        'installments',
    ];

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id'); // assuming 'user' is the foreign key in hargas table
    }

    public function sales_gold()
    {
        return $this->belongsTo(SalesGold::class, 'sales_gold_id', 'id'); // assuming 'user' is the foreign key in hargas table
    }
}
