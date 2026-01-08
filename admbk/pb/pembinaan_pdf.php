<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_v7.00_(Code:SmartOffice)                       ///////
/////// (Sistem Informasi Sekolah)                              ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://github.com/hajirodeon                      ///////
///////     * http://gitlab.com/hajirodeon                      ///////
///////     * http://sisfokol.wordpress.com                     ///////
///////     * http://hajirodeon.wordpress.com                   ///////
///////     * http://yahoogroup.com/groups/sisfokol             ///////
///////     * https://www.youtube.com/@hajirodeon               ///////
///////////////////////////////////////////////////////////////////////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS/WA : 081-829-88-54                               ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////



session_start();


require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");





//nilai
$filenya = "pembinaan_pdf.php";
$judul = "[PEMBINAAN]. Bukti Pembinaan";
$judulku = "$judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);

$ikd = cegah($_REQUEST['ikd']);
$swkd = cegah($_REQUEST['swkd']);
$nis = cegah($_REQUEST['nis']);




//bikin pdf
require_once("../../inc/class/dompdf/autoload.inc.php");

use Dompdf\Dompdf;
$dompdf = new Dompdf();






//detail 
$qx = mysqli_query($koneksi, "SELECT * FROM siswa_pelanggaran ".
								"WHERE siswa_kd = '$swkd' ".
								"AND kd = '$ikd'");
$rowx = mysqli_fetch_assoc($qx);
$e_swnama = balikin($rowx['siswa_nama']);
$e_swkelas = balikin($rowx['kelas_nama']);
$e_pjenis = balikin($rowx['jenis_nama']);
$e_pnama = balikin($rowx['point_nama']);
$e_pnilai = balikin($rowx['point_nilai']);
$e_psanksi = balikin($rowx['point_sanksi']);


$e_bkd = balikin($rowx['bina_kd']);
$e_btgl = balikin($rowx['bina_tgl']);
$e_bnama = balikin($rowx['bina_nama']);
$e_bket = balikin($rowx['bina_ket']);






//pembina ne 
$qx2 = mysqli_query($koneksi, "SELECT * FROM m_pembinaan ".
								"WHERE kd = '$e_bkd'");
$rowx2 = mysqli_fetch_assoc($qx2);
$e_pbnama = balikin($rowx2['pembina_nama']);



//pecah
$pecahnya = explode("-", $e_btgl);
$p_thn = trim($pecahnya[0]);
$p_bln = trim($pecahnya[1]);
$p_tgl = trim($pecahnya[2]);

$tanggalnya = "$p_thn-$p_bln-$p_tgl";


$dayya = date('D', strtotime($tanggalnya));
$dayList = array(
    'Sun' => 'Minggu',
    'Mon' => 'Senin',
    'Tue' => 'Selasa',
    'Wed' => 'Rabu',
    'Thu' => 'Kamis',
    'Fri' => 'Jumat',
    'Sat' => 'Sabtu'
);

$dinone = $dayList[$dayya];






						
						


//bikin folder
$foldernya = "../../filebox/pdf/$nis/";
			
			
//buat folder...
if (!file_exists('../../filebox/pdf/'.$nis.'')) {
    mkdir('../../filebox/pdf/'.$nis.'', 0777, true);
	}
	

//bikin pdf ///////////////////////////////////////////////////////////////////////////////////////

?>


<style>
div.page_break + div.page_break{
    page-break-before: always;
}



</style>





<?php

//isi *START
ob_start();




echo '<table width="530" cellpadding="1" cellspacing="1" border="0">
<tr valign="top">
<td align="center" width="100">
	<img src="../../img/logo.png" width="100" height="100">
</td>
<td align="center">

	<font size="5">
	<b>'.$sek_nama.'</b>
	<br>

	<font size="4">
	'.$sek_alamat.'
	</font>
</td>

<td align="center" width="50">
	&nbsp;
</td>


</tr>
</table>



<hr>



<br>
<table width="530" cellpadding="1" cellspacing="1" border="0">
<tr valign="top">
<td align="center">
	
	<font size="4">
	<u><b>BUKTI PEMBINAAN</b></u>
	</font>
	
</td>
</tr>
</table>

<br>



<table width="530" cellpadding="1" cellspacing="1" border="0">
<tr valign="top">
<td align="left" width="10">
a.
</td>
<td align="left" width="150">
NIS
</td>
<td align="left" width="10">
:
</td>
<td align="left">
'.strtoupper($nis).'
</td>
</tr>

<tr valign="top">
<td align="left" width="10">
b.
</td>
<td align="left" width="150">
NAMA
</td>
<td align="left" width="10">
:
</td>
<td align="left">
'.strtoupper($e_swnama).'
</td>
</tr>


<tr valign="top">
<td align="left" width="10">
c.
</td>
<td align="left" width="150">
KELAS
</td>
<td align="left" width="10">
:
</td>
<td align="left">
'.strtoupper($e_swkelas).'
</td>
</tr>


<tr valign="top">
<td align="left" width="10">
d.
</td>
<td align="left" width="150">
HARI, TANGGAL 
</td>
<td align="left" width="10">
: 
</td>
<td align="left">
'.$dinone.', '.$p_tgl.' '.$arrbln1[$p_bln].' '.$p_thn.'
</td>
</tr>


<tr valign="top">
<td align="left" width="10">
e.
</td>
<td align="left" width="150">
PELANGGARAN 
</td>
<td align="left" width="10">
:
</td>
<td align="left">
'.$e_pjenis.'. '.$e_pnama.'
<br>
Point : '.$e_pnilai.'
<br>
Sanksi : '.$e_psanksi.'
</td>
</tr>


<tr valign="top">
<td align="left" width="10">
f.
</td>
<td align="left" width="150">
PEMBINAAN 
</td>
<td align="left" width="10">
:
</td>
<td align="left">
'.$e_bnama.'. '.$e_bket.'
</td>
</tr>


</table>
<br>
<br>



<table width="530" cellpadding="1" cellspacing="1" border="0">
<tr valign="top">

<td align="center" width="250">
	<br>
	<br>
	Siswa
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	
	<u><b>'.$e_swnama.'</b></u>

</td>


<td align="center">

</td>


<td align="center" width="150">
	'.$sek_kota.', '.$p_tgl.' '.$arrbln1[$p_bln].' '.$p_thn.'
	
	<br>
	<br>
	Pembina
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	
	<u><b>'.$e_pbnama.'</b></u>
	
</td>


</tr>
</table>
<br>
<br>
<br>

<hr>

<i>[Postdate Cetak : '.$today.'].</i>';




//isi
$isix = ob_get_contents();
ob_end_clean();







$dompdf->loadHtml($isix);

// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
// Rendering dari HTML Ke PDF
$dompdf->render();


// Melakukan output file Pdf




//auto save ke server
//777
chmod("../../filebox/pdf/$nis", 0777);

$namaku = seo_friendly_url($e_swnama);
$filename = "../../filebox/pdf/$nis/$nis-$namaku-$ikd.pdf";



//hapus dulu...
unlink($filename);

//777
chmod("../../filebox/pdf/$nis", 0777);
	




$output = $dompdf->output();
file_put_contents($filename, $output);



//755
chmod("../../filebox/pdf/$nis", 0755);
	



//re-direct
xloc($filename);
exit();




require("../../inc/niltpl.php");



//null-kan
xfree($qbw);
xclose($koneksi);
exit();
?>