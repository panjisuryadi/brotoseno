<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .invoice {
            width: 100%;
            margin: 0px auto;

            padding: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            color: red; /* Change text color to red */
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            color: red; /* Change text color to red */
        }
        .invoice-details p {
            margin: 0;
        }
        .invoice-items {
            margin-top: 0px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
.table1 table {
            width: 100%;
            border-collapse: collapse;
        }

  .table1 th, td {
            border: none;

        }


        th, td {
            border: 1px solid red; /* Change border color to red */
            padding: 8px;
            text-align: left;
            font-size: 11pt !important;
            color: red; /* Change text color to red */
        }
        th{
            text-transform: uppercase;
        }
        .total {
            margin-top: 20px;
            text-align: right;
            color: red; /* Change text color to red */
        }
    </style>
</head>
<body>
    <div class="invoice">

<div class="invoice-items">

<table class="table1" style='width:100%; border: none !important; font-size:14pt; font-family:calibri; border-collapse: collapse;' border="0">
    <td class="table1" width='60%' align='left' style='border: none !important;padding-right:80px; vertical-align:top'>
        <span style='font-size:22pt'><b>{{ settings()->company_name }}</b></span></br>
         {{ settings()->company_email }}, {{ settings()->company_phone }}
                <br>{{ settings()->company_address }}
    </td>
    <td style='border: none !important;vertical-align:top' width='40%' align='left'>
       
        Tanggal :{{ tanggal($detail->date)}}</br>
        No Retur :{{ $detail->retur_no}}</br>

        Nama Sales: <span style="font-size:16pt;font-weight: bold;">{{$detail->sales->name}}</span>

       </br>
      
    </td>
</table>
<p></p>


<table class="invoice-items">
    <thead>
        <tr>
            <th>No</th>
            <th>Karat</th>
            <th>Berat Bersih</th>
            
        </tr>
    </thead>
    <tbody>
        @php
        $no = 1;
        $totalPrice = 0;
        $totalQty = 0;
        $total = 0;
        @endphp
        @forelse ($detail->detail as $row)
        <tr>

            <td>{{ $no++ }}</td>
          <td>{{ $row->karat->label }}</td>
          <td>{{ formatBerat($row->weight) }} gr</td>

        </tr>
        ​
     
        @empty
        <tr>
            <td colspan="5" class="text-center">Tidak ada data</td>
        </tr>
        @endforelse


    </tbody>
  
</table>
<hr style="color: red;">
<br>
<br>
<br>
<br>
<br>
<br>

        <table style='width:100%!important; font-size:12pt;' cellspacing='2'>
            <tr>
                <td style="border: none !important;text-align: center;" align='center'>
                    Diterima Oleh,
                </br></br>
                </br></br>
                </br></br>
                <u>(..................................................)</u>
                </td>
                <td style='border: none !important; padding:5px; text-align:left; width:30%'></td>
                <td style="text-align: center; border: none !important;" align='center'>Hormat Kami,<br>
                <span style='font-size:12pt'><b>{{ settings()->company_name }}</b></span></br>

                </br>
                </br></br>
                </br></br>
                <u>(...................................................)</u>
                </td>
            </tr>
        </table>






        </div>





