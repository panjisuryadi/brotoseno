<?php

namespace Modules\GoodsReceipt\Models\Toko\BuyBackBarangLuar;

use App\Models\TrackingStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cabang\Models\Cabang;
use Modules\Status\Models\ProsesStatus;
use Modules\GoodsReceipt\Models\Toko\BuyBackBarangLuar;
use Modules\KategoriProduk\Models\KategoriProduk;

class GoodsReceiptNota extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice',
        'invoice_number',
        'invoice_series',
        'date',
        'cabang_id',
        'status_id',
        'kategori_produk_id',
        'pic_id',
        'note'
    ];

    protected $table = 'goodsreceipt_toko_nota';

    protected static function booted(): void
    {
        parent::booted();
        self::created(static function (GoodsReceiptNota $goodsreceipt_nota) {
            $goodsreceipt_nota->statuses()->attach($goodsreceipt_nota->status_id,[
                'pic_id'=> auth()->id(),
                'note' => empty($goodsreceipt_nota->note)?null:$goodsreceipt_nota->note,
                'date' => now(),
                'cabang_id' => $goodsreceipt_nota->cabang_id
            ]);
        });

        if (auth()->check()) {
            if(auth()->user()->isUserCabang()){
                static::addGlobalScope('filter_by_cabang', function (Builder $builder) {
                    $builder->where('cabang_id', auth()->user()->namacabang()->id);
                });
            }
        }
    }

    public function kategoriProduk()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id', 'id');
    }

    public function statuses(){
        return $this->belongsToMany(TrackingStatus::class,'goodsreceipt_toko_nota_tracking','goodsreceipt_toko_nota_id','status_id')->using(GoodsReceiptNotaTracking::class)->withPivot(['cabang_id','pic_id','date','note']);
    }

    public function current_status(){
        return $this->belongsTo(TrackingStatus::class, 'status_id');
    }

    public function items(){
        return $this->hasMany(BuyBackBarangLuar\GoodsReceiptItem::class,'goodsreceipt_toko_nota_id');
    }

    public function cabang(){
        return $this->belongsTo(Cabang::class);
    }

    public function isProcessing(){
        return $this->status_id == TrackingStatus::PROCESSING;
    }

    public function isReturned(){
        return $this->status_id == TrackingStatus::RETURNED;
    }


    public function isSent(){
        return $this->status_id == TrackingStatus::SENT;
    }

    public function history(){
        return $this->hasMany(GoodsReceiptNotaTracking::class,'goodsreceipt_toko_nota_id');
    }

    public function pic(){
        return $this->belongsTo(User::class,'pic_id')->withoutGlobalScopes();
    }

    public function send(){
        $this->status_id = TrackingStatus::SENT;
        if($this->save()){
            $this->statuses()->attach($this->status_id,[
                'pic_id'=> auth()->id(),
                'note' => null,
                'date' => now(),
                'cabang_id' => $this->cabang_id
            ]);
        }
    }

    public function process(){
        $this->status_id = TrackingStatus::PROCESSING;
        if($this->save()){
            $this->statuses()->attach($this->status_id,[
                'pic_id'=> auth()->id(),
                'note' => null,
                'date' => now(),
                'cabang_id' => null
            ]);
        }
    }

    public function updateTracking($status_id, $cabang_id, $note = null){
        $this->status_id = $status_id;
        if($this->save()){
            $this->statuses()->attach($this->status_id,[
                'pic_id'=> auth()->id(),
                'note' => $note,
                'date' => now(),
                'cabang_id' => $cabang_id
            ]);
        }
    }

    public function latest_status_tracking(){
        return $this->statuses()->orderBy('date','desc')->first();
    }

    public function current_status_pic(){
        return $this->latest_status_tracking()->pivot->pic;
    }

    public function current_status_date(){
        return $this->latest_status_tracking()->pivot->date;
    }

    public function current_status_note(){
        return $this->latest_status_tracking()->pivot->note;
    }
}
