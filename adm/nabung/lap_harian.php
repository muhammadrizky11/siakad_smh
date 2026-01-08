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
$tpl = LoadTpl("../../template/adm.html");




//nilai
$filenya = "lap_harian.php";
$judul = "Laporan Tabungan Harian";
$judulku = "[TABUNGAN]. $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);

$ke = "$filenya?tapelkd=$tapelkd&uthn=$uthn&ubln=$ubln&utgl=$utgl";



//focus...
if (empty($tapelkd))
{
$diload = "document.formx.tapel.focus();";
}
else if (empty($utgl))
{
$diload = "document.formx.utglx.focus();";
}
else if (empty($ubln))
{
$diload = "document.formx.ublnx.focus();";
}







//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';

echo "<select name=\"tapel\" class=\"btn btn-warning\" onChange=\"MM_jumpMenu('self',this,0)\">";
//terpilih
$qtpx = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
								"WHERE kd = '$tapelkd'");
$rowtpx = mysqli_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn = balikin($rowtpx['nama']);

echo '<option value="'.$tpx_kd.'">'.$tpx_thn.'</option>';

$qtp = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
								"WHERE kd <> '$tapelkd' ".
								"ORDER BY nama DESC");
$rowtp = mysqli_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth = balikin($rowtp['nama']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tpth.'</option>';
	}
while ($rowtp = mysqli_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>';


//pecah tapel
$pecahku = explode("/", $tpx_thn);
$tpx_thn1 = trim($pecahku[0]);
$tpx_thn2 = trim($pecahku[1]);



echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tanggal : ';
echo "<select name=\"utglx\" class=\"btn btn-warning\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$utgl.'">'.$utgl.'</option>';
for ($itgl=1;$itgl<=31;$itgl++)
	{
	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&utgl='.$itgl.'">'.$itgl.'</option>';
	}
echo '</select>';

echo "<select name=\"ublnx\" class=\"btn btn-warning\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$ubln.''.$uthn.'" selected>'.$arrbln[$ubln].' '.$uthn.'</option>';
for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;

		echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn1.'">'.$arrbln[$ibln].' '.$tpx_thn1.'</option>';
		}

	else if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;

		echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn2.'">'.$arrbln[$ibln].' '.$tpx_thn2.'</option>';
		}
	}

echo '</select>
</td>
</tr>
</table>';


//nek blm dipilih
if (empty($tapelkd))
{
echo '<p>
<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
</p>';
}
else if (empty($utgl))
{
echo '<p>
<font color="#FF0000"><strong>TANGGAL Belum Dipilih...!</strong></font>
</p>';
}
else if (empty($ubln))
{
echo '<p>
<font color="#FF0000"><strong>BULAN Belum Dipilih...!</strong></font>
</p>';
}
else
{


//query
$qcc = mysqli_query($koneksi, "SELECT siswa_tabungan.*, ".
								"siswa_tabungan.siswa_kd AS siswa_kd, ".
								"siswa_tabungan.kd AS pkd, ".
								"siswa_tabungan.postdate AS pdate, ".
								"m_siswa.* ".
								"FROM siswa_tabungan, m_siswa ".
								"WHERE siswa_tabungan.siswa_kd = m_siswa.kd ".
								"AND round(DATE_FORMAT(siswa_tabungan.tgl, '%d')) = '$utgl' ".
								"AND round(DATE_FORMAT(siswa_tabungan.tgl, '%m')) = '$ubln' ".
								"AND round(DATE_FORMAT(siswa_tabungan.tgl, '%Y')) = '$uthn' ".
								"ORDER BY siswa_tabungan.postdate DESC");
$rcc = mysqli_fetch_assoc($qcc);
$tcc = mysqli_num_rows($qcc);


//jika ada
if ($tcc != 0)
{
echo '<br>
<table width="100%" border="1" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="100"><strong><font color="'.$warnatext.'">Waktu</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td width="150" align="center"><strong><font color="'.$warnatext.'">DEBET</font></strong></td>
<td width="150" align="center"><strong><font color="'.$warnatext.'">KREDIT</font></strong></td>
</tr>';

do
	{
	if ($warna_set ==0)
		{
		$warna = $warna01;
		$warna_set = 1;
		}
	else
		{
		$warna = $warna02;
		$warna_set = 0;
		}

	$i_nomer = $i_nomer + 1;
	$i_pkd = nosql($rcc['pkd']);
	$i_swkd = nosql($rcc['siswa_kd']);
	$i_nis = nosql($rcc['siswa_nis']);
	$i_nama = balikin($rcc['siswa_nama']);
	$i_nilai = nosql($rcc['nilai']);
	$i_status = nosql($rcc['debet']);
	$i_postdate = $rcc['pdate'];



	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$i_postdate.'</td>
	<td>'.$i_nis.'</td>
	<td>'.$i_nama.'</td>';

	//jika debet
	if ($i_status == "true")
		{
		echo '<td align="right">'.xduit2($i_nilai).'</td>
		<td>-</td>';
		}
	else
		{
		echo '<td>-</td>
		<td align="right">'.xduit2($i_nilai).'</td>';
		}

	echo '</tr>';
	}
while ($rcc = mysqli_fetch_assoc($qcc));


//ketahui jumlah uang nya... [DEBET]
$qjmx1 = mysqli_query($koneksi, "SELECT SUM(nilai) AS total ".
						"FROM siswa_tabungan ".
						"WHERE round(DATE_FORMAT(tgl, '%d')) = '$utgl' ".
						"AND round(DATE_FORMAT(tgl, '%m')) = '$ubln' ".
						"AND round(DATE_FORMAT(tgl, '%Y')) = '$uthn' ".
						"AND debet = 'true'");
$rjmx1 = mysqli_fetch_assoc($qjmx1);
$tjmx1 = mysqli_num_rows($qjmx1);
$jmx1_total = nosql($rjmx1['total']);



//ketahui jumlah uang nya... [KREDIT]
$qjmx2 = mysqli_query($koneksi, "SELECT SUM(nilai) AS total ".
						"FROM siswa_tabungan ".
						"WHERE round(DATE_FORMAT(tgl, '%d')) = '$utgl' ".
						"AND round(DATE_FORMAT(tgl, '%m')) = '$ubln' ".
						"AND round(DATE_FORMAT(tgl, '%Y')) = '$uthn' ".
						"AND debet = 'false'");
$rjmx2 = mysqli_fetch_assoc($qjmx2);
$tjmx2 = mysqli_num_rows($qjmx2);
$jmx2_total = nosql($rjmx2['total']);


//uang yang ada
$uang_ada = round($jmx1_total - $jmx2_total);


echo '<tr bgcolor="'.$warnaover.'">
<td></td>
<td></td>
<td></td>
<td align="right"><strong>'.xduit2($jmx1_total).'</strong></td>
<td align="right"><strong>'.xduit2($jmx2_total).'</strong></td>
</tr>
</table>
<br>

<p>
Jumlah Uang Yang Ada :
<br>
<big>
<strong>'.xduit2($uang_ada).'</strong>
</big>
</p>';
}
else
{
echo '<p>
<font color="red">
<strong>Tidak Ada Data</strong>
</font>
</p>';
}



}

echo '</form>
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