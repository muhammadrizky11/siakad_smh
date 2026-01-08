<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMK_v6.78_(Code:Tekniknih)                          ///////
/////// (Sistem Informasi Sekolah untuk SMK)                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://github.com/hajirodeon/                          ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * https://www.youtube.com/@hajirodeon       ///////
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
require("../../inc/cek/admwk.php");
$tpl = LoadTpl("../../template/admwk.html");





//nilai
$filenya = "jadwal.php";
$judul = "Jadwal Pelajaran";
$judulku = "[JADWAL]. $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$s = nosql($_REQUEST['s']);



//focus
if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}









//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">

[<a href="../index.php" title="Daftar Detail">DAFTAR DETAIL</a>]

<table width="100%" bgcolor="'.$warnaover.'" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>
Tahun Pelajaran : ';

//terpilih
$qtpx = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysqli_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<strong>'.$tpx_thn1.'/'.$tpx_thn2.'</strong>,

Kelas : ';

//terpilih
$qbtx = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysqli_fetch_assoc($qbtx);

$btxkd = nosql($rowbtx['kd']);
$btxkelas = balikin($rowbtx['kelas']);

echo '<strong>'.$btxkelas.'</strong>,


Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qsmtx = mysqli_query($koneksi, "SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowsmtx = mysqli_fetch_assoc($qsmtx);
$smtx_kd = nosql($rowsmtx['kd']);
$smtx_smt = nosql($rowsmtx['smt']);

echo '<option value="'.$smtx_kd.'">'.$smtx_smt.'</option>';

$qsmt = mysqli_query($koneksi, "SELECT * FROM m_smt ".
						"WHERE kd <> '$smtkd' ".
						"ORDER BY smt ASC");
$rowsmt = mysqli_fetch_assoc($qsmt);

do
	{
	$smt_kd = nosql($rowsmt['kd']);
	$smt_smt = nosql($rowsmt['smt']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smtkd='.$smt_kd.'&kelkd='.$kelkd.'&keahkd='.$keahkd.'">'.$smt_smt.'</option>';
	}
while ($rowsmt = mysqli_fetch_assoc($qsmt));

echo '</select>
</td>
</tr>
</table>
<br>';

//cek
if (empty($smtkd))
	{
	echo '<h4>
	<strong><font color="#FF0000">SEMESTER Belum Dipilih...!</font></strong>
	</h4>';
	}
else
	{
	echo '<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
	<input name="smtkd" type="hidden" value="'.$smtkd.'">
	<input name="kelkd" type="hidden" value="'.$kelkd.'">

	<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="3%">&nbsp;</td>';

	//hari
	$qhri = mysqli_query($koneksi, "SELECT * FROM m_hari ".
							"ORDER BY round(no) ASC");
	$rhri = mysqli_fetch_assoc($qhri);

	do
		{
		$hri_kd = nosql($rhri['kd']);
		$hri_hr = balikin($rhri['hari']);

		echo '<td><strong>'.$hri_hr.'</strong></td>';
		}
	while ($rhri = mysqli_fetch_assoc($qhri));

	echo '</tr>';


	//jam
	$qjm = mysqli_query($koneksi, "SELECT * FROM m_jam ".
							"ORDER BY round(jam) ASC");
	$rjm = mysqli_fetch_assoc($qjm);

	do
		{
		//nilai
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

		$jm_kd = nosql($rjm['kd']);
		$jm_jam = nosql($rjm['jam']);


		//hari
		$qhri = mysqli_query($koneksi, "SELECT * FROM m_hari ".
								"ORDER BY round(no) ASC");
		$rhri = mysqli_fetch_assoc($qhri);


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td width="3%"><strong>'.$jm_jam.'.</strong></td>';

		do
			{
			$hri_kd = nosql($rhri['kd']);
			$hri_hr = balikin($rhri['hari']);


			//datane...
			$qdte = mysqli_query($koneksi, "SELECT jadwal.kd AS jdkd, jadwal.kd_ruang1 AS rukd1, ".
						"jadwal.kd_ruang2 AS rukd2, jadwal.kd_guru_prog_pddkn AS gpkd ".
						"FROM jadwal ".
						"WHERE jadwal.kd_tapel = '$tapelkd' ".
						"AND jadwal.kd_smt = '$smtkd' ".
						"AND jadwal.kd_kelas = '$kelkd' ".
						"AND jadwal.kd_jam = '$jm_kd' ".
						"AND jadwal.kd_hari = '$hri_kd'");
			$rdte = mysqli_fetch_assoc($qdte);
			$tdte = mysqli_num_rows($qdte);


			echo '<td width="16%">';

			do
				{
				$dte_kd = nosql($rdte['jdkd']);
				$dte_rukd = nosql($rdte['rukd1']);
				$dte_rukd2 = nosql($rdte['rukd2']);
				$dte_gpkd = nosql($rdte['gpkd']);




				//guru ne
				$qku1 = mysqli_query($koneksi, "SELECT * FROM m_guru_prog_pddkn ".
							"WHERE kd = '$dte_gpkd'");
				$rku1 = mysqli_fetch_assoc($qku1);
				$ku1_gurkd = nosql($rku1['kd_guru']);
				$ku1_progkd = nosql($rku1['kd_prog_pddkn']);


				//guru ne
				$qku2 = mysqli_query($koneksi, "SELECT kd_pegawai FROM m_guru ".
							"WHERE kd = '$ku1_gurkd'");
				$rku2 = mysqli_fetch_assoc($qku2);
				$ku2_pkd = nosql($rku2['kd_pegawai']);







				//detail e
				$qcc1 = mysqli_query($koneksi, "SELECT nip, nama FROM m_pegawai ".
							"WHERE kd = '$ku2_pkd'");
				$rcc1 = mysqli_fetch_assoc($qcc1);
				$dte_nip = nosql($rcc1['nip']);
				$dte_nm = balikin($rcc1['nama']);


				//pddkn
				$qcc2 = mysqli_query($koneksi, "SELECT prog_pddkn FROM m_prog_pddkn ".
							"WHERE kd = '$ku1_progkd'");
				$rcc2 = mysqli_fetch_assoc($qcc2);
				$dte_pel = balikin($rcc2['prog_pddkn']);



				//ruang e
				$qru1 = mysqli_query($koneksi, "SELECT * FROM m_ruang ".
							"WHERE kd = '$dte_rukd'");
				$rru1 = mysqli_fetch_assoc($qru1);
				$ru1_ruang = balikin($rru1['ruang']);


				//ruang e
				$qru2 = mysqli_query($koneksi, "SELECT * FROM m_ruang ".
							"WHERE kd = '$dte_rukd2'");
				$rru2 = mysqli_fetch_assoc($qru2);
				$ru2_ruang = balikin($rru2['ruang']);


				//nek ada
				if ($tdte != 0)
					{
					echo '<strong>'.$dte_pel.'</strong>
					<br>
					<em>'.$dte_nip.'. '.$dte_nm.'.</em>
					<br>
					[Ruang : '.$ru1_ruang.', '.$ru2_ruang.'].
					<br>';
					}
				else
					{
					echo '-';
					}
				}
			while ($rdte = mysqli_fetch_assoc($qdte));

			echo '</td>';

			}
		while ($rhri = mysqli_fetch_assoc($qhri));

		echo '</tr>';
		}
	while ($rjm = mysqli_fetch_assoc($qjm));

	echo '</table>';
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