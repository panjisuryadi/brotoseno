<div>
    <div class="form-row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="id_location">@lang('Locations') <span class="text-danger">*</span></label>
                <select wire:model="id_location" wire:change="getParentlocations" name="id_location" class="form-control form-control-sm">
                    <option value="">-- @lang('Select') @lang('Locations') --</option>
                    @foreach($main as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="from-group">
                <div class="form-group">
                    <label for="sub"> @lang('Sub Locations') <span class="text-danger">*</span></label>
                    <select wire:model="sub_location" name="sub_location" class="form-control form-control-sm">
                        <option value="">-- @lang('Select') @lang('Sub Locations') --</option>
                        @if(!empty($locations))
                        @foreach($locations as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>