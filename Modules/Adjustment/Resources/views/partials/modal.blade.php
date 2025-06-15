<div class="modal fade" id="confirmmodal" tabindex="-1" role="dialog" aria-labelledby="confirmmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="confirmmodalLabel">Pilih Lokasi</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h2>
                Bila anda menjalankan Stock Opname, Feature Pembelian, POS dan Penjualan akan dikunci.
            </h2>
            <form action="">
                <div class="row pt-2">
                    <div class="col-12 form-group">
                            <label for="">Pilih Lokasi Stock Opname</label> <br>
                        <select id="adjustment-location" class="form-control">
                            <option value="">Pilih Lokasi </option>
                        @foreach (\Modules\Adjustment\Entities\AdjustmentSetting::LOCATION as $key => $value)
                            @if(auth()->user()->isUserCabang() && $key == '6' ||auth()->user()->isUserCabang() && $key == '7')
                                <option value="{{ $key }}">{{ $value }}</option>
                            @elseif(!auth()->user()->isUserCabang())
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endif
                        @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary" onclick="runningadjustment()">
                @lang('Run Adjustment') 
            </button>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailmodal" tabindex="-1" role="dialog" aria-labelledby="detailmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="detailmodalLabel">Detail</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div id="modal-content">

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
        </div>
    </div>
</div>


<div class="modal fade" id="stopAdjustmentModal" tabindex="-1" role="dialog" aria-labelledby="stopAdjustmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title text-value-md">Stop Adjustment</h1>
        </div>
        <div class="modal-body">
            <h3 class="">Apakah anda yakin ingin menghentikan proses Stok Opname ?</h3>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary" onclick="stopAdjustment()">
                @lang('Stop Adjustment') 
            </button>
        </div>
        </div>
    </div>
</div>