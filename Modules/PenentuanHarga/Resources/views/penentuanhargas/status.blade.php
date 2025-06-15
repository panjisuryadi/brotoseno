<div class="items-center justify-items-center text-center">

    <span class="badge badge-primary">
        Aktif
    </span>
    {{-- set di list menjadi selalu aktif karena perubahan table, jadi tidak ada kolom lock di struktur yang sekaran --}}
{{-- @if ($data->lock == 1)
    <span class="badge badge-primary">
        Aktif
    </span>
@else
    <span class="badge badge-success">
      Non Aktif
    </span>
@endif --}}
</div>