     <div class="form-group">
            <select name="location_id" id="location_id" class="form-control form-control-sm">
                    <option value="">Pilih Lokasi</option>
                    @foreach(\Modules\Locations\Entities\Locations::where('parent_id',null)->orderby('name','asc')
                             ->get() as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                     @if(!empty($p->childs))
                            @foreach($p->childs as $loc1)
                            <option value="{{ $loc1->id }}">> {{ $loc1->name }}</option>
                                @if(!empty($loc1->childs))
                                    @foreach($loc1->childs as $loc2)
                                    <option value="{{ $loc2->id }}"> &nbsp;=> {{ $loc2->name }}</option>
                                        @if(!empty($loc2->childs))
                                            @if(!empty($loc2->childs))
                                                @foreach($loc2->childs as $loc3)
                                                <option value="{{ $loc3->id }}">&nbsp;==> {{ $loc3->name }}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                  @endforeach
                </select>
            </div>


