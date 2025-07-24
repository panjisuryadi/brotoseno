<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCashData extends Model
{
    use HasFactory;
    protected $table    = 'petty_cash_datas';
    protected $fillable = [
        'petty_cash_id',
        'cash_in',
        'cash_out',
        'keterangan',
        'image',
    ];
}
