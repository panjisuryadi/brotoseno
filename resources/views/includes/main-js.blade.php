<script src="{{ url('/') }}{{ mix('js/app.js') }}"></script>
<script src="{{ url('/') }}{{ mix('js/backend.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/perfect-scrollbar.js"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript">

$(function () {
    // Show the time
    showTime();
})

function showTime(){
    var date = new Date();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();

    var session = hours >= 12 ? '' : '';

    hours = hours % 12;
    hours = hours ? hours : 12;
    minutes = minutes < 10 ? '0'+minutes : minutes;
    seconds = seconds < 10 ? '0'+seconds : seconds;

    var time = hours + ":" + minutes + ":" + seconds + " " + session;
    document.getElementById("liveClock").innerText = time;
    document.getElementById("liveClock").textContent = time;

    setTimeout(showTime, 1000);
}
</script>

@include('sweetalert::alert')

@yield('third_party_scripts')

@livewireScripts



<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.js" integrity="sha512-MBa5biLyZuJEdQR7TkouL0i1HAqpq8lh8suPgA//wpxGx4fU1SGz1hGSlZhYmm+b7HkoncCWpfVKN3NDcowZgQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@stack('page_scripts')
<script src="{{  asset('js/jquery.min.js') }}"></script>

<!-- batass================================Create Modal============================= -->
<div class="modal fade" id="ModalGue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalHeader"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
           <div class="modal-body p-0" id="ModalContent"></div>
           <div class="modal-footer" id="ModalFooter"></div>
        </div>
    </div>
</div>
{{-- end modal ======================================================================--}}
<script type='text/javascript'>
    var jq = $.noConflict();
    (function($){
      $('document').ready(function(){
       jq('#ModalGue').on('hide.bs.modal', function () {
         setTimeout(function(){
             jq('#ModalHeader, #ModalContent, #ModalFooter').html('');
         }, 500);

     })
       jq('#ModalGue').on('click', '.modal .close', function () {
        jq(this).closest('.modal').modal('hide');
    })
    $.ajax({
            type: "get",
            url: "{{ route('adjustment.getsetting2') }}",
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept' : 'application/json'
            },
            success:function(data){	
                if(data == 1){
                    $('#runningopname').show()
                    setInterval(function() {
                        $('#runningopname').toggle();
                    }, 500);
                }else{
                    $('#runningopname').hide()
                }
            },
        })

   })
  })(jq);

</script>