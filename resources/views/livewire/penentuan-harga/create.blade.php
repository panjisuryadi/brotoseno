<div>
     <form wire:submit.prevent="store">
    <div class="flex justify-between py-2 border-bottom">
        
      <div>
          
<p class="uppercase text-lg text-gray-600 font-semibold">
                      Setting | <span class="text-yellow-500 uppercase">Penentuan harga</span>
                           <span class="text-gray-400 uppercase"></span>
                  </p>

      </div>
        
      

<div id="buttons" class="flex flex-row">
<a class="flex" title="Master Data Karat" href="{{ route("karat.index") }}">
    <div class="flex h-8 w-8 items-center justify-center p-2 mr-1 rounded-full border border-muted bg-muted">
        <i class="bi bi-card-list text-gray-600"></i>
    </div>
 </a>


<a class="flex" title="Kembali ke Iventory" href="{{ route("iventory.index") }}">
    <div class="flex h-8 w-8 items-center justify-center p-2 rounded-full border border-muted bg-muted">
        <i class="bi bi-house text-gray-600"></i>
    </div>
 </a>


</div>



      
    </div>
   


<div class="px-3">
       @if($updateMode)
         <span>kosong</span>
       @endif

</div>

<div class="px-1">

<table style="width: 100%;" class="table table-striped table-bordered">
    <tbody><tr>
        <th>{{ Label_case('No') }}</th>
        <th style="width:8%;" class="text-center">{{ Label_case('tgl_update') }}</th>
        <th>{{ Label_case('Karat') }}</th>
        <th style="width:12%;" class="text-center">{{ Label_case('Harga_emas') }}</th>
        <th style="width:12%;" class="text-center">{{ Label_case('Harga_modal') }}</th>
        <th style="width:12%;" class="text-center">{{ Label_case('margin') }}</th>
        <th style="width:12%;" class="text-center">{{ Label_case('harga_jual') }}</th>
        <th style="width:10%;" class="text-center">{{ Label_case('Status') }}</th>
        <th style="width:10%;" class="text-center">{{ Label_case('user') }}</th>
    </tr>

  @foreach ($inputs as $index => $row)

    <tr>
        <td>{{ $loop->iteration }}</td> 
        <td class="text-center text-blue-600"> {{ shortdate($row->list_harga->first()->tgl_update ?? '') }}</td> 
        <td class="font-semibold"> {{ $row->kode }} | {{ $row->name }}
           <input wire:model="pharga.{{ $index }}.karat_id" type="text" class="form-control form-control-sm" name="karat_id">
        </td> 
        <td> 
                @if(isset($row->list_harga->first()->harga_emas))
            <input type="text" class="form-control form-control-sm" 
             value=" {{ $row->list_harga->first()->harga_emas ?? ''}} " name="harga_emas">
                @else
                    <input type="text" class="form-control form-control-sm" name="harga_emas">
                @endif
        </td> 
        <td>  

            @if(isset($row->list_harga->first()->harga_modal))
                  
             <input type="text" class="form-control form-control-sm" 
             value="{{ $row->list_harga->first()->harga_modal ?? ''}} " name="harga_modal">   @else
                 <input type="text" class="form-control form-control-sm" name="harga_modal">
              @endif


        </td> 
        <td>  

              @if(isset($row->list_harga->first()->margin))
               <input type="text" wire:model="pharga.{{ $index }}.margin"  class="form-control form-control-sm" 
               placeholder="{{ $row->list_harga->first()->margin ?? ''}}" name="margin">
                @else
                 <input wire:model="pharga.{{ $index }}.margin" type="text" class="form-control form-control-sm" name="margin">
              @endif

        </td> 
        <td>  

         @foreach ($row->list_harga as $list)
         {{ $list->user->name }}
          @endforeach

        </td> 

         <td class="text-center">  
               @if(isset($row->list_harga->first()->lock))
                <div class="rounded-md w-full bg-green-600 px-2 text-white">Locked</div>
                @else
                <div class="rounded-md w-full bg-red-600 px-2 text-white">Unlocked</div>
                @endif

        </td> 


       
    </tr>
        
    @endforeach
</tbody></table> 


</div>





<div class="flex justify-between px-3 pb-2 border-bottom">
    <div>
    </div>
    <div class="form-group">
        <a class="px-5 btn btn-outline-danger"
            href="{{ route("iventory.index") }}">
        @lang('Cancel')</a>
        <button id="SimpanTambah" type="submit" class="px-4 btn btn-outline-success">
        @lang('Save')  <i class="bi bi-check"></i></button>
    </div>
</div>





</form>






</form>






</form>

@push('page_scripts')
<script type="text/javascript">

document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
  element.addEventListener('keyup', function(e) {
    let cursorPostion = this.selectionStart;
    let value = parseInt(this.value.replace(/[^,\d]/g, ''));
    let originalLenght = this.value.length;
    if (isNaN(value)) {
      this.value = "";
    } else {
      this.value = value.toLocaleString('id-ID', {
        currency: 'IDR',
        style: 'currency',
        minimumFractionDigits: 0
      });
      cursorPostion = this.value.length - originalLenght + cursorPostion;
      this.setSelectionRange(cursorPostion, cursorPostion);
    }
  });
});

</script>

@endpush
















</div>