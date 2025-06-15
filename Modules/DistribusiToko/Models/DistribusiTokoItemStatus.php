<?php

namespace Modules\DistribusiToko\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DistribusiTokoItemStatus extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $table = 'distribusi_toko_item_status';

}
