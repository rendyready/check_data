<?php
function tanggal_indonesia($tgl, $tampil_hari=true){
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
   
   return $text;    
}

  
 function namahari($tanggal)
{
    
    $tgl=substr($tanggal,8,2);
    $bln=substr($tanggal,5,2);
    $thn=substr($tanggal,0,4);
    $info=date('w', mktime(0,0,0,$bln,$tgl,$thn));
    switch($info){
        case '0': return "Minggu"; break;
        case '1': return "Senin"; break;
        case '2': return "Selasa"; break;
        case '3': return "Rabu"; break;
        case '4': return "Kamis"; break;
        case '5': return "Jumat"; break;
        case '6': return "Sabtu"; break;
    };
}

function tgl_waktuid ($timestamp = '', $date_format = 'l, j F Y | H:i:s', $suffix = 'WIB') {
	if (trim ($timestamp) == '')
	{
			$timestamp = time ();
	}
	elseif (!ctype_digit ($timestamp))
	{
		$timestamp = strtotime ($timestamp);
	}
	# remove S (st,nd,rd,th) there are no such things in indonesia :p
	$date_format = preg_replace ("/S/", "", $date_format);
	$pattern = array (
		'/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
		'/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
		'/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
		'/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
		'/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
		'/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
		'/April/','/June/','/July/','/August/','/September/','/October/',
		'/November/','/December/',
	);
	$replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
		'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
		'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
		'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
		'Oktober','November','Desember',
	);
	$date = date ($date_format, $timestamp);
	$date = preg_replace ($pattern, $replace, $date);
	$date = "{$date} {$suffix}";
	return $date;
	
} 
function terbilang($angka) {
	$angka = abs($angka);
	$baca = array("", "satu", "dua", "tiga", "empat", "lima",
	"enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$terbilang = "";
	if ($angka <12) {
	   $terbilang = " ". $baca[$angka];
	} else if ($angka <20) {
	   $terbilang = terbilang($angka - 10). " belas";
	} else if ($angka <100) {
	   $terbilang = terbilang($angka/10)." puluh". terbilang($angka % 10);
	} else if ($angka <200) {
	   $terbilang = " seratus" . terbilang($angka - 100);
	} else if ($angka <1000) {
	   $terbilang = terbilang($angka/100) . " ratus" . terbilang($angka % 100);
	} else if ($angka <2000) {
	   $terbilang = " seribu" . terbilang($angka - 1000);
	} else if ($angka <1000000) {
	   $terbilang = terbilang($angka/1000) . " ribu" . terbilang($angka % 1000);
	} else if ($angka <1000000000) {
	   $terbilang = terbilang($angka/1000000) . " juta" . terbilang($angka % 1000000);
	}    
	
	return $terbilang;
}

function rupiah($angka,$decimal = 2){
	$hasil = "Rp ".number_format($angka,$decimal,',','.');
	return $hasil;	 
}
function number_to_alphabet($number) {
    $number = intval($number);
    if ($number <= 0) {
        return '';
    }
    $alphabet = '';
    while($number != 0) {
        $p = ($number - 1) % 26;
        $number = intval(($number - $p) / 26);
        $alphabet = chr(65 + $p) . $alphabet;
    }
    return $alphabet;
}
function tgl_indo($tgl, $tampil_hari=true){
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
	
	return $text;    
 }
 function convertfloat($number) {
    // menghapus karakter titik
    $number = str_replace('.', '', $number);
    // mengganti koma dengan titik
    $number = str_replace(',', '.', $number);
    // mengembalikan nilai dalam format numerik
    return (float)$number;
}

function convertindo($number) {
	// Set pemisah ribuan dan desimal sesuai dengan format yang diinginkan
	$thousands_separator = '.';
	$decimal_separator = ',';
  
	// Format angka menjadi string dengan pemisah ribuan dan desimal yang ditentukan
	$formatted_number = number_format($number, 2, $decimal_separator, $thousands_separator);
  
	// Mengganti pemisah ribuan dan desimal yang digunakan oleh number_format() dengan yang diinginkan
	$formatted_number = str_replace($decimal_separator, '.', $formatted_number);
	$formatted_number = str_replace($thousands_separator, ',', $formatted_number);
  
	return $formatted_number;
  }
  
