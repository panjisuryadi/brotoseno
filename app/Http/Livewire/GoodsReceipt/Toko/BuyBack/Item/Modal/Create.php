<?php

namespace App\Http\Livewire\GoodsReceipt\Toko\BuyBack\Item\Modal;

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
use Modules\Status\Models\ProsesStatus;
use Modules\Stok\Models\StockPending;

class Create extends Component
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
    public $potongan;
    public $nominal = 0;

    public $note = '';


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
            'code' => [
                'required',
                function ($attribute, $value, $fail) {
                    $product = Product::withoutGlobalScope('filter_by_cabang')->where(['product_code' => $value])->first();
                    if(is_null($product)){
                        $fail('Produk tidak ditemukan');
                    }else{
                        $is_exist = BuyBackBarangLuar\GoodsReceiptItem::where('product_id',$product->id)->exists();
                        if($is_exist){
                            $fail('Produk yang sama telah ditambahkan');
                        }else{
                            if($product->status_id != ProductStatus::SOLD){
                                $fail('Produk belum terjual');
                            }
                        }
                    }
                }
            ],
            'customer' => 'required',
            'date' => 'required',
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
        return view('livewire.goods-receipt.toko.buyback.item.modal.create');
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
            $data = [
                'product_id' => $this->product->id,
                'cabang_id' => auth()->user()->namacabang()->id,
                'customer' => $this->customer,
                'pic_id' => auth()->id(),
                'nominal' => $this->grand_total,
                'note' => empty($this->note)?null:$this->note,
                'date' => $this->date,
                'type' => 1
            ];

            $item = BuyBackBarangLuar\GoodsReceiptItem::create($data);
            $this->managePayment($item);
            $product = $item->product;
            $product->update([
                'cabang_id' => $item->cabang_id,
                'status_id' => ProductStatus::PENDING_CABANG
            ]);
            $product->refresh();
            $product->statuses()->attach($product->status_id,['cabang_id' => $product->cabang_id, 'properties' => json_encode(['product'=>$product])]);

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        toast('Berhasil Menyimpan Barang Buy Back','success');
        return redirect(route('goodsreceipt.toko.buyback-barangluar.index'));
        
    }

    public function updatedNominal($value){
        $this->nominal_text = 'Rp. ' . number_format(intval($value), 0, ',', '.');
    }

    private function managePayment($item){
        if($this->multiple_payment_method === 'false'){
            $data = [
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
            $item->payments()->create($data);
        }elseif($this->multiple_payment_method === 'true'){
            foreach($this->payments as $index => $payment){
                $data = [
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
        
                $item->payments()->create($data);
            }
        }
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

}
