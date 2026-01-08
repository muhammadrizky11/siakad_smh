<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_v7.00_(Code:SmartOffice)                       ///////
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

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/window.html");



//nilai
$filenya = "siswa_prt.php";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulku = $judul;
$judulx = $judul;
$nis = nosql($_REQUEST['nis']);
$swkd = nosql($_REQUEST['swkd']);



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "siswa.php?nis=$nis&swkd=$swkd";
$diload = "window.print();location.href='$ke'";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//js
require("../../inc/js/swap.js");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table width="500" border="1" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" align="center">


<table width="500" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" align="center">
<P>
<big>
<strong><u>BUKTI DEBET/KREDIT TABUNGAN</u></strong>
</big>
</P>
<P>
<big>
<strong><u>'.$sek_nama.'</u></strong>
</big>
</P>

<hr height="1">
</td>
</tr>
</table>
<table width="500" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" width="200">
Hari, Tanggal
</td>
<td width="1">:</td>
<td>
<strong>'.$arrhari[$hari].', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="200">
Nomor Induk
</td>
<td width="1">:</td>
<td>
<strong>'.$nis.'</strong>
</td>
</tr>';

//cek
$qcc = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
								"WHERE kode = '$nis' ".
								"ORDER BY tapel DESC");
$rcc = mysqli_fetch_assoc($qcc);
$tcc = mysqli_num_rows($qcc);
$cc_kd = nosql($rcc['kd']);
$cc_nama = balikin($rcc['nama']);
$cc_tapel = balikin($rcc['tapel']);
$cc_kelas = balikin($rcc['kelas']);



//debet/kredit terakhir
$qswu = mysqli_query($koneksi, "SELECT * FROM siswa_tabungan ".
									"WHERE siswa_kd = '$swkd' ".
									"ORDER BY postdate DESC");
$rswu = mysqli_fetch_assoc($qswu);
$swu_status = nosql($rswu['debet']);
$swu_nilai = nosql($rswu['nilai']);
$swu_saldo_akhir = nosql($rswu['saldo']);


//jika debet
if ($swu_status == "true")
	{
	$x_status = "DEBET";
	}
else
	{
	$x_status = "KREDIT";
	}





//kelasnya...
$kel_kelas = $cc_kelas;





echo '<tr valign="top">
<td valign="top" width="200">
Nama Siswa
</td>
<td width="1">:</td>
<td>
<strong>'.$cc_nama.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="200">
Kelas
</td>
<td width="1">:</td>
<td>
<strong>'.$kel_kelas.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="200">
Status
</td>
<td width="1">:</td>
<td>
<strong>'.$x_status.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="200">
Jumlah
</td>
<td width="1">:</td>
<td>
<strong>'.xduit2($swu_nilai).'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="200">
Saldo Akhir
</td>
<td width="1">:</td>
<td>
<strong>'.xduit2($swu_saldo_akhir).'</strong>
</td>
</tr>


</table>
<br>
<br>
<br>

<table width="500" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" width="200" align="center">
</td>
<td valign="top" align="center">
<strong>'.$sek_kota.', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'</strong>
<br>
<br>
<br>
<br>
<br>
(<strong>BENDAHARA</strong>)
</td>
</tr>
<table>


<input name="swkd" type="hidden" value="'.$cc_kd.'">
<input name="nis" type="hidden" value="'.$nis.'">
</td>
</tr>
</table>

<br>
<br>

</td>
</tr>
</table>
<i>Code : '.$today3.'</i>


</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>