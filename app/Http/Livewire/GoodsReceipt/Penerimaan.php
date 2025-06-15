<?php

namespace App\Http\Livewire\GoodsReceipt;
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
use Modules\GoodsReceipt\Http\Controllers\GoodsReceiptsController;
use Modules\Karat\Models\Karat;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\People\Entities\Supplier;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

use function PHPUnit\Framework\isEmpty;

class Penerimaan extends Component
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
        $harga_beli = 0,
        $pic_id = '',
        $document = [],
        $image = '',
        $uploaded_image = '';

    public $updateMode = false;
    public $total_berat = 0;
    public $inputs = [
        [
            'karat_id' => '',
            'berat_real' => 0,
            'berat_kotor' => 0
        ]
    ];

    public $total_berat_real = 0;
    public $total_berat_kotor = 0;
    public $dataSupplier = [];
    public $dataKarat = [];
    public $dataKategoriProduk = [];

    public $hari_ini;

    protected $listeners = [
        'imageUploaded' => 'handleUploadedImage',
        'imageRemoved' => 'handleRemoveUploadedImage',
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset'

    ];

    public function handleWebcamCaptured($key, $data_uri)
    {
        $this->image = $data_uri;
        $this->handleRemoveUploadedImage();
    }

    public function handleWebcamReset($key = null)
    {
        $this->image = '';
        $this->dispatchBrowserEvent('webcam-image:remove');
    }

    public function handleUploadedImage($fileName)
    {
        $this->uploaded_image = $fileName;
        $this->handleWebcamReset();
    }

    public function handleRemoveUploadedImage()
    {
        $this->uploaded_image = '';
        $this->dispatchBrowserEvent('uploaded-image:remove');
    }

    public function mount()
    {
        $this->dataSupplier = Supplier::all();
        $this->dataKarat = Karat::whereNull('parent_id')->get();
        $this->dataKategoriProduk = KategoriProduk::all();

        $this->hari_ini = new DateTime();
        $this->hari_ini = $this->hari_ini->format('Y-m-d');
        $this->pic_id = auth()->user()->id;
        $this->tanggal = $this->hari_ini;
    }

    public function addInput()
    {
        $this->inputs[] = [
            'karat_id' => '',
            'berat_real' => 0,
            'berat_kotor' => 0
        ];
    }


    public function remove($i)
    {
        $this->resetErrorBag();
        unset($this->inputs[$i]);
        $this->inputs = array_values($this->inputs);
        // $this->calculateTotalBeratReal();
        $this->calculateTotalBeratKotor();
    }

    public function render()

    {
        return view('livewire.goods-receipt.penerimaan');
    }

    private function resetInputFields()
    {
        $this->inputs = [
            [
                'karat_id' => '',
                'berat_real' => 0,
                'berat_kotor' => 0
            ]
        ];
    }


    public function rules()
    {
        $rules = [
            'code' => 'required',
            'no_invoice' => 'required|string|max:50',
            'supplier_id' => 'required',
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
            'total_berat_real' => 'required|numeric',
            'total_berat_kotor' => 'required|numeric',
            'tipe_pembayaran' => 'required',
            'harga_beli' => 'required_if:tipe_pembayaran,lunas|gt:-1',
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
            'berat_timbangan' => 'required|numeric|gt:0',
            'selisih' => 'numeric',
            'pengirim' => 'required',
            'pic_id' => 'required',
            'image' => ['required_if:uploaded_image,']
        ];

        foreach ($this->inputs as $key => $value) {
            $rules['inputs.' . $key . '.karat_id'] = 'required';
            $rules['inputs.' . $key . '.berat_real'] = 'required|gt:0';
            $rules['inputs.' . $key . '.berat_kotor'] = 'required|gt:0';
        }

        if ($this->cicil != '') {
            for ($i = 1; $i <= $this->cicil; $i++) {
                $rules['detail_cicilan.' . $i] = 'required_if:tipe_pembayaran,cicil';
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
        // dd($this->image);
        $data = [
            'code' => $this->code,
            'no_invoice' => $this->no_invoice,
            'pengirim' => $this->pengirim,
            'supplier_id' => $this->supplier_id,
            'tipe_pembayaran' => $this->tipe_pembayaran,
            'tanggal' => $this->tanggal,
            'cicil' => $this->tipe_pembayaran == 'cicil' ? $this->cicil : 0,
            'tgl_jatuh_tempo' => $this->tipe_pembayaran == 'jatuh_tempo' ? $this->tgl_jatuh_tempo : null,
            'berat_timbangan' => $this->berat_timbangan,
            'selisih' => $this->selisih,
            'catatan' => $this->catatan,
            'pic_id' => $this->pic_id,
            'harga_beli' => $this->harga_beli,
            'document' => $this->document,
            'total_berat_real' => $this->total_berat_real,
            'total_berat_kotor' => $this->total_berat_kotor,
            'items' => $this->inputs,
            'detail_cicilan' => $this->detail_cicilan,
            'image' => $this->image,
            'uploaded_image' => $this->uploaded_image
        ];

        $request = new Request($data);
        $controller = new GoodsReceiptsController();
        $controller->store($request);
        $this->resetInputFields();

        session()->flash('message', 'Created Successfully.');
    }


    // public function calculateTotalBeratReal()
    // {
    //     $this->total_berat_real = 0;
    //     foreach ($this->inputs as $key => $value) {
    //         $this->total_berat_real += doubleval($this->inputs[$key]['berat_real']);
    //         $this->total_berat_real = round($this->total_berat_real, 3);
    //     }
    // }

    public function calculateTotalBeratKotor()
    {
        $this->total_berat_kotor = 0;
        foreach ($this->inputs as $key => $value) {
            $this->total_berat_kotor += doubleval($this->inputs[$key]['berat_kotor']);
            $this->total_berat_kotor = round($this->total_berat_kotor, 3);
        }
    }

    public function calculateSelisih(){
        $this->selisih = round(doubleval($this->berat_timbangan) - $this->total_berat_real,3);
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
}
