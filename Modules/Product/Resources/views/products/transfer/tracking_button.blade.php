 <div class="flex row justify-center items-center">
@can('show_product_transfer')
<a href="{{ route('products.transfer.detail', $data->id) }}" class="btn btn-outline-info btn-sm">
    <i class="bi bi-eye"></i> Tracking
</a>
@endcan
</div>
