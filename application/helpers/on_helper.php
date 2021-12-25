<?php 
function jam($tanggal){
    if(empty($tanggal)) {
        return "";
    }
    $x = explode(" ", $tanggal);
    return "Pukul ".$x[1]. " WITA";
}

function ye($a){
    if ($a == "0") {
        $b =  "<b class = 'text-danger'>0</b>";
    } else {
        $b =  "<b class = 'text-primary'>".uang($a)."</b>";
    }
    return $b;
}

function flipdate($tanggal){
    if(empty($tanggal)) {
        return "";
    }
    $tanggal = substr($tanggal, 0,10);
    $x = explode("-", $tanggal);
    $x[0] = isset($x[0])?$x[0]:"0";
    $x[1] = isset($x[1])?$x[1]:"0";
    $x[2] = isset($x[2])?$x[2]:"0";
    return $x[2]."-".$x[1]."-".$x[0];
}

function save_date_time($tanggal){
    if(empty($tanggal)) {
        return "";
    }
    $tanggal = substr($tanggal, 0,10);
    $x = explode("-", $tanggal);
    $x[0] = isset($x[0])?$x[0]:"0";
    $x[1] = isset($x[1])?$x[1]:"0";
    $x[2] = isset($x[2])?$x[2]:"0";
    return $x[2]."-".$x[1]."-".$x[0];
}

function numb($x){

    if ($x == "100") {
        $y = "100";
    } else {
        $y = number_format($x, 1,",",".");

    }

    if ($y== "nan" or $y == "inf") {
        $h = " ";
    } else {
        $h = $y;
    }

    return $h;
}

function umur($tgl_lahir){

    $birthDt = new DateTime($tgl_lahir);
    $today = new DateTime('today');
    $y = $today->diff($birthDt)->y;
    $m = $today->diff($birthDt)->m;

    $d = $today->diff($birthDt)->d;
    if ($y == 0 and $m == 0 and $d == 0) {
       return "< 24 jam";
   } elseif ($y == 0 and $m == 0 ) {
       return $d . " hari";;
   } elseif ($y == 0) {
    return $m . " bulan " . $d . " hari";;
} elseif ($m == 0) {
    return $y . " tahun " . $d . " hari";;
}  elseif ($y > 5) {
 return $y. " tahun";
} else {
    return $y . " tahun " . $m . " bulan " . $d . " hari";;
}

}

function umur_bulan($tgl_lahir){
    $birthDt = new DateTime($tgl_lahir);
    $today = new DateTime('today');
    $y = $today->diff($birthDt)->y;
    $m = $today->diff($birthDt)->m;
    $d = $today->diff($birthDt)->d;
    return $m . " bulan " ;
}




function imun_berikut($id,$tgl_suntik){
    if ($id == "154" or $id == "137") {
        $ber = "Bulan ".bulan_view(date('Y-m-d', strtotime('+1 month', strtotime($tgl_suntik))))."<br><span class='badge bg-warning text-dark'>BCG dan Polio (1) </span>";
    } elseif ($id == "117" or $id == "127") {
        $ber = "Bulan ".bulan_view(date('Y-m-d', strtotime('+2 month', strtotime($tgl_suntik))))."<br><span class='badge bg-warning text-dark'>Polio (2) dan Pentavalen (1) </span>";
    } elseif ($id == "119" or $id == "126") {
        $ber = "Bulan ".bulan_view(date('Y-m-d', strtotime('+3 month', strtotime($tgl_suntik))))."<br><span class='badge bg-warning text-dark'>Polio (3) dan Pentavalen (2) </span>";
    } elseif ($id == "122" or $id == "128") {
        $ber = "Bulan ".bulan_view(date('Y-m-d', strtotime('+4 month', strtotime($tgl_suntik))))."<br><span class='badge bg-warning text-dark'>Polio (4), Pentavalen (3) dan IPV </span>";
    } elseif ($id == "130" or $id == "125" or $id == "121") {
        $ber = "Bulan ".bulan_view(date('Y-m-d', strtotime('+9 month', strtotime($tgl_suntik))))."<br><span class='badge bg-warning text-dark'>MR </span>";
    } elseif ($id == "124") {
        $ber = "Bulan ".bulan_view(date('Y-m-d', strtotime('+18 month', strtotime($tgl_suntik))))." <br><span class='badge bg-warning text-dark'>Pentavalen Lanjutan dan Campak Lanjutan </span>";
    } elseif ($id == "118" or $id == "129" or $id == "120") {
        $ber = "Bulan ".bulan_view(date('Y-m-d', strtotime('+18 month', strtotime($tgl_suntik))))." <br><span class='badge bg-warning text-dark'>MR Lanjutan/ Imunisasi BIAS </span>";
    } else {
        $ber = "-";
    }
    return $ber;
}

