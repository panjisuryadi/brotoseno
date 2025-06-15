@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item">Penerimaan Barang (Toko)</li>
    <li class="breadcrumb-item active">BuyBack - Barang Luar</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    @if (auth()->user()->isUserCabang())
        @include('goodsreceipt::goodsreceipts.toko.buyback-barangluar.datatable.item')
    @else
        @include('goodsreceipt::goodsreceipts.toko.buyback-barangluar.datatable.nota-office')
    @endif
</div>
@endsection

@push('page_scripts')
<script src="https://unpkg.com/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript">

window.addEventListener('total_payment_amount', event => {
    toastr.error(event.detail.message);
});
function createModal(){
    $('#goodsreceipt-toko-buyback-create').modal('show');
}

function createBarangLuar(){
    $('#create-barangluar-modal').modal('show');
}

function process(data){
        Swal.fire({
            title: "Proses Nota",
            text: "Proses Nota #"+ data.invoice +"?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#0a0",
            cancelButtonColor: "#d33",
            confirmButtonText: "Proses"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{route('goodsreceipt.toko.buyback-barangluar.nota-process')}}/",
                    type: 'PATCH',
                    data: {data},
                    dataType: 'json',
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        window.location.href = response.redirectRoute;
                        toastr.success('Processing Nota')
                    },
                    error: function(xhr, status, error) {
                        toastr.success('Gagal memproses Nota')
                    }
                });
            }
        });
    }
</script>
@endpush
