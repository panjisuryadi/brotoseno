<div class="flex flex-row grid grid-cols-3 gap-2">
<div class="form-group">
<?php
$field_name = 'jenis_mutiara_id';
$field_lable = label_case($field_name);
$field_placeholder = $field_lable;
$invalid = $errors->has($field_name) ? ' is-invalid' : '';
$required = "required";
?>
<label class="mt-1" for="jenis_mutiara_id">Jenis Mutiara </label>
<select class="form-control" data-placeholder="Pilih Mutiara" tabindex="1" name="{{ $field_name }}" id="{{ $field_name }}">
  
     @foreach(\Modules\JenisMutiara\Models\JenisMutiara::all() as $row)
        <option value="{{$row->id}}">
        {{$row->name}}</option>
        @endforeach
</select>
</div>

<div class="form-group">
   <label class="mt-1" for="kategori_mutiara_id">Kategori Mutiara </label>
    <select class="form-control" name="kategori_mutiara_id" id="kategori_mutiara_id" required>
        <option value="" selected disabled>Select Kategori Mutiara</option>
        
    </select>
</div>




    <div class="form-group">
        <label for="berat_emas">@lang('Berat') <span class="text-danger">*</span></label>
        <input min="0" step="0.01" id="berat_emas" type="number" class="form-control" name="berat_emas" required value="{{ old('berat_emas') }}">
    </div>



</div>

<div class="flex relative py-1">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-b border-gray-300"></div>
    </div>
    <div class="relative flex justify-left">
        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Berat <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Detail Berat Barang."></i>
        </span>
    </div>
</div>
<div class="flex flex-row grid grid-cols-2 gap-2">
    
    <div class="form-group">
        <?php
        $field_name = 'berat_emas';
        $field_lable = label_case('Berat');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.01"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>
    
    <div class="form-group">
        <?php
        $field_name = 'berat_total';
        $field_lable = label_case('berat_total');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control berat_total"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.01"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>
    
</div>



    <div class="flex relative py-1">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-b border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-left">
                                        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Harga</span>
                                    </div>
                                </div>


                             <div class="flex flex-row grid grid-cols-2 gap-2">
                                   
                                         <div class="form-group">
                                                <?php
                                                $field_name = 'harga_emas';
                                                $field_lable = label_case($field_name);
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="small text-danger">(Harga Emas Hari ini)</span></label>
                                                <input class="form-control harga_emas"
                                                type="text"
                                                name="{{ $field_name }}"
                                                id="{{ $field_name }}"
                                                value="{{old($field_name)}}"
                                                placeholder="{{ $field_placeholder }}"
                                                >
                                                <span class="invalid feedback" role="alert">
                                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                                </span>
                                            </div>



                                         <div class="form-group">
                                                <?php
                                                $field_name = 'product_cost';
                                                $field_lable = label_case('Biaya Produk');
                                                $field_placeholder =label_case('Harga Emas x Berat');
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                <input class="form-control pc"
                                                type="text"
                                                name="{{ $field_name }}"
                                                id="{{ $field_name }}"
                                                value="{{old($field_name)}}"
                                                placeholder="{{ $field_placeholder }}"
                                                >
                                                <span class="invalid feedback" role="alert">
                                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                                </span>
                                            </div>
                            


                                    
                                   </div>


                           <div class="flex flex-row grid grid-cols-2 gap-2">
                                   

      <div class="form-group">
                                                <?php
                                                $field_name = 'margin';
                                                $field_lable = label_case($field_name);
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                             <div class="flex justify-between py-0 px-0">
                                               
                                                <div>
                                                     <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                </div>
                                 
                              <div class="py-0">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input margin" type="radio" name="margin" id="nominal" checked>
                                            <label class="form-check-label" for="nominal">Nominal</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input margin" type="radio" name="margin"
                                            id="persentase">
                                            <label class="form-check-label" for="persentase">Persentase</label>
                                        </div>
                                    </div>




                                            </div>



                                             <div id="m2" >
                                                <input class="form-control margin"
                                                type="number"
                                                name="{{ $field_name }}"
                                                id="{{ $field_name }}"
                                                value="{{old($field_name)}}"
                                                placeholder="Margin Nominal"
                                                >
                                                </div>

                                               <div id="m1" style="display: none !important;" >
                                                <input class="form-control margin"
                                                type="number"
                                                name="{{ $field_name }}"
                                                id="{{ $field_name }}"
                                                value="{{old($field_name)}}"
                                                placeholder="Persentase (%)"
                                                >
                                                </div>




                                                <span class="invalid feedback" role="alert">
                                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                                </span>
                                            </div>





                                        <div class="form-group">
                                                <?php
                                                $field_name = 'product_price';
                                                $field_lable = label_case('Harga Jual');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}
                                                    <span class="small text-danger">Product cost + margin</span>
                                                </label>
                                                <input class="form-control"
                                                type="text"
                                                name="{{ $field_name }}"
                                                id="{{ $field_name }}"
                                                value="{{old($field_name)}}"
                                                placeholder="{{ $field_placeholder }}"
                                                >

                                            <span id="grand_total" class="text-lg text-danger"></span>


                                                <span class="invalid feedback" role="alert">
                                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                                </span>
                                            </div>
                                        
                                    
                                   </div>                                 


    <script type='text/javascript'>
    $(document).ready(function(){

      //  Change
        $('#jenis_mutiara_id').change(function(){
             var id = $(this).val();
             //alert(id);
             $('#kategori_mutiara_id').find('option').not(':first').remove();
             // AJAX request 
             $.ajax({
                 url: base_url + '/kategorimutiara/getid/'+id,
                 type: 'get',
                 dataType: 'json',
                 success: function(response){
                     var len = 0;
                     if(response['data'] != null){
                          len = response['data'].length;
                     }
                     if(len > 0){
                          for(var i=0; i<len; i++){
                               var id = response['data'][i].id;
                               var name = response['data'][i].name;
                               var option = "<option value='"+id+"'>"+name+"</option>";
                               $("#kategori_mutiara_id").append(option); 
                          }
                     }

                 }
             });
        });
    });
    </script>