function drop_out($id,$tgl_suntik){
    $ber_hbo7 = date('Y-m-d', strtotime('+7 days', strtotime($tgl_suntik)));
    $bcg_p1 = date('Y-m-d', strtotime('+1 month', strtotime($tgl_suntik)));
    $p2_p1 = date('Y-m-d', strtotime('+2 month', strtotime($tgl_suntik)));
    if (date("Y-m-d") >= $ber_hbo7 and $id == "154") {
        $do = "<span class='badge bg-warning text-dark'>Drop Out HB0 7</span>";
    } elseif (date("Y-m-d") >= $bcg_p1 and  $id == "117" or $id == "127" ) {
        $do = "<span class='badge bg-warning text-dark'>Drop Out BCG dan Polio (1)</span>";
    } elseif (date("Y-m-d") >= $p2_p1 and $id == "119" or $id =="126") {
        $do = "<span class='badge bg-warning text-dark'>Drop Out Pentavalen (1) dan Polio (2)</span>";
    }
    return $do;
}

function arr_vaksin_ibu($tt){
    if ($tt == "tt1") {
        $re = "TT Bumil 1";
    } elseif ($tt == "tt2") {
        $re = "TT Bumil 2";
    } elseif ($tt == "tt3") {
        $re = "TT Bumil 3";
    } elseif ($tt == "tt4") {
        $re = "TT Bumil 4";
    } elseif ($tt == "tt5") {
        $re = "TT Bumil 5";
    } elseif ($tt == "ttll") {
        $re = "TT Bumil LL";
    } elseif ($tt == "ttw1") {
        $re = "TT WUS Tidak Hamil 1";
    } elseif ($tt == "ttw2") {
        $re = "TT WUS Tidak Hamil 2";
    } elseif ($tt == "ttw3") {
        $re = "TT WUS Tidak Hamil 3";
    } elseif ($tt == "ttw4") {
        $re = "TT WUS Tidak Hamil 4";
    } elseif ($tt == "ttw5") {
        $re = "TT WUS Tidak Hamil 5";
    } elseif ($tt == "ttwll") {
        $re = "TT WUS Tidak Hamil LL";
    } 
    return $re;
}


function arr_vaksin_ibu_p($tt){
    if ($tt == "tt1") {
        $re = "Tetanus Toxoid Ibu Hamil 1";
    } elseif ($tt == "tt2") {
        $re = "Tetanus Toxoid Ibu Hamil 2";
    } elseif ($tt == "tt3") {
        $re = "Tetanus Toxoid Ibu Hamil 3";
    } elseif ($tt == "tt4") {
        $re = "Tetanus Toxoid Ibu Hamil 4";
    } elseif ($tt == "tt5") {
        $re = "Tetanus Toxoid Ibu Hamil 5";
    } elseif ($tt == "ttll") {
        $re = "Tetanus Toxoid Ibu Hamil LL";
    } elseif ($tt == "ttw1") {
        $re = "Tetanus Toxoid Wanita Usia Subur Tidak Hamil 1";
    } elseif ($tt == "ttw2") {
        $re = "Tetanus Toxoid Wanita Usia Subur Tidak Hamil 2";
    } elseif ($tt == "ttw3") {
        $re = "Tetanus Toxoid Wanita Usia Subur Tidak Hamil 3";
    } elseif ($tt == "ttw4") {
        $re = "Tetanus Toxoid Wanita Usia Subur Tidak Hamil 4";
    } elseif ($tt == "ttw5") {
        $re = "Tetanus Toxoid Wanita Usia Subur Tidak Hamil 5";
    } elseif ($tt == "ttwll") {
        $re = "Tetanus Toxoid Wanita Usia Subur Tidak Hamil LL";
    } 
    return $re;
}

function umur_simpan($tgl_lahir,$tgl_suntik){

    $birthDt = new DateTime($tgl_lahir);
    $today = new DateTime($tgl_suntik);
    $y = $today->diff($birthDt)->y;
    $m = $today->diff($birthDt)->m;

    $d = $today->diff($birthDt)->d;
    if ($y == 0 and $m == 0 and $d == 0) {
       return "< 24 jam";
   } elseif ($y == 0 and $m == 0 ) {
       return $d . " hari";;
   } elseif ($y == 0) {
    return $m . " bulan " . $d . " hari";;
} elseif ($m == 0) {
    return $y . " tahun " . $d . " hari";;
}  elseif ($y > 5) {
 return $y. " tahun";
} else {
    return $y . " tahun " . $m . " bulan " . $d . " hari";;
}

}


