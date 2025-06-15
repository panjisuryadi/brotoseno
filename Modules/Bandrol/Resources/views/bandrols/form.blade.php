<!-- batass================================Create Modal============================= -->
<div class="modal fade" id="{{ $module_name }}CreateModal" tabindex="-1" role="dialog" aria-labelledby="{{ $module_name }}CreateModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $module_name }}CreateModalLabel font-semibold">
<i class="bi bi-grid-fill"></i> &nbsp;
                {{ __('Add') }} {{ $module_title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FormTambah" action="{{ route("$module_name.store") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

             <x-library.alert />
             <div class="flex flex-row grid grid-cols-2 gap-4">
                            <div class="form-group">
                                <?php
                                $field_name = 'name';
                                $field_lable = label_case('Keterangan');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="{{ $field_name }}"
                         placeholder="{{ $field_placeholder }}">
                                <span class="invalid feedback" role="alert">
                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                </span>

                            </div>
                 <div class="form-group">
                                <?php
                                $field_name = 'berat';
                                $field_lable = label_case($field_name);
                                $field_placeholder =$field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                <input class="form-control"
                                step="0.01"
                                 min="0"
                                placeholder="{{ $field_placeholder }}" type="number" name="{{ $field_name }}">
                                <span class="invalid feedback" role="alert">
                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                </span>

                            </div>
                        </div>
                    </div>
                <div id="ModalFooter" class="modal-footer"> </div>
            </form>
        </div>
    </div>
</div>
{{-- end modal ======================================================================--}}