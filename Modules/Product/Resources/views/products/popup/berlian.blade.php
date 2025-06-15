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
        <label for="round_id">@lang('Round') <span class="text-danger">*</span></label>
        <select class="form-control select2" name="round_id" id="round_id" required>
            <option value="" selected disabled>Select Round</option>
            @foreach(\Modules\ItemRound\Models\ItemRound::all() as $round)
            <option value="{{ $round->id }}">{{ $round->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="shape_id">@lang('Shape') <span class="text-danger">*</span></label>
        <select class="form-control select2" name="shape_id" id="shape_id" required>
            <option value="" selected disabled>Select Shape</option>
            @foreach(\Modules\ItemShape\Models\ItemShape::all() as $shape)
            <option value="{{ $shape->id }}">{{ $shape->name }}</option>
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

<div class="col-span-2">
   <div class="form-group">
        <label for="no_certificate">@lang('No .Certificate') <span class="text-danger">*</span></label>
        <input id="no_certificate" type="text" class="form-control" name="no_certificate" required value="{{ old('no_certificate') }}">
    </div>

</div>



</div>