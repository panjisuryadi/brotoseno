<?php

namespace App\Http\Livewire\Pos;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Livewire\Component;
use Modules\Cabang\Models\Cabang;
use Modules\DataBank\Models\DataBank;
use Modules\DataRekening\Models\DataRekening;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\Sale\Entities\Customs;
use Modules\Sale\Entities\CustomsCt;
use Modules\Sale\Entities\CustomsManual;
use Modules\Sale\Entities\SaleManual;

class Checkout extends Component
{

    public $cabangs;
    public $cabang_id;
    public $other_fees = [];
    public $other_thing = [];
    public $payment_method = '';
    public $paid_amount = 0;
    public $return_amount = 0;
    public $note = '';
    public $banks;
    public $edcs;
    public $bank_id = '';
    public $edc_id = '';
    public $multiple_payment_method = "false";
    public $total_payment_amount = 0;
    public $remaining_payment_amount = 0;
    // public $inputs = [
    //     [
    //         'karat_id' => '',
    //         'berat_real' => 0,
    //         'berat_kotor' => 0
    //     ]
    // ];
    public $inputCustom = [
        [
            
            'berat_ct' => 0,
            'harga_ct' => 0
        ]
    ];

    public $payments = [
        [
            'method' => '',
            'amount' => 0,
            'paid_amount' => 0,
            'return_amount' => 0,
            'bank_id' => '',
            'edc_id' => ''
        ]
    ];

    public $listeners = ['productSelected',  'discountModalRefresh'];

    public $cart_instance;
    public $row_id;
    public $customers;
    public $data;
    public $customer_id;
    public $total_amount = 0;

    public $discount;
    public $diskon = 0;
    public $bayar = 0;
    public $kembali = 0;
    public $total = 0;
    public $keterangan = 0;


    public $keterangan_manual = '';
    public $manual = 0;
    public $manual_item = 0;
    public $manual_price = 0;

    public $sub_total = 0;
    public $sub_total_hidden = 0;
    public $discountAmount = 0;
    public $grand_total;
    public $show = false;
    public $showTunai = true;
    public $showTransfer = false;
    public $showEdc = false;
    public $loading = false;
    public $PaymentType;
    public $showPaymentType = 'tunai';
    public $dp_payment = 0;
    public $dp_nominal = 0;
    public $remain_amount = 0;
    public $tmp_grand_total = 0;

    // Custome oop
    public $jenis_barang;
    public $karat_id;
    public $berat_gr;
    public $harga_gr;
    public $ongkos_produksi;
    public $ongkos_cuci;
    public $ongkos_rnk;
    public $ongkos_mt;
    public $total_custom;
    // end

    public function updatedMultiplePaymentMethod($value)
    {
        $this->resetSinglePaymentMethod();
        $this->resetMultiplePaymentMethod();
        if ($value == 'true') {
            $this->updateRemainingPaymentAmount();
        }
    }

    public function resetSinglePaymentMethod()
    {
        $this->reset([
            'payment_method',
            'paid_amount',
            'return_amount',
            'bank_id',
            'edc_id'
        ]);
    }

    public function resetMultiplePaymentMethod()
    {
        $this->reset('payments');
        $this->reset('total_payment_amount');
        $this->reset('remaining_payment_amount');
    }

    public function getTotalAmountTextProperty()
    {
        return format_uang($this->total_amount);
    }

    public function getGrandTotalTextProperty()
    {
        return format_uang($this->grand_total);
    }

    public function updatedDiskon($value)
    {
        $this->calculateGrandTotal();
    }

    public function add_other_fee()
    {
        $this->other_fees[] = [
            'nominal' => 0,
            'note' => ''
        ];
    }

    public function remove_other_fee($index)
    {
        unset($this->other_fees[$index]);
        $this->calculateGrandTotal();
    }

    public function updatedPaidAmount($value)
    {
        if ($value != '' && $value >= $this->grand_total) {
            $this->return_amount = $value - $this->grand_total;
        }
    }

