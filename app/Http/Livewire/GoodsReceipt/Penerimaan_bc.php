<?php

namespace App\Http\Livewire\GoodsReceipt;
        use Livewire\Component;
        use App\Http\Livewire\Field;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\Validator;
        use Modules\GoodsReceipt\Models\GoodsReceipt;
        use App\Models\User;
        use Livewire\WithFileUploads;
        class Penerimaan_bc extends Component
        {
            use WithFileUploads;
            public $goodsreceipt,
             $total_emas,
             $post = [],
             $generateCode,
             $code,
             $no_invoice,
             $harga,
             $qty,
             $pengirim,
             $user_id,
             $berat_kotor,
             $berat_real,
             $kategori_id,
             $supplier_id,
             $kasir,
             $tanggal,
             $karat_id;

            public $updateMode = false;
            public $total_qty = 0;
            public $tipe_pembayaran = 'cicil';
            public $inputs = [];
            public $i = 1;

            public function add($i)
            {
                $i = $i + 1;
                $this->i = $i;
                array_push($this->inputs ,$i);
            }

            public function remove($i)
            {
                unset($this->inputs[$i]);
            }


          public function hydrate()
           {
               $this->emit('select2');

           }



            public function render()
            {
                $this->generateCode = GoodsReceipt::generateCode();
                $this->kasir = User::role('Kasir')->orderBy('name')->get();
                 $this->goodsreceipt = GoodsReceipt::all();
                return view('livewire.goods-receipt.penerimaan');
            }

            private function resetInputFields(){
                $this->karat_id = '';
                $this->kategori_id = '';
                $this->no_invoice = '';
                $this->qty = '';
                $this->total_emas = '';
                $this->berat_kotor = '';
                $this->berat_real = '';
                $this->harga = '';
                $this->user_id = '';
                $this->supplier_id = '';
                $this->tanggal = '';
                $this->pengirim = '';
                $this->tipe_pembayaran = '';
            }


               public function rules()
                {
                        $rules = [
                              'no_invoice'     => 'required',
                              'total_emas'     => 'required',
                              'berat_kotor'     => 'required',
                              'berat_real'     => 'required',
                              'tanggal'     => 'required',
                              'user_id'     => 'required',
                              'supplier_id'     => 'required',
                              'pengirim'     => 'required',
                              'tipe_pembayaran'     => 'required',
                              'karat_id.0'     => 'required',
                              'karat_id.*'     => 'required',
                              'kategori_id.0'     => 'required',
                              'kategori_id.*'     => 'required',
                              'qty.0'     => 'required',
                              'qty.*'     => 'required'
                        ];

                        foreach($this->inputs as $key => $value)
                        {
                            $rules['kategori_id.0'] = 'required';
                            $rules['kategori_id.'.$value] = 'required';
                            $rules['qty.0'] = 'required';
                            $rules['qty.'.$value] = 'required';
                            $rules['karat_id.0'] = 'required';
                            $rules['karat_id.'.$value] = 'required';

                        }
                        return $rules;
                   }


                public function messages()
                {
                    $messages = [];
                      foreach($this->inputs as $key => $value)
                      {
                        $messages['qty.0'] = 'required';
                        $messages['qty.'.$value] = 'required';
                        $messages['kategori.0'] = 'kosong';
                        $messages['kategori.'.$value] = 'kosong';
                        $messages['karat_id.0'] = 'required';
                        $messages['karat_id.'.$value] = 'required';
                      }
                      return $messages;

                }




            public function changeEvent($value)
                {
                    $this->pilih_tipe_pembayaran = $value;
                }



            public function updated($propertyName)
                {
                    $this->validateOnly($propertyName);
                    $this->total_qty = 0;
                    // if ($this->inputs) {
                    //     $this->validateOnly($propertyName);
                    // }
                }

            public function store()
            {

                // $this->validate();

                  $this->post['no_invoice'] = $this->no_invoice;
                  $this->post['karat_id'] = $this->karat_id;
                  $this->post['kategori_id'] = $this->kategori_id;
                  $this->post['total_emas'] = $this->total_emas;
                  $this->post['berat_real'] = $this->berat_real;
                  $this->post['tanggal'] = $this->tanggal;
                  $this->post['tipe_pembayaran'] = $this->tipe_pembayaran;

                  dd($this->post);


                 foreach ($this->no_invoice as $key => $value) {
                    $harga = preg_replace("/[^0-9]/", "", $this->harga[$key]);
                   // dd($harga);
                    //GoodsReceipt::create(['code' => $this->code[$key], 'no_invoice' => $this->no_invoice[$key]]);
                }

                $this->inputs = [];

                $this->resetInputFields();

                session()->flash('message', 'Created Successfully.');
                      }


             public function convertRupiah()
            {
                $this->product_price = 'Rp ' . number_format($this->price, 0, ',', '.');
            }



}
