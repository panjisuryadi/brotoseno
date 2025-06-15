<?php

namespace App\Http\Livewire\PenjualanSale\Dp;

use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\BuysBack\Models\BuyBackItem;
use Modules\DataBank\Models\DataBank;
use Modules\DataRekening\Models\DataRekening;
use Modules\GoodsReceipt\Models\Toko\BuyBackBarangLuar;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\Sale\Entities\Sale;
use Modules\Status\Models\ProsesStatus;
use Modules\Stok\Models\StockPending;

class Bayar extends Component
{
    public $grand_total = 0;
    public $paid_amount = 0;
    public $return_amount = 0;
    public $banks;
    public $edcs;
    public $bank_id = '';
    public $edc_id = '';
    public $payment_method = '';
    public $multiple_payment_method = "false";
    public $total_payment_amount = 0;
    public $remaining_payment_amount = 0;
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


    public $code;
    public $date;
    public Product $product;
    public $nominal_text = '';

    public $customer;
    public $customers;
    public $nominal = 0;

    public $note = '';

    public $postCount;
    public $sale_id;
    public $sale;
    public $total;
    public $dp_nominal;
    public $remain_amount;
 
    protected $listeners = ['setSaleId' => 'setSaleId'];
 
    public function setSaleId($sale_id)
    {
        $this->sale_id = $sale_id;
        $sale = Sale::with('saleDetails')->find($this->sale_id);
        $this->sale = $sale;
        $this->total = $sale->dp_nominal + $sale->remain_amount;
        $this->remain_amount = $sale->remain_amount;
        $this->grand_total = $sale->remain_amount;
        $this->dp_nominal = $sale->dp_nominal;
    }

    public function updatedGrandTotal($value)
    {
        $this->calculateGrandTotal();
    }

    public function calculateGrandTotal()
    {
        if ($this->multiple_payment_method == 'false') {
            if($this->payment_method === 'tunai'){
                if (!empty($this->grand_total) && !empty($this->paid_amount)) {
                    $this->return_amount = $this->paid_amount - $this->grand_total;
                }else{
                    $this->reset('return_amount');
                }
            }
        }elseif($this->multiple_payment_method == 'true'){
            $this->updateRemainingPaymentAmount();
        }
    }
    
    public function updatedMultiplePaymentMethod($value){
        $this->resetSinglePaymentMethod();
        $this->resetMultiplePaymentMethod();
        if($value == 'true'){
            $this->updateRemainingPaymentAmount();
        }
    }

    public function resetSinglePaymentMethod(){
        $this->reset([
            'payment_method',
            'paid_amount',
            'return_amount',
            'bank_id',
            'edc_id'
        ]);
    }

    public function resetMultiplePaymentMethod(){
        $this->reset('payments');
        $this->reset('total_payment_amount');
        $this->reset('remaining_payment_amount');
    }

    public function getReturnAmountTextProperty()
    {
        return format_uang($this->return_amount);
    }

    public function getTotalAmountTextProperty()
    {
        return format_uang($this->total_amount);
    }

    public function getGrandTotalTextProperty()
    {
        if(!empty($this->grand_total)){
            return format_uang($this->grand_total);
        }
    }

    public function getTotalPaymentAmountTextProperty(){
        return format_uang($this->total_payment_amount);
    }

    public function getRemainingPaymentAmountTextProperty(){
        return format_uang($this->remaining_payment_amount);
    }

    public function getAmountText($index){
        if(!empty($this->payments[$index]['amount'])){
            return format_uang($this->payments[$index]['amount']);
        }
    }

    public function remove_payment_method($index){
        unset($this->payments[$index]);
        $this->payments = array_values($this->payments);
        $this->calculateTotalPaymentAmount();
    }

    public function calculateTotalPaymentAmount(){
        $total = 0;
        foreach($this->payments as $payment){
            if(!empty($payment['amount'])){
                $total += $payment['amount'];
            }
        }
        $this->total_payment_amount = $total;
        $this->updateRemainingPaymentAmount();
    }

    public function updateRemainingPaymentAmount(){
        $this->remaining_payment_amount = $this->grand_total - $this->total_payment_amount;
    }

    public function amountUpdated($index){
        $paid_amount = $this->payments[$index]['paid_amount'];
        if($this->payments[$index]['method'] === 'tunai'){
            if(!empty($paid_amount) && !empty($this->payments[$index]['amount']) && ($paid_amount >= $this->payments[$index]['amount'])){
                $this->payments[$index]['return_amount'] = $paid_amount - $this->payments[$index]['amount'];
            }else{
                $this->payments[$index]['return_amount'] = 0;
            }
        }
        $this->calculateTotalPaymentAmount();
    }
    
    public function paymentPaidAmountUpdated($index){
        if ($this->payments[$index]['paid_amount'] != '' && $this->payments[$index]['amount'] != '' && $this->payments[$index]['paid_amount'] >= $this->payments[$index]['amount']) {
            $this->payments[$index]['return_amount'] = $this->payments[$index]['paid_amount'] - $this->payments[$index]['amount'];
        }else{
            $this->payments[$index]['return_amount'] = 0;
        }
    }

    public function getReturnAmountText($index)
    {
        return format_uang($this->payments[$index]['return_amount']);
    }

    public function add_payment_method(){
        $this->payments[] = [
            'method' => '',
            'amount' => 0,
            'paid_amount' => 0,
            'return_amount' => 0,
            'bank_id' => '',
            'edc_id' => ''
        ];
    }

