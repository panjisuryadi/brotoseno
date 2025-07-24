<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CicilData extends Model
{
    use HasFactory;
    protected $table    = 'cicils_datas';
    protected $fillable = [
        'cicil_id',
        'sales_gold_id',
        'nominal',
        'method',
        'bank',
        'rekening',
    ];

    public function sales_gold()
    {
        return $this->belongsTo(SalesGold::class, 'sales_gold_id', 'id'); // assuming 'user' is the foreign key in hargas table
    }

    public function bank()
    {
        return $this->belongsTo(SalesGold::class, 'bank', 'id'); // assuming 'user' is the foreign key in hargas table
    }

    public function rekening()
    {
        return $this->belongsTo(SalesGold::class, 'rekening', 'id'); // assuming 'user' is the foreign key in hargas table
    }
}
