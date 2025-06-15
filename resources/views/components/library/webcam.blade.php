@push('page_css')
    <!-- CSS -->
    <style>
    #camera{
        width:100% !important;
        height: 240px !important;
        border: 2px dashed #FF9800 !important;
        border-radius: 8px;
        background: #ff98003d !important;

    }


     #results{
        width: 100% !important;
        /*height: 240px !important;*/
       /* border: 2px dashed #FF9800 !important;*/
        border-radius: 8px;
        background: #ff98003d !important;

    }
    .d-none{
        display:none !important;
    }
    .d-blok{
        display: block;
    }

    </style>

    <!-- -->

@endpush
  <?php
$ogg = asset('js/webcamjs/shutter.ogg');
$mp3 = asset('js/webcamjs/shutter.mp3');

   ?>
<div class="flex flex-row grid grid-cols-1">
<div class="py-0">

 <div class="h-320 d-flex flex-wrap align-items-center justify-content-center d-blok" id="camera">
 <i style="font-size: 3.5rem !important;" class="text-red-800 bi bi-camera"></i>
 </div>


<div class="d-flex flex-wrap align-items-center justify-content-center" id="results"></div>


<div class="flex py-3 flex-row gap-1 align-items-center justify-content-center">
   <input class="btn btn-sm btn-warning" type=button value="Start" onClick="configure()">

   <input class="btn btn-sm btn-warning" type=button value="Capture" onClick="take_snapshot()">
     <input class="btn btn-sm btn-primary" type=button value="Reset" 
     onClick="reset_snapshot()">
   
 <input type="hidden" name="image" class="image-tag">

   {{--  <input class="btn btn-sm btn-warning" type=button value="Save Snapshot" onClick="saveSnap()"> --}}
</div>

</div>


</div>
    <!-- Script -->




@push('page_scripts')
 <script type="text/javascript" src="{{ asset('js/webcamjs/webcam.min.js') }}"></script>
<script language="JavaScript">
        function configure(){
            Webcam.set({
                width: 360,
                height: 220,
                autoplay: false,
                image_format: 'jpeg',
                jpeg_quality: 90,
                force_flash: false
            });
            Webcam.attach( '#camera' );
        }
        // preload shutter audio clip
        var shutter = new Audio();
        shutter.autoplay = false;
        shutter.src = navigator.userAgent.match(/Firefox/) ? asset('js/webcamjs/shutter.ogg') : asset('js/webcamjs/shutter.mp3');

        function take_snapshot() {
            // play sound effect
            shutter.play();
           // take snapshot and get image data
            Webcam.snap( function(data_uri) {
                $('#camera').removeClass('d-blok');
                $('#camera').addClass('d-none');
                $('#results').addClass('d-blok');
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML =
                    '<img id="imageprev" src="'+data_uri+'"/>';
            });
           Webcam.reset();
        }

        function reset() {
             //  alert('Reset');
               $('#camera').removeClass('d-none');
             Webcam.reset();
        }


       function reset_snapshot() {
            alert('Reset');
            $('#camera').removeClass('d-none');
            $('#camera').addClass('d-blok');
            $('#results').addClass('d-blok');
            $('#imageprev').addClass('d-none');
             Webcam.reset();
        }

        function saveSnap(){
            // Get base64 value from <img id='imageprev'> source
            var base64image =  document.getElementById("imageprev").src;

             Webcam.upload( base64image, 'upload.php', function(code, text) {
                 console.log('Save successfully');
                 //console.log(text);
            });

        }


</script>



@endpush
