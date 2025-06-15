{{-- {{ $detail }} --}}

{{-- {"id":44,"date":"2023-10-13","reference":"SL-00001","customer_id":2,"cabang_id":1,"user_id":1,"customer_name":"Amalia Sakura Usamah","tax_percentage":0,"tax_amount":0,"discount_percentage":0,"discount_amount":0,"shipping_amount":0,"total_amount":2000000,"paid_amount":20000,"due_amount":0,"status":"Completed","payment_status":"partial","payment_method":"cicilan","note":null,"cicilan":null,"tipe_bayar":"cicilan","tgl_jatuh_tempo":"2024-06-15","created_at":"2023-10-13T02:14:44.000000Z","updated_at":"2023-10-13T02:14:44.000000Z" --}}



<div class="py-2 px-4">
    
<div class="flex justify-between mt-3 mb-6">
        <h1 class="text-lg font-bold">Invoice</h1>
        <div class="text-gray-700">
            <div>Date: {{ tanggal($detail->date) }}</div>
            <div>Invoice #:{{ @$detail->reference }}</div>
        </div>
    </div>

<table class="w-full mb-8 poppins">
        <thead>
            <tr>
                <th class="text-left font-bold text-gray-700">
               Customer</th>
                <th class="text-right font-semibold text-gray-800">
               {{ @$detail->customer->customer_name }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-left text-gray-700"> Cabang</td>
                <td class="text-right text-gray-700">  {{ @$detail->cabang->name }} </td>
            </tr>
           
            
        </tbody>
        <tfoot>
            <tr>
                <td class="text-left text-gray-700">Grand Total</td>
                <td class="text-right font-bold text-xl text-gray-700">{{ rupiah(@$detail->total_amount) }}</td>
            </tr>
        </tfoot>
    </table>


</div>

















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