    public function getReturnAmountTextProperty()
    {
        return format_uang($this->return_amount);
    }

    public function getReturnAmountText($index)
    {
        return format_uang($this->payments[$index]['return_amount']);
    }

    public function add_payment_method()
    {
        $this->payments[] = [
            'method' => '',
            'amount' => 0,
            'paid_amount' => 0,
            'return_amount' => 0,
            'bank_id' => '',
            'edc_id' => ''
        ];
    }

    public function remove_payment_method($index)
    {
        unset($this->payments[$index]);
        $this->payments = array_values($this->payments);
        $this->calculateTotalPaymentAmount();
    }

    public function calculateTotalPaymentAmount()
    {
        $total = 0;
        foreach ($this->payments as $payment) {
            if (!empty($payment['amount'])) {
                $total += $payment['amount'];
            }
        }
        $this->total_payment_amount = $total;
        $this->updateRemainingPaymentAmount();
    }

    public function amountUpdated($index)
    {
        $paid_amount = $this->payments[$index]['paid_amount'];
        if ($this->payments[$index]['method'] === 'tunai') {
            if (!empty($paid_amount) && $paid_amount >= $this->payments[$index]['amount']) {
                $this->payments[$index]['return_amount'] = $paid_amount - $this->payments[$index]['amount'];
            } else {
                $this->payments[$index]['return_amount'] = 0;
            }
        }
        $this->calculateTotalPaymentAmount();
    }

    public function updateRemainingPaymentAmount()
    {
        $this->remaining_payment_amount = $this->grand_total - $this->total_payment_amount;
    }

    public function getTotalPaymentAmountTextProperty()
    {
        return format_uang($this->total_payment_amount);
    }

    public function getRemainingPaymentAmountTextProperty()
    {
        return format_uang($this->remaining_payment_amount);
    }

    public function getAmountText($index)
    {
        if (!empty($this->payments[$index]['amount'])) {
            return format_uang($this->payments[$index]['amount']);
        }
    }

