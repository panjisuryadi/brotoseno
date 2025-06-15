@php
$main = Modules\Locations\Entities\Locations::whereNull('parent_id')->get();
@endphp
<select name="destination" class="form-control form-control-sm" onchange="setlocation()" id="location_ids" required>
    <option value="">-- @lang('Select') @lang('Locations') --</option>
    @foreach($main as $p)
    <option value="{{ $p->id }}" disabled>{{ $p->name }}</option>
        @if(!empty($p->childs))
            @foreach($p->childs as $loc1)
            @if($loc1->id != $location_id)
            <option value="{{ $loc1->id }}">> {{ $loc1->name }}</option>
                @if(!empty($loc1->childs))
                    @foreach($loc1->childs as $loc2)
                    @if($loc2->id != $location_id)
                    <option value="{{ $loc2->id }}"> &nbsp;- {{ $loc2->name }}</option>
                        @if(!empty($loc2->childs))
                            @foreach($loc2->childs as $loc3)
                            @if($loc3->id != $location_id)
                            <option value="{{ $loc3->id }}">&nbsp; -> {{ $loc3->name }}</option>
                            @endif
                            @endforeach
                        @endif
                    @endif
                    @endforeach
                @endif
            @endif
            @endforeach
        @endif
    @endforeach
</select>