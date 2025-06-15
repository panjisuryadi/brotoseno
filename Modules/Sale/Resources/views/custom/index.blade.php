@extends('layouts.app')
@section('title', 'Custome')
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Custome</li>
</ol>
@endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between py-1 border-bottom">
                        <div class="flex justify-between">
                            <p class="uppercase text-lg text-gray-600 font-semibold">
                            Data <span class="text-yellow-500 uppercase">CUSTOM</span>
                                {{-- <span class="text-gray-400 uppercase">{{ $type }}</span> --}}
                            </p>
                        </div>
                        @php
                            $users = Auth::user()->id;
                        @endphp

  
                        @if($users == 1)
                        <div class="form-group px-4">
                        <select class="form-control form-control-sm select2" data-placeholder="Pilih Cabang" tabindex="1" name="cabang_id" id="cabang_id">
                            <option value="">Pilih Cabang</option>
                                @foreach($cabangs as $k)
                                <option value="{{$k->id}}" {{ old("id") == $k ? 'selected' : '' }}>{{$k->name}}</option>
                            @endforeach
                        </select>
                        </div>
                        @else
                        <p class="uppercase text-lg text-gray-600 font-semibold">
                            &nbsp;| {{ Auth::user()->isUserCabang()?ucfirst(Auth::user()->namacabang()->name):'' }} 
                        </p>
                        @endif
                    </div>  
  
                    {{-- <div class="btn-group btn-group-md">
                        <a href="{{ route('sale.custom.create') }}"
                            id="Tambah"
                            data-toggle="tooltip"
                            class="btn btn-outline-secondary px-3">
                            <i class="bi bi-plus"></i>@lang('Add')&nbsp;Barang DP
                        </a>
                    </div> --}}

                    <div class="w-full mt-1">
                        <table id="datatable" style="wid    th: 100%" class="table table-bordered table-hover md:table-sm lg:table-sm table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 3%!important;">No</th>
                                    <th style="width: 10%!important;" class="text-center">{{ __("Date") }}</th>
                                    <th style="width: 10%!important;" class="text-center">{{ __("Nomor Pesanan") }}</th>
                                    <th style="width: 19%!important;" class="text-center">{{ __('Jenis Barang') }}</th>
                                    <th style="width: 11%!important;" class="text-center">{{ __('Berat Emas') }}</th>
                                    <th style="width: 18%!important;" class="text-center">{{ __('Nominal DP') }}</th>
                                    <th style="width: 11%!important;" class="text-center">{{ __("Harga Jual") }}</th>
                                    <th style="width: 18%!important;" class="text-center">{{ __('Status') }}</th>
                                    <th style="width: 18%!important;" class="text-center"> {{ __('Action') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customs as $custom)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($custom['created_at'])->format('d/m/Y') }}</td>
                                        <td class="text-center">{{ $custom['custom_code'] }}</td>
                                        <td class="text-center">{{ $custom['jenis_barang'] }}</td>
                                        <td class="text-center">{{ $custom['berat'] }}</td>
                                        <td class="text-center">{{ format_uang($custom['total']) }}</td>
                                        <td class="text-center">{{ $custom['harga_jual'] ? format_uang($custom['harga_jual']) : '-'}}</td>
                                        <td class="text-center p-6 bg-violet-600 border-4 border-violet-300 border-dashed">
                                            @if ($custom['status'])
                                                
                                                <span class="inline-block bg-green-700 px-2 py-1 rounded-lg text-sm text-white capitalize">
                                                    {{ $custom['status'] }}
                                                </span>
                                            @else
                                                <span class="inline-block bg-red-700 px-2 py-1 rounded-lg text-sm text-white">
                                                    Not Complete
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{ __('Action') }}
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if($custom['code'] || $custom['status'])
                                                        <a id="hidden-link" href="{{ route('sale.custom.create', $custom['id']) }}"></a>
                                                        <button class="dropdown-item" disabled>Hasil</button>
                                                    @else
                                                        <a class="dropdown-item" href="{{ route('sale.custom.create', $custom['id']) }}">Hasil</a>
                                                    @endif
                                                    <button id="pembayaran-dp-btn"
                                                        class="dropdown-item @if(!$custom['code'] || $custom['status']) opacity-50 @endif"
                                                        data-custom-id="{{ $custom['id'] }}"
                                                        data-toggle="modal"
                                                        data-target="{{ $custom['code'] ? '#pembayaran_dp' : '' }}"
                                                        onclick="Livewire.emit('showModal', {{ $custom['id'] }});"
                                                        @if(!$custom['code'] || $custom['status']) disabled @endif>Pelunasan DP
                                                    </button>
                                                    <form action="{{ route('sale.custom.destroy', $custom['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@livewire('custom.custom')
@endsection

{{-- Ga tau kenapa javascript tidak jalan --}}
{{-- @push('page_scripts')
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#pembayaran-dp-btn').on('click', function() {
                var customId = $(this).data('custom-id');
                Livewire.emit('showModal', customId);
                console.log(customId);
            });
        });
    </script>
@endpush --}}