<div class="grid grid-cols-2 gap-2 m-2">
    
    <div class="px-2">
        @if(!empty($product->getBerlianShortLabelAttribute()))
        
        @else
            <table class="table table-sm">
                @foreach ($diamondCertifikatAttribute as $attribute)
                <tr>
                   <th>{{ $attribute->name }} </th>
                   <td>{{ $attribute->keterangan }}</td>
                </tr>
                @endforeach
            </table>
        @endif

    </div>
    <div class="px-2">
        <div class="flex justify-center text-center items-center">
            {!! \Milon\Barcode\Facades\DNS2DFacade::getBarCodeSVG($product->product_code,'QRCODE', 12, 12) !!}
        </div>
        <div class="flex justify-center text-center items-center">
            <a target="_blank" href="{{ route('products.print_sertifikat', $detail->id) }}" class="btn btn-danger btn-sm mt-3">
                <i class="bi bi-printer"></i>&nbsp; Sertifikat
            </a>
        </div>
    </div>
</div>