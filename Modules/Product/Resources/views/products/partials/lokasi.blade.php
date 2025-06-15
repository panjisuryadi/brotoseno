 <div class="justify-center text-center items-center">
<?php
  $location = $data->productlocation;
   ;?>
<ul>
    @forelse($location as $item)
  <li class="justify-center text-center items-center uppercase text-body-color mb-1 flex text-xs" style="font-size: 0.8rem !important;">
  {{ @$item->location->name }}
  </li>
 @empty
  <li class="text-body-color text-danger mb-1 font-semibold flex text-xs" style="font-size: 0.8rem !important;">
 Tidak Ada</li>
@endforelse

</ul>
</div>