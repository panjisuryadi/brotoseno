<?php

namespace Modules\Produksi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiamondCertificateAttribute extends Model
{
    use HasFactory;

    protected $table = 'diamond_certificate_attributes_t';
    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Produksi\Database\factories\DiamondCertificateAttributeFactory::new();
    }
}
