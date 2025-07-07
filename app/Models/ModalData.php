<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModalData extends Model
{
    use HasFactory;
    protected $table    = 'modal_datas';
    protected $fillable = [
        'modal_id',
        'type',
        'nominal',
        'from',
    ];
}
