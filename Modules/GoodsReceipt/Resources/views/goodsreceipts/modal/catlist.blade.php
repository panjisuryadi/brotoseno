
<div class="flex row px-1 py-1 grid grid-cols-2 gap-2 m-2 no-underline">
    <div class="text-left font-semibold">
        Tambah Produk untuk PO  {{$pembelian->code}}
    </div>

<div></div>
</div>

<div class="flex rowpx-1 py-1 grid grid-cols-2 gap-2 m-2 text-center no-underline">


    {{-- {{$pembelian->code}} --}}
    @foreach($listcategories as $category)

    
    <div class="no-underline cursor-pointer p-2 w-full">
           <a class="w-full no-underline hover:no-underline" id="openModalKategori"
                href="{{route(''.$module_name.'.add_products_by_categories',[
                                 'id'=>encode_id($category->id),
                                 'po'=>$pembelian->code]
                                 )}}">
        <div class="justify-center items-center border-2 border-yellow-500 bg-white  px-2 py-3 rounded-lg transform transition duration-500 hover:scale-110">
            <div class="justify-center text-center items-center">
                <?php
                if ($category->category[0]->image) {
                $image = asset(imageUrl() . $category->category[0]->image);
                }else{
                $image = asset('images/logo.png');
                }
                ?>
                <img id="default_1" src="{{ $image }}" alt="images"
                class="h-16 w-16 object-contain mx-auto"/>
            </div>
            <div
            class="font-semibold text-gray-600 no-underline hover:text-red-600 leading-tight">
            {{ $category->name }}
            </div>
        </div>
        </a>
    </div>


    @endforeach
</div>

<script type="text/javascript">
      $(document).ready(function(){
            var Tombol = "<a href='{{ route('products.create-modal') }}' id='GroupKategori' class='btn btn-warning px-5'>{{ __('Back') }}</a>";
            Tombol += "<button type='button' class='px-5 btn btn-danger' id='SimpanTambah'>{{ __('Create') }}</button>";
            $('#ModalFooterKategori').html(Tombol);
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