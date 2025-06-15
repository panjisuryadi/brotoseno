<div class="modal fade" id="product-process-modal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
     aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title uppercase font-bold text-lg" id="detailmodalLabel">Ubah Status</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="form-product-process" method="POST">
                    <div id="modal-content">
                        @csrf
                        <input type="hidden" name="data_name" id="data_name" value="">
                        <input type="hidden" name="data_category" id="data_category" value="">
                        <input type="hidden" name="data_id" id="data_id" value="">
                        <div class="flex">
                            <select class="form-control uppercase" name="status_id" id="status_id" required>
                                <option value="" selected disabled>Pilih Status</option>
                                @foreach($product_status as $status)
                                    <option value="{{$status->id}}" class="uppercase">
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-4" id="form_berat_asal">
                            <label class="inline" for="">Berat Asal</label>
                            <input class="form-control" type="text" name="berat_asal" id="berat_asal" value="" readonly>
                        </div>
                        <div class="form-group " id="form_berat_total">
                            <label for="">Kembali</label>
                            <input class="form-control" type="number" name="berat_total" id="berat_total" value="">
                            <span class="invalid feedback" role="alert">
                                <span class="text-danger error-text berat_total_err"></span>
                            </span>
                            <small id="emailHelp" class="form-text text-muted">Abaikan atau isi 0 jika beratnya tetap
                                sama.</small>
                        </div>
                        <div class="form-group " id="form_berat_susut">
                            <label for="">Penyusutan</label>
                            <input class="form-control" type="text" name="berat_susut" id="berat_susut" value=""
                                   readonly>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#form_berat_asal').hide()
        $('#form_berat_total').hide()
        $('#form_berat_susut').hide()

        $('#status_id').on('change', function () {
            let current_value = $('option:selected', this).val();

            if (status_id_ready_office == current_value) {
                $('#form_berat_asal').show()
                $('#form_berat_total').show()
                $('#form_berat_susut').show()
                $('#berat_asal').val(_datas.berat_emas)
            } else {

                $('#form_berat_asal').hide()
                $('#form_berat_total').hide()
                $('#form_berat_susut').hide()
                $('#berat_asal').val(_datas.berat_emas)
            }
        })

        $('#berat_total').on('change', function () {
            let current_value = $(this).val();
            $('#berat_susut').val(_datas.berat_emas - current_value)
        })

        function printErrorMsg(msg) {
            $.each(msg, function (key, value) {
                console.log(key);
                $('#' + key + '').addClass("");
                $('#' + key + '').addClass("is-invalid");
                $('.' + key + '_err').text(value);
            });
        }

    </script>
@endpush
