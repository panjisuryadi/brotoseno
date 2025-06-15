<?php

namespace App\Http\Livewire\PenerimaanBarangDp;

use Livewire\Component;

class Pembayaran extends Component {
    public $tipe_pembayaran = '',
        $cicil = '',
        $tgl_jatuh_tempo;

    public function render()
    {
        return view('livewire.penerimaan-barang-dp.pembayaran');
    }
}