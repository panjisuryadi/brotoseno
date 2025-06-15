@extends('layouts.app')

@section('title', 'Sales Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('penerimaanbarangluar.index') }}">Penerimaan Barang Luar</a></li>
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
                            Invoice: <strong>{{@$detail->no_barang_luar}}</strong>
                        </div>
                        <a target="_blank" class="btn btn-sm btn-secondary mfs-auto mfe-1 d-print-none" href="#"><i class="bi bi-printer"></i> Print
                        </a>
                        <a target="_blank" class="btn btn-sm btn-info mfe-1 d-print-none" href="#">
                            <i class="bi bi-save"></i> Save
                        </a>
                    </div>
                    <div class="card-body">


<div class="flex justify-between px-3 py-2">
    
    <div class="w-50 mb-3 mb-md-0">
        <h5 class="mb-2 border-bottom pb-2">Company Info:</h5>
        <div><strong>{{ settings()->company_name }}</strong></div>
        <div>{{ settings()->company_address }}</div>
        <div>Cabang: <strong>{{ Auth::user()->isUserCabang()?ucfirst(Auth::user()->namacabang()->name):'' }} </strong></div>
        {{-- <div>Email: {{ settings()->company_email }}</div> --}}
        <div>Phone: {{ settings()->company_phone }}</div>
    </div>
    <div class="w-50 mb-3 mb-md-0 justify-end">
        
        <h5 class="mb-2 border-bottom pb-2">Invoice Info:</h5>
 <div>Date: {{ \Carbon\Carbon::parse($detail->date)->format('d M, Y') }}</div>
        <div class="text-lg">Customer: <strong>{{@$detail->customer_name}}</strong></div>
        <div>Invoice: <strong>{{@$detail->no_barang_luar}}</strong></div>
      
    </div>
    
</div>


                        <div class="row mb-6">
              
                  

        

                        </div>

                        <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">
                            <table style="width: 100% !important;" class="px-3 table table-sm table-striped">
                                <thead>
                                <tr>
                                    <th class="align-middle">Product</th>
                                    <th class="align-middle">Karat</th>
                                    <th class="align-middle">Berat</th>
                                  
                                    <th class="align-middle">Sub Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                 {{-- {{$detail}} --}}
                                    <tr>
                                     <td> {{@$detail->product_name}}</td>   
                                     <td> {{@$detail->karat?->label}}</td>   
                                     <td> {{@$detail->weight}} <small>Gram</small></td>   
                                     <td> {{format_uang(@$detail->nominal)}}</td>   
                                     

                                    </tr>

             


                                </tbody>
                            </table>
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
             padding: .4em !important;
          }
        }
        </style>
        @endpush

