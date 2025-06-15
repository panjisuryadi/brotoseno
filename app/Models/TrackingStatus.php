<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    const CREATED = 1;
    const SENT = 2;
    const PROCESSING = 3;
    const APPROVED = 4;
    const RETURNED = 5;
    const COMPLETED = 6;

    protected $table = 'tracking_status';
}
