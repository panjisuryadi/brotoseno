@foreach($data->getPermissionNames() as $permission)
    <span class="p-1 badge badge-primary">{{ $permission }}</span>
@endforeach
{{-- <a class="text-danger" href="{{ route('roles.edit', $data->id) }}">edit</a> --}}
