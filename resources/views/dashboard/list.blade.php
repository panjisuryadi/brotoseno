@extends('layouts.app')
@section('title', 'Petty Cash')
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
        <div class="col-md-6 col-lg-3">
            <div class="card border-0">
                <div class="card-body p-0 d-flex align-items-center shadow-sm">
                    <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
                        <i class="bi bi-bar-chart font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-primary">Rp. {{number_format($pettycash->current)}}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">
                        Petty Cash                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0">
                <div class="card-body p-0 d-flex align-items-center shadow-sm">
                    <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
                        <i class="bi bi-arrow-return-left font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-warning">Rp. {{number_format($pettycash->in)}}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">
                        Penjualan                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0">
                <div class="card-body p-0 d-flex align-items-center shadow-sm">
                    <div class="bg-gradient-success p-4 mfe-3 rounded-left">
                        <i class="bi bi-arrow-return-right font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-success">Rp. {{number_format($buyback)}}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">
                        Buyback                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0">
                <div class="card-body p-0 d-flex align-items-center shadow-sm">
                    <div class="bg-gradient-info p-4 mfe-3 rounded-left">
                        <i class="bi bi-trophy font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-info">Rp. {{number_format($luar)}}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">
                            Barang Luar                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<x-library.datatable />
@push('page_scripts')
   
@endpush
