<?php

namespace App\Http\Livewire\GoodsReceiptBerlian;

use Livewire\Component;
use App\Http\Livewire\Field;
use App\Models\LookUp as ModelsLookUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;
use Modules\Currency\Entities\Currency;
use Modules\GoodsReceipt\Models\KlasifikasiBerlian;
use Modules\GoodsReceiptBerlian\Http\Controllers\GoodsReceiptBerliansController;
use Modules\Group\Models\Group;
use Modules\Karat\Models\Karat;
use Modules\KaratBerlian\Models\KaratBerlian;
use Modules\KaratBerlian\Models\ShapeBerlian;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\People\Entities\Supplier;
use Modules\Produksi\Models\DiamondCertificateAttributes;
use PhpOffice\PhpSpreadsheet\Calculation\LookupRef\Lookup;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

use function PHPUnit\Framework\isEmpty;

class PenerimaanQc extends Component
{
    use WithFileUploads;
    public $code,
        $no_invoice,
        $pengirim,
        $supplier_id = '',
        $tipe_pembayaran = '',
        $tanggal,
        $cicil = '',
        $detail_cicilan = [],
        $tgl_jatuh_tempo,
        $berat_timbangan,
        $selisih,
        $catatan,
        $pic_id = '',
        $nama_produk = '',
        $karat_id,
        $model_id,
        $berat_real,
        $image,
        $kategoriproduk_id,
        $harga_beli,
        $jenis_sertifikat,
        $currency_id,
        $document = [];

    public $updateMode = false;
    public $total_berat = 0;
    public $inputs = [
        [
            'karatberlians' => '',
            'shapeberlian_id' => '',
            'colour' => '',
            'clarity' => '',
            'harga_beli' => '',
            'currency_id' => '',
            'qty' => 1,
            'keterangan' => ''
        ]
    ];

    public $total_berat_real ;
    public $total_berat_kotor = 0;
    public $dataSupplier = [];
    public $dataKarat = [];
    public $dataKaratBerlian = [];
    public $dataShapes = [];
    public $dataKategoriProduk = [];
    public $dataGroup = [];
    public $kasir = [];

    public $hari_ini;

    public $type; // 1 pcs - 2 Mata tabur
    public $total_karat;

    public $dataCertificateAttribute = [];
    public $dataCurrency = [];
    public $dataKlasifikasiBerlian = [];
    public $currentKey;

    public $sertifikat = [];

    protected $listeners = [
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset'
    ];

    public function handleWebcamCaptured($data_uri)
    {
        $this->image = $data_uri;
    }

    public function mount()
    {
        $this->dataSupplier = Supplier::all();
        $this->dataKarat = Karat::whereNull('parent_id')->get();
        $this->dataKaratBerlian = KaratBerlian::all();
        $this->dataGroup = Group::all();
        $this->dataShapes = ShapeBerlian::all();
        $this->dataKategoriProduk = KategoriProduk::all();
        $this->hari_ini = new DateTime();
        $this->hari_ini = $this->hari_ini->format('Y-m-d');
        $this->type = 1;
        $this->dataCurrency = Currency::all();
        $this->dataKlasifikasiBerlian = KlasifikasiBerlian::all();

        $id_kategoriproduk_berlian = ModelsLookUp::select('value')->where('kode', 'id_kategoriproduk_berlian')->first();
        $this->kategoriproduk_id = !empty($id_kategoriproduk_berlian['value']) ? $id_kategoriproduk_berlian['value'] : 0;
        $this->dataCertificateAttribute = DiamondCertificateAttributes::where('status', 1)->get();

        $this->inputs[0]['code'] = $this->generateCodeItems(0);
    }

