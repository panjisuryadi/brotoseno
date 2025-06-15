@foreach($data->childs as $data)
  {{$data->name}} >>
 @if(count($data->childs))
    @include('locations::locations.partials.child_location',['sublocations' => $data->childs])
  @endif
@endforeach
