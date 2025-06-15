<?php

namespace App\Http\Livewire\Penerimaan\BarangLuar\Sales;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\DataSale\Models\DataSale;
use Modules\PenerimaanBarangLuar\Models\PenerimaanBarangLuarIncentive;
use Modules\PenerimaanBarangLuarSale\Models\PenerimaanBarangLuarSale;

class Insentif extends Component
{

    public $bulan;
   
    public $month;
    public $year;

    public $sales_id = '';
    public $nilai_angkat;
    public $nilai_tafsir;
    public $nilai_selisih;
    public $persentase;
    public $nilai_insentif;

    public $datasales;

    public function mount()
    {
        $this->datasales = DataSale::all();
    }
    public function render()
    {
        return view('livewire.penerimaan.barang-luar.sales.insentif');
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
      if(!empty($this->sales_id) && !empty($this->month) && !empty($this->year)){
         $barangluar = PenerimaanBarangLuarSale::where('sales_id',$this->sales_id);
         $this->nilai_angkat = $barangluar->whereMonth('date',$this->month)->whereYear('date',$this->year)->sum('nilai_angkat');
         $this->nilai_tafsir = $barangluar->whereMonth('date',$this->month)->whereYear('date',$this->year)->sum('nilai_tafsir');
         $this->nilai_selisih = $barangluar->whereMonth('date',$this->month)->whereYear('date',$this->year)->sum('nilai_selisih');
      }
    }


     public function calculateIncentive(){
      $this->nilai_insentif = $this->nilai_selisih * $this->persentase / 100;
     }


     public function rules(){
      return [
         'bulan' => [
          'required',
            function ($attribute, $value, $fail) {
              $exist = PenerimaanBarangLuarIncentive::where('sales_id',$this->sales_id)->whereMonth('date',$this->month)->whereYear('date',$this->year)->exists();
              if ($exist) {
                  $fail('Insentif sudah ditentukan pada bulan dan sales yang sama');
              }
            },
          ],
         'sales_id' => 'required',
         'persentase' => 'required|gt:0'
      ];
     }

     public function store(){
      $this->validate();
      $tanggal = Carbon::createFromFormat('Y-m', $this->bulan)->startOfMonth();
      PenerimaanBarangLuarIncentive::create([
         'date' => $tanggal,
         'sales_id' => $this->sales_id,
         'incentive' => $this->nilai_insentif,
      ]);
      return redirect()->route('penerimaanbarangluarsale.insentif');
     }


}
