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
.invoice-table {
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
}
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

                    <div class="invoice">
                        <div class="header">
                        <img src="./storage/uploads/logo.png" alt="Logo">
<!-- <img src="logo.png" alt="Logo"> Replace with your actual logo -->
                            <h2>Toko Emas Cahaya</h2>
                            <p>{{ $alamat }}</p>
                            <p>Telp: {{ $telp }}</p>
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
                            <thead>
                                <tr>
                                    <th>Img</th>
                                    <th>Kode</th>
                                    <th>Jenis</th>
                                    <th>Deskripsi</th>
                                    <th>Berat</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img src="./storage/uploads/1742774180.png" order="0" width="70" class="img-thumbnail"></td>
                                    <td>Aring F</td>
                                    <td>Aring L6</td>
                                    <td>Gold 1 ml Ruth</td>
                                    <td>0.98 g</td>
                                    <td>Rp. 1.360.000</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="total">
                            <div><strong>Total:</strong></div>
                            <div>Rp. 1.360.000</div>
                        </div>

                        <div class="footer">
                            <p>Hormat Kami,</p>
                            <p>Toko Emas Cahaya</p>
                            <table class="invoice-table">
                                <thead>
                                    <tr>
                                        <th>{{ $info }}</th>
                                    </tr>
                                </thead>
                            </table>
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
