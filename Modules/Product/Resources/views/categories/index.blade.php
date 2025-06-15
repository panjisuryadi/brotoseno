@extends('layouts.app')
@section('title', 'Product Categories')
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">

<style type="text/css">
table.dataTable th {
    -webkit-box-sizing: content-box;
    box-sizing: content-box;
    padding: 0.8rem !important;
     border: 1px solid #d8dbe054 !important;
}
</style>

@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
    <li class="breadcrumb-item active">{{ $module_title }}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @include('utils.alerts')
            <div class="card">
                <div class="card-body">
                    {{--    {!! $dataTable->table() !!} --}}
                    <div class="flex justify-between py-1 border-bottom">
                        <div>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#categoryCreateModal">
                            {{ __('Add Product Category') }} <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        <div id="buttons">
                        </div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 5%!important;">NO</th>
                                    <th style="width: 9%!important;">{{ __('Image') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th class="text-center items-center" style="width: 16%!important;">{{ __('Products Count') }}</th>
                                    <th style="width: 15%!important;" class="text-center">
                                        {{ __('Updated') }}
                                    </th>
                                    <th style="width: 18%!important;" class="text-center">
                                        {{ __('action') }}
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
<!-- batass================================Create Modal============================= -->
<div class="modal fade" id="categoryCreateModal" tabindex="-1" role="dialog" aria-labelledby="categoryCreateModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryCreateModalLabel font-semibold">
<i class="bi bi-grid-fill"></i> &nbsp;
              {{ __('Add Product Category') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('product-categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="flex row px-4">
                        <div class="w-1/3 text-center items-center">
                            <div x-data="{photoName: null, photoPreview: null}" class="justify-center form-group">
                                <?php
                                $field_name = 'image';
                                $field_lable = __($field_name);
                                $label = Label_Case($field_lable);
                                $field_placeholder = $label;
                                $required = '';
                                ?>
                                <input type="file" name="{{ $field_name }}" accept="image/*" class="hidden" x-ref="photo" x-on:change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.photo.files[0]);
                                ">
                                <div class="text-center">
                                    <div class="mt-2 py-2" x-show="! photoPreview">
                                        <img src="{{asset("images/logo.png")}}" class="w-40 h-40 m-auto rounded-xl ">
                                    </div>
                                    <div class="mt-2 py-2" x-show="photoPreview" style="display: none;">
                                        <span class="block w-40 h-40 rounded-xl m-auto" x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'" style="background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url('null');">
                                        </span>
                                    </div>
                                    <button type="button" class="btn btn-secondary px-5" x-on:click.prevent="$refs.photo.click()">
                                   {{ __('Select Image') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="w-2/3">
                            <div class="form-group">
                                <label for="kategori_produk_id">{{ __('Main Category') }} <span class="text-danger">*</span></label>
                                <select class="form-control" name="kategori_produk_id" id="kategori_produk_id" required>
                                    <option value="" selected disabled>{{ __('Select Main Kategori') }}</option>
                                    @foreach(\Modules\KategoriProduk\Models\KategoriProduk::all() as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category_code">{{ __('Category Code') }}<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="category_code" required>
                            </div>
                            <div class="form-group">
                                <label for="category_name">{{ __('Category Name') }} <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="category_name" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
<button type="button" class="btn btn-danger px-5" data-dismiss="modal" aria-label="Close">
               {{ __('Close') }}
                </button>
                    <button type="submit" class="px-5 btn btn-primary">{{ __('Create') }} <i class="bi bi-check"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end modal ======================================================================--}}

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
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [ 0,1,2,3,4 ]
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [ 0,1,2,3,4 ]
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [ 0,1,2,3,4 ]
                    }
                }
            ],
            columns: [{
                    "data": 'id',
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                {
                    data: 'image',
                    name: 'image'
                },
                 {
                    data: 'category_name',
                    name: 'category_name'
                }, {
                    data: 'products_count',
                    name: 'products_count'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
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
@endpush