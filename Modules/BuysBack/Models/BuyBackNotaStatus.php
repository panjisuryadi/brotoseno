<?php

namespace Modules\BuysBack\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuyBackNotaStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    const STATUS = [
        'CREATED' => 1,
        'SENT' => 2,
        'PROCESSING' => 3,
        'APPROVED' => 4,
        'RETURNED' => 5,
        'COMPLETED' => 6
    ];

    protected $table = 'buyback_nota_status';
    
    protected static function newFactory()
    {
        return \Modules\BuysBack\Database\factories\BuyBackNotaStatusFactory::new();
    }
}
