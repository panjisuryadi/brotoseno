<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
          {{ session('message') }}
        </div>
    @endif
<form wire:submit.prevent="store">
            @csrf
<div class="pt-2 flex justify-between">
    <div></div>
    <div class="form-group">
       lkklklk
    </div>
</div>





<div class="flex justify-between">
 <div class="add-input w-full mx-auto flex flex-row grid grid-cols-7 gap-2">
             <div class="form-group">
                        <?php
                        $field_name = 'code.0';
                        $field_lable = label_case('code');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                       {{--  {{ html()->label($field_lable, $field_name)->class('mb-0') }} --}}
                           {{ html()->text($field_name)->placeholder($field_placeholder)
                          ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}

                 @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                    </div>



                    <div class="form-group">
                        <?php
                        $field_name = 'no_invoice.0';
                        $field_lable = label_case('no_invoice');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                      {{--   {{ html()->label($field_lable, $field_name)->class('mb-0') }} --}}
                           {{ html()->text($field_name)->placeholder($field_placeholder)
                          ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}

                 @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                    </div>

                      <div class="form-group">
                        <?php
                        $field_name = 'qty.0';
                        $field_lable = label_case('qty');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                           {{ html()->number($field_name)->placeholder($field_placeholder)
                          ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}

                 @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                    </div>

                      <div class="form-group">
                        <?php
                        $field_name = 'qty_diterima.0';
                        $field_lable = label_case('qty_diterima');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                           {{ html()->number($field_name)->placeholder($field_placeholder)
                          ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}

                 @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                    </div>


                      <div class="form-group">
                        <?php
                        $field_name = 'berat_barang.0';
                        $field_lable = label_case('berat_barang');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                           {{ html()->number($field_name)->placeholder($field_placeholder)
                          ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}

                 @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                    </div>


            <div class="form-group">
                        <?php
                        $field_name = 'berat_real.0';
                        $field_lable = label_case('berat_real');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                           {{ html()->number($field_name)->placeholder($field_placeholder)
                          ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}

                 @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                    </div>


   <div class="form-group">
                        <?php
                        $field_name = 'pengirim.0';
                        $field_lable = label_case('pengirim');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                           {{ html()->number($field_name)->placeholder($field_placeholder)
                          ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}

                 @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                    </div>


            </div>


            <div class="px-1">


 <button class="btn text-white text-xl btn-info btn-md"
                    wire:click.prevent="add({{$i}})"><i class="bi bi-plus"></i>
                   </button>



            </div>

        </div>

        @foreach($inputs as $key => $value)
        <div class="flex justify-between">
             <div class="add-input w-full mx-auto flex flex-row grid grid-cols-7 gap-2">

                    <div class="form-group">
                        <?php
                        $field_name = 'code.'.$value.'';
                        $field_lable = label_case('code');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                           {{ html()->text($field_name)->placeholder($field_placeholder)
                          ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}

                      @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                    </div>


                       <div class="form-group">
                        <?php
                        $field_name = 'no_invoice.'.$value.'';
                        $field_lable = label_case('no_invoice');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                           {{ html()->text($field_name)->placeholder($field_placeholder)
                          ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}

                      @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                    </div>


                    <div class="form-group">
                        <?php
                        $field_name = 'qty.'.$value.'';
                        $field_lable = label_case('qty');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                           {{ html()->number($field_name)->placeholder($field_placeholder)
                          ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}
@error('qty.'.$value)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                    </div>

                    <div class="form-group">
                        <?php
                        $field_name = 'qty_diterima.'.$value.'';
                        $field_lable = label_case('qty_diterima');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                           {{ html()->number($field_name)->placeholder($field_placeholder)
                          ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}

                      @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                    </div>


                          <div class="form-group">
                        <?php
                        $field_name = 'berat_barang.'.$value.'';
                        $field_lable = label_case('berat_barang');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                           {{ html()->number($field_name)->placeholder($field_placeholder)
                          ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}

                      @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                    </div>
                          <div class="form-group">
                        <?php
                        $field_name = 'berat_real.'.$value.'';
                        $field_lable = label_case('berat_real');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                           {{ html()->number($field_name)->placeholder($field_placeholder)
                          ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}

                      @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                    </div>


                     <div class="form-group">
                        <?php
                        $field_name = 'pengirim.'.$value.'';
                        $field_lable = label_case('pengirim');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                           {{ html()->number($field_name)->placeholder($field_placeholder)
                          ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}

                      @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                    </div>







            </div>


                    <div class="px-1">
                        <button class="btn text-white text-xl btn-danger btn-md"
                        wire:click.prevent="remove({{$key}})"><i class="bi bi-trash"></i>
                        </button>
                    </div>
            </div>
        @endforeach


<div class="pt-2 border-t flex justify-between">
    <div></div>
    <div class="form-group">
        <a class="px-5 btn btn-danger"
            href="{{ route("goodsreceipt.index") }}">
        @lang('Cancel')</a>




<button class="px-5 btn btn-success" wire:target="save" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="save">
                >@lang('Save')
                </span>
                <span wire:loading wire:target="save" class="text-center">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
                </span>
                </button>



    </div>
</div>


    </form>
</div>