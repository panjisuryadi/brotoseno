@extends('layouts.app')
@section('title', ''.$module_title.' Details')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("goodsreceipt.index") }}">{{$module_title}}</a></li>
    <li class="breadcrumb-item active">{{$module_action}}</li>
</ol>
@endsection
@section('content')
@php
    $isBerlian = $id_kategoriproduk_berlian == $detail->kategoriproduk_id ? true : false;
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center">
                    <div>
                        Invoice: <strong>{{ $detail->no_invoice }}</strong>
                    </div>



                      <a  class="btn  mfs-auto btn-sm btn-success mfe-1" href="{{ route("goodsreceipt.index") }}"><i class="bi bi-house-door"></i> Home 
                    </a>


                    <a target="_blank" class="btn btn-sm btn-secondary mfe-1 d-print-none" href="{{ route(''.$module_name.'.print',encode_id($detail->id)) }}"><i class="bi bi-printer"></i> Print
                    </a>

                    <a target="_blank" class="btn btn-sm btn-info mfe-1 d-print-none" href="{{ route(''.$module_name.'.cetak',encode_id($detail->id)) }}">
                        <i class="bi bi-save"></i> Save
                    </a>





                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-3 mb-3 mb-md-0">
                            <h5 class="mb-2 border-bottom pb-2">Company Info:</h5>
                            <div><strong>{{ settings()->company_name }}</strong></div>
                            <div>{{ settings()->company_address }}</div>
                            <div>Cabang: <strong>{{ Auth::user()->isUserCabang()?ucfirst(Auth::user()->namacabang()->name):'' }} </strong></div>
                            <div>Email: {{ settings()->company_email }}</div>
                            <div>Phone: {{ settings()->company_phone }}</div>
                        </div>
                        <div class="col-sm-3 mb-3 mb-md-0">
                            <h5 class="mb-2 border-bottom pb-2">Supplier Info:</h5>
                            <div><strong>{{ $detail->supplier->supplier_name }}</strong></div>
                            <div>{{ $detail->supplier->address }}</div>
                            <div>Email: {{ $detail->supplier->supplier_email }}</div>
                            <div>Phone: {{ $detail->supplier->supplier_phone }}</div>
                            {{--  {{ $detail->supplier }} --}}
                        </div>
                        <div class="col-sm-3 mb-3 mb-md-0">
                            <h5 class="mb-2 border-bottom pb-2">Invoice Info:</h5>
                            <div>Invoice: <strong>{{ $detail->no_invoice }}</strong></div>
                              <div>Tanggal: {{ \Carbon\Carbon::parse($detail->date)->format('d M, Y') }}</div>
                            <div>
                                Pengirim: <strong>{{ $detail->pengirim }}</strong>
                            </div>
                            <div>
                                {{ Label_case('tipe_pembayaran') }}: <label class="bg-green-400 rounded-md py-0 px-3">{{ $detail->tipe_pembayaran }}</label>
                                @if($detail->pembelian->tipe_pembayaran == 'jatuh_tempo')
                                <div class="text-gray-800 text-sm">
                                    <label class="small text-blue-500">Jatuh Tempo</label>
                                    {!! tanggal2(@$data->pembelian->jatuh_tempo)!!}
                                </div>
                                @elseif($detail->pembelian->tipe_pembayaran == 'cicil')
                                <p class="text-gray-600">Cicilan : {{ $detail->pembelian->cicil }} Kali</p>
                                @else
                                <p class="text-gray-600">LUNAS</p>
                                @endif
                            </div>

                         {{--    {{ $detail }} --}}

                        </div>


                   <div class="col-sm-3 mb-3 mb-md-0 ">
                            <h5 class="mb-2 border-bottom pb-2">Gambar Nota :</h5>
                           <div class="flex align-items-center justify-center">

                              @php
                                $image = $detail->images;
                                $imagePath = empty($image)?url('images/fallback_product_image.png'):asset(imageUrl().$image);
                              @endphp


                               <div class="text-center align-items-center items-center">

                                 <a href="{{ $imagePath }}" data-lightbox="{{ @$image }} " class="single_image">
                                    <img src="{{ $imagePath }}" order="0" width="40%" class="img-thumbnail"/>
                                </a>

                               </div>
                    {{--        {{ $detail }} --}}



                           </div>

                        </div>








                    </div>
                    <div class="card-header">
                       <span class="text-gray-600 text-md font-semibold">Detail</span>
                    </div>
                    <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">
                        @if($isBerlian)
                        <table style="width: 100% !important;" class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Karat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($detail->goodsreceiptitem as $row)
                                @php
                                    $karat = '-';

                                    if(!empty($row->karatberlians)) {
                                        $karat = $row->karatberlians . ' ct)';
                                    }
                                    if(!empty($row->klasifikasi_berlian)) {
                                        $karat = $row->klasifikasi_berlian . ' (' . $row->karatberlians . ' ct)';
                                    }
                                    if(!empty($row->karat_id)) {
                                        $karat = $row->karat?->label;
                                    }
                                @endphp
                                <tr>
                                    <th class="text-center">{{$loop->iteration}}</th>
                                    <td class="text-center"> {{@$row->mainkategori->name}} {{ $row->shape_berlian->shape_name }}</td>
                                    <td class="text-center"> {{ $karat }} </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="5" class="text-center">Tidak ada data</th>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @else
                        <table style="width: 100% !important;" class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Karat</th>
                                    <th class="text-center">Berat Real</th>
                                    <th class="text-center">BeratKotor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($detail->goodsreceiptitem as $row)
                                @php
                                    $karat = '-';

                                    if(!empty($row->karatberlians)) {
                                        $karat = $row->karatberlians . ' ct)';
                                    }
                                    if(!empty($row->klasifikasi_berlian)) {
                                        $karat = $row->klasifikasi_berlian . ' (' . $row->karatberlians . ' ct)';
                                    }
                                    if(!empty($row->karat_id)) {
                                        $karat = $row->karat?->label;
                                    }
                                @endphp
                                <tr>
                                    <th class="text-center">{{$loop->iteration}}</th>
                                    <td class="text-center"> {{@$row->mainkategori->name}}</td>
                                    <td class="text-center"> {{ $karat }} </td>
                                    <td class="text-center"> {{@$row->berat_real}}</td>
                                    <td class="text-center"> {{@$row->berat_kotor}}</td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="5" class="text-center">Tidak ada data</th>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @endif
                        @if ($detail->pembelian->isCicil())
                        <div class="card-header">
                            <span class="text-gray-600 text-md font-semibold">Rincian Cicilan</span>

                        </div>
                        <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">
                            <table style="width: 100% !important;" class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nomor Cicilan</th>
                                        <th class="text-center">Tanggal Cicilan</th>
                                        <th class="text-center">Jumlah Cicilan Emas</th>
                                        <th class="text-center">Jumlah Cicilan Nominal</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Sisa Cicilan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sisa_nominal = $detail->harga_beli ?? 0;
                                        $sisa_emas = $detail->total_emas ?? 0;
                                    @endphp
                                    @forelse($detail->pembelian->detailCicilan as $row)
                                    <tr>
                                        <th class="text-center">{{$row->nomor_cicilan}}</th>
                                        <td class="text-center"> {{@$row->tanggal_cicilan}}</td>
                                        <td class="text-center"> {{!empty($row->jumlah_cicilan) ? formatBerat($row->jumlah_cicilan) . ' gr' : ''}} </td>
                                        <td class="text-center"> {{!empty($row->nominal) ? format_currency($row->nominal) : '' }}</td>
                                        <td class="text-center"> {{label_case($detail->pembelian->lunas)}} </td>
                                        @if($isBerlian)
                                            <td class="text-center"> {{ format_currency(($sisa_nominal - $row->nominal) > 0 ? $sisa_nominal - $row->nominal : 0) }}</td>
                                        @endif
                                        @if(!$isBerlian)
                                            <td class="text-center"> {{ formatBerat(($sisa_emas - $row->jumlah_cicilan) ? $sisa_emas - $row->jumlah_cicilan : 0 ) }} gr</td>
                                        @endif
                                    </tr>
                                    @empty
                                    <tr>
                                        <th colspan="5" class="text-center">Tidak ada data</th>
                                    </tr>
                                    @php
                                        $sisa_nominal -= $row->nominal;
                                        $sisa_emas -= $row->jumlah_cicilan;
                                    @endphp
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-5 ml-md-auto">
                            <table style="width: 100% !important;"
                                class="table md:table-sm lg:table-sm">
                                <tbody>
                                    @if($isBerlian)
                                    <tr>
                                        <td class="left"><strong>{{ Label_case('Total Karat') }}</strong></td>
                                        <td class="right"><strong class="text-blue-600 text-md">{{ $detail->total_karat }}
                                         <small class="text-gray-700">ct</small></strong></td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td class="left"><strong>{{ Label_case('total_berat_kotor') }}</strong></td>
                                        <td class="right"><strong class="text-blue-600 text-md">{{ $detail->total_berat_kotor }}
                                         <small class="text-gray-700">Gram</small></strong></td>
                                    </tr>
                                     <tr>
                                        <td class="left"><strong>{{ Label_case('berat_timbangan') }}</strong></td>
                                        <td class="right"><strong class="text-blue-600 text-md">{{ $detail->berat_timbangan }}
                                         <small class="text-gray-700">Gram</small></strong></td>
                                    </tr>

                                    <tr>
                                        <td class="left"><strong>{{ Label_case('total emas yang harus di bayar') }}</strong></td>
                                        <td class="right"><strong class="text-blue-600 text-md">{{ $detail->total_emas }}
                                         <small class="text-gray-700">Gram</small></strong></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page_css')
<style type="text/css">
@media (max-width: 767.98px) {
.table-sm th,
.table-sm td {
padding: .2em !important;
}
}
</style>
@endpush