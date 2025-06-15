<div class="form-group">
    <label class="mb-1">Product Category</label>
  <select id="category" wire:model="selectedOption" 
  class="form-control" name="category" wire:change="selectOption($event.target.value)">
     <option value="">All Products</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
        @endforeach
    </select>
    @if ($errors->has('category'))
        <span class="invalid feedback"role="alert">
            <small class="text-danger">{{ $errors->first('category') }}.</small
            class="text-danger">
        </span>
        @endif

</div>


@push('page_scripts')
{{-- <script>
    $(document).ready(function() {
        $('#category').select2();
        $('#category').on('change', function (e) {
            var data = $('#category').select2("val");
            @this.set('category', data);
        });
    });
</script> --}}
@endpush