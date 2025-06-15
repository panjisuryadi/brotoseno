
<style type="text/css">
    .form-group {
    margin-bottom: 0.3rem !important;
}
</style>

<div class="flex py-0 flex-row grid grid-cols-3 gap-2">

    <div class="form-group">
        <label for="karat_id">@lang('Jenis Perhiasan') <span class="text-danger">*</span></label>
         <select class="form-control select2" name="jenis_perhiasan_id" id="jenis_perhiasan_id" required>
            <option value="" selected disabled>Jenis Perhiasan</option>
            @foreach(\Modules\JenisPerhiasan\Models\JenisPerhiasan::all() as $jp)
            <option value="{{ $jp->id }}">{{ $jp->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="round_id">@lang('Clarity') <span class="text-danger">*</span></label>
        <select class="form-control select2" name="round_id" id="round_id" required>
            <option value="" selected disabled>Select Clarity</option>
            @foreach(\Modules\ItemClarity\Models\ItemClarity::all() as $cl)
            <option value="{{ $cl->id }}">{{ $cl->name }}</option>
            @endforeach
        </select>
    </div>
 <div class="form-group">
        <label for="baki_id">@lang('Baki') <span class="text-danger">*</span></label>
        <select class="form-control select2" name="baki_id" id="baki_id" required>
            <option value="" selected disabled>Select Baki</option>
            @foreach(\Modules\Baki\Models\Baki::all() as $baki)
            <option value="{{ $baki->id }}">{{ $baki->name }}</option>
            @endforeach
        </select>
    </div>


    <div class="form-group">
        <label for="shape_id">@lang('Cut / Shape') <span class="text-danger">*</span></label>
        <select class="form-control select2" name="shape_id" id="shape_id" required>
            <option value="" selected disabled>Select Cut /  Shape</option>
            @foreach(\Modules\ItemShape\Models\ItemShape::all() as $shape)
            <option value="{{ $shape->id }}">{{ $shape->name }}</option>
            @endforeach
        </select>

    </div>


    <div class="form-group">
        <label for="colour_id">@lang('Colour') <span class="text-danger">*</span></label>
        <select class="form-control select2" name="colour_id" id="colour_id" required>
            <option value="" selected disabled>Select Colour</option>
            @foreach(\Modules\ItemColour\Models\ItemColour::all() as $color)
            <option value="{{ $color->id }}">{{ $color->name }}</option>
            @endforeach
        </select>
    </div>



    <div class="form-group">
        <label for="certificate_id">@lang('Certificate') <span class="text-danger">*</span></label>
        <select class="form-control select2" name="certificate_id" id="certificate_id" required>
            <option value="" selected disabled>Select Certificate</option>
            @foreach(\Modules\DiamondCertificate\Models\DiamondCertificate::all() as $certificate)
            <option value="{{ $certificate->id }}">{{ $certificate->name }}</option>
            @endforeach
        </select>
    </div>



</div>


<div id="shape1" class="flex py-0 px-0 flex-row grid grid-cols-1 gap-2 d-none">

<table style="width: 100% !important; padding: 0.5rem !important;" class="p-1 table table-bordered" id='myTable'>

            <tbody>
                <tr id="FacultyEmployees">
                    <th align="center" class="style1">Carat</th>

                    <th align="center" class="style1">Kadar</th>
                    <th align="center" class="style1">Aksi</th>
                </tr>
                <tr id="regFacEmpType1" data-child-type='regExemptEmpType1' data-parent-type='regFacEmpType1'>
                    <td align="center">
                     <select class="form-control form-control-sm"
                        name="round_id" id="round_id" required="">
                        <option value="" selected="" disabled="">Select</option>
                        <option value="1">c230</option>
                    </select>
                    </td>
                    <td align="center">
                         <select class="form-control form-control-sm"
                        name="round_id" id="round_id" required="">
                        <option value="" selected="" disabled="">Select</option>
                        <option value="1">c230</option>
                    </select>

                    </td>
                    <td colspan="2" class="text-center"><button type='button' class="btn btn-sm btn-outline-danger addRegular">+</button></td>
                </tr>
            </tbody>

        </table>


</div>



<div class="flex py-0 flex-row grid grid-cols-2 gap-2">
    <div class="form-group">
        <label for="no_certificate">@lang('No .Certificate') <span class="text-danger">*</span></label>
        <input id="no_certificate" type="text" class="form-control" name="no_certificate" required value="{{ old('no_certificate') }}">
    </div>

     <div class="form-group">
        <label for="no_certificate">@lang('Karat Berlian') <span class="text-danger">*</span></label>
          <select class="form-control select2" name="karat_berlian_id" id="karat_berlian_id" required>
            <option value="" selected disabled>Pilih Karat</option>
            @foreach(\Modules\KaratBerlian\Models\KaratBerlian::all() as $karat)
            <option value="{{ $karat->id }}">{{ $karat->label }}</option>
            @endforeach
        </select>
    </div>
    </div>




<script type="text/javascript">

$(document).ready(function() {
  $('#shape_id').change(function() {
    var option = $(this).val();
    alert(option);
    if (option === '1') {
     // $('#shape1').show();
      $('#shape1').removeClass('d-none');
    } else {
       $('#shape2').addClass('d-none');
       $('#shape2').hide();
    }
  });
});

</script>
<script>

$(document).ready(function () {

            function addRow() {
                var $myTable = $("#myTable").find('tbody');
                var parent = $(this).parent("td").parent("tr").attr("id");
                var newRowID = $myTable.children("tr").length + 1;
                var $newRow = $("<tr id='regFacEmpType" + newRowID + "' data-parent-row='" + parent + "'>");
                $newRow.append($(`<td align='center'>
                    <select class="form-control form-control-sm"
                        name="round_id" id="round_id" required="">
                        <option value="" selected="" disabled="">Select</option>
                        <option value="1">c230</option>
                    </select>
                    </td>`));

                $newRow.append($("<td></td>")
                    .append($(`<select class="form-control form-control-sm"
                        name="round_id" id="round_id" required="">
                        <option value="" selected="" disabled="">Select</option>
                        <option value="1">c230</option>
                    </select>`)
                    .bind("click", addRow)));
                $newRow.append($("<td class='text-center'></td>").append($("<button class='removeRegular btn btn-sm btn-outline-danger' id='removeRegular" + newRowID +"' type='button'>-</button>").bind("click", function(){ removeRegularRow(newRowID); })));
                $myTable.append($newRow);
            };

            function removeRegularRow(index) {
                        $("#regFacEmpType" + index).remove();
                         };
            $(".addRegular").on("click", addRow);
        });







</script>

