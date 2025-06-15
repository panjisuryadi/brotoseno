<?php

namespace App\Http\Livewire\BarangDp\Emas;

use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Modules\Karat\Models\Karat;
use Modules\PenerimaanBarangDP\Models\PenerimaanBarangDP;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;

class Create extends Component
{
    public PenerimaanBarangDP $barang_dp;
    public Product $product;
    public $karats = [];
    public $tipe_pembayaran = '';
    public $tipe_pembayaran_map = [
        'jatuh_tempo' => 1,
        'cicil' => 2
    ];
    public $hari_ini;
    public $pic_id;
    public $cicil = '';
    public $detail_cicilan = [];
    public $tgl_jatuh_tempo;
    public $uploaded_image = '';
    public $webcam_image = '';


    public function render()
    {
        return view('livewire.barang-dp.emas.create');
    }

    public function __construct()
    {
        // Initialize Product
        $this->barang_dp = new PenerimaanBarangDP();
        $this->product = new Product();
    }

    public function mount(){
        $this->karats = Karat::karat()->get();
        $this->hari_ini = (new DateTime())->format('Y-m-d');
        $this->barang_dp->date = $this->hari_ini;
        $this->pic_id = auth()->user()->id;
    }

    public function rules(){
        return [
            'barang_dp.cabang_id' => [
                function ($attribute, $value, $fail) {
                    if(!auth()->user()->isUserCabang() && empty($value)){
                        $fail('Wajib diisi.');
                    }
                }
            ],
            'barang_dp.date' => ['required', 'date',
                function ($attribute, $value, $fail) {
                    $today = Carbon::today();
                    $inputDate = Carbon::parse($value);

                    if ($inputDate > $today) {
                        $fail($attribute . ' harus tanggal hari ini atau sebelumnya.');
                    }
                }
            ],
            'barang_dp.owner_name' => ['required'],
            'barang_dp.contact_number' => ['required'],
            'barang_dp.address' => ['required'],
            'barang_dp.no_ktp' => ['required'],
            'product.karat_id' => ['required'],
            'product.berat_emas' => ['required'],
            'barang_dp.nominal' => ['required','gt:0'],
            'barang_dp.note' => ['required'],
            'tipe_pembayaran' => ['required'],
            'cicil' => 'required_if:tipe_pembayaran,cicil',
            'webcam_image' => ['required_if:uploaded_image,']
        ];
    }

    public function getNominalTextProperty()
    {
        return 'Rp. ' . number_format((intval($this->barang_dp->nominal) + intval($this->barang_dp->box_fee)), 0, ',', '.');
    }

    public function getMinCicilDate($key){
        if(in_array($key-1,array_keys($this->detail_cicilan))){
            $minCicilDate = new DateTime($this->detail_cicilan[$key-1]);
            return $minCicilDate->modify("+1 day")->format("Y-m-d");
        }else{
            return $this->hari_ini;
        }
    }

    public function resetDetailCicilanAfterwards($key){
        for ($i=$key+1; $i <= count($this->detail_cicilan) ; $i++) { 
            $this->detail_cicilan[$i] = "";
        }
    }

    public function updatedTipePembayaran(){
        $this->reset('cicil');
        $this->reset('detail_cicilan');
        $this->reset('tgl_jatuh_tempo');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    private function getUploadedImage(){
        $folderPath = "uploads/";
        if(!empty($this->uploaded_image)){
            Storage::disk('public')->move("temp/dropzone/{$this->uploaded_image}","{$folderPath}{$this->uploaded_image}");
            return $this->uploaded_image;  
        }
        elseif(!empty($this->webcam_image)){
            $image_parts = explode(";base64,", $this->webcam_image);
            $image_base64 = base64_decode($image_parts[1]);
            $fileName ='webcam_'. uniqid() . '.jpg';
            $file = $folderPath . $fileName;
            Storage::disk('public')->put($file,$image_base64);
            return $fileName;
        }
    }

    public function store()
    {
        $this->validate();
        DB::beginTransaction();
        try{
            // create product
            $this->product->images = $this->getUploadedImage();
            $this->product->save();
            // create penerimaan barang luar
            $this->barang_dp->product_id = $this->product->id;
            $this->barang_dp->pic_id = auth()->id();
            $this->barang_dp->save();
            $this->product->updateTracking(ProductStatus::DP, $this->barang_dp->cabang_id);
            // create payment
            $payment = $this->barang_dp->payment()->create([
                'type' => $this->tipe_pembayaran_map[$this->tipe_pembayaran],
                'cicil' => ($this->tipe_pembayaran === 'cicil')?$this->cicil:0
            ]);
            foreach($this->detail_cicilan as $cicilan){
                $payment->detail()->create([
                    'due_date' => $cicilan,
                ]); 
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        $this->reset();

        session()->flash('message', 'Created Successfully.');
        return redirect(route('penerimaanbarangdp.index'));
    }

     protected $listeners = [
        'imageUploaded',
        'imageRemoved',
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset'

    ];

    public function handleWebcamCaptured($data_uri){
        $this->webcam_image = $data_uri;
        $this->imageRemoved();
    }

    public function handleWebcamReset(){
        $this->webcam_image = '';
        $this->dispatchBrowserEvent('webcam-image:remove');
    }

    public function imageUploaded($fileName){
        $this->uploaded_image = $fileName;
        $this->handleWebcamReset();
    }

    public function imageRemoved($fileName = null){
        $this->uploaded_image = '';
        $this->dispatchBrowserEvent('uploaded-image:remove');
    }
}
