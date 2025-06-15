<?php

namespace App\Http\Livewire\GoodsReceipt\Toko\BarangLuar\Item\Modal;

use App\Models\LookUp;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Modules\DataBank\Models\DataBank;
use Modules\DataRekening\Models\DataRekening;
use Modules\DistribusiToko\Models\DistribusiToko;
use Modules\DistribusiToko\Models\DistribusiTokoItem;
use Modules\Group\Models\Group;
use Modules\Karat\Models\Karat;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\Stok\Models\StockOffice;
use Modules\GoodsReceipt\Models\Toko\BuyBackBarangLuar;
use Modules\ProdukModel\Models\ProdukModel;

use function PHPUnit\Framework\isEmpty;

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

    public $date;
    public $today;
    public $customer;
    public $nominal = 0;
    public $nominal_text = '';
    public $dist_toko;
    public $data = [
        'additional_data' => [
            'product_category' => [
                'id' => '',
                'name' => ''
            ],
            'group' => [
                'id' => '',
                'name' => ''
            ],
            'model' => [
                'id' => '',
                'name' => ''
            ],
            'code' => '',
            'certificate_id' => '',
            'no_certificate' => '',
            'accessories_weight' => 0,
            'tag_weight' => 0,
            'image' => '',
            'uploaded_image' => ''
        ],
        'gold_weight' => 0,
        'total_weight' => 0,
        'karat_id' => ''
    ];

    public $isLogamMulia;
    public $logam_mulia_id;

    public $karat_logam_mulia;

    public $dataLabel;

    public $categories;

    public $dataKarat;

    public $cabang;

    public $groups;
    public $models;

    public $total_weight_per_karat = [];

    protected $listeners = [
        'setAdditionalAttribute',
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset',
        'imageUploaded',
        'imageRemoved'
    ];

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





    public function render(){
        return view("livewire.goods-receipt.toko.barangluar.item.modal.create");
    }

    public function handleWebcamCaptured($data_uri){
        $this->data['additional_data']['image'] = $data_uri;
        $this->imageRemoved();
    }

    public function handleWebcamReset(){
        $this->data['additional_data']['image'] = '';
        $this->dispatchBrowserEvent('webcam-image:remove');
    }

    public function imageUploaded($fileName){
        $this->data['additional_data']['uploaded_image'] = $fileName;
        $this->handleWebcamReset();
    }

    public function imageRemoved($fileName = null){
        $this->data['additional_data']['uploaded_image'] = '';
        $this->dispatchBrowserEvent('uploaded-image:remove');
    }



    


    public function mount(){
        $kategori = LookUp::where('kode','id_kategori_produk_emas')->value('value');
        $this->categories = Category::where('kategori_produk_id',$kategori)->get();
        $this->dataKarat = Karat::where(function ($query) {
            $query
                ->where('parent_id', null);
        })->get();
        
        $this->logam_mulia_id = Category::where('category_name','LIKE','%logam mulia%')->value('id');
        $this->karat_logam_mulia = Karat::logam_mulia()->id;

        $this->today = (new DateTime())->format('Y-m-d');
        $this->date = $this->today;
        $this->cabang = auth()->user()->namacabang();
        $this->groups = Group::all();
        $this->models = ProdukModel::all();
        $this->banks = DataBank::all();
        $this->edcs = DataRekening::all();
    }

    public function setAdditionalAttribute($name,$selectedText){
        $this->data['additional_data'][$name]['name'] = $selectedText;
    }

    public function productCategoryChanged(){
        $this->clearKaratAndTotal();
        $this->isLogamMulia();
        if($this->data['additional_data']['product_category']['id'] == $this->logam_mulia_id){
            $this->data['karat_id'] = $this->karat_logam_mulia;
        }
    }

    public function clearKaratAndTotal(){
        $this->data['karat_id'] = '';
        $this->data['additional_data']['accessories_weight'] = 0;
        $this->data['additional_data']['tag_weight'] = 0;
        $this->data['gold_weight'] = 0;
        $this->data['total_weight'] = 0;
        $this->data['additional_data']['certificate_id'] = '';
        $this->data['additional_data']['no_certificate'] = '';
    }

    public function calculateTotalWeight(){
        $this->data['total_weight'] = 0;
        $this->data['total_weight'] += doubleval($this->data['gold_weight']);
        $this->data['total_weight'] += doubleval($this->data['additional_data']['accessories_weight']);
        $this->data['total_weight'] += doubleval($this->data['additional_data']['tag_weight']);
        $this->data['total_weight'] = round($this->data['total_weight'], 3);
    }


    private function isLogamMulia(){
        $this->isLogamMulia = $this->data['additional_data']['product_category']['id'] == $this->logam_mulia_id;
    }

    public function generateCode(){
        $group = Group::find($this->data['additional_data']['group']['id']);
        $karat = Karat::find($this->data['karat_id']);
        $this->data["additional_data"]["code"] = Product::generateCode($group->code, $karat->name);
    }

    private function checkGroup(){
        $this->validateOnly("data.additional_data.group.id");
    }


    public function rules()
    {
        $rules = [
            'date' => 'required',
            'customer' => 'required',
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


        $rules['data.additional_data.product_category.id'] = [
            'required',
        ];
        $rules['data.additional_data.group.id'] = 'required';
        $rules['data.additional_data.code'] = 'required|max:255|unique:products,product_code';
        $rules['data.karat_id'] = 'required';
        $rules['data.additional_data.accessories_weight'] = 'required_unless:data.additional_data.product_category.id,'.$this->logam_mulia_id;
        $rules['data.additional_data.tag_weight'] = 'required_unless:data.additional_data.product_category.id,'.$this->logam_mulia_id;
        $rules['data.gold_weight'] = [
            'required',
            'gt:0',
        ];
        $rules['data.total_weight'] = 'required|gt:0';
        $rules['data.additional_data.certificate_id'] = 'required_if:data.additional_data.product_category.id,'.$this->logam_mulia_id;
        $rules['data.additional_data.no_certificate'] = 'required_if:data.additional_data.product_category.id,'.$this->logam_mulia_id;
        $rules['data.additional_data.image'] =['required_if:data.additional_data.uploaded_image,'];


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

    public function store()
    {
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
            // Create product first
            $product_data = [
                'category_id' => $this->data['additional_data']['product_category']['id'],
                'cabang_id' => $this->cabang->id,
                'product_stock_alert'        => 5,
                'group_id' => $this->data['additional_data']['group']['id'],
                'model_id' => !empty($this->data['additional_data']['model']['id'])?$this->data['additional_data']['model']['id']:null,
                'karat_id' => $this->data['karat_id'],
                'berat_emas' => $this->data['gold_weight'],
                'status_id' => ProductStatus::PENDING_CABANG,
                'product_code'               => $this->data['additional_data']['code'],
                'product_barcode_symbology'  => 'C128',
                'product_unit'               => 'Gram',
                'images' => $this->getUploadedImage(),
            ];
            $product_data['product_name'] = $this->groups->find($this->data['additional_data']['group']['id'])->name;
            if(!empty($this->data['additional_data']['model']['id'])){
                $product_data['product_name'] = $product_data['product_name'] . ' ' . $this->models->find($this->data['additional_data']['model']['id'])->name;
            }
            $product = Product::create($product_data);

            $product_item = $product->product_item()->create([
                'certificate_id'              => empty($this->data['additional_data']['certificate_id'])?null:$this->data['additional_data']['certificate_id'],
                'berat_label'                 => $this->data['additional_data']['tag_weight'],
                'berat_accessories'           => $this->data['additional_data']['accessories_weight'],
                'berat_total'                 => $this->data['total_weight'],
            ]);
            $product->statuses()->attach($product->status_id,['cabang_id' => $product->cabang_id, 'properties' => json_encode([
                'product' => $product,
                'product_additional_information' =>  $product_item
            ])]);

            $data = [
                'product_id' => $product->id,
                'cabang_id' => $this->cabang->id,
                'customer' => $this->customer,
                'pic_id' => auth()->id(),
                'nominal' => $this->grand_total,
                'date' => $this->date,
                'type' => 2,
            ];

            $item = BuyBackBarangLuar\GoodsReceiptItem::create($data);
            $this->managePayment($item);

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        toast('Berhasil Menyimpan Barang Luar','success');
        return redirect(route('goodsreceipt.toko.buyback-barangluar.index'));
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


    private function uploadImage($img){
        $folderPath = "uploads/";
        $image_parts = explode(";base64,", $img);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName ='webcam_'. uniqid() . '.jpg';
        $file = $folderPath . $fileName;
        Storage::disk('public')->put($file,$image_base64);
        return $fileName;
    }

    private function getUploadedImage(){
        $folderPath = "uploads/";
        if(!empty($this->data['additional_data']['uploaded_image'])){
            Storage::disk('public')->move("temp/dropzone/{$this->data['additional_data']['uploaded_image']}","{$folderPath}{$this->data['additional_data']['uploaded_image']}");
            return $this->data['additional_data']['uploaded_image'];  
        }
        elseif(!empty($this->data['additional_data']['image'])){
            $image_parts = explode(";base64,", $this->data['additional_data']['image']);
            $image_base64 = base64_decode($image_parts[1]);
            $fileName ='webcam_'. uniqid() . '.jpg';
            $file = $folderPath . $fileName;
            Storage::disk('public')->put($file,$image_base64);
            return $fileName;
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function messages(){
        return [
            'data.*.required' => 'Wajib di isi',
            'data.*.required_unless' => 'Wajib di isi',
            'data.*.gt' => 'Nilai harus lebih besar dari 0',
            'data.*.required_if' => 'Wajib di isi',    
            'data.*.*.required' => 'Wajib di isi',
            'data.*.*.required_unless' => 'Wajib di isi',
            'data.*.*.required_if' => 'Wajib di isi', 
            'data.*.*.*.required' => 'Wajib di isi',
            'data.*.*.*.required_if' => 'Wajib di isi',
            'data.*.*.*.required_unless' => 'Wajib di isi',
        ];
    }

    public function updatedNominal($value){
        $this->nominal_text = 'Rp. ' . number_format(intval($value), 0, ',', '.');
    }
}