    public function addInput()
    {
        $this->inputs[] = [
            'code' => $this->generateCodeItems(),
            'karatberlians' => '',
            'shapeberlian_id' => '',
            'colour' => '',
            'clarity' => '',
            'harga_beli' => '',
            'currency_id' => '',
            'qty' => 1,
            'keterangan' => ''
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
        $this->kasir = User::role('Kasir')->orderBy('name')->get();
        $this->tanggal = $this->hari_ini;
        return view('livewire.goods-receipt-berlian.penerimaanqc');
    }

    private function resetInputFields()
    {
        $this->inputs = [
            [
                'karatberlians' => '',
                'shapeberlian_id' => '',
                'colour' => '',
                'clarity' => '',
                'harga_beli' => '',
                'currency_id' => '',
                'qty' => 1,
                'keterangan' => ''
            ]
        ];
    }


    public function rules()
    {
        $currency_id = $this->currency_id;
        $rules = [
            'code' => 'required',
            'supplier_id' => 'required',
            // 'no_invoice' => 'required',
            // 'nama_produk' => 'required',
            'tanggal' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $today = Carbon::today();
                    $inputDate = Carbon::parse($value);

                    if ($inputDate > $today) {
                        $fail($attribute . ' harus tanggal hari ini atau sebelumnya.');
                    }
                }
            ],
            // 'karat_id' => 'required',
            // 'model_id' => 'required',
            // 'total_berat_real' => 'required',
            'tipe_pembayaran' => 'required',
            'cicil' => 'required_if:tipe_pembayaran,cicil',
            'tgl_jatuh_tempo' => [
                'required_if:tipe_pembayaran,jatuh_tempo',
                function ($attribute, $value, $fail) {
                    $today = Carbon::today();
                    $inputDate = Carbon::parse($value);
                    if ($inputDate < $today) {
                        $fail($attribute . ' harus tanggal hari ini atau setelahnya.');
                    }
                }
            ],
            // 'harga_beli' => [
            //     'required',
            //     function ($attribute, $value, $fail) use ($currency_id){

            //         if (empty($currency_id)) {
            //             $fail('Mata uang belum dipilih');
            //         }
            //     }
            // ],
        ];

        // if($this->type == 2) {
        //     $rules['karat_id'] = 'required';
        // }

        if (!empty($this->karat_id)) {
            foreach ($this->inputs as $key => $value) {
                $rules['inputs.' . $key . '.karatberlians'] = 'required';
                $rules['inputs.' . $key . '.qty'] = 'required|gt:0';
            }
        }

        return $rules;
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit(Request $request)
    {
        $this->validate();
        $total_karat = 0;
        if (!empty($this->inputs)) {

            foreach ($this->inputs as $k => $item) {
                $total_karat += !empty($item['karatberlians']) ? $item['karatberlians'] : 0;
                $this->inputs[$k]['sertifikat'] = !empty($this->sertifikat[$k]) ? $this->sertifikat[$k] : [];
            }
        }

        $data = [
            'code' => $this->code,
            'nama_produk' => $this->type == 2 ? 'mata-tabur' : $this->nama_produk,
            'no_invoice' => !empty($this->no_invoice) ? $this->no_invoice : '-',
            'pengirim' => $this->pengirim,
            'supplier_id' => $this->supplier_id,
            'karat_id' => $this->karat_id,
            'model_id' => $this->model_id,
            'tipe_pembayaran' => $this->tipe_pembayaran,
            'tanggal' => $this->tanggal,
            'cicil' => $this->tipe_pembayaran == 'cicil' ? $this->cicil : 0,
            'tgl_jatuh_tempo' => $this->tipe_pembayaran == 'jatuh_tempo' ? $this->tgl_jatuh_tempo : null,
            'berat_timbangan' => $this->berat_timbangan,
            'selisih' => $this->selisih,
            'catatan' => $this->catatan,
            'pic_id' => auth()->user()->id,
            'image' => $this->image,
            'document' => $this->document,
            'harga_beli' => $this->harga_beli,
            'total_berat_real' => $this->total_berat_real,
            'total_berat_kotor' => $this->total_berat_kotor,
            'total_karat' => !empty($this->total_karat) ? $this->total_karat : $total_karat,
            'items' => $this->inputs,
            'kategoriproduk_id' => $this->kategoriproduk_id,
            'sertifikat' => !empty($this->sertifikat['code']) ? $this->sertifikat : [],
            'tipe_penerimaan_barang' => $this->type,
            'currency_id' => $this->currency_id,
            'detail_cicilan' => $this->detail_cicilan,
        ];

        $request = new Request($data);
        $controller = new GoodsReceiptBerliansController();
        $store = $controller->store_qc($request);
    }


