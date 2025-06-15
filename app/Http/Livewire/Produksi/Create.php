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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\GoodsReceipt\Models\GoodsReceiptItem;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductItem;
use Modules\Product\Models\ProductAccessories;
use Modules\Product\Models\ProductStatus;
use Modules\Produksi\Models\Accessories;
use Modules\Produksi\Models\DiamondCertificateAttribute;
use Modules\Produksi\Models\DiamondCertificateAttributes;
use Modules\Produksi\Models\DiamondCertifikatT;
use Modules\Produksi\Models\ProduksiItems;
use Modules\Produksi\Models\Satuans;

use function PHPUnit\Framework\isEmpty;

class Create extends Component
{
    use WithFileUploads;
    public $source_kode = 'lantakan',
        $berat_asal,
        $karatasal_id,
        $karat_id,
        $kategoriproduk_id,
        $berat,
        $tanggal,
        $karat24k,
        $id_kategoriproduk_berlian,
        $code,
        $harga_jual,
        $model_id,
        $document = [],
        $image = '',
        $uploaded_image = '';

    public $inputs = [
        [
            'id_items' => '',
            'accessories_id' => '',
            'type' => '2',
            'amount' => '',
            'shapeberlian_id' => '',
            'qty' => 1,
            'gia_report_number' => '',
            'produksi_item_id' => '',
            'keterangan' => ''
        ]
    ];

    public $dataKarat = [];
    public $dataKaratArray = [];
    public $dataKaratBerlian = [];
    public $dataShapes = [];
    public $dataKategoriProduk = [];
    public $dataGroup = [];
    public $dataGroupArray = [];
    public $arrayKaratBerlian = [];
    public $dataCertificateAttribute = [];
    public $dataItemProduksi = [];
    public $dataItemProduksiArray = [];
    public $dataPenerimaanBerlian = [];
    public $dataPenerimaanBerlianArray = [];
    public $dataItempenerimaanBerlian = [];
    public $selectedItemId = [];
    public $selectedAccItemId = [];
    public $sertifikat = [
        'code' => '',
        'tanggal' => '',
    ];

    public $currentKey;
    public $dataPembelianQc;
    public $tmpCertificate = [];

    public $hari_ini;
    public $category_id;
    public $produksi_item_id;
    public $accessories = [
        [
            'accessories_id' => '',
            'amount' => '',
        ]
    ];

    public $dataAccessories = [];
    public $dataAccessoriesArray = [];

    public $dataPcs = [];
    public $dataPcsArray = [];
    public $selectedTotalKarat = '';


    public $dataSatuans = [];

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

        $this->dataKarat = Karat::whereNull('parent_id')->get();
        $this->dataKaratBerlian = KaratBerlian::all();
        $this->dataShapes = ShapeBerlian::all();
        $this->dataPembelianQc = GoodsReceipt::all();
        $this->dataGroup = Group::all();
        $this->hari_ini = new DateTime();
        $this->hari_ini = $this->hari_ini->format('Y-m-d');
        $id_karat_24k = LookUp::select('value')->where('kode', 'id_karat_emas_24k')->first();
        $this->karat24k = !empty($id_karat_24k['value']) ? $id_karat_24k['value'] : 0;
        $id_kategoriproduk_berlian = LookUp::select('value')->where('kode', 'id_kategoriproduk_berlian')->first();
        $this->id_kategoriproduk_berlian = !empty($id_kategoriproduk_berlian['value']) ? $id_kategoriproduk_berlian['value'] : 0;
        $this->dataKategoriProduk = Category::where('kategori_produk_id', $this->id_kategoriproduk_berlian)->get();
        $this->dataCertificateAttribute = DiamondCertificateAttributes::all();
        $this->code = Product::generateCodeBerlian();
        $this->sertifikat['tanggal'] = $this->hari_ini;

        $arrayKaratBerlian = [];
        foreach ($this->dataKaratBerlian as $k => $row) {
            $arrayKaratBerlian[$row->id] = $row->karat;
        }

        $this->arrayKaratBerlian = $arrayKaratBerlian;

