<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMK_v6.78_(Code:Tekniknih)                     ///////
/////// (Sistem Informasi Sekolah untuk SMK)                    ///////
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
$filenya = "agenda_pdf.php";
$judul = "[JURNAL MENGAJAR KUR13]. Agenda";
$judulku = "$judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);

$pkd = cegah($_REQUEST['pkd']);
$swkd = cegah($_REQUEST['swkd']);
$nis = cegah($_REQUEST['nis']);




//bikin pdf
require_once("../../inc/class/dompdf/autoload.inc.php");

use Dompdf\Dompdf;
$dompdf = new Dompdf();






//detail 
$qx = mysqli_query($koneksi, "SELECT * FROM rev_guru_agenda ".
								"WHERE kd = '$pkd'");
$rowx = mysqli_fetch_assoc($qx);
$e_tapel = balikin($rowx['tapel']);
$e_kelas = balikin($rowx['kelas']);
$e_no = balikin($rowx['pertemuan_ke']);
$e_tgl = balikin($rowx['tglnya']);
$e_smt = balikin($rowx['smt']);
$e_jam = balikin($rowx['jamnya']);
$e_mapel = balikin($rowx['mapel_nama']);
$e_mapel_kode = balikin($rowx['mapel_kode']);

$e_anama = balikin($rowx['namanya']);
$e_aindikator = balikin($rowx['indikatornya']);
$e_acatatan = balikin($rowx['catatan']);
$e_alanjut = balikin($rowx['tindak_lanjut']);





//pecah
$pecahnya = explode("-", $e_tgl);
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






		
//nilai
$qku = mysqli_query($koneksi, "SELECT * FROM m_ks");
$rku = mysqli_fetch_assoc($qku);
$ks_kode = balikin($rku['peg_kode']);
$ks_nama = balikin($rku['peg_nama']);

		
						
						
$nis = cegah($_SESSION['nip1_session']);
$nama2 = balikin($_SESSION['nm1_session']);


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
	<img src="../../img/logo2.png" width="100" height="100">
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



<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="center"><h3>AGENDA MENGAJAR</h3></td>
	</tr>
</table>



<table width="530" cellpadding="1" cellspacing="1" border="0">
<tr valign="top">
<td align="left" width="10">
a.
</td>
<td align="left" width="150">
Tahun Pelajaran
</td>
<td align="left" width="10">
:
</td>
<td align="left">
'.$e_tapel.'
</td>
</tr>

<tr valign="top">
<td align="left" width="10">
b.
</td>
<td align="left" width="150">
Kelas
</td>
<td align="left" width="10">
:
</td>
<td align="left">
'.$e_kelas.'
</td>
</tr>


<tr valign="top">
<td align="left" width="10">
c.
</td>
<td align="left" width="150">
Semester
</td>
<td align="left" width="10">
:
</td>
<td align="left">
'.$e_smt.'
</td>
</tr>



<tr valign="top">
<td align="left" width="10">
d.
</td>
<td align="left" width="150">
Mata Pelajaran
</td>
<td align="left" width="10">
:
</td>
<td align="left">
'.$e_mapel.' ['.$e_mapel_kode.']
</td>
</tr>



<tr valign="top">
<td align="left" width="10">
e.
</td>
<td align="left" width="150">
Pertemuan ke-, Hari, tanggal 
</td>
<td align="left" width="10">
: 
</td>
<td align="left">
#'.$e_no.', '.$dinone.', '.$p_tgl.' '.$arrbln1[$p_bln].' '.$p_thn.'
</td>
</tr>


<tr valign="top">
<td align="left" width="10">
f.
</td>
<td align="left" width="150">
Jam ke-
</td>
<td align="left" width="10">
:
</td>
<td align="left">
'.$e_jam.'
</td>
</tr>
</table>
<br>


<table width="530" cellpadding="1" cellspacing="1" border="0">
<tr valign="top">
<td align="left">
<b>g. Nama KD/Materi/Pokok Bahasan :</b>
<br>
'.$e_anama.'
<br>
<br>
</td>
</tr>

<tr valign="top">
<td align="left">
<b>h. Sub Pokok Bahasan / Indikator Pencapaian Kompetensi :</b>
<br>
'.$e_aindikator.'
<br>
<br>
</td>
</tr>

<tr valign="top">
<td align="left">
<b>i. Catatan :</b>
<br>
'.$e_acatatan.'
<br>
<br>
</td>
</tr>

<tr valign="top">
<td align="left">
<b>j. TINDAK LANJUT :</b>
<br>
'.$e_alanjut.'
<br>
<br>
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
	Guru Mapel
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	
	<u><b>'.$nama2.'</b></u>
	<br>
	<b>'.$nis.'</b>

</td>


<td align="center">

</td>


<td align="center">
	'.$sek_kota.', '.$p_tgl.' '.$arrbln1[$p_bln].' '.$p_thn.'
	
	<br>
	<br>
	Kepala Sekolah
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	
	<u><b>'.$ks_nama.'</b></u>
	<br>
	<b>'.$ks_kode.'</b>
	
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



//echo $isix;





$dompdf->loadHtml($isix);

// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
// Rendering dari HTML Ke PDF
$dompdf->render();


// Melakukan output file Pdf




//auto save ke server
//777
chmod("../../filebox/pdf/$nis", 0777);

$filename = "../../filebox/pdf/$nis/$nis-$pkd.pdf";



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