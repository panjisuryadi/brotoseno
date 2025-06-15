@foreach($sublocations as $data)
 <ul>
    <li>{{$data->name}}</li>
  @if(count($data->childs))
    @include('locations::locations.partials.child_location',['sublocations' => $data->childs])
  @endif
 </ul>
@endforeach