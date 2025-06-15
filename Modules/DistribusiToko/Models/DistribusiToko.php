<?php

namespace Modules\DistribusiToko\Models;

use App\Models\LookUp;
use App\Models\TrackingStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Karat\Models\Karat;
use Modules\Cabang\Models\Cabang;

class DistribusiToko extends Model
{
    use HasFactory;
    protected $table = 'history_distribusi_toko';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        if(auth()->check()){
            if(auth()->user()->isUserCabang()){
                $cabang = auth()->user()->namacabang()->id;
                static::addGlobalScope('filter_by_branch', function (Builder $builder) use ($cabang) {
                    $builder->whereIn('status_id', [2,3,4])
                            ->where('cabang_id', $cabang); // Sesuaikan dengan nama kolom yang sesuai di tabel
                });
            }
        }
    }

    public function updateTracking($status_id, $note = null){
        $this->status_id = $status_id;
        if($this->save()){
            $this->statuses()->attach($this->status_id,[
                'pic_id'=> auth()->id(),
                'note' => $note,
                'date' => now(),
            ]);
        }
    }


    public function cabang() {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    } 

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\DistribusiToko\database\factories\DistribusiTokoFactory::new();
    }

    public function items(){
        return $this->hasMany(DistribusiTokoItem::class,'dist_toko_id','id');
    }

    public function statuses(){
        return $this->belongsToMany(DistribusiTokoStatus::class,'distribusi_toko_tracking_statuses','dist_toko_id','status_id')->using(DistribusiTokoStatusTracking::class)->withPivot(['pic_id','date','note']);
    }

    public function history(){
        return $this->hasMany(DistribusiTokoStatusTracking::class,'dist_toko_id');
    }

    public function current_status(){
        return $this->belongsTo(DistribusiTokoStatus::class, 'status_id');
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

    public function setAsDraft($note = null){
        $this->status_id = 1;
        if($this->save()){
            $this->statuses()->attach($this->status_id,[
                'pic_id'=> auth()->id(),
                'note' => $note,
                'date' => now()
            ]);
        }
    }

    public function isDraft(){
        return $this->current_status->id == 1;
    }

    public function setInProgress($note = null){
        $this->status_id = 2;
        if($this->save()){
            $this->statuses()->attach($this->status_id,[
                'pic_id'=> auth()->id(),
                'note' => $note,
                'date' => now()
            ]);
        }
    }

    public function setAsCompleted($note = null){
        $this->status_id = 4;
        if($this->save()){
            $this->statuses()->attach($this->status_id,[
                'pic_id'=> auth()->id(),
                'note' => $note,
                'date' => now()
            ]);
        }
    }

    public function setAsReturned($note = null){
        $this->status_id = 3;
        if($this->save()){
            $this->statuses()->attach($this->status_id,[
                'pic_id'=> auth()->id(),
                'note' => $note,
                'date' => now()
            ]);
        }
    }

    public function isRetur(){
        return $this->current_status->id == 3;
    }

    public function isDraftOrRetur(){
        return $this->isDraft() || $this->isRetur();
    }

    public function scopeGold($query)
    {
        return $query->where('kategori_produk_id', LookUp::where('kode','id_kategori_produk_emas')->value('value'));
    }  



   public function scopeCompleted($query)
    {
        return $query->where('status_id', 4);
    }

 public function scopeRetur($query)
    {
        return $query->where('status_id', 3);
    }

   public function scopeInprogress($query)
    {
        $query->where('status_id', 2);
    }

    public function scopeDiamond($query)
    {
        return $query->where('kategori_produk_id', LookUp::where('kode','id_kategoriproduk_berlian')->value('value'));
    }

    public function isCompleted(){
        return $this->current_status->id == 4;
    }

    public function isInProgress(){
        return $this->current_status->id == 2;
    }
}
