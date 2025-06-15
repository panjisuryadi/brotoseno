@extends('layouts.app')
@section('title', 'Products')
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<style type="text/css">
div.dataTables_wrapper div.dataTables_filter input {
margin-left: 0.5em;
display: inline-block;
width: 220px !important;
}
div.dataTables_wrapper div.dataTables_length select {
width: 70px !important;
display: inline-block;
}
</style>
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Products</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="flex flex-wrap -m-4 text-center mb-2">
        @foreach(\Modules\Product\Entities\Category::all() as $category)
        <a class="cursor-pointer p-2 md:w-1/4 sm:w-1/2 w-full" id="Tambah" href="{{ route('products.add_products_categories',$category->id) }}">
        <div class="w-full">
            <div class="justify-center items-center border-2 border-yellow-500 bg-white  px-4 py-6 rounded-lg transform transition duration-500 hover:scale-110">
                <div class="justify-center text-center items-center">
                    <?php
                    if ($category->image) {
                    $image = asset(imageUrl() . $category->image);
                    }else{
                    $image = asset('images/logo.png');
                    }
                    ?>
                    <img id="default_1" src="{{ $image }}" alt="images"
                    class="h-16 w-16 object-contain mx-auto" />
                </div>
                <div class="leading-tight no-underline  hover:no-underline">{{ $category->category_name }}</div>
            </div>
        </div>
        </a>
        @endforeach
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between pb-3 border-bottom">
                        <div>
                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                Add Product <i class="bi bi-plus"></i>
                            </a>
                        </div>
                        <div id="buttons"></div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 5%!important;">NO</th>
                                    <th style="width: 9%!important;">{{ Label_case('image') }}</th>
                                    <th>{{ Label_case('product_name') }}</th>
                                    <th>{{ Label_case('price') }}</th>
                                    <th style="width: 15%!important;" class="text-center">{{ Label_case('quantity') }}</th>
                                    <th style="width: 15%!important;" class="text-center">{{ Label_case('weight') }}</th>
                                    <th style="width: 14%!important;" class="text-center">
                                        Action
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
        ajax: '{{ route("$module_name.index_data") }}',
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
            data: 'product_image',
            name: 'product_image'
        }, {
            data: 'product_name',
            name: 'product_name'
        },
        {
            data: 'product_price',
            name: 'product_price'
        }, {
            data: 'product_quantity',
            name: 'product_quantity'
        }, {
            data: 'weight',
            name: 'weight'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        }
        ]
    })
    .buttons()
    .container()
    .appendTo("#buttons");


</script>
<script type="text/javascript">
jQuery.noConflict();
(function( $ ) {
$(document).on('click', '#Tambah, #Edit', function(e){
         e.preventDefault();
        if($(this).attr('id') == 'Tambah')
        {
            $('.modal-dialog').addClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-lg');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbspTambah {{ Label_case($module_title) }}');
        }
        if($(this).attr('id') == 'Edit')
        {
            $('.modal-dialog').addClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-lg');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Edit {{ Label_case($module_title) }}');
        }
        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    });


})(jQuery);
</script>
<script type="text/javascript">
        $('input[type="radio"]').click(function () {
          var inputValue = $(this).attr("value");
          if (inputValue == "up2") {
            $("#webcam").hide();
             $("#upload").show();
          } else {
            $("#upload").hide();
             $('#webcam').removeClass('d-none');
            $("#webcam").show();
          }
        });
      </script>

@endpush