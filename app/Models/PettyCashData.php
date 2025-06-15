<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCashData extends Model
{
    use HasFactory;
    protected $table    = 'petty_cash_data';
    protected $fillable = [
        'petty_cash_id',
        'type',
        'nominal',
        'from',
    ];
}
