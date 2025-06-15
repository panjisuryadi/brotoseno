<table style="width:100%;" class="table table-borderlees">
    <tbody>
        <tr>
            
            <td class="w-50">
                <label class="px-1 font-semibold text-lg uppercase text-gray-600">Bulan </label>
            </td>
            <td class="w-50">
                <div class="form-group">
                    <?php
                    $field_name = 'bulan';
                    $field_lable = label_case('Code');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = "required";
                    ?>
                    
                    <select
                        name="{{ $field_name }}"
                        id="{{ $field_name }}"
                        wire:change="pilihBulan($event.target.value)"
                        class="form-control">
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
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
            <td class="w-50">
                <label class="px-1 font-semibold text-lg uppercase text-gray-600">
                Angkatan </label>
            </td>
            <td class="w-50">
                <div class="form-group">
                  00
                </div>
            </td>
        </tr>
        <tr>
            <td class="w-50">
                <label class="px-1 font-semibold text-lg uppercase text-gray-600">
                Hitungan Office </label>
            </td>
            <td class="w-50">
                <div class="form-group">
                   <button wire:click="like">Like Post</button>
                </div>
            </td>
        </tr>
        <tr>
            <td class="w-50">
                <label class="px-1 font-semibold text-lg uppercase text-gray-600">
                Selisih </label>
            </td>
            <td class="w-50">
                <div class="form-group">
                    Selisih
                </div>
            </td>
        </tr>
        <tr>
            <td class="w-50">
                <label class="px-1 font-semibold text-lg uppercase text-gray-600">
                Persentase </label>
            </td>
            <td class="w-50">
                <div class="form-group">
                    Persentase
                </div>
            </td>
        </tr>
        <tr>
            <td class="w-50">
                <label class="px-1 font-semibold text-lg uppercase text-gray-600">
                Nilai insentif </label>
            </td>
            <td class="w-50">
                <div class="form-group">
                    Nilai insentif
                </div>
            </td>
        </tr>
    </tbody>
</table>
