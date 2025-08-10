<a href="#" data-toggle="modal" data-target="#createModal" onclick="detail_print('{{$data['id']}}');" class="btn btn-outline-primary btn-sm">
    <i class="bi bi-printer"></i>&nbsp;Print
</a>    

<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Print Nota</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="/sale/print" method="post">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="px-0 py-2">
                    @php
                    $number = 0;
                    @endphp
                    <div class="col-span-2 px-2">
                        <div class="flex flex-row grid grid-cols-2 gap-1">
                            <div class="form-group">
                                <label for="password">Password<span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-9">
                                        <input type="password" id="password" name="password" class="form-control" >
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2 border-0 bg-transparent p-0" onclick="togglePassword()" tabindex="-1">
                                            <i id="eye-icon" class="bi bi-eye-fill text-secondary"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- <div class="input-group">
                                </div> -->
                            </div>
                        </div>
                        {{-- ///batas --}}
                    </div>
                    <button class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById("password");
        const icon = document.getElementById("eye-icon");

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye-fill");
            icon.classList.add("bi-eye-slash-fill");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash-fill");
            icon.classList.add("bi-eye-fill");
        }
    }

    function detail_print(id){
        $("#id").val(id);
    }
</script>