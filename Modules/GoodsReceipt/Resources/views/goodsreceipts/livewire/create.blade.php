@extends('layouts.app')
@section('title', 'Create GoodsReceipt')


@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("goodsreceipt.index") }}">GoodsReceipt</a></li>
    <li class="breadcrumb-item active">Add</li>
</ol>
@endsection

@section('content')
@push('page_css')

<style type="text/css">
    .dropzone {
        height: 280px !important;
        min-height: 190px !important;
        border: 2px dashed #FF9800 !important;
        border-radius: 8px;
        background: #ff98003d !important;
    }
    .dropzone i.bi.bi-cloud-arrow-up {
        font-size: 5rem;
        color: #bd4019 !important;
    }

</style>
@endpush
<div class="container-fluid">
<script src="{{  asset('js/jquery.min.js') }}"></script>
    <form action="{{ route('goodsreceipt.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="flex relative py-3">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-b border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-left">
                        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">{{__('Goods Receipts')}} <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="{{__('Goods Receipts')}}"></i>
                        </span>
                    </div>
                </div>


<livewire:goods-receipt.goodsreceipts/>




                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
<x-library.select2 />
<x-toastr />
@section('third_party_scripts')
<script src="{{ asset('js/dropzone.js') }}"></script>
@endsection
@push('page_scripts')
<script>
    var uploadedDocumentMap = {}
    Dropzone.options.documentDropzone = {
        url: '{{ route('dropzone.upload') }}',
        maxFilesize: 1,
        acceptedFiles: '.jpg, .jpeg, .png',
        maxFiles: 3,
        addRemoveLinks: true,
        dictRemoveFile: "<i class='bi bi-x-circle text-danger'></i> remove",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        success: function (file, response) {
            $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
            uploadedDocumentMap[file.name] = response.name;
        },
        removedfile: function (file) {
            file.previewElement.remove();
            var name = '';
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name;
            } else {
                name = uploadedDocumentMap[file.name];
            }
            $.ajax({
                type: "POST",
                url: "{{ route('dropzone.delete') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'file_name': `${name}`
                },
            });
            $('form').find('input[name="document[]"][value="' + name + '"]').remove();
        },
        init: function () {
            @if(isset($product) && $product->getMedia('pembelian'))
            var files = {!! json_encode($product->getMedia('pembelian')) !!};
            for (var i in files) {
                var file = files[i];
                this.options.addedfile.call(this, file);
                this.options.thumbnail.call(this, file, file.original_url);
                file.previewElement.classList.add('dz-complete');
                $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">');
            }
            @endif
        }
    }
</script>

@endpush

@push('page_scripts')

<script type="text/javascript">
jQuery.noConflict();
(function( $ ) {

    $('#up1').change(function() {
        $('#upload2').toggle();
        $('#upload1').hide();
    });
    $('#up2').change(function() {
        $('#upload1').toggle();
        $('#upload2').hide();
    });

$(document).ready(function() {
    $('.numeric').keypress(function(e) {
            var verified = (e.which == 8 || e.which == undefined || e.which == 0) ? null : String.fromCharCode(e.which).match(/[^0-9]/);
            if (verified) {e.preventDefault();}
    });
});


$("#qty_diterima").on('input', function() {
  if ($('#qty_diterima').val() > $('#qty').val()) {
      var bla = $('#qty').val();
     $("#qty_diterima").val(bla);
    return false;
  }
});

})(jQuery);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

@endpush