function umur_cetak($tgl_lahir){

    $birthDt = new DateTime($tgl_lahir);
    $today = new DateTime('today');
    $y = $today->diff($birthDt)->y;
    $m = $today->diff($birthDt)->m;

    $d = $today->diff($birthDt)->d;
    if ($y == 0 and $m == 0 and $d == 0) {
       return "< 24 jam";
   } elseif ($y == 0 and $m == 0 ) {
       return $d . " hr";;
   } elseif ($y == 0) {
    return $m . " bln " . $d . " hr";;
} elseif ($m == 0) {
    return $y . " th " . $d . " hr";;
}  elseif ($y > 5) {
 return $y. " th";
} else {
    return $y . " th " . $m . " bln " . $d . " hr";;
}

}

function ve($a){
    if ($a == "0") {
        $b =  "";
    } else {
        $b =  uang($a);
    }
    return $b;
}

function getSearchTermToBold($text, $words){
    preg_match_all('~[A-Za-z0-9_äöüÄÖÜ]+~', $words, $m);
    if (!$m)
        return $text;
    $re = '~(' . implode('|', $m[0]) . ')~i';
    return preg_replace($re, '<b style="color:red">$0</b>', $text);
}

function tgl_indo($tgl){
    $tmp = explode("-", $tgl);
    $bln = intval($tmp[1]);

    $arr_bln = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober",
        "November","Desember");

    $ret = $tmp[2]." ".ucwords($arr_bln[$bln])." ".$tmp[0];
    return $ret;

}

function rawat($t){
    if ($t == "J") {
        return "Rawat Jalan";
    } else {
        return "Rawat Inap";
    }
}

function isi_split($isi,$split){
    $validasi = strip_tags(html_entity_decode($isi, ENT_QUOTES, 'UTF-8'));
    if (strlen($isi) > $split) {
        $isi = substr($isi, 0,$split)." ...";
    } else {
        $isi = $isi;
    }
    return $isi;

}
function penulis($p){
    $ex = explode(" ", $p);
    if (strlen($ex[0]) > 6) {
        return $name = substr($ex[0], 0,6)."...";
    } else {
        return $name = $ex[0];
    }
}

function uang($x) {
    return "".number_format($x,0,',','.');
}

function tgl_simpan($tgl){
    $tanggal = substr($tgl,0,2);
    $bulan = substr($tgl,3,2);
    $tahun = substr($tgl,6,4);
    return $tahun.'-'.$bulan.'-'.$tanggal;       
}


function tahun_view($tgl){
    $tahun = substr($tgl,6,4);
    return $tahun;       
}

function format_telpon($no_telpon){
    $angka_awal = substr($no_telpon,0,1);
    if ($angka_awal==0){
        $telpon = "62".substr($no_telpon,1,15);
    }elseif ($angka_awal=='62'){
        $telpon = substr($no_telpon,0,15);
    }elseif ($angka_awal=='6'){
        $telpon = "62".substr($no_telpon,1,15);
    }elseif ($angka_awal!='0'){
        $telpon = "62".substr($no_telpon,0,15);
    }else{
        $telpon = substr($no_telpon,0,15);
    }
    return $telpon; 
}

function tgl_view($tgl){
    $tanggal = substr($tgl,8,2);
    $bulan = substr($tgl,5,2);
    $tahun = substr($tgl,0,4);
    return $tanggal.'-'.$bulan.'-'.$tahun;       
}

function bulan_view($tgl){
    $tmp = explode("-", $tgl);
    $bln = intval($tmp[1]);
    $arr_bln = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober",
        "November","Desember");

    $ret = ucwords($arr_bln[$bln])." ".$tmp[0];
    return $ret;    
}

function bulan_view_only($tgl){
    $tmp = explode("-", $tgl);
    $bln = intval($tmp[1]);
    $arr_bln = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober",
        "November","Desember");

    $ret = ucwords($arr_bln[$bln]);
    return $ret;    
}

function generateRandomString($length = 10) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
} 

function linker($l,$int = "") {
    if ($int == "0") {
        $c = array (' ');
        $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+','–');
        $l = str_replace($d, '', $l); 
        $l = strtolower(str_replace($c, '-', $l));
        return $l;
    } else {
        $acak = date("yy-m-d H:i:s");
        $acak = md5($acak);
        $acak = substr(preg_replace("/[^0-9]/", '', $acak),0,10);
        $serial = hash("sha512", md5($acak));
        $serial = substr(preg_replace("/[^0-9]/", '', $serial),0,6);

        $waktu = date("Y/m/d/");
        $c = array (' ');
        $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+','–');
        $l = str_replace($d, '', $l); 
        $l = strtolower(str_replace($c, '-', $l));
        return $waktu.$serial."/".$l;
    }

}

