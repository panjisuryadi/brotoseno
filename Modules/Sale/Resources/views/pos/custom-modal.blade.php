<div class="modal fade" id="customModal" tabindex="-1" role="dialog" aria-labelledby="customModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" wire:ignore.self>
    <div class="modal-xl modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-semibold text-lg" id="customModalLabel">
                    <i class="bi bi-cart-check text-primary"></i>
                    Custom
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-0" style="max-height: 500px; overflow: scroll;">
                <form id="checkout-form" wire:submit.prevent="storeCustom">
                    @csrf
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div>
                                @if(!auth()->user()->isUserCabang())
                                <div class="form-group py-2">
                                    <select class="form-control @error('cabang_id') is-invalid @enderror" name="cabang_id" id="cabang_id" wire:model="cabang_id">
                                        <option value="" selected>Pilih Cabang</option>
                                        @foreach($cabangs as $cabang)
                                        <option value="{{ $cabang->id }}">
                                            {{ $cabang->code }} | {{ $cabang->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('cabang_id'))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first('cabang_id') }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>
                                @endif
                            </div>

                            <div class="modal-body py-0" style="max-height: 500px;">
                                <div class="card shadow-md">
                                    <div class="card-header">
                                        <h3 class="font-bold text-medium">
                                            Spesifikasi Barang Custom
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <?php
                                                $field_name = 'jenis_barang';
                                                $field_lable = label_case('Jenis Barang');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = '';
                                            ?>
                                            <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                            <input class="form-control" type="text" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:model.lazy="{{ $field_name }}" placeholder="{{$field_lable}}">
                                            @if ($errors->has($field_name))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                </span>
                                            @endif
                                        </div>

                                        <div class="add-input w-full mx-auto flex flex-row grid grid-cols-3 gap-2">
                                            <div class="form-group">
                                                <?php
                                                    $field_name = 'karat_id';
                                                    $field_lable = __('Parameter Karat');
                                                    $field_placeholder = Label_case($field_lable);
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = 'wire:model="'.$field_name.'"';
                                                ?>
                                                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                <select class="form-control" name="{{ $field_name }}">
                                                    <option value="" selected disabled>Select Karat</option>
                                                    @foreach(\Modules\Karat\Models\Karat::all() as $row)
                                                        <option value="{{$row->id}}" {{ old('karat_id') == $row->id ? 'selected' : '' }}>
                                                        {{$row->name}} | {{$row->kode}} </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has($field_name))
                                                    <span class="invalid feedback"role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                        class="text-danger">
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <?php
                                                    $field_name = 'berat_gr';
                                                    $field_lable = label_case('Berat (Gr)');
                                                    $field_placeholder = $field_lable;
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = '';
                                                ?>
                                                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:model.lazy="{{ $field_name }}" placeholder="{{$field_lable}}">
                                                @if ($errors->has($field_name))
                                                    <span class="invalid feedback" role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <?php
                                                    $field_name = 'harga_gr';
                                                    $field_lable = label_case('Harga');
                                                    $field_placeholder = $field_lable;
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = '';
                                                ?>
                                                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:model.lazy="{{ $field_name }}" placeholder="{{$field_lable}}">
                                                @if ($errors->has($field_name))
                                                    <span class="invalid feedback" role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                    </span>
                                                @endif
                                            </div>
                                        </div>


                                        @foreach($inputCustom as $key => $value)
                                            <div class="flex justify-between mt-0">
                                                <div class="add-input w-full mx-auto flex flex-row grid grid-cols-3 gap-2">
                                                    <div class="form-group">
                                                        @php
                                                            $field_name = 'inputCustom.' . $key . '.berat_ct';
                                                            $field_label = ucwords(str_replace('_', ' ', 'Berat_(Ct)'));
                                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        @endphp
                                                        @if ($key == 0)
                                                            <label class="mb-0" for="{{ $field_name }}">{{ $field_label }}</label>
                                                        @endif
                                                        <input class="form-control{{ $invalid }}" type="number" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:model.lazy="{{ $field_name }}" placeholder="{{ $field_label }}">
                                                        @if ($errors->has($field_name))
                                                            <span class="invalid feedback" role="alert">
                                                                <small class="text-danger">{{ $errors->first($field_name) }}</small>
                                                            </span>
                                                        @endif
                                                    </div>
                                        
                                                    <div class="form-group">
                                                        @php
                                                            $field_name = 'inputCustom.' . $key . '.harga_ct';
                                                            $field_label = ucwords(str_replace('_', ' ', 'Harga'));
                                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        @endphp
                                                        @if ($key == 0)
                                                            <label class="mb-0" for="{{ $field_name }}">{{ $field_label }}</label>
                                                        @endif
                                                        <input class="form-control{{ $invalid }}" type="number" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:model.lazy="{{ $field_name }}" placeholder="{{ $field_label }}">
                                                        @if ($errors->has($field_name))
                                                            <span class="invalid feedback" role="alert">
                                                                <small class="text-danger">{{ $errors->first($field_name) }}</small>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if ($key == 0)
                                                    <div class="px-1 mt-3">
                                                        <button class="btn text-white text-xl btn-info btn-md" wire:click.prevent="addInput()" wire:loading.attr="disabled">
                                                            <span wire:loading.remove wire:target="addInput"><i class="bi bi-plus"></i></span>
                                                            <span wire:loading wire:target="addInput" class="text-center">
                                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                @else
                                                    <div class="px-1">
                                                        <button class="btn text-white text-xl btn-danger btn-md" wire:click.prevent="remove({{ $key }})" wire:loading.attr="disabled">
                                                            <span wire:loading.remove wire:target="remove({{ $key }})"><i class="bi bi-trash"></i></span>
                                                            <span wire:loading wire:target="remove({{ $key }})" class="text-center">
                                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach


                                        <div class="add-input w-full mx-auto flex flex-row grid grid-cols-2 gap-2">
                                            {{-- <div class="form-group">
                                                <?php
                                                    $field_name = 'ongkos_produksi';
                                                    $field_lable = label_case('Ongkos Produksi');
                                                    $field_placeholder = $field_lable;
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = '';
                                                ?>
                                                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:model.lazy="{{ $field_name }}" placeholder="{{$field_lable}}">
                                                @if ($errors->has($field_name))
                                                    <span class="invalid feedback" role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <?php
                                                    $field_name = 'ongkos_cuci';
                                                    $field_lable = label_case('Ongkos Cuci');
                                                    $field_placeholder = $field_lable;
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = '';
                                                ?>
                                                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:model.lazy="{{ $field_name }}" placeholder="{{$field_lable}}">
                                                @if ($errors->has($field_name))
                                                    <span class="invalid feedback" role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <?php
                                                    $field_name = 'ongkos_rnk';
                                                    $field_lable = label_case('Ongkos RNK');
                                                    $field_placeholder = $field_lable;
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = '';
                                                ?>
                                                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:model.lazy="{{ $field_name }}" placeholder="{{$field_lable}}">
                                                @if ($errors->has($field_name))
                                                    <span class="invalid feedback" role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <?php
                                                    $field_name = 'ongkos_mt';
                                                    $field_lable = label_case('Ongkos MT');
                                                    $field_placeholder = $field_lable;
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = '';
                                                ?>
                                                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:model.lazy="{{ $field_name }}" placeholder="{{$field_lable}}">
                                                @if ($errors->has($field_name))
                                                    <span class="invalid feedback" role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                    </span>
                                                @endif
                                            </div> --}}
                                            <div class="px-1">
                                                <div class="form-group my-3">
                                                    <div class="grid grid-cols-2 gap-2 justify-between mb-1">
                                                        <p>Tambahan Lainnya (Opsional)</p>
                                                        @if (count($other_thing) < 6) 
                                                            <a wire:click="add_other_thing" href="#" class="btn btn-sm btn-success w-1/5 place-self-end"><i class="bi bi-plus"></i></a>
                                                        @endif
                                                    </div>
                                                    @if (count($other_thing))
                                                        <div class="grid grid-cols-7 gap-2 items-center">
                                                            @foreach ($other_thing as $index => $fee)
                                                            <div class="col-span-6 grid grid-cols-2 gap-2">
                                                                <div class="form-group">
                                                                    <?php
                                                                        $field_name = 'other_thing.' . $index . '.custom_note';
                                                                    ?>
                                                                    <input type="text" class="form-control @error($field_name) is-invalid @enderror" wire:model.debounce.500ms="{{$field_name}}" placeholder="Catatan">
                                                                    @if ($errors->has($field_name))
                                                                        <span class="invalid feedback" role="alert">
                                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group">
                                                                    <?php
                                                                    $field_name = 'other_thing.' . $index . '.custom_nominal';
                                                                    ?>
                                                                    <input type="number" class="form-control @error($field_name) is-invalid @enderror" wire:model.debounce.500ms="{{ $field_name }}" placeholder="Nominal" min="0">
                                                                    @if ($errors->has($field_name))
                                                                    <span class="invalid feedback" role="alert">
                                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <a wire:click="remove_other_thing({{$index}})" href="#" class="btn btn-sm btn-danger place-self-center align-self-start"><i class="bi bi-trash"></i></a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                                $field_name = 'total_custom';
                                                $field_lable = label_case('Nominal DP');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = '';
                                            ?>
                                            <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                            <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:model.lazy="{{ $field_name }}" placeholder="{{$field_lable}}">
                                            @if ($errors->has($field_name))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="flex justify-between">
                    <div></div>
                    <div>
                        <button type="button" class="px-2 btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button wire:click.prevent="storeCustom" class="px-5 btn bg-red-400 text-white">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('page_css')
<style type="text/css">
    label {
        display: inline-block;
        margin-bottom: 0.2rem;
    }

    .form-group {
        margin-bottom: 0.3rem;
    }
</style>
@endpush
@push('page_scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('reload-page-create', function () {
            window.location.reload();
            toastr.success('Item Berhasil di ditambahkan')
        });
    });
</script>
@endpush