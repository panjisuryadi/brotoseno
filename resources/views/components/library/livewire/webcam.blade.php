@push('page_css')
<!-- CSS -->
<style>
    .camera {
        width: 100% !important;
        height: 300px !important;
        border: 2px dashed #FF9800 !important;
        border-radius: 8px;
        background: #ff98003d !important;

    }


    .results {
        width: 100% !important;
        /*height: 240px !important;*/
        /* border: 2px dashed #FF9800 !important;*/
        border-radius: 8px;
        background: #ff98003d !important;
        position: absolute;
        z-index: 1;

    }

    .camera-container {
        width: 100% !important;
        height: 100% !important;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .d-none {
        display: none !important;
    }

    .d-block {
        display: block;
    }

    video {
        width: 100% !important;
        height: 100% !important;
    }
</style>

<!-- -->

@endpush
<?php
$ogg = asset('js/webcamjs/shutter.ogg');
$mp3 = asset('js/webcamjs/shutter.mp3');

?>
<div class="flex flex-row grid grid-cols-1" wire:ignore>
    <div class="py-0">

        <div class="h-320 d-flex flex-wrap align-items-center justify-content-center camera relative">
            <div id="camera" class="camera-container">

            </div>
            <div class="absolute m-auto">
                <i style="font-size: 3.5rem !important;" class="text-red-800 bi bi-camera"></i>
            </div>
            <div class="d-flex flex-wrap align-items-center justify-content-center results hidden" id="results">

            </div>
        </div>




        <div class="flex py-3 flex-row gap-1 align-items-center justify-content-center">
            <input class="btn btn-sm btn-warning" type=button value="Start" onClick="configure()">

            <input class="btn btn-sm btn-warning" type=button value="Capture" onClick="take_snapshot()">
            <input class="btn btn-sm btn-primary" type=button value="Reset" onClick="reset_snapshot()">

        </div>

    </div>


</div>
<!-- Script -->




@push('page_scripts')
<script type="text/javascript" src="{{ asset('js/webcamjs/webcam.min.js') }}"></script>
<script language="JavaScript">
    function configure() {
        Livewire.emit('webcamReset')
        document.getElementById('results').innerHTML ='';
        Webcam.set({
            width: 1280,
            height: 720,
            autoplay: false,
            image_format: 'jpeg',
            jpeg_quality: 90,
            force_flash: false
        });
        Webcam.attach('#camera');
    }
    // preload shutter audio clip
    var shutter = new Audio();
    shutter.autoplay = false;
    shutter.src = navigator.userAgent.match(/Firefox/) ? asset('js/webcamjs/shutter.ogg') : asset('js/webcamjs/shutter.mp3');

    function take_snapshot() {
        // play sound effect
        shutter.play();
        // take snapshot and get image data
        Webcam.snap(function(data_uri) {
            $('#camera').addClass('hidden');
            $('#results').removeClass('hidden');
            document.getElementById('results').innerHTML =
                '<img id="imageprev" src="' + data_uri + '"/>';
            Livewire.emit('webcamCaptured', data_uri)
        });
        Webcam.reset();
    }

    function reset() {
        //  alert('Reset');
        $('#camera').removeClass('d-none');
        Webcam.reset();
    }


    function reset_snapshot() {
        $('#camera').removeClass('hidden');
        $('#results').addClass('hidden');
        $('#imageprev').addClass('hidden');
        Livewire.emit('webcamReset')
        Webcam.reset();
    }
</script>



@endpush