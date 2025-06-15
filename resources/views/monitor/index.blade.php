@extends('layouts.blank')

@section('content')
<div class="text-center">
    <div class="container-fluid">
        <div class="card mb-2">
            <div class="card-body">
                <span style="font-size:20px;"><b>Monitor Produk</b></span>
                <center>
                    <div style="width: 300px;" class="pt-2">
                        <div id="reader" style="width: 300px;"></div>
                    </div>
                </center>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <center>
                <span style="font-size:20px;"><b>Data</b></span>
                <div class="pt-2 table-responsive" id="content" style="width:300px;">
                    No Data
                </div>
                </center>
            </div>
        </div>
    </div>
</div>
@endsection

@section('third_party_scripts')
<script type="text/javascript" src="{{ asset('js/html5-qrcode.min.js') }}"></script>
<script>
    var html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: 180 }
    );
    
    html5QrcodeScanner.render(onScanSuccess);
    function onScanSuccess(decodedText, decodedResult) {
        // console.log(`Scan result: ${decodedText}`, decodedResult);
        $.ajax({
			type: "POST",
			url: "{{ route('monitor.check') }}",
			data: {
				code: decodedText
			},
			dataType:'json',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
				'Accept' : 'application/json'
			},
			success:function(data){	
                $('#content').html(data.data)
			},
			error: function(jqXHR, textStatus, errorThrown) { // if error occured
				// toastr.error("Error occured.  please try again");
			}
		})
        // html5QrcodeScanner.clear();
    }
</script>
@endsection