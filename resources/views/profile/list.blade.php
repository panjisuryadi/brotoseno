@extends('layouts.app')
@section('title', 'Profile')
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
                    <form action="./profile/update" method="post" id="form" class="form">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" class="form-control" value="{{$user->email}}" required>
                        </div>

                        <div class="form-group">
                            <label for="">Password (kosongkan bila tidak ingin mengganti password)</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" name="confirm" id="confirm" class="form-control">
                        </div>

                        <button class="btn btn-success" type="button" onclick="cek_password();">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<x-library.datatable />
@push('page_scripts')
    
@endpush


<script>
    function cek_password(){
        let form        = $("#form");
        let password    = $("#password").val();
        let confirm     = $("#confirm").val();
        if(password == ''){
            if(confirm == ''){
                form.submit();
            }else{
                alert('password tidak cocok');
            }
        }else{
            if(password === confirm){
                form.submit();
            }else{
                alert('password tidak cocok');
            }
        }
    }
</script>