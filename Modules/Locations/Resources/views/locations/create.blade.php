@extends('layouts.app')

@section('title', 'Create Customer')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customers.index') }}"> @lang('Locations') </a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
@endsection

                                {{--  <livewire:locations.getlocation/> --}}
@section('content')


<div class="modal" tabindex="-1" role="dialog" id="editlocationModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" value="" placeholder="location Name" required>
                    </div>
                    <div class="form-group">
                          <label for="typeedit">Tipe Gudang</label>
                          <select name="type" id="typeedit" class="form-control">
                              <option value="storage">Penyimpanan</option>
                              <option value="storefront">Etalase</option>
                          </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
       </form>
            </div>
    </div>
</div>






<div class="container-fluid">
   <div class="row">
            <div class="col-md-8">

              <div class="card">
                <div class="card-header">
                  <h5>Locations</h5>
                </div>
                <div class="card-body">
                  <ul class="list-group">
                    @foreach ($locations as $location)
                      <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                          {{ $location->name }}

                          <div class="button-group d-flex">
                            <button type="button" class="btn btn-sm btn-primary mr-1 edit-location" data-toggle="modal" data-target="#editlocationModal" data-id="{{ $location->id }}" data-name="{{ $location->name }}" data-type="{{ $location->type }}">Edit</button>

                            <form action="{{ route('locations.destroy', $location->id) }}" method="POST">
                              @csrf
                              @method('DELETE')

                              <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                          </div>
                        </div>

                        @if ($location->childs)
                          <ul class="list-group mt-2">
                            @foreach ($location->childs as $child)
                              <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                  {{ $child->name }}

                                  <div class="button-group d-flex">
                                    <button type="button" class="btn btn-sm btn-outline-warning mr-1 edit-location" data-toggle="modal" data-target="#editlocationModal" data-id="{{ $child->id }}" data-name="{{ $child->name }}" data-type="{{ $child->type }}">Edit</button>

                                    <form action="{{ route('locations.destroy', $child->id) }}" method="POST">
                                      @csrf
                                      @method('DELETE')

                                      <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                  </div>
                                </div>
                                @if ($child->childs)
                                <ul class="list-group mt-2">
                                  @foreach ($child->childs as $child2)
                                    <li class="list-group-item">
                                      <div class="d-flex justify-content-between">
                                        {{ $child2->name }}

                                        <div class="button-group d-flex">
                                          <button type="button" class="btn btn-sm btn-outline-warning mr-1 edit-location" data-toggle="modal" data-target="#editlocationModal" data-id="{{ $child2->id }}" data-name="{{ $child2->name }}" data-type="{{ $child2->type }}">Edit</button>

                                          <form action="{{ route('locations.destroy', $child2->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                          </form>
                                        </div>
                                      </div>
                                      @if ($child2->childs)
                                      <ul class="list-group mt-2">
                                        @foreach ($child2->childs as $child3)
                                          <li class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                              {{ $child3->name }}

                                              <div class="button-group d-flex">
                                                <button type="button" class="btn btn-sm btn-outline-warning mr-1 edit-location" data-toggle="modal" data-target="#editlocationModal" data-id="{{ $child3->id }}" data-name="{{ $child3->name }}" data-type="{{ $child3->type }}" >Edit</button>

                                                <form action="{{ route('locations.destroy', $child3->id) }}" method="POST">
                                                  @csrf
                                                  @method('DELETE')

                                                  <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                              </div>
                                            </div>
                                          </li>
                                        @endforeach
                                      </ul>
                                    @endif
                                    </li>
                                  @endforeach
                                </ul>
                              @endif
                              </li>
                            @endforeach
                          </ul>
                        @endif
                      </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <h5>Create Locations</h5>
                </div>

                <div class="card-body">
                  <form action="{{ route('locations.store') }}" method="POST">
                    @csrf
                    <livewire:locations.getlocation/>

                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder=" Name" required>
                    </div>

                    <div class="form-group">
                      <label for="type">Tipe Gudang</label>
                      <select name="type" id="type" class="form-control">
                          <option value="storage">Penyimpanan</option>
                          <option value="storefront">Etalase</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-success">Create</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>


</div>
@endsection
 @push('page_scripts')

<script type="text/javascript">
          $('.edit-location').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var type = $(this).data('type');
            var url = "{{ url('locations') }}/" + id;

            $('#editlocationModal form').attr('action', url);
            $('#editlocationModal form input[name="name"]').val(name);
            $('#typeedit').val(type).change();
          });
        </script>


@endpush