    public function calculateTotalBeratReal()
    {
        $this->total_berat_real = 0;
        foreach ($this->inputs as $key => $value) {
            $this->total_berat_real += floatval($this->inputs[$key]['berat_real']);
            $this->total_berat_real = number_format(round($this->total_berat_real, 3), 3, '.', '');
            $this->total_berat_real = rtrim($this->total_berat_real, '0');
            $this->total_berat_real = formatWeight($this->total_berat_real);
        }
    }

    public function calculateTotalBeratKotor()
    {
        $this->total_berat_kotor = 0;
        foreach ($this->inputs as $key => $value) {
            $this->total_berat_kotor += floatval($this->inputs[$key]['berat_kotor']);
            $this->total_berat_kotor = number_format(round($this->total_berat_kotor, 3), 3, '.', '');
            $this->total_berat_kotor = rtrim($this->total_berat_kotor, '0');
            $this->total_berat_kotor = formatWeight($this->total_berat_kotor);
        }
    }

    public function imageUploaded($fileName)
    {
        $this->document[] = $fileName;
    }

    public function imageRemoved($fileName)
    {
        $this->document = array_filter($this->document, function ($file) use ($fileName) {
            return $file != $fileName;
        });
    }

    public function getMinCicilDate($key)
    {
        if (in_array($key - 1, array_keys($this->detail_cicilan))) {
            $minCicilDate = new DateTime($this->detail_cicilan[$key - 1]);
            return $minCicilDate->modify("+1 day")->format("Y-m-d");
        } else {
            return $this->hari_ini;
        }
    }

    public function resetDetailCicilanAfterwards($key)
    {
        for ($i = $key + 1; $i <= count($this->detail_cicilan); $i++) {
            $this->detail_cicilan[$i] = "";
        }
    }

    public function setImageFromWebcam($image)
    {
        $this->image = $image;
    }

    public function clearHarga($key = null)
    {
        if (!is_null($key)) {
            if (isset($this->inputs[$key]['harga_beli'])) {
                $this->inputs[$key]['harga_beli'] = 0;
            }
        } else {
            $this->harga_beli = 0;
        }
    }

    public function generateCodeItems($key = '')
    {
        $dateCode = "POITM" . '-';
        $penerimaan_code = $this->code;
        $penerimaan_code_number = str_replace('PO-', '', $penerimaan_code);
        $orderCode = $dateCode . $penerimaan_code_number .  '001';
        $lastkey = array_key_last($this->inputs);
        $lastGrCode = '';
        if (!empty($this->inputs[$lastkey]['code'])) {
            $lastGrCode = $this->inputs[$lastkey]['code'];
            $lastOrderNumber = str_replace($dateCode . $penerimaan_code_number, '', $lastGrCode);
            $nextOrderNumber = sprintf('%03d', (int)$lastOrderNumber + 1);
            $orderCode = $dateCode . $penerimaan_code_number . $nextOrderNumber;
            return $orderCode;
        } else {
            return $orderCode;
        }
        if ($lastGrCode) {
        }
    }


    public function setCurrentKey($key)
    {
        $this->sertifikat[$key]['tanggal'] = $this->hari_ini;
        $this->currentKey = $key;
    }


    public function handleWebcamReset()
    {
        $this->image = '';
    }
}
