<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center">
                    <h1 class="font-bold">Summary Distribusi</h1>


                      <a  class="btn  mfs-auto btn-sm btn-success mfe-1" href="#" wire:click="back"><i class="bi bi-house-door"></i> Kembali
                    </a>



                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-3 mb-3 mb-md-0">
                            <h5 class="mb-2 border-bottom pb-2">Invoice Info:</h5>
                            <div>No Distribusi Toko: <strong>{{ $distribusi_toko['no_distribusi_toko'] }}</strong></div>
                              <div>Tanggal: {{ \Carbon\Carbon::parse($distribusi_toko['date'])->format('d M, Y') }}</div>
                            <div>
                                Cabang: <strong>{{ \Modules\Cabang\Models\Cabang::find($distribusi_toko['cabang_id'])->name }}</strong>
                            </div>
                        </div>
                    </div>


                   
                    <div class="card-header">
                       <span class="text-gray-600 text-md font-semibold">Detail</span>
                    </div>
                    <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">
                        <table style="width: 100% !important;" class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Karat</th>
                                    <th class="text-center">Berat Emas</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-center">18K</td>
                                        <td class="text-center">20 gram</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>