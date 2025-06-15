<div>
    <!-- CSS -->
    <style type="text/css">
    .search-box .clear{
        clear:both;
        margin-top: 5px;
    }

    .search-box ul{
        list-style: none;
        padding: 0px;
        width: 100% !important;
        position: absolute;
        margin: 0;
        background: white;
/*        z-index:10 !important;*/
    }

    .search-box ul li{
        background: #fdfdfd;
        padding: 4px;
        margin-bottom: 1px;
    }

    .search-box ul li:nth-child(even){
        background: #915a10;
        color: white;
    }

    .search-box ul li:hover{
        cursor: pointer;

    }

    .search-box input[type=text]{
        padding: 5px;
/*        width: 250px;*/
        letter-spacing: 1px;
    }
    </style>

    <div  class="z-10 search-box">

                        <div class="form-group">
                                <label class="mb-1" for="reference">Sales <span class="text-danger">*</span>
                                <span class="small">(ketik Nama atau Tags ID)</span></label>
                               
               
 <input wire:keydown.escape="resetQuery" wire:keyup="searchResult" wire:model.debounce.500ms="search" type="text" class="form-control" placeholder="@lang('Cari Sales') ....">
       
        <!-- Search result list -->
        @if($showdiv)
            <ul class="z-10 mt-0">
                @if(!empty($records))
                    @foreach($records as $record)
                         <li class="z-10" wire:click="fetchSalesDetail({{ $record->id }})">{{ $record->name}}</li>

                    @endforeach
                @endif
            </ul>
        @endif

        <div class="clear"></div>
        <div >
            @if(!empty($salesDetails))
                <div>
                     Name : {{ $salesDetails->name }} <br>
                     ID Sales : <strong>{{ $salesDetails->kode_user }}</strong>
                </div>
            @endif
        </div>
    </div>
     </div> 

</div>