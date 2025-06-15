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
    @livewire('goods-receipt.penerimaan',[
        'code'=>$code,
        'module_name' => $module_name,
        'module_action' => $module_action,
        'module_title' => $module_title,
        'module_icon' => $module_icon,
        'module_model' => $module_model
    ])
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
        url: "{{ route('dropzone.upload') }}",
        maxFilesize: 1,
        acceptedFiles: '.jpg, .jpeg, .png',
        maxFiles: 1,
        addRemoveLinks: true,
        dictRemoveFile: "<i class='bi bi-x-circle text-danger'></i> remove",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        success: function(file, response) {
            $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
            uploadedDocumentMap[file.name] = response.name;
            Livewire.emit('imageUploaded',response.name);
            console.log(response.name);
        },
        removedfile: function(file) {
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
            Livewire.emit('imageRemoved',name);
        },
        init: function() {
            @if(isset($product) && $product->getMedia('pembelian'))
            var files = {
                !!json_encode($product->getMedia('pembelian')) !!
            };
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

    window.addEventListener('webcam-image:remove', event => {
        $('#imageprev0').attr('src','');
    });
    window.addEventListener('uploaded-image:remove', event => {
        Dropzone.forElement("div#document-dropzone").removeAllFiles(true);
    });
</script>

@endpush

@push('page_scripts')

<script type="text/javascript">
    jQuery.noConflict();
    (function($) {

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
                if (verified) {
                    e.preventDefault();
                }
            });
        });

    })(jQuery);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

@endpush