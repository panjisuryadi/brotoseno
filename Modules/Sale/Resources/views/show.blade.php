@extends('layouts.app')

@section('title', 'Sales Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Penjualan</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex flex-wrap align-items-center">
                        <div>
                            Invoice: <strong>{{ $sale->reference }}</strong>
                        </div>
                        <a target="_blank" class="btn btn-sm btn-secondary mfs-auto mfe-1 d-print-none" href="{{ route('sales.cetak', $sale->id) }}"><i class="bi bi-printer"></i> Cetak Nota
                        </a>
                        <a target="_blank" class="btn btn-sm btn-info mfe-1 d-print-none" href="{{ route('sales.pdf', $sale->id) }}">
                            <i class="bi bi-save"></i> Print PDF
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Company Info:</h5>
                    <div><strong>{{ settings()->company_name }}</strong></div>
                                <div>{{ settings()->company_address }}</div>
                       <div>Cabang: <strong>{{ Auth::user()->isUserCabang()?ucfirst(Auth::user()->namacabang()->name):'' }} </strong></div>
                                <div>Email: {{ settings()->company_email }}</div>
                                <div>Phone: {{ settings()->company_phone }}</div>
                            </div>

                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Customer Info:</h5>
                                <div><strong>{{ $customer->customer_name ?? 'Non Member' }}</strong></div>
                                <div>{{ $customer->address ?? '-' }}</div>
                                <div>Email: {{ $customer->customer_email ?? '-' }}</div>
                                <div>Phone: {{ $customer->customer_phone ?? '-' }}</div>
                            </div>

                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Invoice Info:</h5>
                                <div>Invoice: <strong>INV/{{ $sale->reference }}</strong></div>
                                <div>Date: {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}</div>
                                <div>
                                    Status: <strong>{{ $sale->status }}</strong>
                                </div> 

                                
                                
                            </div>

                        </div>

                        <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">
                            <table style="width: 100% !important;" class="table table-sm table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="width:5%;" class="align-middle">No</th>
                                    <th class="align-middle">Product</th>
                                    <th class="align-middle">Karat</th>
                                    <th class="align-middle"> Harga</th>
                                  
                                    <th class="align-middle">Sub Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sale->saleDetails as $item)
                                
                                    <tr>
                                        <td class="align-middle">
                                          {{ $loop->iteration }}
                                        </td>  
                                         <td class="align-middle">
                                            <span class="font-semibold text-gray-600 text-md"> 
                                             {{ $item->product_name }}
                                            </span>
                                           <br>
                                            <span class="font-semibold text-green-600">
                                                {{ $item->product_code }}
                                            </span>
                                            <div class="p-0 object-center">
                                                <?php
                                                
                                                    $image = $item->product->images;
                                                    $imagePath = empty($image)?url('images/fallback_product_image.png'):asset(imageUrl().$image);
                                                
                                                ?>
                                                <a href="{{ $imagePath }}" data-lightbox="{{ @$image }} " class="single_image">
                                                    <img src="{{ $imagePath }}" order="0" width="70" class="img-thumbnail"/>
                                                </a>
                                                 </div>
                                        </td>
                                          <td class="align-middle">
                                       {{ @$item->product->karat?->label }}    
                                        </td>

                                        <td class="align-middle">
                                       {{ @rupiah($item->price) }}    
                                        </td>
                                        
                                        <td class="align-middle">
                                       {{ rupiah( @$item->price) }}
                                        </td>
                                    </tr>




                                @endforeach

                          

                                   @if($sale->note)
                                    <tr>
                                        <td><div class="text-dark py-1 px-1 font-semibold">Note</div></td>
                                        <td colspan ='6'>
                                            <div class="text-dark py-1 px-1">
                                                {{ $sale->note }}
                                            </div>
                                        </td>
                                    </tr> 
                                   @endif 

                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-5 ml-md-auto">
                                <table style="width: 100% !important;" 
                                class="table md:table-sm lg:table-sm">
                                    <tbody>
                                 
                                        <tr>
                                            <td class="left text-gray-600">
                                                <div class="mt-1"> Total</div></td>
                                            <td class="right text-xl text-blue-500"><strong>{{ format_currency($sale->total_amount) }}</strong></td>
                                        </tr>
                                 
                                        <tr>
                                            <td class="left text-gray-600">
                                                <div class="mt-1">Diskon</div></td>
                                            <td class="right text-md text-blue-500"><strong>{{ format_currency($sale->discount_amount) }}</strong></td>
                                        </tr>
                                    
                                    @if(!empty($sale->salePayments))
                                    @foreach($sale->salePayments as $row)
                                        @php
                                            $bank = $row->bank->nama_bank ?? '';
                                        @endphp
                                        <tr>
                                            <td class="left text-gray-600">
                                                <div class="mt-1">{{ label_case($row->payment_method) . ' ' . $bank }}</div></td>
                                            <td class="right text-md text-blue-500"><strong>{{ format_currency($row->paid_amount) }}</strong></td>
                                        </tr>
                                    @endforeach
                                    @endif


                                    @if($sale->dp_payment)
                                    <tr>
                                        <td class="left text-gray-600">
                                            <div class="mt-1">DP</div></td>
                                        <td class="right text-md text-blue-500"><strong>{{ format_currency($sale->dp_nominal) }}</strong></td>
                                    </tr>
                                    @endif
                                 
                                    <tr>
                                        <td class="left text-gray-600">
                                            <div class="mt-1">Grand Total</div></td>
                                        <td class="right text-xl text-blue-500"><strong>{{ format_currency($sale->grand_total_amount) }}</strong></td>
                                    </tr>

                                    @if($sale->dp_payment)
                                    <tr>
                                        <td class="left text-gray-600">
                                            <div class="mt-1">Sisa Pembayaran</div></td>
                                        <td class="right text-md text-blue-500"><strong>{{ format_currency($sale->remain_amount) }}</strong></td>
                                    </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

        @push('page_css')
        <style type="text/css">
        @media (max-width: 767.98px) { 
         .table-sm th,
         .table-sm td {
             padding: .2em !important;
          }
        }
        </style>
        @endpush

