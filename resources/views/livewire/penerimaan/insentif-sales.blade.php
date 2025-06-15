

<div>
<table style="width:100%;" class="table table-borderlees">
    <tbody>
        <tr>
            
            <td class="w-40">
                <label class="px-1 font-semibold text-md mt-1 uppercase text-gray-500">Bulan </label>
            </td>
            <td class="w-60">
                <div class="form-group">
                    <?php
                    $field_name = 'bulan';
                    $field_lable = label_case('Code');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = "required";
                    ?>
                   <select wire:model="id_sales" wire:change="getDataSales" name="id_sales" class="form-control">
                        <option value="140">January</option>
                        <option value="142">February</option>
                        <option value="143">March</option>
                        <option value="144">April</option>
                        <option value="145">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    
                </div>
            </td>
            
        </tr>
        <tr>
            <td class="w-40">
                <label class="px-1 font-semibold text-md mt-1 uppercase text-gray-500">
                Nama Sales</label>
            </td>
            <td class="w-60">

           {{-- {{$listsales}} --}}

           <select wire:model="id_sales" name="id_sales" wire:change="getIdSales" class="form-control">
            <div wire:loading wire:target="id_sales">
                    Processing ...
                </div>

                    <option value="" selected>Pilih Sales</option>
                        @if(!empty($listsales))
                        @foreach($listsales as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                        @endforeach
                        @endif
                    </select>

        
            </td>
        </tr>
        <tr>
            <td class="w-40">
                <label class="px-1 font-semibold text-md mt-1 uppercase text-gray-500">
              Nilai Angkat </label>
            </td>
            <td class="w-60">
                <div class="form-group">
                <input class="form-control" type="text" name="nilai_angkat" id="nilai_angkat" value="{{@$detailsales->target}}" readonly>
                </div>
            </td>
        </tr> 

        <tr>
            <td class="w-40">
                <label class="px-1 font-semibold text-md mt-1 uppercase text-gray-500">
              Nilai Tafsir </label>
            </td>
            <td class="w-60">
                <div class="form-group">
                  <input class="form-control" type="text" name="nilai_angkat" id="nilai_angkat" readonly>
                </div>
            </td>
        </tr>
        <tr>
            <td class="w-40">
                <label class="px-1 font-semibold text-md mt-1 uppercase text-gray-500">
                Selisih </label>
            </td>
            <td class="w-60">
                <div class="form-group">
                   <input class="form-control" type="text" name="nilai_angkat" id="nilai_angkat" readonly>
                </div>
            </td>
        </tr>
        <tr>
            <td class="w-40">
                <label class="px-1 font-semibold text-md mt-1 uppercase text-gray-500">
                Persentase </label>
            </td>
            <td class="w-60">
                <div class="form-group">
                       <input class="form-control" type="text" name="nilai_angkat" id="nilai_angkat">
                </div>
            </td>
        </tr>
        <tr>
            <td class="w-40">
                <label class="px-1 font-semibold text-md mt-1 uppercase text-gray-500">
                Nilai insentif </label>
            </td>
            <td class="w-60">
                <div class="form-group">
                     <input class="form-control" type="text" name="nilai_angkat" id="nilai_angkat" readonly>
                </div>
            </td>
        </tr>
    </tbody>
</table>

</div>
