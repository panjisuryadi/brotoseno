@extends('layouts.app')
@section('title', ''.$module_title.' Details')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("penerimaanbarangdp.index") }}">Penerimaan Barang DP</a></li>
    <li class="breadcrumb-item active">{{ $detail->no_barang_dp }}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center">
                    <div>
                        Invoice: <strong>{{ $detail->no_barang_dp }}</strong>
                    </div>



                      <a  class="btn  mfs-auto btn-sm btn-success mfe-1" href="{{ route("penerimaanbarangdp.index") }}"><i class="bi bi-house-door"></i> Home
                    </a>


                    <a target="_blank" class="btn btn-sm btn-secondary mfe-1 d-print-none" href="{{ route(''.$module_name.'.print',$detail->id) }}"><i class="bi bi-printer"></i> Print
                    </a>


                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-3 mb-3 mb-md-0">
                            <h5 class="mb-2 border-bottom pb-2">Info Perusahaan :</h5>
                            <div><strong>{{ settings()->company_name }}</strong></div>
                            <div>{{ settings()->company_address }}</div>
                            <div>Cabang: <strong>{{ Auth::user()->isUserCabang()?ucfirst(Auth::user()->namacabang()->name):'' }} </strong></div>
                            <div>Email: {{ settings()->company_email }}</div>
                            <div>Phone: {{ settings()->company_phone }}</div>
                        </div>
                        <div class="col-sm-3 mb-3 mb-md-0">
                            <h5 class="mb-2 border-bottom pb-2">Info Pemilik Barang :</h5>
                            <div>Nama : <strong>{{ $detail->owner_name }}</strong></div>
                            <div>Alamat : <strong>{{ $detail->address }}</strong></div>
                            <div>Phone : <strong>{{ $detail->contact_number }}</strong></div>
                            <div>No KTP : <strong>{{ $detail->no_ktp }}</strong></div>
                        </div>
                        <div class="col-sm-3 mb-3 mb-md-0">
                            <h5 class="mb-2 border-bottom pb-2">Info Invoice :</h5>
                            <div>Invoice: <strong>{{ $detail->no_barang_dp }}</strong></div>
                              <div>Tanggal: <strong>{{ \Carbon\Carbon::parse($detail->date)->format('d M, Y') }}</strong></div>
                            <div>
                                PIC / Penerima: <strong>{{ $detail->pic->name }}</strong>
                            </div>
                            <div>
                                {{ Label_case('tipe_pembayaran') }}: <label class="bg-green-400 rounded-md py-0 px-3">{{ $detail->payment->label_type }}</label>
                                @if($detail->payment->type == 1)
                                <p class="text-sm">
                                    Jatuh Tempo: <strong>{!! tanggal2(@$detail->payment->detail->first()->due_date)!!}</strong>
                                </p>
                                @elseif($detail->payment->type == 2)
                                <p class="text-sm">Cicilan : <strong> {{ $detail->payment->cicil }} Kali</strong></p>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm">
                                    Nominal : <strong>{{ format_uang($detail->nominal) }}</strong>
                                </p>
                                <p class="text-sm">
                                    Biaya Box : <strong>{{ format_uang($detail->box_fee) }}</strong>
                                </p>
                            </div>

                        </div>


                   <div class="col-sm-3 mb-3 mb-md-0 ">
                            <h5 class="mb-2 border-bottom pb-2">Gambar Barang :</h5>
                           <div class="flex align-items-center justify-center">

                              @php
                                $image = $detail->product->images;
                                $imagePath = empty($image)?url('images/fallback_product_image.png'):asset(imageUrl().$image);
                              @endphp


                               <div class="text-center align-items-center items-center">
                                 <a href="{{ $imagePath }}" data-lightbox="{{ @$image }} " class="single_image">
                                    <img src="{{ $imagePath }}" order="0" width="40%" class="img-thumbnail"/>
                                </a>
                               </div>



                           </div>

                        </div>








                    </div>
                    <div class="card-header">
                       <span class="text-gray-600 text-md font-semibold">Detail</span>
                    </div>
                    <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">
                        <div class="card-header">
                            <span class="text-gray-600 text-md font-semibold">Rincian Pembayaran</span>

                        </div>
                        <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">
                            <table style="width: 100% !important;" class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nomor Pembayaran</th>
                                        <th class="text-center">Tanggal Jatuh Tempo</th>
                                        <th class="text-center">Tanggal Pembayaran</th>
                                        <th class="text-center">Nominal</th>
                                        <th class="text-center">Biaya Box</th>
                                        <th class="text-center">Total Nominal</th>
                                        <th class="text-center">PIC</th>
                                        <th class="text-center">Cetak Struk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($detail->payment->detail as $row)
                                    <tr>
                                        <th class="text-center">{{@$row->order_number}}</th>
                                        <td class="text-center"> {{tanggal(@$row->due_date)}}</td>
                                        <td class="text-center"> {{@$row->paid_date?tanggal(@$row->paid_date):'-'}}</td>
                                        <td class="text-center"> {{ @$row->nominal?format_uang($row->nominal):'-' }} </td>
                                        <td class="text-center"> {{@$row->box_fee?format_uang($row->box_fee):'-' }} </td>
                                        <td class="text-center"> {{@$row->total_fee?format_uang(@$row->total_fee):'-' }} </td>
                                        <td class="text-center"> {{@$row->pic_id?$row->pic->name:'-' }} </td>
                                        <td class="text-center">
                                             @if (!empty(@$row->paid_date))
                                                 <a target="_blank" href="{{ route('penerimaanbarangdp.payment_detail.print',$row) }}"><i class="bi bi-printer"></i> Cetak</a>
                                             @else
                                                -
                                             @endif
                                            
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <th colspan="5" class="text-center">Tidak ada data</th>
                                    </tr>
                                    @endforelse
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