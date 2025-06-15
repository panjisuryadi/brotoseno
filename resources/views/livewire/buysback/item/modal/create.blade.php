<div class="modal fade" id="buyback-create-modal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Tambah BuyBack</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form wire:submit.prevent="store">
                    <div class="grid grid-cols-2 gap-10">
                        <div class="col-span-2">
                            <div class="grid grid-cols-2 gap-2">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'code';
                                    $field_lable = label_case('kode produk');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    ?>
                                    <label class="font-medium" for="{{ $field_name }}">Masukkan {{ $field_lable }}<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror" wire:model="{{ $field_name }}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info relative rounded-l-none" wire:click.prevent="findProduct">Check</button>
                                        </span>
                                    </div>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <?php
                                    $field_name = 'date';
                                    $field_lable = label_case('tanggal');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    ?>
                                    <label class="font-medium" for="{{ $field_name }}">{{ $field_lable }}</label>
                                    <div class="flex-1">
                                        <input wire:model="{{ $field_name }}" type="date" id="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror">
                                        @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-2">

                            @if (isset($product))
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
                                                    <span class="font-bold">{{ $product['product_name'] }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <span class="font-medium">Karat</span>
                                                <div class="flex-1 mt-1">
                                                    <span class="font-bold">{{ $product['karat']['name'] }} | {{ $product['karat']['kode'] }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <span class="font-medium">Berat Emas</span>
                                                <div class="flex-1 mt-1">
                                                    <span class="font-bold">{{ $product['berat_emas'] }} gr</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex justify-center">
                                            <img src="{{ asset(imageUrl() . $product['images']) }}" alt="">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="grid grid-cols-2 gap-2 mt-3">

                                <div class="form-group">
                                    <?php
                                    $field_name = 'customer_id';
                                    $field_lable = label_case('customer');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    ?>
                                    <label class="font-medium" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                    <select class="form-control select2 @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                        <option value="" selected disabled>Pilih Customer</option>
                                        @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback"role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                        class="text-danger">
                                    </span>
                                    @endif
                                </div>
                                <div></div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'nominal';
                                    $field_lable = label_case('nominal');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    ?>
                                    <label class="font-medium" for="{{ $field_name }}">{{ $field_lable }}</label>
                                    <div class="flex-1">
                                        <input wire:model.1s="{{ $field_name }}" type="number" id="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror">
                                        @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex justify-center items-center">
                                    <span class="text-2xl font-extrabold">{{ $nominal_text }}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-2">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'note';
                                    $field_lable = label_case('note');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    ?>
                                    <label class="font-medium" for="{{ $field_name }}">{{ $field_lable }}</label>
                                    <div class="flex-1">
                                        <textarea name="{{$field_name}}" id="{{$field_name}}" rows="5" wire:model="note" class="form-control"></textarea>
                                        @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            

                            @endif
                        </div>
                    </div>

                   
                </form>
            </div>
            <div class="modal-footer">
                <div class="float-right">
                    <button type="button" class="btn btn-secondary mr-1" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" wire:click.prevent="store">Tambah</button>
                </div>
            </div>


        </div>

    </div>
</div>

@push('page_scripts')
<script>
    function setAdditionalAttribute(name, selectElement) {
        let selectedText = selectElement.options[selectElement.selectedIndex].text;
        Livewire.emit('setAdditionalAttribute', name, selectedText);
    }

    document.addEventListener('livewire:load', function() {
        Livewire.on('reload-page-create', function() {
            window.location.reload();
            toastr.success('Item Berhasil di ditambahkan')
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
@endpush