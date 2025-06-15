<?php

namespace App\Http\Livewire\Karat;


use Livewire\Component;
use App\Models\User;
use Modules\Karat\Models\Karat;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\Karat\Http\Controllers\KaratsController;

class Create extends Component
{
    public Karat $karat;
    public $jenis = '';
    public $dataKarat = [];

    public function __construct()
    {
        $this->karat = new Karat();
    }

    public function mount(){
        $this->dataKarat = Karat::where(function ($query) {
            $query->where('parent_id', null);
        })->get();
    }

    
    public function render(){
        return view('livewire.karat.create');
    }
    
    public function updatedJenis(){
        $this->resetExcept(['jenis','dataKarat']);
    }

    public function rules()
    {
        $rules = [
            'karat.kode' => [
                'requiredIf:jenis,1'
            ],
            'karat.name' => [
                "required",
                function ($attribute, $value, $fail) {
                    $exist = Karat::where(DB::raw('lower(name)'), strtolower($value))->where('parent_id',$this->karat->parent_id)->exists();
                    if ($exist) {
                        $fail('Nama Karat sudah digunakan');
                    }
                },
            ],
            'karat.parent_id' => [
                'requiredIf:jenis,2'
            ],
            'karat.coef' => ['requiredIf:jenis,1'],
            'karat.type' => ['requiredIf:jenis,1']
        ];
        return $rules;
    }

    public function messages(){
        return [
            '*.*.required_if' => 'Wajib diisi',
            '*.*.required' => 'Wajib diisi'
        ];
    }

    public function store(){
        $this->validate();
        DB::beginTransaction();
        try{
            $this->karat->save();
            if(empty($this->karat->parent_id)){
                $data = [
                    'user_id' => auth()->id(),
                    'tgl_update' => now(),
                    'harga_emas' => 0,
                    'harga_modal' => 0,
                    'margin' => 0,
                    'harga_jual' => 0
                ];
                $penentuan_harga = $this->karat->penentuanHarga()->create($data);

                $data['karat_id'] = $this->karat->id;
                $data['updated'] = 1;
                $data['created_by'] = auth()->user()->name;
                unset($data['tgl_update']);
                $data['tanggal'] = now();
                $penentuan_harga->history()->create($data);
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }
        $this->reset();
        return redirect(route('karat.index'));
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function getKaratLabelProperty(){
        if($this->jenis == '1' && !empty($this->karat->name) && !empty($this->karat->kode)){
            return $this->karat->name . ' | ' . $this->karat->kode;
        }elseif($this->jenis == '2'){
            if(!empty($this->karat->parent_id)){
                return $this->dataKarat->find($this->karat->parent_id)->label . ' ' . $this->karat->name;
            }else{
                return '';
            }
        }else{
            return '';
        }
    }

}
