<div class="flex grid grid-cols-3 gap-2">  
    <div class="form-group">
                <input name="rfid" class="form-control rounded rounded-lg sortir text-center" wire:keydown.enter="clickQuery"
                type="text"
                wire:model="search"
                placeholder="@lang('Scan product')" autofocus>
            </div>


       <div class="px-5">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
  @foreach($list_product as $row)
            <?php
            if ($row['id'] == $listrfid) {
               $info = 'bi bi-x-square';
            }else{
              $info = 'bi bi-x-circle';
            }


             ?>

<li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                      {{--       <div class="flex-shrink-0">
                                <img class="w-8 h-8 rounded-full" src="{{$row->getFirstMediaUrl('images', 'thumb')}}" alt="Neil image">
                            </div> --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 truncate dark:text-gray-500">
                                {{ $row['product_name'] }} |  <span class="text-blue-400"> {{ $row['rfid'] }}</span>
                                </p>
                            </div>
                          
                        </div>
                    </li>


  @endforeach

</ul>
        </div>



</div>

<style type="text/css">

.sortir {
    border: 0.2rem solid;
    color: #111827;
    font-size: 1.2rem;
    font-weight: 600;
    letter-spacing: 0.1rem;
    background-color: #f0f0f0;
    border-style: dashed;
    height: 5rem;
}


.sortir:focus {
  background-color: #f3d585;

}

</style>

