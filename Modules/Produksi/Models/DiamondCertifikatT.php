<?php

namespace Modules\Produksi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiamondCertifikatT extends Model
{
    use HasFactory;

    protected $table = 'diamond_certificate_t';

    protected $fillable = ['code', 'tanggal', 'diamond_certificate_id'];
    
    protected static function newFactory()
    {
        return \Modules\Produksi\Database\factories\DiamondCertifikatTFactory::new();
    }
}
