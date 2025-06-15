<div class="modal" id="edit-tafsir-modal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Edit Nilai Tafsir</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="card">
                    <div class="card-header">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex relative py-1">
                                <div class="relative flex justify-left">
                                    <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Informasi Produk <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Detail Berat Barang."></i>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-2 gap-2 mt-3">
                            <div class="grid grid-cols-2 gap-2">
                                <div class="form-group col-span-2">
                                    <span class="font-medium">Nama Produk</span>
                                    <div class="flex-1 mt-1">
                                        <span class="font-bold">{{ $item?->product?->product_name }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span class="font-medium">Karat</span>
                                    <div class="flex-1 mt-1">
                                        <span class="font-bold">{{ $item?->product?->karat->label }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span class="font-medium">Berat Emas</span>
                                    <div class="flex-1 mt-1">
                                        <span class="font-bold">{{ $item?->product?->berat_emas }} gr</span>
                                    </div>
                                </div>
                                <div></div>
                            </div>
                            <div class="flex justify-center">
                                <img src="{{ asset(imageUrl() . $item?->product?->images) }}" alt="">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="grid grid-cols-2 gap-2 mt-3">
                            <div>
                                <label for="nominal_text">Nominal / Nilai Angkat</label>
                                <h3 class="text-2xl font-extrabold">{{ 'Rp. ' . number_format(intval($item?->nominal), 0, ',', '.') }}</h3>
                            </div>
                            <div></div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 mt-3">
                            <div class="form-group">
                                <?php
                                $field_name = 'item.nilai_tafsir';
                                $field_lable = label_case('nilai tafsir');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                ?>
                                <label for="{{ $field_name }}">{{ $field_lable }}</label>
                                <div class="flex-1">
                                    <input wire:model.1s="{{ $field_name }}" type="number" id="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror">
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-center items-center">
                                <span class="text-2xl font-extrabold">{{ 'Rp. ' . number_format(intval($item?->nilai_tafsir), 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 mt-3">
                            <div>
                                <label for="nominal_text">Nilai Selisih</label>
                                <h3 class="text-2xl font-extrabold">{{ 'Rp. ' . number_format(intval($item?->nilai_selisih), 0, ',', '.') }}</h3>
                            </div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" wire:click.prevent="updateNilaiTafsir">
                    @lang('Submit')
                </button>
            </div>
        </div>
    </div>
</div>
