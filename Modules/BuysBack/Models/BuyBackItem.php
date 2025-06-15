<?php

namespace Modules\BuysBack\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Karat\Models\Karat;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Status\Models\ProsesStatus;
use Modules\Stok\Models\StockPending;

class BuyBackItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyback_nota_id',
        'product_id',
        'cabang_id',
        'customer_id',
        'status_id',
        'karat_id',
        'pic_id',
        'nominal',
        'note',
        'weight',
        'date'
    ];

    protected $table = 'buyback_item';
    
    protected static function newFactory()
    {
        return \Modules\BuysBack\Database\factories\BuyBackItemFactory::new();
    }

    public function stock_pending()
    {
        return $this->morphToMany(StockPending::class, 'transaction','stock_pending_history','transaction_id','stock_pending_id','id','id')->withTimestamps();
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function karat(){
        return $this->belongsTo(Karat::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function reduceStockPending(){
        $stock_pending = StockPending::firstOrCreate(
            ['karat_id' => $this->karat_id, 'cabang_id' => $this->cabang_id]
        );
        $this->stock_pending()->attach($stock_pending->id,[
            'karat_id'=>$this->karat_id,
            'cabang_id' => $this->cabang_id,
            'in' => false,
            'berat_real' => -1 * $this->weight,
            'berat_kotor' => -1 * $this->weight
        ]);
        $berat_real = $stock_pending->history->sum('berat_real');
        $berat_kotor = $stock_pending->history->sum('berat_kotor');
        $stock_pending->update(['weight'=> $berat_real]);
    }

    public function scopePending(){
        return $this->where('status_id', ProsesStatus::STATUS['PENDING']);
    }

    public function status(){
        return $this->belongsTo(ProsesStatus::class);
    }
}
