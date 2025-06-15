<div class="row">
    <div class="col-lg-12">

<div id="printArea">

        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center">
                <div>
                    <span>PENGIRIMAN BARANG - DISTRIBUSI TOKO</span>
                </div>

            </div>


            <div class="card-body px-4">
                <div class="row mb-4">

                    <div class="col-sm-6 mb-4 mb-md-0">
                        <h5 class="mb-2 border-bottom pb-2">Invoice Info:</h5>
                        <div>Invoice: <strong>{{ $dist_toko->no_invoice }}</strong></div>
                        <div>Tanggal Nota: <strong> {{ \Carbon\Carbon::parse($dist_toko->date)->format('d M, Y') }}</strong></div>
                        <div>Cabang Tujuan: <strong>{{ @$dist_toko->cabang->name }}</strong></div>
                        <div>
                            Dibuat oleh: <strong>{{ $dist_toko->current_status_pic()->name }}</strong>
                        </div>

                    </div>
                    <div class="col-sm-6 mb-3 mb-md-0">
                        <div class="font-semibold mb-2 border-bottom pb-2">Detail Info: </div>
                        <div>Jumlah Item: <strong>{{ $dist_toko->items()->count() }} buah</strong></div>
                        <div>Jumlah Jenis Karat: <strong> {{ $dist_toko->items()->groupBy('karat_id')->count() }} </strong></div>
                        <div>Total Berat Emas: <strong> {{ $dist_toko->items()->sum('gold_weight') }} gr</strong></div>
                    </div>
                </div>

                <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">


                    <div class="flex relative py-1 pb-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">
                                <span class="text-blue-400">Detail Barang

                                </span>

                        </div>
                    </div>
                    <table style="width: 100% !important;" class="table table-sm table-striped rounded rounded-lg table-bordered">
                        <thead>
                            <tr>

                                <th class="text-center">No</th>
                                <th class="text-center">Produk</th>
                                <th class="text-center">Kode</th>
                                <th class="text-center">Karat</th>
                                <th class="text-center">Berat Emas</th>
                                <th class="text-center">Gambar Produk</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total_weight = 0;
                            @endphp
                            @forelse($dist_toko->items()->get() as $row)
                                @php
                                $row->load('product');
                                $total_weight = $total_weight + @$row->product->berat_emas;
                                $image = $row->product?->images;
                                $imagePath = empty($image)?url('images/fallback_product_image.png'):asset(imageUrl().$image);
                                @endphp
                            <tr>

                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="font-semibold">
                                    <p>Nama : {{ @$row->product->product_name }}</p>
                                    <p>Kategori : {{ @$row->product->category->category_name }}</p>
                                </td>
                                <td class="font-semibold text-center">
                                    <p>{{ @$row->product->product_code }}</p>
                                </td>
                                <td class="text-center font-semibold"> {{@$row->product->karat->label}}</td>
                                <td class="text-center font-semibold"> {{@$row->product->berat_emas}} gr</td>
                                <td class="text-center"> <a href="{{ $imagePath }}" data-lightbox="{{ @$image }} " class="single_image flex justify-center">
                                        <img src="{{ $imagePath }}" order="0" width="70" class="img-thumbnail"/>
                                    </a>
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
        

        <table style='width:100%!important; font-size:12pt;' cellspacing='2'>
            <tr>
                <td style="border: none !important;text-align: center;" align='center'>
                    Diterima Oleh,
                </br></br>
                </br></br>
                </br></br>
                <u>(..................................................)</u>
                </td>
                <td style='border: none !important; padding:5px; text-align:left; width:30%'></td>
                <td style="text-align: center; border: none !important;" align='center'>Hormat Kami,<br>
                <span style='font-size:12pt'><b>{{ settings()->company_name }}</b></span></br>

                </br>
                </br></br>
                </br></br>
                <u>(...................................................)</u>
                </td>
            </tr>
        </table>



            </div>
        </div>




    </div>


</div>
  
</div>

@push('page_css')
<style type="text/css">

        @media print {
            body * {
                visibility: hidden;
            }
            #printArea, #printArea * {
                visibility: visible;
            }
            #printArea {
                width: 100%;
                position: absolute;
                left: 0;
                top: 0;
            }
        }

</style>
@endpush
@push('page_scripts')
<script type="text/javascript">

$(document).ready(function () {
    window.print();
});

</script>
@endpush