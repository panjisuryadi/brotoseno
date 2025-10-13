<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaSilver extends Model
{
    use HasFactory;
    protected $table    = 'harga_silvers';
    protected $fillable = [
        'harga',
        'tanggal',
        'user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user', 'id'); // assuming 'user' is the foreign key in hargas table
    }

}
