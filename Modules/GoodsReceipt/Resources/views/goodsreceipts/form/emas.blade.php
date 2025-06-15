<div class="grid grid-cols-2 gap-2">
    <div class="form-group">
        <label for="product_note">Kategori Emas</label>
        <select class="form-control select2" name="gold_kategori_id" id="gold_kategori_id" required>
            <option value="" selected disabled>Select Kategori</option>
            @foreach(\Modules\GoldCategory\Models\GoldCategory::all() as $sup)
            <option value="{{$sup->id}}" {{ old('gold_kategori_id') == $sup->id ? 'selected' : '' }}>
            {{$sup->name}}</option>
            @endforeach
        </select>
    </div>

 <div class="form-group">
        <label for="karat_id">@lang('Karat') <span class="text-danger">*</span></label>
         <select class="form-control select2" name="karat_id" id="karat_id" required>
            <option value="" selected disabled>Karat</option>
            @foreach(\Modules\Karat\Models\Karat::all() as $jp)
            <option value="{{ $jp->id }}">{{ $jp->name }}</option>
            @endforeach
        </select>
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
                                                $field_name = 'product_cost';
                                                $field_lable = label_case($field_name);
                                                $field_placeholder = $field_lable;
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


                                       <div class="form-group">
                                                <?php
                                                $field_name = 'margin';
                                                $field_lable = label_case($field_name);
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                <input class="form-control margin"
                                                type="number"
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
