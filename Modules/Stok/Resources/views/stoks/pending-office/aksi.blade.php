<div class="text-center">
    <a class="btn btn-sm btn-info font-bold"
       href="{{ route('stok.show_pending_office', ['categoryName' => $data->category_name, 'karatName' => $data->name]) }}">
        Detail
    </a>
{{--
    <button
        onclick="process({{$data}})"
        id="Status"
        data-toggle="tooltip"
        class="btn btn-sm btn-success font-bold">
        Proses
    </button> --}}
</div>