function buat_name($l,$int = "") {
    if ($int == "0") {
        $c = array (' ');
        $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+','–');
        $l = str_replace($d, '', $l); 
        $l = strtolower(str_replace($c, '_', $l));
        return $l;
    } else {
        $acak = date("yy-m-d H:i:s");
        $acak = md5($acak);
        $acak = substr(preg_replace("/[^0-9]/", '', $acak),0,10);
        $serial = hash("sha512", md5($acak));
        $serial = substr(preg_replace("/[^0-9]/", '', $serial),0,6);

        $waktu = date("Y/m/d/");
        $c = array (' ');
        $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+','–');
        $l = str_replace($d, '', $l); 
        $l = strtolower(str_replace($c, '_', $l));
        return $waktu.$serial."/".$l;
    }

}

function translate_bln($bulan){
    if ($bulan == "January") {
     $bln = "1";
 } elseif ($bulan == "February") {
    $bln = "2";
} elseif ($bulan == "March") {
    $bln = "3";
} elseif ($bulan == "April") {
    $bln = "4";
} elseif ($bulan == "May") {
    $bln = "5";
} elseif ($bulan == "June") {
    $bln = "6";
} elseif ($bulan == "July") {
    $bln = "7";
} elseif ($bulan == "August") {
    $bln = "8";
} elseif ($bulan == "September") {
    $bln = "9";
} elseif ($bulan == "October") {
    $bln = "10";
} elseif ($bulan == "November") {
    $bln = "11";
} elseif ($bulan == "December") {
    $bln = "12";
}
return $bln;
}

function hari_ini($tanggal){
    if(empty($tanggal)) {
        return "";
    }

    $x = explode("-", $tanggal);
    $x[0] = isset($x[0])?$x[0]:"0";
    $x[1] = isset($x[1])?$x[1]:"0";
    $x[2] = isset($x[2])?$x[2]:"0";
    // return $x[2]."-".$x[1]."-".$x[0];
    $day = date('D', strtotime($tanggal));
    $dayList = array(
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu'
    );
    return $dayList[$day];

}

function getBulan($bln){
    switch ($bln){
        case 1: 
        return "Januari";
        break;
        case 2:
        return "Februari";
        break;
        case 3:
        return "Maret";
        break;
        case 4:
        return "April";
        break;
        case 5:
        return "Mei";
        break;
        case 6:
        return "Juni";
        break;
        case 7:
        return "Juli";
        break;
        case 8:
        return "Agustus";
        break;
        case 9:
        return "September";
        break;
        case 10:
        return "Oktober";
        break;
        case 11:
        return "November";
        break;
        case 12:
        return "Desember";
        break;
    }
} 

function cek_terakhir($datetime, $full = false) {
  $today = time();    
  $createdday= strtotime($datetime); 
  $datediff = abs($today - $createdday);  
  $difftext="";  
  $years = floor($datediff / (365*60*60*24));  
  $months = floor(($datediff - $years * 365*60*60*24) / (30*60*60*24));  
  $days = floor(($datediff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));  
  $hours= floor($datediff/3600);  
  $minutes= floor($datediff/60);  
  $seconds= floor($datediff);  
     //year checker  
  if($difftext=="")  
  {  
     if($years>1)  
        $difftext=$years." Tahun";  
    elseif($years==1)  
        $difftext=$years." Tahun";  
}  
     //month checker  
if($difftext=="")  
{  
    if($months>1)  
        $difftext=$months." Bulan";  
    elseif($months==1)  
        $difftext=$months." Bulan";  
}  
     //month checker  
if($difftext=="")  
{  
    if($days>1)  
        $difftext=$days." Hari";  
    elseif($days==1)  
        $difftext=$days." Hari";  
}  
     //hour checker  
if($difftext=="")  
{  
    if($hours>1)  
        $difftext=$hours." Jam";  
    elseif($hours==1)  
        $difftext=$hours." Jam";  
}  
     //minutes checker  
if($difftext=="")  
{  
    if($minutes>1)  
        $difftext=$minutes." Menit";  
    elseif($minutes==1)  
        $difftext=$minutes." Menit";  
}  
     //seconds checker  
if($difftext=="")  
{  
    if($seconds>1)  
        $difftext=$seconds." Detik";  
    elseif($seconds==1)  
        $difftext=$seconds." Detik";  
}  
return $difftext;  
}