<?php

namespace Modules\Sale\Http\Controllers;

use App\Http\Livewire\Custom\Custom;
use DateTime;
use App\Models\LookUp;
use Illuminate\Http\Request;
use Modules\Cabang\Models\Cabang;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sale\Entities\Customs;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Category;
use Illuminate\Contracts\Support\Renderable;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Produksi\Models\DiamondCertificateAttributes;
use Modules\Sale\Entities\CustomsCt;

class CustomController extends Controller
{

    private $module_title;
    private $module_name;
    private $module_path;
    private $module_icon;
    private $module_model;
    private $module_detail;
    private $module_payment;
    private $module_product;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Custom';

        // module name
        $this->module_name = 'customs';

        // directory path of the module
        $this->module_path = 'custom';

        // module model name, path
        $this->module_model = "Modules\Sale\Entities\Customs";

    }

    public $dataKategoriProduk = [];
    public $id_kategoriproduk_berlian;
    public $dataCertificateAttribute;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $customs = Customs::get();
        $cabangs = Cabang::get();
        $customsArray = $customs->toArray();

        return view('sale::custom.index', compact('cabangs'))->with(['customs' => $customsArray]);
    }

    public function index_data(Request $request) {
        
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($custom_id)
    {
        $customs_id = $custom_id;
        $code = Product::generateCode();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $id_kategoriproduk_berlian = LookUp::select('value')->where('kode', 'id_kategoriproduk_berlian')->first();
        $id_kategoriproduk_berlian = !empty($id_kategoriproduk_berlian['value']) ? $id_kategoriproduk_berlian['value'] : 0;
        $dataKategoriProduk = Category::where('kategori_produk_id', $id_kategoriproduk_berlian)->get();
        $this->dataCertificateAttribute = DiamondCertificateAttributes::all();
        return view('sale::custom.create', compact(
            'customs_id',
            'code',
            'hari_ini',
            'id_kategoriproduk_berlian'
        ))->with([
            'dataKategoriProduk' => $dataKategoriProduk,
            'dataCertificateAttribute' => $this->dataCertificateAttribute
        ]);
    }

    public function rule (){
        $rules = [
            'code' => 'required',
            'tanggal' => 'required',
            // 'category_id' => 'required',
            'berat' => 'required',
            'harga_jual' => 'required'
        ];
        return $rules;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([ 
            'code' => 'required',
            'tanggal' => 'required',
            // 'category_id' => 'required',
            'berat' => 'required',
            'harga_jual' => 'required'
        ]);
        DB::beginTransaction();
        
        try {
            $customs = Customs::find($request->customs_id);

            $customs->code = $request->code;
            $customs->date = $request->tanggal;
            $customs->berat_jadi = number_format($request->berat_jadi, 3, '.', '');
            $customs->harga_jual = $request->harga_jual;

            $customs->ongkos_produksi = $request->ongkos_produksi ?? 0;
            $customs->ongkos_cuci = $request->ongkos_cuci ?? 0;
            $customs->ongkos_rnk = $request->ongkos_rnk ?? 0;
            $customs->ongkos_mt = $request->ongkos_mt ?? 0;
    
            $customs->save();

            // dd($customs);
            DB::commit();
            return redirect()->route('sale.custom.index')->with('message', 'Barang custom berhasil.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withInput()->withErrors(['error' => $th->getMessage()]);
        }


    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('sale::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('sale::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($custom_id)
    {
        CustomsCt::where('customs_id', $custom_id)->delete();
        Customs::destroy($custom_id);
        return redirect()->back()->with('success', 'Item berhasil dihapus.');
    }
}
