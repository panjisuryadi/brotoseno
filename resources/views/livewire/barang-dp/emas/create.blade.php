<form wire:submit.prevent="store" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 gap-7">

        <div class="col-span-2 bg-transparent order-first pt-3">
            <div class="grid grid-cols-1 gap-y-3">

                <div class="flex flex-row grid grid-cols-3 gap-2">
                    <div class="form-group">
                        <?php
                        $field_name = 'barang_dp.date';
                        $field_lable = __('Tanggal');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'required';
                        ?>
                        <label for="{{ $field_name }}">{{ $field_placeholder }}</label>
                        <input type="date" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" placeholder="{{ $field_placeholder }}" wire:model="{{ $field_name }}" max="{{$hari_ini}}">
                        @if ($errors->has($field_name))
                        <span class="invalid feedback" role="alert">
                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                        </span>
                        @endif
                    </div>
                    @if (!auth()->user()->isUserCabang())
                    <div class="form-group">
                        <?php
                        $field_name = 'barang_dp.cabang_id';
                        $field_lable = __('cabang');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'required';
                        ?>
                        <label for="{{ $field_name }}">Cabang <span class="text-danger">*</span></label>
                        <select class="form-control select2 {{ $invalid }}" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                            <option value="" selected>Pilih Cabang</option>
                            @foreach(\Modules\Cabang\Models\Cabang::all() as $cabang)
                            <option value="{{ $cabang->id }}">{{ $cabang->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has($field_name))
                        <span class="invalid feedback" role="alert">
                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                        </span>
                        @endif
                    </div>
                    @endif

                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div class="card shadow-md">
                        <div class="card-header">
                            <h3 class="font-bold text-md uppercase">Identitas Pemilik</h3>
                        </div>
                        <div class="card-body">
                            <div class="grid grid-cols-1 gap-2">

                                <div class="form-group">
                                    <?php
                                    $field_name = 'barang_dp.owner_name';
                                    $field_lable = __('nama pemilik');
                                    $field_placeholder = Label_case($field_lable);
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = 'required';
                                    ?>
                                    <label for="{{ $field_name}}">Nama Pemilik <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="{{ $field_name}}" class="form-control {{ $invalid }}" name="{{ $field_name}}" placeholder="{{ $field_placeholder }}" wire:model="{{ $field_name }}">
                                    </div>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <?php
                                    $field_name = 'barang_dp.no_ktp';
                                    $field_lable = __('No KTP');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = 'required';
                                    ?>
                                    <label for="{{ $field_name}}">{{ $field_lable }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="Number" min="0" id="{{ $field_name}}" class="form-control {{ $invalid }}" name="{{ $field_name}}" placeholder="{{ $field_placeholder }}" wire:model="{{ $field_name }}">
                                    </div>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <?php
                                    $field_name = 'barang_dp.contact_number';
                                    $field_lable = __('no hp');
                                    $field_placeholder = Label_case($field_lable);
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = 'required';
                                    ?>
                                    <label for="{{ $field_name }}">No HP <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" id="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" placeholder="{{ $field_placeholder }}" wire:model="{{ $field_name }}">
                                    </div>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <?php
                                    $field_name = 'barang_dp.address';
                                    $field_lable = __('alamat');
                                    $field_placeholder = Label_case($field_lable);
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = 'required';
                                    ?>
                                    <label for="{{ $field_name }}">Alamat <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" placeholder="{{ $field_placeholder }}" wire:model="{{ $field_name }}">
                                    </div>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-md col-span-2">
                        <div class="card-header">
                            <h3 class="font-bold text-md uppercase">Detail Barang</h3>
                        </div>
                        <div class="card-body">
                            <div class="grid grid-cols-2 gap-2">
                                <div class="form-group">
                                    <div class="py-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="upload" id="up2" checked>
                                            <label class="form-check-label" for="up2">Upload</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="upload" id="up1">
                                            <label class="form-check-label" for="up1">Webcam</label>
                                        </div>
                                    </div>
                                    <div id="upload2" style="display: none !important;" class="align-items-center justify-content-center" wire:ignore>
                                        <x-library.livewire.webcam />
                                    </div>
                                    <div id="upload1" style="display: block !important;" class="align-items-center justify-content-center" wire:ignore>
                                        <div class="dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone">
                                            <div class="dz-message" data-dz-message>
                                                <i class="text-red-800 bi bi-cloud-arrow-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('webcam_image'))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first('webcam_image') }}.</small class="text-danger">
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <div class="form-group">
                                        <?php
                                        $field_name = 'product.karat_id';
                                        $field_lable = label_case('karat');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                        ?>
                                        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                        <select class="form-control {{ $invalid }}" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                            <option value="" selected>Pilih Karat</option>
                                            @foreach($karats as $karat)
                                            <option value="{{ $karat->id }}">{{ $karat->label }}</option>
                                            @if (count($karat->children))
                                            @foreach ($karat->children as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $karat->label }} - {{ $kategori->name }}</option>
                                            @endforeach
                                            @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        $field_name = 'product.berat_emas';
                                        $field_lable = label_case('berat emas');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                        ?>
                                        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                        <input class="form-control {{ $invalid }}" type="number" name="{{ $field_name }}" min="0" step="0.001" id="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{ $field_placeholder }}">
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







            </div>
            <div class="card shadow-md col-span-2">
                <div class="card-header">
                    <h3 class="font-bold text-md uppercase">Detail Pembayaran</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-3 gap-3">
                        <div class="form-group">
                            <?php
                            $field_name = 'barang_dp.nominal';
                            $field_lable = label_case('nominal');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = "required";
                            ?>
                            <label class="text-left text-md mb-0" for="{{ $field_name }}">{{ $field_lable }}<small class="text-danger">*</small></label>
                            <input wire:model="{{ $field_name }}" type="number" name="{{$field_name}}" class="form-control text-md {{ $invalid }}" placeholder="{{$field_placeholder}}">
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>
                        <div class="flex justify-center items-center">
                            <span class="text-2xl font-extrabold">{{ $this->nominal_text }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="form-group">
                            <?php
                            $field_name = 'tipe_pembayaran';
                            $field_lable = label_case('tipe_pembayaran');
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = "required";
                            ?>
                            <label class="mb-0" for="{{ $field_name }}">Tipe Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-control {{ $invalid }}" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                <option value="" selected disabled>Pilih {{ $field_lable }}</option>
                                <option value="cicil">Cicil</option>
                                <option value="jatuh_tempo">Jatuh Tempo</option>
                            </select>
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>

                        @if ($this->tipe_pembayaran == 'cicil')
                        <div id="cicilan" class="form-group">
                            <?php
                            $field_name = 'cicil';
                            $field_lable = __('cicil');
                            $field_placeholder = Label_case($field_lable);
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = '';
                            ?>
                            <label class="mb-0" for="{{ $field_name }}"> {{ $field_placeholder }} <span class="text-danger">*</span></label>
                            <select class="form-control select2 {{ $invalid }}" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                <option value="" selected disabled>Jumlah {{ $field_name }}an</option>
                                <option value="2">2 kali</option>
                                <option value="3">3 kali </option>
                            </select>
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>
                        @elseif ($this->tipe_pembayaran == 'jatuh_tempo')
                        <div id="jatuh_tempo" class="form-group">
                            <?php
                            $field_name = 'detail_cicilan.0';
                            $field_lable = __('Tanggal Jatuh Tempo');
                            $field_placeholder = Label_case($field_lable);
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            ?>
                            <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                            <input type="date" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" id="{{$field_name}}_input" wire:model="{{ $field_name }}" min="{{ $hari_ini }}" placeholder="{{ $field_placeholder }}">
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>
                        @endif
                    </div>

                    @if ($tipe_pembayaran == 'cicil' && $cicil != '')
                    <div class="card p-6 bg-gray-100 rounded-lg shadow-md">
                        <div class="text-md font-bold mb-4">Input Tanggal Cicilan</div>

                        @for ($i = 1; $i <= $cicil; $i++) 
                        <div class="mb-4">
                            <label for="cicilan{{ $i }}" class="text-gray-600 text-sm mb-2 block">Cicilan Ke {{ $i }}</label>
                            <div class="relative rounded-lg">
                                <?php
                                $field_name = 'detail_cicilan.' . $i;
                                $field_lable = __('Tanggal Jatuh Tempo');
                                $field_placeholder = Label_case($field_lable);
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                ?>
                                <input type="date" id="{{ $field_name }}" name="{{ $field_name }}" wire:model="{{ $field_name }}" wire:change="resetDetailCicilanAfterwards({{$i}})" min="{{ $this->getMinCicilDate($i)}}" class="block w-full py-2 px-3 text-gray-800 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 {{ $invalid }}" />

                                @if ($errors->has($field_name))
                                <span class="invalid feedback" role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                </span>
                                @endif
                            </div>
                    </div>
                    @endfor
                </div>
                @endif
            </div>
        </div>

    </div>







    </div>

    <div class="grid grid-cols-2 gap-4 m-2 mt-0 mb-2">

        <div class="form-group">
            <label class="mb-0" for="barang_dp.note">Keterangan <span class="text-danger">*</span></label>
            <div class="input-group">
                <textarea wire:model="barang_dp.note" name="barang_dp.note" id="barang_dp.note" class="form-control" cols="30" rows="6"></textarea>
            </div>
            @if ($errors->has('barang_dp.note'))
            <span class="invalid feedback" role="alert">
                <small class="text-danger">{{ $errors->first('barang_dp.note') }}.</small class="text-danger">
            </span>
            @endif
        </div>
    </div>


    <div class="flex justify-between px-3 pb-2 border-bottom">
        <div>
        </div>
        <div class="form-group">

            <a class="px-5 btn btn-danger" href="{{ route("goodsreceipt.index") }}">
                @lang('Cancel')</a>
            <button id="SimpanTambah" type="submit" class="px-4 btn btn-primary">@lang('Save') <i class="bi bi-check"></i></button>
        </div>
    </div>




    </div>
    </div>
</form>