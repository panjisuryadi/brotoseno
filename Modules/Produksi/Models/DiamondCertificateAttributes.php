<?php

namespace Modules\Produksi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiamondCertificateAttributes extends Model
{
    use HasFactory;

    protected $table = 'diamond_certificate_attributes_m';
    
    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Produksi\Database\factories\DiamondCertificateAttributesFactory::new();
    }
}