        $this->karatasal_id = $this->karat24k;
        $this->kategoriproduk_id = $this->id_kategoriproduk_berlian;
        $this->category_id = Category::where('kategori_produk_id', $this->id_kategoriproduk_berlian)->first()->value('id');
        $this->dataItemProduksi = ProduksiItems::with('model', 'karat')->where('kategoriproduk_id', $this->id_kategoriproduk_berlian)->where('status', 1)->get();
        $this->dataPcs = GoodsReceipt::where('tipe_penerimaan_barang', 1)->get();
        $this->dataPcsArray = $this->dataPcs->map(function ($data) {
            return $data;
        })
            ->flatten()
            ->keyBy('id')
            ->toArray();
            $this->dataPenerimaanBerlian = GoodsReceiptItem::with('goodsreceiptitem', 'accessories.accessories_berlian.shape')->where('kategoriproduk_id', $this->id_kategoriproduk_berlian)->where('status', 1)->get();
            $this->dataPenerimaanBerlianArray = $this->dataPenerimaanBerlian->map(function ($data) {
                return $data;
            })
            ->flatten()
            ->keyBy('id')
            ->toArray();
            // dd($this->dataPcs);
        $this->dataGroupArray = $this->dataGroup->map(function ($data) {
            return $data;
        })
            ->flatten()
            ->keyBy('id')
            ->toArray();
        $this->dataKaratArray = $this->dataKarat->map(function ($data) {
            return $data;
        })
            ->flatten()
            ->keyBy('id')
            ->toArray();
        $this->dataItemProduksiArray = $this->dataItemProduksi->map(function ($data) {
            return $data;
        })
            ->flatten()
            ->keyBy('id')
            ->toArray();

            $this->dataAccessories = Accessories::where('status', 1)->get();

        $this->dataAccessoriesArray = $this->dataAccessories->map(function ($data) {
            return $data;
        })
            ->flatten()
            ->keyBy('id')
            ->toArray();

