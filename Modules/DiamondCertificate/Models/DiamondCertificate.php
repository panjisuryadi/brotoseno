<?php

namespace Modules\DiamondCertificate\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiamondCertificate extends Model
{
    use HasFactory;
    protected $table = 'diamondcertificates';
    protected $fillable = [
        'name',
       // 'image',
        'description',
        'start_date',
        'end_date',

     ];

  public function certificates() {
        return $this->hasMany(ProductItem::class, 'certificate_id', 'id');
    }


    protected static function newFactory()
    {
        return \Modules\DiamondCertificate\database\factories\DiamondCertificateFactory::new();
    }


}
