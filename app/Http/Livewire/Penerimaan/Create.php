<?php

namespace App\Http\Livewire\Penerimaan;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Auth;
use Modules\PenerimaanBarangLuar\Events\PenerimaanBarangLuarCreated;
use Modules\PenerimaanBarangLuar\Models\PenerimaanBarangLuar;
use Modules\Cabang\Models\Cabang;
use Modules\Status\Models\ProsesStatus;


use Livewire\Component;
use Modules\GoodsReceipt\Models\Toko\BuyBackBarangLuar\GoodsReceiptItem;
use Modules\PenerimaanBarangLuar\Models\PenerimaanBarangLuarIncentive;

class Create extends Component
{
    public $title;

    public $bulan;
   
    public $month;
    public $year;

    public $cabang_id = '';
    public $nilai_angkat;
    public $nilai_tafsir;
    public $nilai_selisih;
    public $persentase;
    public $nilai_insentif;

    public $cabang_for_incentive;
  
    public function mount()
    {
       $this->cabang_for_incentive = Cabang::all();
      
    }
    public function render()
    {
        return view('livewire.penerimaan.create');
    }

    public function pilihBulan($value)

    {
      $this->month = date('m',strtotime($value.'-01'));
      $this->year = date('Y',strtotime($value.'-01'));
      $this->resetInput();
      $this->fetchNilai();
    }

    private function resetInput(){
      $this->persentase = 0;
      $this->nilai_insentif = 0;
    }

    public function fetchNilai(){
      if(!empty($this->cabang_id) && !empty($this->month) && !empty($this->year)){
         $barangluar = GoodsReceiptItem::where('cabang_id',$this->cabang_id)
                        ->where('type',2)
                        ->whereNotNull('nilai_tafsir')
                        ->where('status_id', GoodsReceiptItem::APPROVED);
         $this->nilai_angkat = $barangluar->whereMonth('date',$this->month)->whereYear('date',$this->year)->sum('nominal');
         $this->nilai_tafsir = $barangluar->whereMonth('date',$this->month)->whereYear('date',$this->year)->sum('nilai_tafsir');
         $this->nilai_selisih = $barangluar->whereMonth('date',$this->month)->whereYear('date',$this->year)->sum('nilai_selisih');
      }
    }

     public function calculateIncentive(){
      if(!empty($this->persentase)){
         $this->nilai_insentif = $this->nilai_selisih * $this->persentase / 100;
      }
     }


     public function rules(){
      return [
         'bulan' => [
            'required',
            function ($attribute, $value, $fail) {
               $exist = PenerimaanBarangLuarIncentive::where('cabang_id',$this->cabang_id)->whereMonth('date',$this->month)->whereYear('date',$this->year)->exists();
               if ($exist) {
                   $fail('Insentif sudah ditentukan pada bulan dan cabang yang sama');
               }
            },
         ],
         'cabang_id' => 'required',
         'persentase' => 'required|gt:0'
      ];
     }

     public function store(){
      $this->validate();
      $tanggal = Carbon::createFromFormat('Y-m', $this->bulan)->startOfMonth();
      PenerimaanBarangLuarIncentive::create([
         'date' => $tanggal,
         'cabang_id' => $this->cabang_id,
         'incentive' => $this->nilai_insentif,
      ]);
      return redirect()->route('penerimaanbarangluar.index_insentif');
     }

     public function updated($property){
      $this->validateOnly($property);
     }


}
