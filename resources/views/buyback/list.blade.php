@extends('layouts.app')
@section('title', 'Buyback')
@section('third_party_stylesheets')
<style>
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
                        + BuyBack <i class="bi bi-plus"></i>
                    </a>
                </div>

                    </div>
                        <div id="buttons"></div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 10%!important;" class="text-center">
                                        NO
                                    </th>
                                    <th style="width: 30%!important;" class="text-center">
                                        Product
                                    </th>
                                    <th style="width: 15%!important;" class="text-center">
                                        Nota
                                    </th>
                                     <th style="width: 20%!important;" class="text-center">
                                        Kondisi
                                    </th>  
                                     <th style="width: 10%!important;" class="text-center">
                                        Harga
                                    </th>  
                                    <th style="width: 15%!important;" class="text-center">
                                        Tanggal
                                    </th> 
                                    <th style="width: 15%!important;" class="text-center">
                                        #
                                    </th> 
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Buyback +</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="/buyback_insert" method="post">
                    @csrf
                    <!-- <div class="form-group">
                        <label for="">Code Product</label>
                        <input type="text" class="form-control" name="product" required>
                    </div> -->
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">No Nota</label>
                                <input type="hidden" name="product" id="product">
                                <input type="text" class="form-control" name="nota" id="nota" onkeyup="view_nota();" required>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Kondisi</label>
                                <input type="text" class="form-control" name="kondisi" id="kondisi" required readonly>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Harga</label>
                                <input type="number" class="form-control" name="harga" id="harga" required readonly>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Payment</label>
                                <select name="payment" id="payment" class="form-control">
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>
                        </div>
                            
                        <div class="col-12 mt-5">
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
                                        <td><img id="t_image" src="./storage/uploads/1742774180.png" order="0" width="70" class="img-thumbnail"></td>
                                        <td id="t_kode">Emas Dummy</td>
                                        <td id="t_jenis">Emas Antam</td>
                                        <td id="t_desc">Gold 1 ml Ruth</td>
                                        <td id="t_berat">1 g</td>
                                        <td id="t_harga">Rp. 9.999.999</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <br>
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
    
        $('#datatable').DataTable({
           processing: true,
           serverSide: true,
           autoWidth: true,
           responsive: true,
           lengthChange: true,
            searching: true,
           "oLanguage": {
            "sSearch": "<i class='bi bi-search'></i> {{ __("labels.table.search") }} : ",
            "sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per {{ __("labels.table.page") }} ",
            "sInfo": "{{ __("labels.table.showing") }} _START_ s/d _END_ {{ __("labels.table.from") }} <b>_TOTAL_ data</b>",
            "sInfoFiltered": "(filter {{ __("labels.table.from") }} _MAX_ total data)",
            "sZeroRecords": "{{ __("labels.table.not_found") }}",
            "sEmptyTable": "{{ __("labels.table.empty") }}",
            "sLoadingRecords": "Harap Tunggu...",
            "oPaginate": {
                "sPrevious": "{{ __("labels.table.prev") }}",
                "sNext": "{{ __("labels.table.next") }}"
            }
            },
            "aaSorting": [[ 0, "desc" ]],
            "columnDefs": [
                {
                    "targets": 'no-sort',
                    "orderable": false,
                }
            ],
            "sPaginationType": "simple_numbers",
            ajax: '{{ route("buyback.index_data") }}',
            dom: 'Blfrtip',
            buttons: [
                'excel',
                'pdf',
                'print'
            ],
            columns: [{
                    "data": 'id',
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'nota',
                    name: 'nota'
                },
                {
                    data: 'kondisi',
                    name: 'kondisi'
                },{
                    data: 'harga',
                    name: 'harga'
                },
                // {
                //     data: 'ph',
                //     name: 'ph'
                // }
                // ,
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'action',
                    name: 'action'
                },
                
            ]
        })
        .buttons()
        .container()
        .appendTo("#buttons");
    </script>

    <script type="text/javascript">
jQuery.noConflict();

</script>
<script src="./js/jquery.min.js"></script>
<script>
function view_nota(){
    let nota = $('#nota').val();
    $('#harga').prop('readonly', true);
    $('#kondisi').prop('readonly', true);
    let length = nota.length;
    console.log(length);
    if (length > 9){
        $('#t_image').html();
        $('#t_kode').html();
        $('#t_jenis').html();
        $('#t_desc').html();
        $('#t_berat').html();
        $('#t_harga').html();
        $.ajax({
            url: './buyback_nota/'+nota, // The URL for your route
            type: 'GET', // Request method
            dataType: 'json', // Expecting JSON response
            success: function(response) {
                console.log(response);
                // On success, handle the response
                if(response) {
                    $('#harga').prop('readonly', false);
                    $('#kondisi').prop('readonly', false);
                    
                    $('#product').val(response.product);
                    // $('#name').val(response.name);
                    // $('#desc').val(response.desc);
                    // $('#total').val(response.total);

                    $('#t_image').attr('src', './storage/uploads/'+response.image);
                    $('#t_kode').html(response.kode);
                    $('#t_jenis').html(response.jenis);
                    $('#t_desc').html(response.desc);
                    $('#t_berat').html(response.berat);
                    $('#t_harga').html(response.harga);
                    
                } else {
                    // $("#result").html("<p>No data found.</p>");
                }
            },
            error: function() {
                // Handle errors
                alert('An error occurred.');
            }
        });
    }
}
</script>
@endpush
