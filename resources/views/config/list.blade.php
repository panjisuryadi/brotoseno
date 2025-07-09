@extends('layouts.app')
@section('title', 'Config')
@section('third_party_stylesheets')
<style>
body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        page-break-before: always;
    }
.invoice {
    width: 100%;
    max-width: 900px;
    border: 1px solid #000;
    padding: 20px;
    background-color: #f9f9f9;
}
.header, .footer {
    text-align: center;
    margin-bottom: 10px;
}
.header img {
    width: 100px;
}
.invoice-details, .total {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}
.invoice-details div, .total div {
    width: 45%;
}
.total {
    margin-top: 20px;
    font-size: 18px;
    font-weight: bold;
}
/* .invoice-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
.invoice-table th, .invoice-table td {
    padding: 8px 12px;
    text-align: left;
    border: 1px solid #ddd;
}
.invoice-table th {
    background-color: #f2f2f2;
}
.invoice-table td {
    background-color: #fff;
} */


/* ——— Invoice wrapper ——— */
.invoice {
        max-width: 900px;
        padding: 24px 28px;
        border: 1px solid #000;
        background:#f9f9f9;
        font-family: Arial, sans-serif;
        font-size: 14px;
        line-height: 1.45;
    }

    /* ——— Header ——— */
    .invoice .header{
        display:flex;
        gap:20px;
        align-items:center;
        margin-bottom:16px;
    }
    .invoice .header img{width:100px;object-fit:contain}

    /* ——— Meta (no & tanggal) ——— */
    .invoice .meta{
        display:flex;
        justify-content:space-between;
        margin-bottom:20px
    }

    /* ——— Items table ——— */
    .items{width:100%;border-collapse:separate;border-spacing:0;margin-bottom:20px}
    .item{display:flex;border-bottom:1px solid #ddd;padding:10px 0}
    .item .photo{flex:0 0 150px}
    .item .photo img{width:140px;height:auto;border:1px solid #ccc;border-radius:4px}
    .item .desc{flex:1;padding-left:16px}
    .item .desc strong{display:inline-block;width:80px}

    /* ——— Total ——— */
    .invoice .total{
        display:flex;
        justify-content:space-between;
        font-weight:600;
        font-size:16px;
        margin-bottom:24px
    }

    /* ——— Footer ——— */
    .invoice .footer{text-align:center;font-size:12px}

</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">{{$module_title}}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between py-1 border-bottom">
                        <div>
                            <div class="btn-group">
                                <a href="#" class="px-3 btn btn-danger" data-toggle="modal" data-target="#createModal">
                                    Create Config <i class="bi bi-plus"></i>
                                </a>
                            </div>

                            </div>
                                <div id="buttons"></div>
                            </div>

                    {{-- <div class="invoice">
                        <div class="header flex">
                            <img src="./storage/uploads/logo.png" alt="Logo">
                            <div class="">
                                <h2>{{$toko}}</h2>
                                <p>{{ $alamat }}</p>
                                <p>Telp: {{ $telp }}</p>
                            </div>
                        </div>

                        <div class="invoice-details">
                            <div>
                                <p><strong>Faktur No:</strong> 222536</p>
                                <p><strong>Tanggal:</strong> 15 April 2025</p>
                            </div>
                            <div>
                                <p><strong>Penerima:</strong> Aring F</p>
                                <p><strong>Alamat:</strong> -</p>
                            </div>
                        </div>

                        <table class="invoice-table">
                            <tbody>
                                <tr>
                                    <td class="img-cell">
                                        <img src="{{ asset('storage/uploads/1742774180.png') }}" alt="Produk">
                                    </td>
                                    <td class="data-cell" colspan="5">
                                        <strong>Kode:</strong> ARF001<br>
                                        <strong>Jenis:</strong> Cincin L6<br>
                                        <strong>Deskripsi:</strong> Gold 1 ml Ruth<br>
                                        <strong>Berat:</strong> 0,98 g<br>
                                        <strong>Harga:</strong> Rp 1.360.000
                                    </td>
                                </tr>
                                <!-- Tambahkan baris produk lain jika perlu -->
                            </tbody>

                        </table>


                        <div class="total">
                            <div><strong>Total:</strong></div>
                            <div>Rp. 1.360.000</div>
                        </div>

                        <div class="footer">
                            <p>Hormat Kami,</p>
                            <p>Toko Emas Lovin Cahaya</p>
                            <table class="invoice-table">
                                <thead>
                                    <tr>
                                        <th>{{ $info }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div> --}}

                    <div class="invoice">

                        <!-- Header -->
                        <div class="header">
                            <img src="{{ asset('storage/uploads/logo.png') }}" alt="Logo">
                            <div>
                                <h2 style="margin:0">{{$toko}}</h2>
                                <div>{{ $alamat }}</div>
                                <div>Telp: {{ $telp }}</div>
                            </div>
                        </div>

                        <!-- Meta -->
                        <div class="meta">
                            <div>
                                <strong>Faktur No:</strong> 222536<br>
                                <strong>Tanggal:</strong> 15 April 2025
                            </div>
                            <div>
                                <strong>Penerima:</strong> Aring F<br>
                                <strong>Alamat:</strong> -
                            </div>
                        </div>

                        <!-- Items -->
                        <table class="items">
                            <tbody>
                                <tr class="item">
                                    <td class="photo">
                                        <img src="{{ asset('storage/uploads/1742774180.png') }}" alt="Produk">
                                    </td>
                                    <td class="desc">
                                        <div><strong>Kode</strong> ARF001</div>
                                        <div><strong>Jenis</strong> Cincin L6</div>
                                        <div><strong>Deskripsi</strong> Gold 1 ml Ruth</div>
                                        <div><strong>Berat</strong> 0,98 g</div>
                                        <div><strong>Harga</strong> Rp 1.360.000</div>
                                    </td>
                                </tr>

                                <!-- Tambah baris produk lain di sini -->
                            </tbody>
                        </table>

                        <!-- Total -->
                        <div class="total">
                            <span>Total:</span>
                            <span>Rp 1.360.000</span>
                        </div>

                        <!-- Footer -->
                        <div class="footer">
                            <p>Hormat Kami,</p>
                            <p>Toko Emas Lovin Cahaya</p>
                            <small>{{ $info }}</small>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Config</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="/config/update" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Toko</label>
                        <textarea name="toko" id="toko" class="form-control">{{ $toko }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control">{{ $alamat }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Telp</label>
                        <input type="text" class="form-control" id="telp" name="telp" value="{{ $telp }}">
                    </div>

                    <div class="form-group">
                        <label for="">Info</label>
                        <textarea name="info" id="info" class="form-control">{{ $info }}</textarea>
                    </div>

                    <br>
                    <button class="btn btn-sm btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Set Harga</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="/karats_update" method="post">
                    @csrf
                    <label for="">Harga</label>
                    <input type="number" class="form-control" name="harga">
                    <button class="btn btn-sm btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
<x-library.datatable />
@push('page_scripts')
   <script type="text/javascript">
    </script>

    <script type="text/javascript">
jQuery.noConflict();
(function( $ ) {
$(document).on('click', '#Tambah, #Edit', function(e){
         e.preventDefault();
        if($(this).attr('id') == 'Tambah')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbspTambah {{ Label_case($module_title) }}');
        }
        if($(this).attr('id') == 'Edit')
        {
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Edit {{ Label_case($module_title) }}');
        }
        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    });
})(jQuery);
</script>
@endpush
