<div class="grid grid-cols-2 gap-2">
@foreach($data->getPermissionNames() as $permission)
  <div class="flex radio p-1 cursor-pointer font-extralight text-xs">
    <input class="my-auto transform" type="checkbox" name="sfg" checked />
    <div style="font-size: 0.7rem !important;" class="title px-2 my-auto text-xs">{{ $permission }}</div>
  </div>
@endforeach
</div>

{{-- <a class="text-danger" href="{{ route('roles.edit', $data->id) }}">edit</a> --}}
