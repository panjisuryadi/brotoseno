<div class="row">
    <div class="col-lg-12">
        <div class="card">

  <div class="card-header justify-between d-flex flex-wrap align-items-center">
                <div>
                    <h1 class="text-lg font-semibold">DISTRIBUSI TOKO</h1>
                </div>
                <div class="px-2">
                    {{ \Carbon\Carbon::parse(date('Y-m-d'))->format('d M, Y') }}
                </div>
                
            </div>




            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6 mb-3 mb-md-0">
                        <div class="font-semibold mb-2 border-bottom pb-2">Invoice Info: </div>
                        <div>Invoice: <strong>{{ $dist_toko->no_invoice }}</strong></div>
                        <div>Tanggal Distribusi: <strong> {{ \Carbon\Carbon::parse($dist_toko->date)->format('d M, Y') }}</strong></div>
                        <div>Cabang: <strong>{{ $dist_toko->cabang->name }}</strong></div>
                        <div class="uppercase">Status: <span class="text-green-600 font-bold">{{ $dist_toko->current_status->name }}</span></div>

                    </div>

                    <div class="col-sm-6 mb-3 mb-md-0">
                        <div class="font-semibold mb-2 border-bottom pb-2">Distribusi Info: </div>
                        <div>Jumlah Item: <strong>{{ $dist_toko->items()->count() }} buah</strong></div>
                        <div>Jumlah Jenis Karat: <strong> {{ $dist_toko->items()->groupBy('karat_id')->count() }} </strong></div>
                        <div>Total Berat Emas: <strong> {{ $dist_toko->items()->sum('gold_weight') }} gr</strong></div>
                    </div>





                </div>


                <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">


                    <!-- Approved Items -->
                    <div class="flex relative py-1 pb-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">
                                <span class="text-blue-400"> Detail Distribusi (Approved Items)
                                </span>

                        </div>
                    </div>

                    <table style="width: 100% !important;" class="table table-sm table-striped rounded rounded-lg table-bordered">
                        <thead>
                            <tr>

                                <th class="text-center">No</th>
                                <th class="text-center">Karat</th>
                                <th class="text-center">Berat Emas</th>
                                <th class="text-center">Produk</th>
                                <th class="text-center">Group</th>
                                <th class="text-center">Model</th>
                                <th class="text-center">Code</th>
                              

                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total_weight = 0;
                            @endphp
                            @forelse($dist_toko->items()->approved()->get() as $row)
                            @php
                            $data = json_decode($row->additional_data)->product_information;
                            $total_weight = $total_weight + $row->gold_weight;
                            @endphp
                            <tr>

                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-center font-semibold"> {{@$row->karat?->label}}</td>
                                <td class="text-center font-semibold"> {{@$row->gold_weight}} gr</td>
                                <td class="text-center font-semibold">{{ $data->product_category->name }}</td>
                                <td class="text-center font-semibold">{{ $data->group->name }}</td>
                                <td class="text-center font-semibold">{{ $data->model->name }}</td>
                                <td class="text-center font-semibold">{{ $data->code }}</td>
                               

                            </tr>
                            @empty
                            <tr>
                                <th colspan="8" class="text-center">Tidak ada data</th>
                            </tr>
                            @endforelse
                            <tr>
                                <td class="border-0" colspan="3"></td>
                                <td class="border-0"></td>
                                <td class="border-0"></td>

                                <td colspan="3" class="border-0 text-center font-semibold">
                                    <div class="text-right px-3 text-2xl">
                                        <span class="text-base text-gray-500"> Jumlah Emas : </span>

                                        <span class="px-2"> {{ $total_weight }} <small>GR</small></span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>

                <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">


                    <!-- Returned Items -->
                    <div class="flex relative py-1 pb-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">
                                <span class="text-blue-400"> Detail Distribusi (Returned Items)
                                </span>

                        </div>
                    </div>

                    <table style="width: 100% !important;" class="table table-sm table-striped rounded rounded-lg table-bordered">
                        <thead>
                            <tr>

                                <th class="text-center">No</th>
                                <th class="text-center">Karat</th>
                                <th class="text-center">Berat Emas</th>
                                <th class="text-center">Produk</th>
                                <th class="text-center">Group</th>
                                <th class="text-center">Model</th>
                                <th class="text-center">Code</th>
                                <th class="text-center">Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total_weight = 0;
                            @endphp
                            @forelse($dist_toko->items()->returned()->get() as $row)
                            @php
                            $data = json_decode($row->additional_data)->product_information;
                            $total_weight = $total_weight + $row->gold_weight;
                            @endphp
                            <tr>

                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-center font-semibold"> {{@$row->karat?->label}}</td>
                                <td class="text-center font-semibold"> {{@$row->gold_weight}} gr</td>
                                <td class="text-center font-semibold">{{ $data->product_category->name }}</td>
                                <td class="text-center font-semibold">{{ $data->group->name }}</td>
                                <td class="text-center font-semibold">{{ $data->model->name }}</td>
                                <td class="text-center font-semibold">{{ $data->code }}</td>
                                <td class="text-center font-semibold">
                                    <a href="#" class="hover:text-blue-400 btn btn-sm btn-info px-4">View</a>

                                </td>

                            </tr>
                            @empty
                            <tr>
                                <th colspan="8" class="text-center">Tidak ada data</th>
                            </tr>
                            @endforelse
                            <tr>
                                <td class="border-0" colspan="3"></td>
                                <td class="border-0"></td>
                                <td class="border-0"></td>

                                <td colspan="3" class="border-0 text-center font-semibold">
                                    <div class="text-right px-3 text-2xl">
                                        <span class="text-base text-gray-500"> Jumlah Emas : </span>

                                        <span class="px-2"> {{ $total_weight }} <small>GR</small></span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>