    public function paymentPaidAmountUpdated($index)
    {
        if ($this->payments[$index]['paid_amount'] != '' && $this->payments[$index]['amount'] != '' && $this->payments[$index]['paid_amount'] >= $this->payments[$index]['amount']) {
            $this->payments[$index]['return_amount'] = $this->payments[$index]['paid_amount'] - $this->payments[$index]['amount'];
        } else {
            $this->payments[$index]['return_amount'] = 0;
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedPaymentMethod($value)
    {
        $this->reset([
            'paid_amount',
            'return_amount',
            'bank_id',
            'edc_id'
        ]);
    }



    protected function rules()
    {
        $rules = [
            'cabang_id' => 'required',
            'diskon' => 'gt:-1',
            'payment_method' => 'required_if:multiple_payment_method,false',
            'paid_amount' => [
                'required_if:payment_method,tunai',
                function ($attribute, $value, $fail) {
                    if (($this->multiple_payment_method === "false") && ($this->payment_method === "tunai")) {
                        if (empty(intval($value))) {
                            $fail('Wajib diisi');
                        }
                        if ($value < $this->grand_total && !$this->isDp()) {
                            $fail('Jumlah yang dibayarkan tidak cukup.');
                        }
                        if ($this->isDp() && $value < $this->dp_nominal) {
                            $fail('Jumlah yang dibayarkan tidak cukup.');
                        }
                    }
                },
            ],
            'total_amount' => 'required',
            'grand_total' => 'gt:0',
            'bank_id' => 'required_if:payment_method,transfer',
            'edc_id' => 'required_if:payment_method,edc',
            'dp_nominal' => 'required_if:dp_payment,==,1|gt:-1',
            'remain_amount' => 'required_if:dp_payment,==,1',
        ];

        // Rules storeCustome
        foreach ($this->other_thing as $index => $fee) {
            $rules['other_thing.' . $index . '.custom_note'] = ['required'];
            $rules['other_thing.' . $index . '.custom_nominal'] = ['required', 'gt:0'];
        }
        // end

        foreach ($this->other_fees as $index => $fee) {
            $rules['other_fees.' . $index . '.note'] = ['required'];
            $rules['other_fees.' . $index . '.nominal'] = ['required', 'gt:0'];
        }

        foreach ($this->payments as $index => $payment) {
            $rules['payments.' . $index . '.method'] = ['required_if:multiple_payment_method,true'];
            $rules['payments.' . $index . '.amount'] = [
                'required_if:multiple_payment_method,true',
                function ($attribute, $value, $fail) {
                    if ($this->multiple_payment_method == 'true') {
                        if (empty(intval($value))) {
                            $fail('Wajib diisi');
                        }
                        if ($this->total_payment_amount > $this->grand_total && !$this->isDp()) {
                            $fail('Jumlah melebihi grand total');
                        }
                        if ($this->total_payment_amount > $this->dp_nominal && $this->isDp()) {
                            $fail('Jumlah melebihi grand total');
                        }
                    }
                },
            ];
            $rules['payments.' . $index . '.paid_amount'] = [
                'required_if:payments.' . $index . '.method,tunai',
                function ($attribute, $value, $fail) use ($index) {
                    if ($this->multiple_payment_method == 'true' && $this->payments[$index]['method'] === 'tunai') {
                        if (empty(intval($value))) {
                            $fail('Wajib diisi');
                        }
                        if ($value < $this->payments[$index]['amount']) {
                            $fail('Jumlah yang dibayarkan tidak cukup');
                        }
                    }
                },
            ];
        }

        return $rules;
    }


    public function mount($cartInstance, $customers)
    {
        $this->cart_instance = $cartInstance;
        $this->customers = $customers;
        $this->customer_id = null;
        $this->global_discount = 0;
        $this->global_tax = 0;
        $this->shipping = 0.00;
        $this->check_quantity = [];
        $this->quantity = [];
        $this->discount_type = [];
        $this->item_discount = [];
        $this->cart = [];
        $this->total_amount;
        $this->manual_item;
        $this->manual_price;
        $this->manual;
        $this->row_id;
        $this->showPaymentType;
        $this->paid_amount;
        $this->cabangs = Cabang::all();
        // $this->customs;
        $this->cabang_id = auth()->user()->isUserCabang() ? auth()->user()->namacabang()->id : '';
        $this->banks = DataBank::all();
        $this->edcs = DataRekening::all();
    }


    public function PaymentType($type)
    {
        $this->loading = true;
        sleep(1);
        $this->showPaymentType = $type;
        $this->loading = false;
    }


    public function totalbayar()
    {
        //$this->resetInput();
        if ($this->paid_amount == 0  && $this->sub_total == 0) {
            $this->sub_total = $this->total_amount;
        }
        $subtotal = preg_replace("/[^0-9]/", "", $this->total_amount);
        $hitung_bayar = preg_replace("/[^0-9]/", "", $this->paid_amount);
        $kembalian = (int)$hitung_bayar - (int)$subtotal;
        $this->kembali = 'Rp ' . number_format($kembalian, 0, ',', '.');

        $this->grand_total = 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }




    public function recalculateTotal()
    {
        if (
            $this->total_amount == 0
            && $this->diskon == 0
        ) {
            $this->total = 0;
        }

        $hitung_bayar = preg_replace("/[^0-9]/", "", $this->total_amount);
        $hitung_diskon = preg_replace("/[^0-9]/", "", $this->diskon);
        $total = (int)$hitung_bayar - (int)$hitung_diskon;


        if ($hitung_diskon > $hitung_bayar) {
            session()->flash('pesan', 'Diskon melebihi jumlah yang dibayar.');
            $this->diskon = 0;
            $this->sub_total = $this->total_amount;
            $this->sub_total_hidden = $hitung_bayar;
        } else {
            $this->sub_total = 'Rp ' . number_format($total, 0, ',', '.');
            $this->grand_total = 'Rp ' . number_format($total, 0, ',', '.');
            $this->total = $total;
            $this->sub_total_hidden = $total;
        }
        // dd($hitung_bayar);


    }



    public function togglePanel()
    {
        $this->showEdc = false;
        $this->showTransfer = false;
        $this->loading = true;
        sleep(1);
        $this->showTunai = !$this->showTunai;
        $this->loading = false;
    }




    public function btnTransfer()
    {

        $this->showEdc = false;
        $this->showTunai = false;
        $this->loading = true;
        sleep(1);

        $this->showTransfer = !$this->showTransfer;
        $this->loading = false;
    }

    public function btnEdc()
    {
        $this->showTransfer = false;
        $this->showTunai = false;
        $this->loading = true;
        sleep(1);
        $this->showEdc = !$this->showEdc;
        $this->loading = false;
    }

    public function hydrate()
    {
        //$this->total_amount = $this->calculateTotal();
        //$this->updatedCustomerId();
    }


    public function convertRupiah()
    {
        $this->paid_amount = 'Rp ' . number_format($this->paid_amount, 0, ',', '.');
    }

    public function grandtotal()
    {
        return Cart::instance($this->cart_instance)->total();
    }



    public function render()
    {
        $cart_items = Cart::instance($this->cart_instance)->content();
        $customs = Customs::where('sales_id', null)->get();
        return view('livewire.pos.checkout', [
            'cart_items' => $cart_items,
            'customs' => $customs
        ]);
    }

    //========================== Custom Function ====================================
    public function showCustom()
    {
        $this->dispatchBrowserEvent(
            'showCustomModal',
            [
                'customer_id' => $this->customer_id
            ]
        );
    }

    public function addInput()
    {
        $this->inputCustom[] = [
            'berat_ct' => 0,
            'harga_ct' => 0
        ];
    }

    public function remove($i)
    {
        $this->resetErrorBag();
        unset($this->inputCustom[$i]);
        $this->inputCustom = array_values($this->inputCustom);
    }

    public function storeCustom()
    {
        $this->validate([
            'cabang_id' => 'required',
            'jenis_barang' => 'required',
            // 'karat_id' => 'required',
            'berat_gr' => 'required',
            'harga_gr' => 'required',
            // 'ongkos_produksi' => 'required',
            // 'ongkos_cuci' => 'required',
            // 'ongkos_rnk' => 'required',
            // 'ongkos_mt' => 'required',
            'total_custom' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $customs = Customs::create([
                'cabang_id' => $this->cabang_id,
                'custom_code' => $this->generateCodeCustom(),
                'jenis_barang' => $this->jenis_barang,
                'karat_id' => 1,
                'berat' => $this->berat_gr,
                'harga' => $this->harga_gr,
                'ongkos_produksi' => $this->ongkos_produksi ?: 0,
                'ongkos_cuci' => $this->ongkos_cuci ?: 0,
                'ongkos_rnk' => $this->ongkos_rnk ?: 0,
                'ongkos_mt' => $this->ongkos_mt ?: 0,
                'total' => $this->total_custom
            ]);
            foreach ($this->inputCustom as $input) {
                CustomsCt::create([
                    'customs_id' => $customs->id,
                    'berat' => $input['berat_ct'],
                    'harga' => $input['harga_ct'],
                ]);
            }
            foreach ($this->other_thing as $fee) {
                CustomsManual::create([
                    'customs_id' => $customs->id,
                    'catatan' => $fee['custom_note'],
                    'nominal' => $fee['custom_nominal'],
                ]);
            }

            // dd($this->karat_id);

            DB::commit();
            toast('Produk Custom Berhasil Dibuat!', 'success');
            return redirect()->route('sale.custom.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function removeCustome($row_id)
    {
        CustomsCt::where('customs_id', $row_id)->delete();
        Customs::destroy($row_id);
    }

    public function add_other_thing()
    {
        $this->other_thing[] = [
            'custom_note' => '',
            'custom_nominal' => 0
        ];
    }

    public function remove_other_thing($index)
    {
        unset($this->other_thing[$index]);
    }

    public function generateCodeCustom()
    {
        $date = now()->format('dmY');
        $code = 'CTM';
        $dateCode = $code . $date;
        $lastOrder = Customs::where('custom_code', 'like', $dateCode . '%')
                         ->orderBy('custom_code', 'desc')
                         ->first();
        
        $lastOrderCode = $lastOrder ? $lastOrder->custom_code : null;
    
        $orderCode = $dateCode . '00001';
        
        if ($lastOrderCode) {
            $lastOrderNumber = intval(substr($lastOrderCode, -5));
            $nextOrderNumber = sprintf('%05d', $lastOrderNumber + 1);
            $orderCode = $code . '-' . $nextOrderNumber;
        }
    
        return $orderCode;
    }
    

    // ========================= End Function =======================================

    public function proceed()
    {


        //  $cart = $this->total_amount;
        $cart = [
            "customer_id" => $this->customer_id,
            "total_amount" => $this->total_amount,
            "paid" => $this->total_amount
        ];
        $this->emit('cartAdded', $cart);
        $cart_items = Cart::instance($this->cart_instance)->content();

        $dataCustoms = Customs::whereNull('sales_id')->exists();
        $this->dp_payment = $dataCustoms ? 1 : 0;

        $this->dispatchBrowserEvent(
            'showCheckoutModal',
            [
                'customer_id' => $this->customer_id

            ]
        );
    }

    public function selectcartModal()
    {
        $cart = Cart::instance($this->cart_instance)->content();
        //$this->emit('cartModal', $cart);
    }

    public function calculateTotal()
    {
        $this->total_amount = Cart::instance($this->cart_instance)->total() + $this->shipping;
    }

    public function resetCart()
    {
        Cart::instance($this->cart_instance)->destroy();
        $this->calculateTotal();
        $this->calculateGrandTotal();
    }

    public function productSelected(Product $product)
    {
        $cart = Cart::instance($this->cart_instance);
        $exists = $cart->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id == $product->id;
        });


        if (empty($product->product_price) && empty($product->karat->penentuanHarga->harga_jual)) {
            session()->flash('message', 'Penentuan Harga ' . $product->karat?->label . ' Belum di setting!');
            return;
        }

        if ($exists->isNotEmpty()) {
            session()->flash('message', 'Product exists in the cart!');
            return;
        }

        $cart->add([
            'id'      => $product->id,
            'name'    => $product->product_name,
            'qty'     => 1,
            //'price'   => $product['karat']['penentuan_harga']['harga_jual']*$product['berat_emas'],
            'price'   => $this->HitungHarga($product),
            'weight'  => 1,
            'options' => [
                'product_discount'      => 0.00,
                'product_discount_type' => 'fixed',
                'sub_total'             => 1,
                'code'                  => $product->product_code,
                'stock'                 => 1,
                'unit'                  => $product->product_unit,
                'karat_id'              => $product->karat_id,
                'karat'                 => $product->karat->label ?? '',
                'harga_jual'            => $this->HitungHarga($product),
                'berat_emas'            => $product->berat_emas,
                'images'                => $product->images,
                'product_tax'           => 1,
                'manual'                => 0,
                'manual_item'           => 0,
                'manual_price'          => 0,
                'unit_price'            => 1
            ]
        ]);

        $this->check_quantity[$product->id] = 1;
        $this->quantity[$product->id] = 1;
        $this->discount_type[$product->id] = 'fixed';
        $this->item_discount[$product->id] = 0;
        $this->calculateTotal();
        $this->calculateGrandTotal();
        //$this->emit('cartModal', $product);
    }

    public function calculateGrandTotal()
    {
        $diskon = !empty($this->diskon) ? $this->diskon : 0;
        $this->grand_total = ($this->total_amount - $diskon) + $this->totalOtherFees();
        if ($this->multiple_payment_method == 'false') {
            if ($this->payment_method === 'tunai') {
                $this->return_amount = $this->paid_amount - $this->grand_total;
            }
        } elseif ($this->multiple_payment_method == 'true') {
            $this->updateRemainingPaymentAmount();
        }
        $this->tmp_grand_total = $this->grand_total;
    }

    private function totalOtherFees()
    {
        $total = 0;
        if (count($this->other_fees)) {
            foreach ($this->other_fees as $fee) {
                if ($fee['nominal'] > 0) {
                    $total += $fee['nominal'];
                }
            }
        }
        return $total;
    }


    public function setManualtype()
    {
        $manual_price = $this->manual_price;
        $manual_item = $this->manual_item;
        $row_id = Cart::instance($this->cart_instance)->content()->first()->rowId;
        $this->updateManualOptions($row_id, $manual_item, $manual_price);
        session()->flash('manual', 'Manual tipe diupdate');
    }



    public function removeItem($row_id)
    {
        Cart::instance($this->cart_instance)->remove($row_id);
        $this->calculateTotal();
        $this->calculateGrandTotal();
    }



    public function updatedGlobalTax()
    {
        Cart::instance($this->cart_instance)->setGlobalTax((int)$this->global_tax);
    }



    public function updatedGlobalDiscount()
    {
        Cart::instance($this->cart_instance)->setGlobalDiscount((int)$this->global_discount);
    }



    public function updateQuantity($row_id, $product_id)
    {
        if ($this->check_quantity[$product_id] < $this->quantity[$product_id]) {
            session()->flash('message', 'The requested quantity is not available in stock.');

            return;
        }

        Cart::instance($this->cart_instance)->update($row_id, $this->quantity[$product_id]);

        $cart_item = Cart::instance($this->cart_instance)->get($row_id);

        Cart::instance($this->cart_instance)->update($row_id, [
            'options' => [
                'sub_total'             => $cart_item->price * $cart_item->qty,
                'code'                  => $cart_item->options->code,
                'stock'                 => $cart_item->options->stock,
                'unit'                  => $cart_item->options->unit,
                'harga_jual'           => $cart_item->options->harga_jual,
                'product_tax'           => $cart_item->options->product_tax,
                'unit_price'            => $cart_item->options->unit_price,
                'product_discount'      => $cart_item->options->product_discount,
                'product_discount_type' => $cart_item->options->product_discount_type,
            ]
        ]);
    }



    public function HitungHarga($product)
    {
        $totalPrice = 0;
        if (empty($product->product_price)) {
            $totalPrice = $product->karat->penentuanHarga->harga_jual * $product->berat_emas;
        } else {
            $totalPrice = $product->product_price;
        }
        return $totalPrice;
    }



    public function updatedDiscountType($value, $name)
    {
        $this->item_discount[$name] = 0;
    }


    public function discountModalRefresh($product_id, $row_id)
    {
        $this->updateQuantity($row_id, $product_id);
    }


    //set utk diskon
    public function setProductDiscount($row_id, $product_id)
    {
        $cart_item = Cart::instance($this->cart_instance)->get($row_id);

        if ($this->discount_type[$product_id] == 'fixed') {
            Cart::instance($this->cart_instance)
                ->update($row_id, [
                    'price' => ($cart_item->price + $cart_item->options->product_discount) - $this->item_discount[$product_id]
                ]);

            $discount_amount = $this->item_discount[$product_id];

            $this->updateCartOptions($row_id, $product_id, $cart_item, $discount_amount);
        } elseif ($this->discount_type[$product_id] == 'percentage') {
            $discount_amount = ($cart_item->price + $cart_item->options->product_discount) * ($this->item_discount[$product_id] / 100);

            Cart::instance($this->cart_instance)
                ->update($row_id, [
                    'price' => ($cart_item->price + $cart_item->options->product_discount) - $discount_amount
                ]);

            $this->updateCartOptions($row_id, $product_id, $cart_item, $discount_amount);
        }

        session()->flash('discount_message' . $product_id, 'Discount added to the product!');
    }








    public function calculate($product)
    {
        $price = 0;
        $unit_price = 0;
        $product_tax = 0;
        $sub_total = 0;

        // if ($product['product_tax_type'] == 1) {
        //     $price = 1000;
        //     $unit_price = 1000;
        //     $product_tax = 100;
        //     $sub_total = 1000;
        // }

        // elseif ($product['product_tax_type'] == 2) {
        //     $price = $product['product_price'];
        //     $unit_price = $product['product_price'] - ($product['product_price'] * ($product['product_order_tax'] / 100));
        //     $product_tax = $product['product_price'] * ($product['product_order_tax'] / 100);
        //     $sub_total = $product['product_price'];
        // } else {
        //     $price = $product['product_price'];
        //     $unit_price = $product['product_price'];
        //     $product_tax = 0.00;
        //     $sub_total = $product['product_price'];
        // }

        return ['price' => $price, 'unit_price' => $unit_price, 'product_tax' => $product_tax, 'sub_total' => $sub_total];
    }





    public function updateCartOptions($row_id, $product_id, $cart_item, $discount_amount)
    {
        Cart::instance($this->cart_instance)->update($row_id, ['options' => [
            'sub_total'             => $cart_item->price * $cart_item->qty,
            'code'                  => $cart_item->options->code,
            'stock'                 => $cart_item->options->stock,
            'unit'                  => $cart_item->options->unit,
            'product_tax'           => $cart_item->options->product_tax,
            'unit_price'            => $cart_item->options->unit_price,
            'harga_jual'            => $cart_item->options->harga_jual,
            'product_discount'      => $discount_amount,
            'product_discount_type' => $this->discount_type[$product_id],
        ]]);
    }

    public function updateManualOptions($row_id, $manual_item, $manual_price)
    {
        Cart::instance($this->cart_instance)->update($row_id, ['options' => [
            'manual'                => 1,
            'manual_item'           => $manual_item,
            'manual_price'          => $manual_price,

        ]]);
    }





    public function store()
    {
        $this->validate();
        $this->validate([
            'total_payment_amount' => [
                function ($attribute, $value, $fail) {
                    if ($this->multiple_payment_method == 'true') {
                        if ($value < $this->grand_total && !$this->isDp()) {
                            $fail('Jumlah yang dibayarkan tidak cukup');
                            $this->dispatchBrowserEvent('total_payment_amount', [
                                'message' => 'Total yang dibayarkan belum memenuhi Grand Total'
                            ]);
                        } elseif ($value > $this->grand_total  && !$this->isDp()) {
                            $fail('Jumlah yang dibayarkan melebihi grand total');
                            $this->dispatchBrowserEvent('total_payment_amount', [
                                'message' => 'Total yang dibayarkan melebihi Grand Total'
                            ]);
                        }

                        if ($value < $this->dp_nominal && $this->isDp()) {
                            $fail('Jumlah yang dibayarkan tidak cukup');
                            $this->dispatchBrowserEvent('total_payment_amount', [
                                'message' => 'Total yang dibayarkan belum memenuhi nominal dp'
                            ]);
                        } elseif ($value > $this->dp_nominal && $this->isDp()) {
                            $fail('Jumlah yang dibayarkan melebihi nominal dp');
                            $this->dispatchBrowserEvent('total_payment_amount', [
                                'message' => 'Total yang dibayarkan melebihi nominal dp'
                            ]);
                        }
                    }
                },
            ]
        ]);
        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'date' => date('Y-m-d'),
                'reference' => 'jsr',
                'customer_id' => !empty($this->customer_id) ? $this->customer_id : null,
                'customer_name' => Customer::find($this->customer_id)?->customer_name,
                'total_amount' => $this->total_amount,
                'grand_total_amount' => $this->grand_total,
                'other_total_amount' => $this->totalOtherFees(),
                'discount_amount' => !empty($this->diskon) ? $this->diskon : 0,
                'note' => !empty($this->note) ? $this->note : null,
                'user_id' => Auth::user()->id,
                'cabang_id' => $this->cabang_id,
                'payment_status' => !$this->isDp() ? Sale::SP_PAID : Sale::SP_DP,
                'status' => !$this->isDp() ? Sale::S_COMPLETED : Sale::S_DP,
                'dp_payment' => $this->dp_payment,
                'dp_nominal' => $this->dp_nominal,
                'remain_amount' => $this->remain_amount,
            ]);
            foreach (Cart::instance('sale')->content() as $cart_item) {
                $detail = SaleDetails::create([
                    'sale_id' => $sale->id,
                    'product_id' => $cart_item->id,
                    'product_name' => $cart_item->name,
                    'product_code' => $cart_item->options->code,
                    'quantity' => $cart_item->qty,
                    'price' => $cart_item->options->harga_jual,
                    'unit_price' => 1,
                    'product_discount_amount' => 0,
                    'product_tax_amount' => 0,

                ]);
                if ($this->isDp()) {
                    $detail->product->updateTracking(ProductStatus::DP, $sale->cabang_id);
                } else {
                    $detail->product->updateTracking(ProductStatus::SOLD, $sale->cabang_id);
                }
            }

            // sale manual
            $this->manageSaleManual($sale);

            // payment
            $this->managePayment($sale);
            Customs::whereNull('sales_id')->update(['sales_id' => $sale->id]);

            Cart::instance('sale')->destroy();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        toast('POS Sale Created!', 'success');
        return redirect()->route('sales.index');
    }

    private function managePayment($sale)
    {
        if ($this->multiple_payment_method === 'false') {
            $data = [
                'date' => now()->format('Y-m-d'),
                'reference' => 'INV/' . $sale->reference,
                'paid_amount' => ($this->payment_method === 'tunai') ? $this->paid_amount : $this->grand_total,
                'payment_method' => $this->payment_method
            ];
            if ($this->payment_method === 'tunai') {
                $data['return_amount'] = $this->return_amount;
            } elseif ($this->payment_method === 'transfer') {
                $data['bank_id'] = $this->bank_id;
            } elseif ($this->payment_method === 'edc') {
                $data['edc_id'] = $this->edc_id;
            }

            $sale->salePayments()->create($data);
        } elseif ($this->multiple_payment_method === 'true') {
            foreach ($this->payments as $index => $payment) {
                $data = [
                    'date' => now()->format('Y-m-d'),
                    'reference' => 'INV/' . $sale->reference,
                    'paid_amount' => ($payment['method'] === 'tunai') ? $payment['paid_amount'] : $payment['amount'],
                    'payment_method' => $payment['method']
                ];
                if ($payment['method'] === 'tunai') {
                    $data['return_amount'] = $payment['return_amount'];
                } elseif ($payment['method'] === 'transfer') {
                    $data['bank_id'] = $payment['bank_id'];
                } elseif ($payment['method'] === 'edc') {
                    $data['edc_id'] = $payment['edc_id'];
                }

                $sale->salePayments()->create($data);
            }
        }
    }

    private function manageSaleManual($sale)
    {
        if (count($this->other_fees)) {
            foreach ($this->other_fees as $index => $fee) {
                $sale->manual()->create([
                    'date' => now()->format('Y-m-d'),
                    'reference' => 'INV/' . $sale->reference,
                    'nominal' => $fee['nominal'],
                    'note' => $fee['note']
                ]);
            }
        }
    }

    public function updatedDpNominal()
    {
        $this->grand_total = $this->tmp_grand_total;
        $this->remain_amount = (int) $this->grand_total - (int) (!empty($this->dp_nominal) ? $this->dp_nominal :  0);
        $this->grand_total = $this->dp_nominal;
    }

    public function isDp()
    {
        return $this->dp_payment ?? 0;
    }
}