    public function updatedPaidAmount($value)
    {
        if ($value != '') {
            $this->return_amount = $value - $this->grand_total;
        }else{
            $this->reset('return_amount');
        }
    }

    public function updatedPaymentMethod($value){
        $this->reset([
            'paid_amount',
            'return_amount',
            'bank_id',
            'edc_id'
        ]);
    }

    public function __construct()
    {
        $this->product = new Product();
    }

    public function mount() {
        $this->date = (new DateTime())->format('Y-m-d');
        $this->customers = Customer::all();
        $this->banks = DataBank::all();
        $this->edcs = DataRekening::all();

    }

    public function rules()
    {
        $rules = [
            'payment_method' => 'required_if:multiple_payment_method,false',
            'paid_amount' => [
                'required_if:payment_method,tunai',
                function ($attribute, $value, $fail) {
                    if (($this->multiple_payment_method === "false") && ($this->payment_method === "tunai")) {
                        if (empty(intval($value))) {
                            $fail('Wajib diisi');
                        }
                        if ($value < $this->grand_total) {
                            $fail('Jumlah yang dibayarkan tidak cukup.');
                        }
                    }
                },
            ],
            'grand_total' => 'required|gt:0',
            'bank_id' => 'required_if:payment_method,transfer',
            'edc_id' => 'required_if:payment_method,edc'
        ];

        foreach($this->payments as $index => $payment){
            $rules['payments.' . $index . '.method'] = ['required_if:multiple_payment_method,true'];
            $rules['payments.' . $index . '.amount'] = [
                'required_if:multiple_payment_method,true',
                function ($attribute, $value, $fail) {
                    if ($this->multiple_payment_method == 'true') {
                        if (empty(intval($value))) {
                            $fail('Wajib diisi');
                        }
                        if ($this->total_payment_amount > $this->grand_total) {
                            $fail('Jumlah melebihi grand total');
                        }
                    }
                },
            ];
            $rules['payments.' . $index . '.paid_amount'] = [
                'required_if:payments.'.$index.'.method,tunai',
                function ($attribute, $value, $fail) use ($index){
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

    public function render() {
        return view('livewire.penjualan-sale.dp.modal.create');
    }

    public function findProduct(){
        $this->reset('product');
        $this->validateOnly('code');
        $this->setProduct();
    }

    private function setProduct(){
        $this->product = Product::withoutGlobalScope('filter_by_cabang')->with('karat')->where(['product_code' => $this->code])->first();
    }

    public function store(){

        $this->validate();
        $this->validate([
            'total_payment_amount' => [
                function ($attribute, $value, $fail){
                    if ($this->multiple_payment_method == 'true') {
                        if ($value < $this->grand_total) {
                            $fail('Jumlah yang dibayarkan tidak cukup');
                            $this->dispatchBrowserEvent('total_payment_amount',[
                                'message' => 'Total yang dibayarkan belum memenuhi Grand Total'
                            ]);
                        }elseif($value > $this->grand_total){
                            $fail('Jumlah yang dibayarkan melebihi grand total');
                            $this->dispatchBrowserEvent('total_payment_amount',[
                                'message' => 'Total yang dibayarkan melebihi Grand Total'
                            ]);
                        }
                    }
                },
            ]
        ]);

        DB::beginTransaction();
        try{

            $sale = $this->sale;

            if(!empty($sale->saleDetails)){
                foreach($sale->saleDetails as $detail) {
                    $detail->product->updateTracking(ProductStatus::SOLD, $sale->cabang_id);
                }

                $sale->status = Sale::S_COMPLETED;
                $sale->grand_total_amount = $this->dp_nominal+$this->remain_amount;
                $sale->remain_amount = 0;
                $sale->save();
                
            // payment
            $this->managePayment($sale);
            
            }

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        toast('Pembayaran barang DP sukses','success');
        return redirect(route('sales.index'));
        
    }


    private function managePayment($sale){
        if($this->multiple_payment_method === 'false'){
            $data = [
                'date' => now()->format('Y-m-d'),
                'reference' => 'INV/'.$sale->reference,
                'paid_amount' => ($this->payment_method === 'tunai')?$this->paid_amount:$this->grand_total,
                'payment_method' => $this->payment_method
            ];
            if($this->payment_method === 'tunai'){
                $data['return_amount'] = $this->return_amount;
            }elseif($this->payment_method === 'transfer'){
                $data['bank_id'] = $this->bank_id;
            }elseif($this->payment_method === 'edc'){
                $data['edc_id'] = $this->edc_id;
            }
    
            $sale->salePayments()->create($data);
        }elseif($this->multiple_payment_method === 'true'){
            foreach($this->payments as $index => $payment){
                $data = [
                    'date' => now()->format('Y-m-d'),
                    'reference' => 'INV/'.$sale->reference,
                    'paid_amount' => ($payment['method'] === 'tunai')?$payment['paid_amount']:$payment['amount'],
                    'payment_method' => $payment['method']
                ];
                if($payment['method'] === 'tunai'){
                    $data['return_amount'] = $payment['return_amount'];
                }elseif($payment['method'] === 'transfer'){
                    $data['bank_id'] = $payment['bank_id'];
                }elseif($payment['method'] === 'edc'){
                    $data['edc_id'] = $payment['edc_id'];
                }
        
                $sale->salePayments()->create($data);
            }
        }
    }

    public function updatedNominal($value){
        $this->nominal_text = 'Rp. ' . number_format(intval($value), 0, ',', '.');
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

}
