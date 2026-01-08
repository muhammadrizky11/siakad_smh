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
$filenya = "ijin_pdf.php";
$judul = "[IJIN MASUK PULANG]. Bukti Ijin";
$judulku = "$judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);

$ikd = cegah($_REQUEST['ikd']);


//file image qrcode
$fileku = "../../filebox/qrcode/$ikd.png";




//bikin pdf
require_once("../../inc/class/dompdf/autoload.inc.php");

use Dompdf\Dompdf;
$dompdf = new Dompdf();






//detail 
$qx = mysqli_query($koneksi, "SELECT * FROM user_ijin ".
								"WHERE kd = '$ikd'");
$rowx = mysqli_fetch_assoc($qx);
$e_swkode = balikin($rowx['user_kode']);
$e_swnama = balikin($rowx['user_nama']);
$e_swjabatan = balikin($rowx['user_jabatan']);
$e_swkelas = balikin($rowx['user_kelas']);
$e_tgl = balikin($rowx['tanggal']);
$e_postdate = balikin($rowx['postdate']);
$e_status = balikin($rowx['status']);
$e_ket = balikin($rowx['ket']);




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







//pecah
$pecahnya = explode(" ", $e_postdate);
$p_jam = trim($pecahnya[1]);






//jika masuk
if ($e_status == "IJIN MASUK")
	{
	$e_status_ket = "JAM DATANG";
	} 

else
	{
	$e_status_ket = "JAM PULANG";
	} 




						
						


//bikin folder
$foldernya = "../../filebox/pdf/$e_swkode/";
			
			
//buat folder...
if (!file_exists('../../filebox/pdf/'.$e_swkode.'')) {
    mkdir('../../filebox/pdf/'.$e_swkode.'', 0777, true);
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
	<u><b>SURAT '.$e_status.'</b></u>
	</font>
	
</td>
</tr>
</table>

<br>




<table width="530" cellpadding="1" cellspacing="1" border="0">
<tr valign="top">
<td>
<br>
	<table width="400" cellpadding="1" cellspacing="1" border="0">';
	
	//jika siswa
	if ($e_swjabatan == "SISWA")
		{
		echo '<tr valign="top">
		<td align="left" width="10">
		a.
		</td>
		<td align="left" width="120">
		NIS
		</td>
		<td align="left" width="10">
		:
		</td>
		<td align="left">
		'.strtoupper($e_swkode).'
		</td>
		</tr>
		
		<tr valign="top">
		<td align="left" width="10">
		b.
		</td>
		<td align="left" width="120">
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
		<td align="left" width="120">
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
		<td align="left" width="120">
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
		<td align="left" width="120">
		'.$e_status_ket.'
		</td>
		<td align="left" width="10">
		:
		</td>
		<td align="left">
		'.$p_jam.'
		</td>
		</tr>
		
		
		<tr valign="top">
		<td align="left" width="10">
		f.
		</td>
		<td align="left" width="120">
		KETERANGAN
		</td>
		<td align="left" width="10">
		:
		</td>
		<td align="left">
		'.$e_ket.'
		</td>
		</tr>';
		}
	
	else
		{
		echo '<tr valign="top">
		<td align="left" width="10">
		a.
		</td>
		<td align="left" width="120">
		NIP
		</td>
		<td align="left" width="10">
		:
		</td>
		<td align="left">
		'.strtoupper($e_swkode).'
		</td>
		</tr>
		
		<tr valign="top">
		<td align="left" width="10">
		b.
		</td>
		<td align="left" width="120">
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
		<td align="left" width="120">
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
		d.
		</td>
		<td align="left" width="120">
		'.$e_status_ket.'
		</td>
		<td align="left" width="10">
		:
		</td>
		<td align="left">
		'.$p_jam.'
		</td>
		</tr>
		
		
		<tr valign="top">
		<td align="left" width="10">
		e.
		</td>
		<td align="left" width="120">
		KETERANGAN
		</td>
		<td align="left" width="10">
		:
		</td>
		<td align="left">
		'.$e_ket.'
		</td>
		</tr>';
		}
	
	
	
	echo '</table>
	<br>
	<br>
	
</td>

<td>

<img src="'.$fileku.'" width="150" />

</td>
</tr>
</table>



<table width="530" cellpadding="1" cellspacing="1" border="0">
<tr valign="top">

<td align="center" width="250">

	

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
chmod("../../filebox/pdf/$e_swkode", 0777);

$namaku = seo_friendly_url($e_swnama);
$filename = "../../filebox/pdf/$e_swkode/$e_swkode-$namaku-$ikd.pdf";



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