<?php

namespace App\Http\Livewire\Produksi;

use Livewire\Component;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;
use Modules\Produksi\Http\Controllers\ProduksisController;
use Modules\Karat\Models\Karat;
use Modules\KaratBerlian\Models\KaratBerlian;
use Modules\KaratBerlian\Models\ShapeBerlian;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Group\Models\Group;
use Modules\Produksi\Models\Produksi;
use Modules\Stok\Models\StockKroom;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;
use App\Models\LookUp;
use Modules\Produksi\Models\DiamondCertificateAttributes;

use function PHPUnit\Framework\isEmpty;

class Proses extends Component
{
    use WithFileUploads;
    public $source_kode = 'lantakan',
        $berat_asal,
        $karatasal_id,
        $kategoriproduk_id,
        $berat,
        $tanggal,
        $type = 1,
        $karat24k,
        $id_kategoriproduk_berlian,
        $code,
        $image,
        $harga_jual,
        $model_id;

    public $inputs = [
        [
            'model_id' => '',
            'karat_id' => '',
            'berat_asal_item' => '',
            'berat' => '',
        ]
    ];

    public $dataKarat = [];
    public $dataKaratBerlian = [];
    public $dataShapes = [];
    public $dataKategoriProduk = [];
    public $dataGroup = [];
    public $arrayKaratBerlian = [];
    public $dataCertificateAttribute = [];

    public $currentKey;
    public $tmpCertificate = [];

    public $hari_ini;

    public function mount()
    {
        $this->dataKarat = Karat::whereNull('parent_id')->get();
        $this->dataKaratBerlian = KaratBerlian::all();
        $this->dataShapes = ShapeBerlian::all();
        $this->dataGroup = Group::all();
        $this->hari_ini = new DateTime();
        $this->hari_ini = $this->hari_ini->format('Y-m-d');
        $id_karat_24k = LookUp::select('value')->where('kode', 'id_karat_emas_24k')->first();
        $this->karat24k = !empty($id_karat_24k['value']) ? $id_karat_24k['value'] : 0;
        $id_kategoriproduk_berlian = LookUp::select('value')->where('kode', 'id_kategoriproduk_berlian')->first();
        $this->id_kategoriproduk_berlian = !empty($id_kategoriproduk_berlian['value']) ? $id_kategoriproduk_berlian['value'] : 0;
        $this->code = Produksi::generateCode();

        $this->karatasal_id = $this->karat24k;
        $this->kategoriproduk_id = $this->id_kategoriproduk_berlian;

    }

    protected $listeners = [
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset'
    ];

    public function handleWebcamCaptured($data_uri){
        $this->image= $data_uri;
    }

    public function addInput()
    {
        $this->inputs[] = [
            'model_id' => '',
            'karat_id' => '',
            'berat_asal_item' => '',
            'berat' => '',
        ];
    }

    public function remove($i)
    {
        $this->resetErrorBag();
        unset($this->inputs[$i]);
        $this->inputs = array_values($this->inputs);
    }

    public function render()
    {
        $this->tanggal = $this->hari_ini;
        return view('livewire.produksi.proses');
    }

    private function resetInputFields()
    {
        $this->inputs = [
            [
                'model_id' => '',
                'karat_id' => '',
                'berat_asal' => '',
                'berat' => '',
            ]
        ];
    }


    public function rules()
    {
        $rules = [
            'source_kode' => 'required',
            'karatasal_id' => 'required',
            'berat_asal' => 'required',
            'code' => 'required|unique:produksis',
        ];

        /** rules cek stok lantakan */
        if($this->source_kode == "lantakan") {
            $inputs = $this->inputs;
            $rules['berat_asal'] = [
                'required',
                function ($attribute, $value, $fail) use ($inputs){
                    $stok_lantakan = StockKroom::sum('weight');
                    $stok_lantakan_terpakai = Produksi::where('source_kode', $this->source_kode)->sum('berat_asal');
                    $sisa_stok_lantakan = $stok_lantakan - $stok_lantakan_terpakai;
                    if ($value > $sisa_stok_lantakan) {
                        $fail('Sisa stok tidak mencukupi, berat asal harus kurang dari sama dengan '. $sisa_stok_lantakan);
                    }
                    if(!empty($inputs)) {
                        $total_berat_item = 0;
                        foreach($inputs as $item) {
                            $total_berat_item += !empty($item['berat_asal_item']) ? $item['berat_asal_item'] : 0;
                        }
                        if($total_berat_item != 0 && $total_berat_item != $value){
                            $fail('Total berat asal item tidak cocok dengan total berat asal');
                        }
                    }
                }

            ];

            /** validasi stok berlian
             * cek dulu apakah ini produksi berlian
             * collect data stok per jenis karat
             * bandingkan stok
             */
            if($this->kategoriproduk_id == $this->id_kategoriproduk_berlian && !empty($this->inputs[0]['karatberlians'])) {
                $sisa_stok_berlian = GoodsReceipt::where('kategoriproduk_id', $this->id_kategoriproduk_berlian)->sum('total_karat');
                $total_karat_dipinta = 0;
                foreach ($this->inputs as $key => $value) {
                    $rules['inputs.' . $key . '.karatberlians'] = 'required|gt:0';
                    $rules['inputs.' . $key . '.qty'] = 'required|gt:0';

                    $qty = !empty($value['qty']) ? $value['qty'] : 0;
                    $karat = !empty($value['karatberlians']) ? $value['karatberlians'] : 0;
                    if(filter_var($karat, FILTER_VALIDATE_FLOAT)) {
                        $stok_berlian_terpakai = $karat * $qty;
                        $total_karat_dipinta += $stok_berlian_terpakai;
    
                        if($sisa_stok_berlian < $total_karat_dipinta) {
                            $rules['inputs.' . $key . '.karatberlians'] = [
                                function ($attribute, $value, $fail) use ($sisa_stok_berlian) {
                                    $fail('Sisa stok tidak mencukupi, sisa stok berlian saat ini ' . $sisa_stok_berlian . ' ct');
                                }
                            ];

                            $rules['inputs.' . $key . '.qty'] = [
                                function ($attribute, $value, $fail) use ($sisa_stok_berlian) {
                                    $fail('Sisa stok tidak mencukupi, sisa stok berlian saat ini ' . $sisa_stok_berlian . ' ct');
                                }
                            ];
    
                        }
                    }else{
                        $rules['inputs.' . $key . '.karatberlians'] = [
                            function ($attribute, $value, $fail) use ($sisa_stok_berlian) {
                                $fail('input karat berlians harus berupa decimal');
                            }
                        ];
                    }
                    
                }

            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'karatasal_id.required' => 'Karat asal harus diisi!',
            'berat.required' => 'Berat jadi harus diisi!',
        ];
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit(Request $request)
    {

        $this->validate();

        $data = [
            'code' => $this->code,
            'image' => $this->image,
            'karatasal_id' => $this->karatasal_id,
            'model_id' => !empty($this->model_id) ? $this->model_id : null,
            'source_kode' => $this->source_kode,
            'berat_asal' => $this->berat_asal,
            'berat' => $this->berat,
            'tanggal' => $this->tanggal,
            'created_by' => auth()->user()->id,
            'items' => $this->inputs,
            'kategoriproduk_id' => $this->kategoriproduk_id,
        ];

        $request = new Request($data);
        $controller = new ProduksisController();
        $store = $controller->store($request);
    }

    public function setCurrentKey($key)
    {
        $this->currentKey = $key;
    }
    
}
