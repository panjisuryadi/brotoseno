<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use Modules\ProdukModel\Models\ProdukModel;
use Modules\Product\Entities\Category;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Product\Entities\Product;
class Tambah extends Component
{

 
    public $selectedOption = '';
    public $berat_total = 0;
    public $margin;
    public $harga_emas = 0;
    public $totalPrice = 0;
    public $totalRupiah = 0;
    public $total_amount = 0;
   

    public $hargaEmas = 0;
    public $formattedHargaEmas = '';
    public $inputHargaEmas = 0;
    public $inputBeratTotal = 0.00;
    public $discount = 0;
    public $price = 0;
    public $hargaEmasBeratTotal = 0;
    public $productCost = 0;
    public $inputMargin = 0;
    public $inputMarginPersentase = 0;
    public $produkPriceResult = 0;

    public $berat_accessories = 0;
    public $berat_emas = 0;
    public $berat_tag = 0;
    // public $berat_total = 0;
    public $beratTotalFinal = 0;
    public $margin_nominal;
    public $margin_gram;
    public $margin_persentase;
    public $hasilnominal = 0;
    public $grandtotal = 0;

    public $show = false;
    public $tipeMarginGram;

    protected $listeners = [
        
                            'optionSelected' => 'handleOptionSelected'

                             ];


    public function mount() {
       
        // $this->hargaEmas = 0;
        // $this->berat_total = 0;
        
    }

   public function tipeMargin($value)
    {
           //dd($value);
            $this->tipeMarginGram = $value;

    }

    public function toggleMarginPersentase()
    {
         //dd('xx');
        $this->persentase = !$this->persentase;
        if ($this->persentase) {
            $this->nominal = false;
        }
    }


    public function updatedinputHargaEmas()
    {
       // $this->beratTotalFinal;
       // dd($this->beratTotalFinal);
        $hasil = (int)$this->inputHargaEmas * $this->beratTotalFinal;
        ////
        $discountAmount = $hasil * ($this->discount / 100);
        $this->price = $hasil - $discountAmount;

        $this->hargaEmasBeratTotal = $hasil;
        $this->productCost = 'Rp ' . number_format($this->hargaEmasBeratTotal, 0, ',', '.');
       // $this->calculatePrice();
    }


  

    public function recalculateTotal()
    {
         //dd($this->berat_accessories);
        if ($this->berat_accessories == null && $this->berat_tag == null && $this->berat_emas == null) {
            $this->berat_accessories = 0;
            $this->berat_tag = 0;
            $this->berat_emas = 0;
        }

        $this->beratTotalFinal = $this->berat_accessories + $this->berat_tag + $this->berat_emas;
    }



    public function calculateMarginGram()
    {
        $this->resetInput();


        $this->hasilnominal = $this->margin_gram * $this->beratTotalFinal;
        $this->grandtotal = $this->hasilnominal + $this->hargaEmasBeratTotal;
        $this->produkPriceResult = 'Rp ' . number_format($this->grandtotal, 0, ',', '.');
    } 


     public function calculateMarginNominal()
    {

        $this->resetInput();

        $this->hasilnominal = (int)$this->price + $this->margin_nominal;
       //dd($this->margin_nominal);
        $this->grandtotal = $this->hasilnominal;
        $this->produkPriceResult = 'Rp ' . number_format($this->hasilnominal, 0, ',', '.');
    }

    
  public function calculateMarginPersentase()
    {
       // dd('xxxx');
        $this->resetInput();
        $this->hasilnominal = $this->price / (int)$this->margin_persentase;
        $this->grandtotal = $this->hasilnominal + $this->hargaEmasBeratTotal;
       // dd($this->grandtotal);
        $this->produkPriceResult = 'Rp ' . number_format($this->grandtotal, 0, ',', '.');
    }

  

    public function updatedinputMargin()
    {
       // $this->resetInput();
        $this->calculateMargin();
    }

  


    public function updatedinputBeratTotal()
    {
        $this->calculatePrice();
    }



    public function updatedDiscount()
    {
        $this->calculatePrice();
       
    }



   public function updatedhargaEmas()
    {
    
       $this->konversihargaEmas();
    }



    public function konversihargaEmas()
    {
    
        $this->formattedHargaEmas = 'Rp ' . number_format($this->hargaEmas, 0, ',', '.');
    }




    private function calculatePrice()
    {
        // Perform the price calculation based on input values and discount
        //$totalValue = $this->inputHargaEmas + $this->inputBeratTotal;

       //input harga emas di x berat total
        $beratTotalFinal = (int)$this->inputHargaEmas * $this->inputBeratTotal;
        ////
        $discountAmount = $beratTotalFinal * ($this->discount / 100);
        $this->price = $beratTotalFinal - $discountAmount;

        $this->hargaEmasBeratTotal = $beratTotalFinal;
        $this->productCost = 'Rp ' . number_format($this->hargaEmasBeratTotal, 0, ',', '.');
             

    }


    private function calculateBerat()
      {
       //input harga emas di x berat total
      
        $hasil = (int)$this->berat_accessories 
        + (int)$this->berat_emas + (int)$this->berat_tag;
        ////
        $this->beratTotalFinal = $hasil;
       
       }


    private function calculateMargin()
      {
       //input harga emas di x berat total
       
        $produkPrice = (int)$this->price + (int)$this->inputMargin;
        ////
        $this->totalprodukPrice = $produkPrice;
        $this->produkPriceResult = 'Rp ' . number_format($this->totalprodukPrice, 0, ',', '.');
       }






          public function resetInput()
            {
                $this->grandtotal = '';
                $this->produkPriceResult = '';
          
              
            }


    public function calculateHargaEmas()
    {
       // dd('dsdss');
        $total = $this->berat_total * $this->harga_emas;
        $this->totalRupiah = 'Rp ' . number_format($total, 0, ',', '.');
    }


     public function hitungMargin() {
       // return $harga + $this->margin;
    }



    public function handleOptionSelected($value)
    {

        if ($value) {
           $cat = Category::where('id', $value)->first();
           $slug = $cat->slug;
           $this->selectedOption = $slug;
        } else {
            $this->selectedOption = '0';
        }
        
        
       
    }




    public function render()
    {
        return view('livewire.product.add-produk-toko');
    }
    


    public function updatedBeratTotal() {
         $this->berat_total +1;
            }





}
