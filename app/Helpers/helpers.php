<?php

use Illuminate\Support\Str;
use Carbon\Carbon;





/*
 *
 * fielf_required
 * Show a * if field is required
 *
 * ------------------------------------------------------------------------
 */
if (!function_exists('fielf_required')) {

    /**
     * Prepare the Column Name for Lables.
     */
    function fielf_required($required)
    {
        $return_text = '';

        if ($required != '') {
            $return_text = '<span class="text-danger">*</span>';
        }

        return $return_text;
    }
}




/*
 *
 * Encode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (!function_exists('encode_id')) {

    /**
     * Prepare the Column Name for Lables.
     */
    function encode_id($id)
    {
        $hashids = new Hashids\Hashids(config('app.salt'), 8, 'abcdefghijklmnopqrstuvwxyz1234567890');
        $hashid = $hashids->encode($id);

        return $hashid;
    }
}

/*
 *
 * Decode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (!function_exists('decode_id')) {

    /**
     * Prepare the Column Name for Lables.
     */
    function decode_id($hashid)
    {
        $hashids = new Hashids\Hashids(config('app.salt'), 8, 'abcdefghijklmnopqrstuvwxyz1234567890');
        $id = $hashids->decode($hashid);

        if (count($id)) {
            return $id[0];
        } else {
            abort(404);
        }
    }
}


if (!function_exists('qrCode')) {

     function qrCode($content)
    {

    }
}


function generateQRCode($content)
{
    /**
     * result in data uri
     */

}







/*
 *
 * label_case
 *
 * ------------------------------------------------------------------------
 */
if (!function_exists('label_case')) {

    /**
     * Prepare the Column Name for Lables.
     */
    function label_case($text)
    {
        $order = ['_', '-'];
        $replace = ' ';

        $new_text = trim(\Illuminate\Support\Str::title(str_replace('"', '', $text)));
        $new_text = trim(\Illuminate\Support\Str::title(str_replace($order, $replace, $text)));
        $new_text = preg_replace('!\s+!', ' ', $new_text);

        return $new_text;
    }
}

if (!function_exists('imageUrl')) {
    function imageUrl()
    {
        $return_text = '';
        if (config('app.env') == 'production') {
            $return_text = 'storage/uploads/';
        }else{
            $return_text = 'storage/uploads/';
        }
        return $return_text;
    }
}




if (!function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}


if (!function_exists('logo')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function logo()
    {
        $return_text = '';
        if (settings()->site_logo) {
            $return_text = asset("storage/logo/" .settings()->site_logo);
        }else{
            $return_text = asset('images/logo-white.png');
        }
        return $return_text;
    }
}
if (!function_exists('slogo')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function slogo()
    {
        $return_text = '';
        if (settings()->site_logo) {
            $return_text = asset("storage/logo/" .settings()->site_logo);
        }else{
            $return_text = asset('images/logo2.png');
        }
        return $return_text;
    }
}



if (!function_exists('date_today')) {

    function date_today()
    {
        $str = \Carbon\Carbon::now()->isoFormat('dddd, LL');

        return $str;
    }
}



if (!function_exists('timestamp')) {

    function timestamp($data)
    {

        $diff = Carbon::now()->diffInHours($data);
            if ($diff < 25) {
                return \Carbon\Carbon::parse($data)->diffForHumans();
            } else {
                return \Carbon\Carbon::parse($data)->isoFormat('L');
            }

    }
}

if (!function_exists('waktu')) {

    function waktu($data)
    {

        return \Carbon\Carbon::parse($data)->isoFormat('L');

    }
}



if (!function_exists('uname')) {

    function uname($string) {
        return preg_replace('/(\S+) (\S{2}).*/', '$1$2', strtolower($string)) . random_int(0, 100);

    }
}


if (!function_exists('randomEmail')) {
    function randomEmail($string)
    {
      //$name = Str::random(8);
        $name = uname($string);
        $domain = ['gmail.com', 'yahoo.com', 'hotmail.com'];

        $randomDomain = $domain[array_rand($domain)];

        return $name . '@' . $randomDomain;
    }

}








