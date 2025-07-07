<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{
    use HasFactory;
    protected $table    = 'modals';
    protected $fillable = [
        'tanggal',
        'modal',
        'current',
        'cash_in',
        'cash_out',
        'final',
        'keterangan',
        'status',
    ];
}
