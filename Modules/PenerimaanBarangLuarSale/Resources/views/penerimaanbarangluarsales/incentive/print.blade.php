<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Insentif {{$incentive->sales->name}}</title>
    <style type="text/css">

        body {
            font-family: Helvetica,sans-serif;
        }
        h4,h5{
            margin: 5px;
        }

        .header {
            text-align: center;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Memberikan tinggi sebesar viewport height untuk membuatnya vertikal di tengah */
            margin-bottom: 20px;
        }

        .img-container {
            position: absolute;
            top: 0;
            left: 37%;
            align-items: center;
            max-width: 200px;
        }

        .img {
            width: 100%;
            height: auto;
            margin-left: auto;
        }
        .text{
            margin-top: 120px;
        }

        .nota-title{
            text-align: center;
        }

        .penerima {
            float: right;
            margin-top: 150px;
            margin-right: 100px;
            font-weight: bold;
        }

        
    </style>
</head>

<body>
    <header class="header">
            <div class="img-container">
                <img class="img" src="{{public_path('images/logo.png')}}" alt="Image">
            </div>
            <div class="text">
                <h4>JSR DIAMONOND & JEWERLY</h4>
                Jl. Kamboja Gg. Tewaz V No. 25 Tanjung Karang Pusat Telp. 0813-6994-6343
                <br>
                <h5>Bandar Lampung</h5>
            </div>
        </header>
    <hr>
    <table width="100%">
        <thead>
        <h3 class="nota-title">NOTA PENERIMAAN INSENTIF</h3>
        </thead>
        <tr>
            <td width="100%">
                <table width="100%">
                    <tr>
                        <td width="30%">Tanggal</td>
                        <td width="2%">:</td>
                        <td><b>{{ now() }}</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Sales</td>
                        <td width="2%">:</td>
                        <td><b>{{$incentive->sales->name}}</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Bulan</td>
                        <td width="2%">:</td>
                        <td><b>{{$month}}</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Nominal</td>
                        <td width="2%">:</td>
                        <td><b>Rp. {{number_format($incentive->incentive)}}</b></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <p class="penerima">Penerima</p>
</body>

</html>