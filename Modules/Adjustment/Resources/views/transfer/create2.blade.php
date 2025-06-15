@extends('layouts.app')

@section('title', 'Create Stock Transfer')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('stocktransfer.index') }}">@lang('Stock Transfer')</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-1">

    <div class="card">
        <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('utils.alerts')
                        <form action="{{ route('stocktransfer.store') }}" method="POST" id="myForm">
                            @csrf
                            <div class="form-row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="reference">Reference <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="reference" required readonly value="{{$reference}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="date">Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control form-control-sm" name="date" required value="{{ now()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="product">Product <span class="text-danger">*</span></label>
                                            <select name="product" id="product" class="form-control" required>
                                                <option value="" selected disabled>Pilih Produk</option>
                                                @foreach ($product as $product)
                                                    <option value="{{$product->id}}">{{$product->product->product_name}} | {{$product->product->product_code}} | {{$product->product->meter}} | {{$product->location->name}} | {{$product->stock}} PCS</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="table_product">
                                    <thead>
                                        <tr class="align-middle">
                                            <th class="align-middle">@lang('Product Name')</th>
                                            <th class="align-middle">Lokasi</th>
                                            <th class="align-middle">Stock</th>
                                            <th class="align-middle">@lang('Pilih Lokasi')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="align-middle">
                                            <th class="align-middle"><span id="product_names"></span><input type="hidden" id="product_id"><input type="hidden" id="product_name"></th>
                                            <th class="align-middle"><span id="location_name"></span><input type="hidden" name="origin" id="origin"></th>
                                            <th class="align-middle"><span id="stock_name"></span><input type="hidden" name="stock_value" id="stock_value"></th>
                                            <th class="align-middle"><div id="locationselect"><select name="locations" id="locations" class="form-control"></select></div></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                            Detail
                                <table class="table table-sm table-bordered" id="table_detail">
                                    <thead>
                                        <tr class="align-middle">
                                            <th class="align-middle" width="32%">@lang('Product Name')</th>
                                            <th class="align-middle" width="30%">@lang('Location')</th>
                                            <th class="align-middle" width="32%">@lang('Stock Move')</th>
                                            <th class="align-middle" width="6%">@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <label for="note">Note <span class="small text-danger">( @lang('If Needed'))</span></label>
                                <textarea name="note" id="note" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="mt-3">
                                <button type="button" onclick="storetransfer()" class="btn btn-primary" id="btnsubmit">
                                @lang('Create Stock Tranfer')  <i class="bi bi-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



 @push('page_css')
<style>
    html,
    body {
        /* height: 100vh;*/
    }
</style>
    
 <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
 @endpush
 @push('page_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script type="text/javascript">
    $("#load").scroll(function (e) {
        e.preventDefault();
        var elem = $(this);
        if (elem.scrollTop() > 0 &&
                (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight())) {
            //alert("At the bottom");
        // window.livewire.emit('load-more');

        }
    });
    var location_product = [];
    function storetransfer(){
        $('#btnsubmit').prop('disabled', true);
        var available = $('#stock_value').val()
        var stocks = $('input[name="stock_sent[]"]').map(function() {
            return parseInt($(this).val());
        }).get();
        available = parseInt(available)
        stocks = parseInt(stocks)
        if (stocks > available) {
            $('#btnsubmit').prop('disabled', false);
            toastr.error('Stok Yang Dikirim Melebihi Stok Tersedia<br>Stok Tersedia :'+available+' Dikirim :'+stocks)
        }else{
            var form = $('#myForm');
            var url = '{{ route('stocktransfer.store') }}';
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept' : 'application/json'
                },
                success:function(data){	
                    if(data.status == 'error'){
                        toastr.error(data.message);
                    }else{
                        toastr.success(data.message);
                        setTimeout(function(){ window.location.replace("{{ route('stocktransfer.index') }}"); }, 1000);  
                    }	
                    $('#btnsubmit').prop('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) { // if error occured
                    if(jqXHR['status'] == 422){
                        toastr.error("The Given Data Was Invalid");
                    } else {
                        toastr.error("Error occured.  please try again");
                    }
                    console.log(textStatus);    
                    $('#btnsubmit').prop('disabled', false);
                }
            })
        }
    }
    $('#product').change(function(){
        $('#table_detail tbody').empty()
        location_product = [];
        $.ajax({
            type: "GET",
            url: "{{route('stock.getone','')}}/"+this.value,
            dataType:'json',
            contentType: false,
            processData: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                $('#product_names').html(data.name)
                $('#product_name').val(data.name)
                $('#product_id').val(data.product_id)
                $('#origin').val(data.location_id)
                $('#stock_value').val(data.stock)
                $('#stock_name').html(data.stock+' PCS')
                $('#location_name').html(data.location)
                $.ajax({
                    type: "GET",
                    url: "{{route('stocktransfer.getlocation','')}}/"+data.location_id,
                    dataType:'json',
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data2){
                        $('#locationselect').html(data2)
                    }
                })
            }
        })
    })
    function setlocation(){
        $.ajax({
            type: "GET",
            url: "{{route('locations.getone','')}}/"+$('#location_ids').val(),
            dataType:'json',
            contentType: false,
            processData: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                if ($.inArray(data.id, location_product) !== -1) {
                    toastr.error('Data Sudah Ada')
                }else{
                    location_product.push(data.id)
                    list = '<tr id="row'+data.id+'">\
                                <td>'+$('#product_name').val()+'<input type="hidden" name="product_ids[]" value="'+$('#product_id').val()+'"></input></td>\
                                <td>'+data.name+'<input type="hidden" name="destination[]" value="'+data.id+'"></input></td>\
                                <td><input type="number" name="stock_sent[]" class="form-control form-control-sm" required></input></td>\
                                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeProduct('+data.id+')">\
                                            <i class="bi bi-trash"></i>\
                                        </button></td>\
                            </tr>';
                    $('#table_detail tbody').append(list)
                    console.log(location_product)
                }
            }
        })
    }

    function removeProduct(id){
        location_product = location_product.filter(function(value) {
            return value !== id;
        });
        console.log(location_product)
        $('#row'+id).remove()
    }
</script>

@endpush