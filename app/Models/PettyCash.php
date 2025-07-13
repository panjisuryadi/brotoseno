<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    use HasFactory;
    protected $table    = 'petty_cashs';
    protected $fillable = [
        'tanggal',
        'current',
        'cash_in',
        'cash_out',
        'final',
        'keterangan',
        'status',
    ];
}
