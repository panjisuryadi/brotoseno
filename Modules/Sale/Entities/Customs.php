<?php

namespace Modules\Sale\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customs extends Model
{
    use HasFactory;
    
    public const SP_PAID = 'paid';
    public const S_COMPLETED = 'completed';

    protected $guarded = [];
    protected $table = 'customs';
    
}