        $this->dataSatuans = Satuans::all();
    }

    protected $listeners = [
        'imageUploaded' => 'handleUploadedImage',
        'imageRemoved' => 'handleRemoveUploadedImage',
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset'
    ];

    public function imageUploaded($fileName)
    {
        $this->document = $fileName;
    }

    public function imageRemoved($fileName)
    {
        $this->document = array_filter($this->document, function ($file) use ($fileName) {
            return $file != $fileName;
        });
    }

    public function addInput()
    {
        $this->inputs[] = [
            'id_items' => '',
            'accessories_id' => '',
            'type' => '2',
            'amount' => '',
            'shapeberlian_id' => '',
            'qty' => 1,
            'gia_report_number' => '',
            'produksi_item_id' => '',
            'keterangan' => ''
        ];
    }

    public function addInputAccessories()
    {
        $this->accessories[] = [
            'id' => '',
            'amount' => '',
            'satuan_id' => '',
        ];
    }

    public function remove($i)
    {
        $this->resetErrorBag();
        unset($this->inputs[$i]);
        $this->inputs = array_values($this->inputs);
    }

    public function removeAccessories($i)
    {
        $this->resetErrorBag();
        unset($this->accessories[$i]);
        $this->inputs = array_values($this->inputs);
    }

    public function render()
    {
        $this->model_id = !empty($this->dataItemProduksiArray[$this->produksi_item_id]['model_id']) ? $this->dataItemProduksiArray[$this->produksi_item_id]['model_id'] : null;
        $this->karat_id = !empty($this->dataItemProduksiArray[$this->produksi_item_id]['karat_id']) ? $this->dataItemProduksiArray[$this->produksi_item_id]['karat_id'] : null;
        $this->berat = !empty($this->dataItemProduksiArray[$this->produksi_item_id]['berat']) ? $this->dataItemProduksiArray[$this->produksi_item_id]['berat'] : $this->berat;

        $this->tanggal = $this->hari_ini;
        return view('livewire.produksi.create');
    }

    private function resetInputFields()
    {
        $this->inputs = [
            [
                'id_items' => '',
                'accessories_id' => '',
                'type' => '2',
                'karatberlians' => '',
                'shapeberlian_id' => '',
                'qty' => 1,
                'gia_report_number' => '',
                'produksi_item_id' => '',
                'keterangan' => ''
            ]
        ];
    }


    public function rules()
    {
        $rules = [
            // 'produksi_item_id' => 'required',
            'code' => 'required|unique:products,product_code',
            // 'model_id' => 'required',
            // 'karat_id' => 'required',
            'category_id' => 'required',
            'image' => ['required_if:uploaded_image,'],
            'harga_jual' => 'required|gt:0',
            'berat' => 'required|numeric|regex:/^\d+(\.\d{1,3})?$/'
        ];

        /** validasi stok berlian
         * cek dulu apakah ini produksi berlian
         * collect data stok per jenis karat
         * bandingkan stok
         */
        if ($this->kategoriproduk_id == $this->id_kategoriproduk_berlian && !empty($this->inputs[0]['amount'])) {
            foreach ($this->inputs as $key => $value) {
                // $rules['inputs.' . $key . '.id_items'] = 'required';
                // $rules['inputs.' . $key . '.accessories_id'] = 'required';
                $rules['inputs.' . $key . '.amount'] = 'required|gt:0';
                $rules['inputs.' . $key . '.qty'] = 'required|gt:0';
                $qty = !empty($value['qty']) ? $value['qty'] : 0;
                $amount_used = !empty($value['amount']) ? $value['amount'] : 0;

                if (filter_var($amount_used, FILTER_VALIDATE_FLOAT)) {

                    if (!empty($value['accessories_id'])) {
                        $accessories = Accessories::where('id', $value['accessories_id'])->first();
                        if ($accessories->amount < ($accessories->amount_used + ($amount_used * $qty))) {
                            $stok_remains = $accessories->amount - $accessories->amount_used;

                            $rules['inputs.' . $key . '.amount'] = [
                                function ($attribute, $value, $fail) use ($stok_remains) {
                                    $fail('Sisa stok tidak mencukupi, sisa stok saat ini ' . $stok_remains . ' ct');
                                }
                            ];

                            $rules['inputs.' . $key . '.qty'] = [
                                function ($attribute, $value, $fail) use ($stok_remains) {
                                    $fail('Sisa stok tidak mencukupi, sisa stok berlian saat ini ' . $stok_remains . ' ct');
                                }
                            ];
                        }
                    }
                } else {
                    $rules['inputs.' . $key . '.amount'] = [
                        function ($attribute, $value, $fail) {
                            $fail('input amount harus berupa decimal');
                        }
                    ];
                }
            }
        }

        if (!empty($this->accessories[0]['amount'])) {
            foreach ($this->accessories as $key => $value) {
                $rules['accessories.' . $key . '.amount'] = 'required|gt:0';
                $amount_used = !empty($value['amount']) ? $value['amount'] : 0;
                if (filter_var($amount_used, FILTER_VALIDATE_FLOAT)) {

                    if (!empty($value['accessories_id'])) {
                        $accessories = Accessories::with('satuan')->where('id', $value['accessories_id'])->first();
                        if ($accessories->amount < ($accessories->amount_used + ($amount_used))) {

                            $rules['accessories.' . $key . '.amount'] = [
                                function ($attribute, $value, $fail) use ($accessories) {
                                    $stok_remains = $accessories->amount - $accessories->amount_used;
                                    $fail('Sisa stok tidak mencukupi, sisa stok saat ini ' . $stok_remains . ' ' . $accessories->satuan?->code);
                                }
                            ];
                        }
                    }
                } else {
                    $rules['accessories.' . $key . '.amount'] = [
                        function ($attribute, $value, $fail) {
                            $fail('input amount harus berupa decimal');
                        }
                    ];
                }
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'karatasal_id.required' => 'Karat asal harus diisi!',
            'karat_id.required' => 'Karat jadi harus diisi!',
            'category_id.required' => 'Category belum dipilih',
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
        $this->accessories = array_merge($this->inputs, $this->accessories);
        // dd($this->uploaded_image);
        DB::beginTransaction();
        try {
            $attribute = [];
            if (!empty($this->sertifikat) && !empty($this->sertifikat['code'] || !empty($this->sertifikat['attribute']))) {
                $sertifikat = $this->sertifikat;
                $attribute = !empty($sertifikat['attribute']) ? $sertifikat['attribute'] : [];
                if (isset($sertifikat['attribute'])) {
                    unset($sertifikat['attribute']);
                }

                $hari_ini = new DateTime();
                $hari_ini = $hari_ini->format('Y-m-d');
                $sertifikat['tanggal'] = !empty($sertifikat['tanggal']) ? $sertifikat['tanggal'] : $hari_ini;
                $sertifikat['code'] = !empty($sertifikat['code']) ? $sertifikat['code'] : '-';
                $diamond_certificate = DiamondCertifikatT::create($sertifikat);

                $dataInsertSertifikatAttribute = $attribute;
                foreach ($dataInsertSertifikatAttribute as $k => $row) {
                    $dataInsertSertifikatAttribute[$k]['diamond_certificate_id'] = $diamond_certificate->id;
                    $dataInsertSertifikatAttribute[$k]['diamond_certificate_attributes_id'] = $k;
                    $dataInsertSertifikatAttribute[$k]['keterangan'] = !empty($row['keterangan']) ? $row['keterangan'] : '';
                }
                DiamondCertificateAttribute::insert($dataInsertSertifikatAttribute);
            }
            $model_name = !empty($this->dataGroupArray[$this->model_id]['name']) ? $this->dataGroupArray[$this->model_id]['name'] : '';
            $karat_name = !empty($this->dataKaratArray[$this->karat_id]['name']) ? $this->dataKaratArray[$this->karat_id]['name'] : '';
            $total_karat_berlians = 0;
            if (!empty($this->inputs)) {
                foreach ($this->inputs as $item) {
                    $total_karat_berlians += !empty($item['amount']) ? $item['amount'] : 0;
                }
            }

            // Gagal upload image dropzone, tpi siapa tau kepake lagi
            // $image = '';
            // if ($this->image) {
            //     $img = $this->image;
            //     $folderPath = "uploads/";
            //     $image_parts = explode(";base64,", $img);
            //     $image_type_aux = explode("image/", $image_parts[0]);
            //     $image_type = $image_type_aux[1];
            //     $image_base64 = base64_decode($image_parts[1]);
            //     $fileName = 'webcam_' . uniqid() . '.jpg';
            //     $file = $folderPath . $fileName;
            //     Storage::disk('public')->put($file, $image_base64);
            //     $image = "$fileName";
            // }



            $product = Product::create([
                'category_id' => $this->category_id,
                'cabang_id' => null,
                'product_stock_alert' => 5,
                'product_name' => $model_name . ' ' . $karat_name . ' Berlian',
                'product_code' => $this->code,
                'product_price' => $this->harga_jual,
                'product_barcode_symbology' => 'C128',
                'product_unit'              => 'Gram',
                'karat_id'                  => $this->karat_id,
                'group_id'                  => $this->model_id,
                'berat_emas'                => $this->berat,
                'total_karatberlians'       => $total_karat_berlians,
                'diamond_certificate_id'    => !empty($diamond_certificate->id) ? $diamond_certificate->id : null,
                'images'                    => $this->getUploadedImage($this->image, $this->uploaded_image),
                // 'images'                    => $image,
                'status_id'                 => 11,
                'produksi_item_id'          => $this->produksi_item_id,
            ]);
            $product->updateTracking(ProductStatus::READY_OFFICE);



            $product_accessories = $this->accessories;

            if (!empty($product_accessories)) {
                $array_product_accessories = [];
                foreach ($product_accessories as $val) {

                    $amount_used = !empty($val['amount']) ? $val['amount'] : 0;
                    $accessories_id = !empty($val['accessories_id']) ? $val['accessories_id'] : null;
                    if (!empty($val['accessories_id'])) {
                        $accessories = Accessories::where('id', $val['accessories_id'])->first();
                        $status = ($accessories->amount > ($accessories->amount_used + $amount_used)) ? 1 : 2; // jika sudah terpakai semua maka set statusnya jadi 2
                        $accessories->amount_used = $amount_used;
                        $accessories->status = $status;
                        $accessories->save();
                    }
                    $array_product_accessories[] = [
                        'product_id' => $product->id,
                        'accessories_id' => $accessories_id,
                        'amount' => $amount_used,
                    ];
                }
                if (!empty($array_product_accessories) && !empty($array_product_accessories[0]['accessories_id'])) {
                    ProductAccessories::insert($array_product_accessories);
                }
                ProduksiItems::where('id', $this->produksi_item_id)->update(['status' => 2]); //update stok produksi agar tidak bisa dipilih kembali

            }
        } catch (\Throwable $th) {
            DB::rollBack();
            if (!empty($file)) {
                Storage::disk('public')->delete($file);
            }
            dd($th->getMessage());
            return $th->getMessage();
        }
        DB::commit();
        activity()->log(' ' . auth()->user()->name . ' input data pembuatan product ' . !empty($product->id) ? $product->id : '');
        toast('Produk Berhasil dibuat!', 'success');
        return redirect()->route('produksi.index');
    }

    private function getUploadedImage($image, $uploaded_image)
    {
        $folderPath = "uploads/";
        if (!empty($uploaded_image)) {
            Storage::disk('public')->move("temp/dropzone/{$uploaded_image}", "{$folderPath}{$uploaded_image}");
            return $uploaded_image;
        } elseif (!empty($image)) {
            $image_parts = explode(";base64,", $image);
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = 'webcam_' . uniqid() . '.jpg';
            $file = $folderPath . $fileName;
            Storage::disk('public')->put($file, $image_base64);
            return $fileName;
        }
    }

    public function setCurrentKey($key)
    {
        $this->currentKey = $key;
    }

    public function setItem($old_produksi_item_id = 0)
    {
        if (empty($this->produksi_item_id)) {
            $this->resetInputFields();
        }

        if ((!empty($this->inputs))) {
            foreach ($this->inputs as $k => $row) {
                if (!empty($row['produksi_item_id'])) {
                    unset($this->inputs[$k]);
                }
            }

            if (isset($this->inputs[0]) && empty($this->inputs[0]['id_items'])) {
                unset($this->inputs[0]);
            }
        }

        if (!empty($this->dataItemProduksiArray[$this->produksi_item_id]['goodsreceipt_id'])) {

            $goodsreceipt_id = $this->dataItemProduksiArray[$this->produksi_item_id]['goodsreceipt_id'];
            $items = GoodsReceiptItem::with('accessories')->where('goodsreceipt_id', $goodsreceipt_id)->get(); //Notes : urang ge poho naha ieu kudu ngequery dua kali/ only god knows it!
            $this->dataPenerimaanBerlian = GoodsReceiptItem::with('goodsreceiptitem', 'accessories.accessories_berlian.shape')->where('kategoriproduk_id', $this->id_kategoriproduk_berlian)->where('status', 1)->orWhere('goodsreceipt_id', $goodsreceipt_id)->get();
            foreach ($items as $row) {
                $this->inputs[] = [
                    'id_items' => $row->id,
                    'accessories_id' => $row->accessories?->id,
                    'type' => '1',
                    'amount' => floatval($row->accessories->amount),
                    'shapeberlian_id' => $row->shapeberlian_id,
                    'qty' => $row->qty,
                    'gia_report_number' => '',
                    'produksi_item_id' => $this->produksi_item_id,
                    'keterangan' => ''
                ];
            }
        } else {
            $this->dataPenerimaanBerlian = GoodsReceiptItem::with('goodsreceiptitem', 'accessories.accessories_berlian.shape')->where('kategoriproduk_id', $this->id_kategoriproduk_berlian)->where('status', 1)->get();
        }
        if (empty($this->inputs)) {
            $this->resetInputFields();
        }
        $this->setSelectedItem();
    }

    public function setSelectedItem($key = null)
    {

        if (!is_null($key)) {

            $id = !empty($this->inputs[$key]['id_items']) ? $this->inputs[$key]['id_items'] : '';
            if ($id) {
                $amount = !empty($this->dataPenerimaanBerlianArray[$id]['accessories']['amount']) ? $this->dataPenerimaanBerlianArray[$id]['accessories']['amount'] : 0;
                $amount_used = !empty($this->dataPenerimaanBerlianArray[$id]['accessories']['amount_used']) ? $this->dataPenerimaanBerlianArray[$id]['accessories']['amount_used'] : 0;
                $this->inputs[$key]['amount'] = floatval($amount - $amount_used);
            }
        }

        if (!empty($this->inputs)) {
            foreach ($this->inputs as $key => $row) {
                $this->selectedItemId[$key] = !empty($row['id_items']) ? $row['id_items'] : '';
                $this->setSelectedAccItem($key);
            }
        }
    }

    public function setSelectedAccItem($key = null)
    {

        if (!is_null($key)) {
            $id = !empty($this->inputs[$key]['accessories_id']) ? $this->inputs[$key]['accessories_id'] : '';
            if ($id) {
                $amount = !empty($this->dataAccessoriesArray[$id]['amount']) ? $this->dataAccessoriesArray[$id]['amount'] : 0;
                $amount_used = !empty($this->dataAccessoriesArray[$id]['amount_used']) ? $this->dataAccessoriesArray[$id]['amount_used'] : 0;
                $this->inputs[$key]['amount'] = floatval($amount - $amount_used);
            }
        }

        if (!empty($this->inputs)) {
            foreach ($this->inputs as $key => $row) {
                $this->selectedAccItemId[$key] = !empty($row['accessories_id']) ? $row['accessories_id'] : '';
            }
        }
    }
    public function setSelectedPcs($key)
    {
        // Logika pemilihan item
        $totalKaratPcs = $this->dataPcs[$key];

        // Tetapkan nilai total_karat yang dipilih ke variabel
        $this->selectedTotalKarat = $totalKaratPcs->total_karat;
    }
}
