<div class=" px-3 py-2 grid grid-cols-4 gap-4 m-2 text-center no-underline">
    @foreach($groupkategori as $category)
    <div class="no-underline cursor-pointer p-2 w-full">
           <a class="w-full no-underline hover:no-underline"
                href="{{ route('products.add_products_by_categories',$category->id) }}" >
        <div class="justify-center items-center border-2 border-yellow-500 bg-white  px-2 py-3 rounded-lg transform transition duration-500 hover:scale-110">
            <div class="justify-center text-center items-center">
                <?php
                if ($category->image) {
                $image = asset(imageUrl() . $category->image);
                }else{
                $image = asset('images/logo.png');
                }
                ?>
                <img id="default_1" src="{{ $image }}" alt="images"
                class="h-16 w-16 object-contain mx-auto"/>
            </div>
            <div
            class="font-semibold text-gray-600 no-underline hover:text-red-600 leading-tight">
            {{ $category->category_name }}
            </div>
        </div>
        </a>
    </div>


    @endforeach

   
</div>


<script type="text/javascript">

  $(document).ready(function(){
            var Tombol = "<a href='{{ route('products.create-modal') }}' id='GroupKategori' class='btn btn-danger px-5'>{{ __('Back') }}</a>";
            // Tombol += "<button type='button' class='px-5 btn btn-primary' id='SimpanTambah'>{{ __('Create') }}</button>";
            $('#ModalFooterGroupKategori').html(Tombol);
            $("#FormTambah").find('input[type=text],textarea,select').filter(':visible:first').focus();
            $('#SimpanTambah').click(function(e){
                e.preventDefault();
                Tambah();
            });
            $('#FormTambah').submit(function(e){
                e.preventDefault();
                Tambah();
            });
        });



</script>