if (!function_exists('uploadFile')) {

 function uploadFile($file, $path, $existingPath = '', $filename = '')
    {
        try {
            if ($existingPath != '' && file_exists($existingPath)) {
                unlink($existingPath);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($filename == '') {
            // generate filename with date original and extention
            $filename = date('YmdHis') . '_' . $file->getClientOriginalName();
        }
        $file->move($path, $filename);
        $data = (object) [
            'path' => $path,
            'filename' => $filename,
            'extension' => $file->getClientOriginalExtension(),
            'url' => $path . '/' . $filename,
        ];
        return $data;
    }


}



if (!function_exists('settings')) {
    function settings() {
        $settings = cache()->remember('settings', 24*60, function () {
            return \Modules\Setting\Entities\Setting::firstOrFail();
        });

        return $settings;
    }
}




if (!function_exists('format_currency')) {
    function format_currency($value, $format = true) {
        if (!$format) {
            return $value;
        }

        $settings = settings();
        $position = $settings->default_currency_position;
        $symbol = $settings->currency?->symbol;
        $decimal_separator = $settings->currency?->decimal_separator;
        $thousand_separator = $settings->currency?->thousand_separator;

        if ($position == 'prefix') {
            $formatted_value = $symbol . number_format((float) $value, 2, $decimal_separator, $thousand_separator);
        } else {
            $formatted_value = number_format((float) $value, 2, $decimal_separator, $thousand_separator) . $symbol;
        }

        return $formatted_value;
    }
}






if (!function_exists('make_reference_id')) {
    function make_reference_id($prefix, $number) {
        $padded_text = $prefix . '-' . str_pad($number, 5, 0, STR_PAD_LEFT);

        return $padded_text;
    }
}





if (!function_exists('statusProduk')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function statusProduk($required)
    {
        // status barang baru masuk
        $return_text = '';
        if ($required == 0) {
             $return_text = '<div class="rounded-lg bg-blue-400 px-2 py-1 uppercase items-center text-center text-white small">Purchase</div>';

        }

        //status Barang Aktif
        elseif ($required == 1){

             $return_text = '<div class="rounded-lg bg-blue-400 px-2 py-1 uppercase items-center text-center text-white small">Aktif</div>';



        }
        //status belum di approve
        elseif ($required == 2){
             $return_text = '<div class="rounded-lg bg-yellow-400 px-2 py-1 uppercase items-center text-center text-white text-xs small">Need Approve</div>';

        }
        //status barang di Approve
        elseif ($required == 3){

             $return_text = '<div class="rounded-lg bg-green-400 px-2 py-1 uppercase items-center text-center text-white small">Approve</div>';

        }

        //status barang Rejected
        elseif ($required == 4){

             $return_text = '<div class="rounded-lg bg-red-500 px-2 py-1 uppercase items-center text-center text-white small">Rejected</div>';

        }
        return $return_text;
    }
}













if (!function_exists('statusTrackingProduk')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function statusTrackingProduk($required)
    {
        // status barang baru masuk
        $return_text = '';
        if ($required == 0) {

             $return_text = '<span class="rounded-lg bg-blue-400 px-1 uppercase items-center text-center text-white small">Purchase</span>';

        }

        //status Barang Aktif
        elseif ($required == 1){

             $return_text = '<span class="rounded-lg bg-blue-400 px-1 uppercase items-center text-center text-white small">Aktif</span>';



        }
        //status belum di approve
        elseif ($required == 2){

             $return_text = '<span class="rounded-lg bg-yellow-400 px-1 uppercase items-center text-center text-white text-xs small">Need Approve</span>';



        }
        //status barang di Approve
        elseif ($required == 3){

             $return_text = '<span class="rounded-lg bg-green-400 px-1 uppercase items-center text-center text-white small">Approve</span>';

        }

        //status barang Rejected
        elseif ($required == 4){

             $return_text = '<span class="rounded-lg bg-red-500 px-1 uppercase items-center text-center text-white small">Rejected</span>';

        }

        //status barang Rejected
        elseif ($required == 5){

             $return_text = '<span class="rounded-lg bg-yellow-900 px-1 uppercase items-center text-center text-white small">Reparasi</span>';

        }



        return $return_text;
    }
}




if (!function_exists('pstatus')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function pStatus($required)
    {
        // status barang baru masuk
        $return_text = '';
        if ($required == 0) {
             $return_text = 'Purchase';
         }
        //status Barang Aktif
        elseif ($required == 1){
             $return_text = 'Aktif';
        }
        //status belum di approve
        elseif ($required == 2){
             $return_text = 'Need Approve';
        }
        //status barang di Approve
        elseif ($required == 3){
             $return_text = 'Approve';
        }

        //status barang Rejected
        elseif ($required == 4){
             $return_text = 'Rejected';
        }
        return $return_text;
    }
}



if (!function_exists('bpstts')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function bpstts($required)
    {
        $return_text = 'btn-outline-success';
        if ($required == 'pending') {
             $return_text = 'btn-outline-success';
         }

        elseif ($required == 'cuci'){
             $return_text = 'btn-outline-info';
        }

        elseif ($required == 'masak'){
             $return_text = 'btn-outline-warning';
        }

        elseif ($required == 'rongsok'){
             $return_text = 'btn-outline-primary';
        }

        elseif ($required == 'second'){
             $return_text = 'btn-outline-danger';
        }
        return $return_text;
    }
}






 if (!function_exists('tgljam')) {
        function tgljam($value)
        {

        $date = '';
        $date = \Carbon\Carbon::parse($value);
        $tgl = $date->format('d/m/Y');
        $jam = $date->format('H:i');

         return $date = '<div class="text-center"><span class="text-gray-500">'. $tgl.'</span> | <span class="ml-1 text-jsr">'. $jam.'</span></div>';

         }
      }



 if (!function_exists('shortdate')) {
        function shortdate($value)
        {

        $date = '';
        $date = \Carbon\Carbon::parse($value);
        $tgl = $date->format('d/m/Y');

         return $date = ''. $tgl.'';

         }
      }


      if (!function_exists('tgl')) {
        function tgl($value)
        {

        $date = '';
        $date = \Carbon\Carbon::parse($value);
        $tgl = $date->isoFormat('dddd, LL');
        $jam = $date->format('H:i');

         return $date = ''. $tgl.' | '. $jam.'';

         }
      }

   if (!function_exists('tanggal2')) {
        function tanggal2($value)
        {
        $date = '';
        $date = \Carbon\Carbon::parse($value);
        $tgl = $date->isoFormat('dddd, LL');
        $jam = $date->format('H:i');
         return $date = ''. $tgl.' ';

         }
      }





if (!function_exists('statusPo')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function statusPo($required)
    {
        // status barang baru masuk
        $return_text = '';
        if ($required == 0) {
             $return_text = '<div class="w-full btn btn-sm text-xs btn-outline-secondary items-center text-center">Uncompleted</div>';

        }

        //status Barang Aktif
        elseif ($required == 1){
             $return_text = '<div class="w-full btn btn-sm text-xs btn-outline-success items-center text-center">Aktif</div>';

        }

          //status Barang Aktif
        elseif ($required == 2){
             $return_text = '<div class="w-full btn btn-sm text-xs btn-outline-primary items-center text-center">Completed</div>';

        }

        //status barang di kembalikan
        elseif ($required == 3){
             $return_text = '<div class="w-full btn btn-sm text-xs btn-outline-danger items-center text-center">Di Retur</div>';

        }

        return $return_text;
    }
}



if (!function_exists('draf')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function draf($required)
    {
        // status barang baru masuk
       // $return_text = '';
        if ($required == 1) {
             $return_text = '<div class="w-full btn btn-sm text-xs btn-outline-warning items-center text-center">Draft</div>';

        }else{


         $return_text = '<div class="w-full btn btn-sm text-xs btn-danger-secondary items-center text-center">Terkirim</div>';

        }

        return $return_text;
    }
}


if (!function_exists('keBulan')) {
    function keBulan($number)
    {
        $search_array = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
        $replace_array = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $bn_number = str_replace($search_array, $replace_array, $number);
        return $bn_number;
    }
}



if (!function_exists('tanggal')) {
    date_default_timezone_set("Asia/Jakarta");
        function tanggal($tgl, $tampil_hari=true, $tampil_jam = false){

           $nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
           $nama_bulan = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

           $tahun = substr($tgl,0,4);
           $bulan = $nama_bulan[(int)substr($tgl,5,2)];
           $tanggal = substr($tgl,8,2);

           $text = "";

           if($tampil_hari){
              $urutan_hari = date('w', mktime(0,0,0, substr($tgl,5,2), $tanggal, $tahun));
              $hari = $nama_hari[$urutan_hari];
              $text .= $hari.", ";
           }

           $text .= $tanggal ." ". $bulan ." ". $tahun;

           if($tampil_jam) {
                $text .= " " . date('H:i:s', strtotime($tgl));
           }

           return $text;
        }

}




if(! function_exists('rupiah')) {

    function rupiah($number,$dec=0,$trim=false){
      if($trim){
        $parts = explode(".",(round($number,$dec) * 1));
        $dec = isset($parts[1]) ? strlen($parts[1]) : 0;
       }
      $formatted = number_format($number,$dec);
      return $formatted;
    }


}



if (!function_exists('array_merge_numeric_values')) {
    function array_merge_numeric_values() {
        $arrays = func_get_args();
        $merged = array();
        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                if (!is_numeric($value)) {
                    continue;
                }
                if (!isset($merged[$key])) {
                    $merged[$key] = $value;
                } else {
                    $merged[$key] += $value;
                }
            }
        }

        return $merged;
    }
}

if (!function_exists('formatWeight')) {
    function formatWeight($weight) {
        if (substr($weight, -1) === '.') {
            $weight = substr($weight, 0, -1);
        }
        return $weight . ' gr';
    }
}

if (!function_exists('formatBerat')) {
    function formatBerat($weight) {
        $weight = number_format(round($weight, 3), 3, '.', '');
        $weight = rtrim($weight, '0');
        $weight = formatWeight($weight);
        return $weight;
    }
}


if (!function_exists('format_uang')) {
    function format_uang($angka) {
       $hasil = number_format($angka,0,',','.');
       return 'Rp. ' .$hasil;
    }
}



if (!function_exists('penyebut')) {

function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = penyebut($nilai - 10). " Belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
        }
        return $temp;
    }

}



if (!function_exists('terbilang')) {
   function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }
         return $hasil;
    }

}



if (!function_exists('getipadress')) {
    function getipadress()
    {
        try {
            $response = Http::get('https://httpbin.org/ip');
            $data = $response->json();
            return $data['origin'] ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
