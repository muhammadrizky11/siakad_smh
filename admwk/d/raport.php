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

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admwk.php");
$tpl = LoadTpl("../../template/admwk.html");






//nilai
$filenya = "raport.php";
$judul = "Raport";

$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$skkd = nosql($_REQUEST['skkd']);
$swkd = nosql($_REQUEST['swkd']);
$progkd = nosql($_REQUEST['progkd']);
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);

//page...
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"swkd=$swkd&skkd=$skkd&progkd=$progkd&page=$page";


//siswa ne
$qsiw = mysqli_query($koneksi, "SELECT siswa_kelas.*, siswa_kelas.kd AS skkd, m_siswa.* ".
						"FROM siswa_kelas, m_siswa ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd = '$skkd'");
$rsiw = mysqli_fetch_assoc($qsiw);
$siw_nis = nosql($rsiw['nis']);
$siw_nama = balikin($rsiw['nama']);
$skkd = nosql($rsiw['skkd']);



//judul
$judul = "Raport Siswa : ($siw_nis).$siw_nama";
$judulku = "[AKADEMIK]. $judul";
$judulz = $judul;




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//jika simpan catatan
if ($_POST['btnSMP5'])
	{
	//ambil nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$skkd = nosql($_POST['skkd']);
	$catatan = cegah($_POST['catatan']);


	//cek
	$qcc = mysqli_query($koneksi, "SELECT * FROM siswa_catatan ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd'");
	$rcc = mysqli_fetch_assoc($qcc);
	$tcc = mysqli_num_rows($qcc);

	//nek ada
	if ($tcc != 0)
		{
		//update
		mysqli_query($koneksi, "UPDATE siswa_catatan SET catatan = '$catatan' ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_smt = '$smtkd'");
		}
	//jika blm ada
	else
		{
		mysqli_query($koneksi, "INSERT INTO siswa_catatan(kd, kd_siswa_kelas, kd_smt, catatan) VALUES ".
						"('$x', '$skkd', '$smtkd', '$catatan')");
		}


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&skkd=$skkd";
	xloc($ke);
	exit();
	}





//jika simpan saran
if ($_POST['btnSMP6'])
	{
	//ambil nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$skkd = nosql($_POST['skkd']);
	$catatan = cegah($_POST['saran']);


	//cek
	$qcc = mysqli_query($koneksi, "SELECT * FROM siswa_saran ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd'");
	$rcc = mysqli_fetch_assoc($qcc);
	$tcc = mysqli_num_rows($qcc);

	//nek ada
	if ($tcc != 0)
		{
		//update
		mysqli_query($koneksi, "UPDATE siswa_saran SET saran = '$catatan' ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_smt = '$smtkd'");
		}
	//jika blm ada
	else
		{
		mysqli_query($koneksi, "INSERT INTO siswa_saran(kd, kd_siswa_kelas, kd_smt, saran) VALUES ".
						"('$x', '$skkd', '$smtkd', '$catatan')");
		}


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&skkd=$skkd";
	xloc($ke);
	exit();
	}





//kenaikan kelas
if ($_POST['btnSMP6'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$tpfkd = nosql($_POST['tpfkd']);
	$tpfthn1 = nosql($_POST['tpfthn1']);
	$tpfthn2 = nosql($_POST['tpfthn2']);
	$kelasx = nosql($_POST['kelasx']);
	$skkd = nosql($_POST['skkd']);
	$swkd = nosql($_POST['swkd']);


	//nek null
	if (empty($tpfkd))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Tahun Pelajaran : $tpfthn1/$tpfthn2, Belum Ada. Silahkan Anda Setting Dahulu Tahun Pelajaran Tersebut...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&skkd=$skkd";
		pekem($pesan,$ke);
		exit();
		}

	else if (empty($kelasx))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Kenaikan atau Tinggal Kelas, Belum Ditentukan. Silahkan Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&skkd=$skkd";
		pekem($pesan,$ke);
		exit();
		}

	else
		{
		//cek
		$qcc = mysqli_query($koneksi, "SELECT * FROM siswa_kelas ".
								"WHERE kd_tapel = '$tpfkd' ".
								"AND kd_siswa = '$swkd'");
		$rcc = mysqli_fetch_assoc($qcc);
		$tcc = mysqli_num_rows($qcc);

		//nek ada
		if ($tcc != 0)
			{
			//update
			mysqli_query($koneksi, "UPDATE siswa_kelas SET kd_kelas = '$kelasx' ".
							"WHERE kd_tapel = '$tpfkd' ".
							"AND kd_siswa = '$swkd'");

			//kenaikan
			if ($kelasx == $kelkd)
				{
				//tinggal kelas
				$naik_ket = "false";
				}
			else
				{
				//naik kelas
				$naik_ket = "true";
				}


			//cek
			$qcc1 = mysqli_query($koneksi, "SELECT * FROM siswa_naik ".
									"WHERE kd_tapel = '$tpfkd' ".
									"AND kd_siswa_kelas = '$skkd'");
			$rcc1 = mysqli_fetch_assoc($qcc1);
			$tcc1 = mysqli_num_rows($qcc1);

			if ($tcc1 != 0)
				{
				//siswa_naik
				mysqli_query($koneksi, "UPDATE siswa_naik SET naik = '$naik_ket', ".
								"kd_kelas = '$kelasx' ".
								"WHERE kd_tapel = '$tpfkd' ".
								"AND kd_siswa_kelas = '$skkd'");
				}
			else
				{
				//siswa_naik
				mysqli_query($koneksi, "INSERT INTO siswa_naik(kd, kd_tapel, kd_kelas, kd_siswa_kelas, naik) VALUES ".
								"('$x', '$tpfkd', '$kelasx', '$skkd', '$naik_ket')");
				}


			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "Kenaikan atau Tinggal Kelas, Berhasil Dilakukan. Silahkan Lakukan Penempatan untuk Siswa Tersebut...!!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&skkd=$skkd";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//baru
			mysqli_query($koneksi, "INSERT INTO siswa_kelas(kd, kd_tapel, kd_kelas, kd_siswa) VALUES ".
							"('$x', '$tpfkd', '$kelasx', '$swkd')");


			//kenaikan
			if ($kelasx == $kelkd)
				{
				//tinggal kelas
				$naik_ket = "false";
				}
			else
				{
				//naik kelas
				$naik_ket = "true";
				}


			//siswa_naik
			mysqli_query($koneksi, "INSERT INTO siswa_naik(kd, kd_tapel, kd_kelas, kd_siswa_kelas, naik) VALUES ".
							"('$x', '$tpfkd', '$kelasx', '$skkd', '$naik_ket')");

			//re-direct
			$pesan = "Kenaikan atau Tinggal Kelas, Berhasil Dilakukan. Silahkan Lakukan Penempatan untuk Siswa Tersebut...!!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&skkd=$skkd";
			pekem($pesan,$ke);
			exit();
			}
		}
	}





//kelulusan
if ($_POST['btnSMP7'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$tpfkd = nosql($_POST['tpfkd']);
	$lulus = nosql($_POST['lulus']);
	$skkd = nosql($_POST['skkd']);


	//nek null
	if (empty($lulus))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Kelulusan Belum Ditentukan. Harap diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&skkd=$skkd";
		pekem($pesan,$ke);
		exit();
		}

	else
		{
		//cek
		$qcc = mysqli_query($koneksi, "SELECT * FROM siswa_lulus ".
								"WHERE kd_tapel = '$tpfkd' ".
								"AND kd_siswa_kelas = '$skkd'");
		$rcc = mysqli_fetch_assoc($qcc);
		$tcc = mysqli_num_rows($qcc);

		//nek ada
		if ($tcc != 0)
			{
			//update
			mysqli_query($koneksi, "UPDATE siswa_lulus SET lulus = '$lulus' ".
							"WHERE kd_tapel = '$tpfkd' ".
							"AND kd_siswa_kelas = '$skkd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);


			//re-direct
			$pesan = "Lulus atau Tidak Lulus, Berhasil Dilakukan.";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&skkd=$skkd";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//baru
			mysqli_query($koneksi, "INSERT INTO siswa_lulus(kd, kd_tapel, kd_siswa_kelas, lulus) VALUES ".
							"('$x', '$tpfkd', '$skkd', '$lulus')");

			//re-direct
			$pesan = "Lulus atau Tidak Lulus, Berhasil Dilakukan.";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&skkd=$skkd";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////










//focus....focus...
if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}









//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table>
<tr>
<td>
[<a href="detail.php?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'" title="Daftar Siswa">Daftar Siswa</a>]
</td>
</table>


<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
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
$btxno = nosql($rowbtx['no']);
$btxkelas = balikin($rowbtx['kelas']);

echo '<strong>'.$btxkelas.'</strong>

</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstx = mysqli_query($koneksi, "SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowstx = mysqli_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
$stx_no = nosql($rowstx['no']);
$stx_smt = nosql($rowstx['smt']);

echo '<option value="'.$stx_kd.'">'.$stx_smt.'</option>';

$qst = mysqli_query($koneksi, "SELECT * FROM m_smt ".
						"WHERE kd <> '$smtkd' ".
						"ORDER BY smt ASC");
$rowst = mysqli_fetch_assoc($qst);

do
	{
	$st_kd = nosql($rowst['kd']);
	$st_smt = nosql($rowst['smt']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&swkd='.$swkd.'&skkd='.$skkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysqli_fetch_assoc($qst));

echo '</select>
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
<input name="skkd" type="hidden" value="'.$skkd.'">
<input name="swkd" type="hidden" value="'.$swkd.'">
</td>
</tr>
</table>
<br>';

if (empty($smtkd))
	{
	echo '<h4>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
	</h4>';
	}

else
	{
	echo '<p>
	[<a href="raport2_xls.php?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&smtkd='.$smtkd.'&swkd='.$swkd.'&skkd='.$skkd.'" target="_blank" title="Lihat Raport..."><img src="'.$sumber.'/img/xls.gif" width="16" height="16" border="0"></a>]
	</p>



	<p>
	<big><strong>Ekstrakurikuler / Life Skill : </strong></big>
	<br>';


	//daftar ekstra yang diikuti
	$qkuti = mysqli_query($koneksi, "SELECT siswa_ekstra.*, siswa_ekstra.kd AS sekd, m_ekstra.* ".
							"FROM siswa_ekstra, m_ekstra ".
							"WHERE siswa_ekstra.kd_ekstra = m_ekstra.kd ".
							"AND siswa_ekstra.kd_siswa_kelas = '$skkd' ".
							"AND siswa_ekstra.kd_smt = '$smtkd' ".
							"ORDER BY m_ekstra.ekstra ASC");
	$rkuti = mysqli_fetch_assoc($qkuti);
	$tkuti = mysqli_num_rows($qkuti);

	//nek ada
	if ($tkuti != 0)
		{
		echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td><strong>Nama Ekstra</strong></td>
		<td width="50"><strong>Predikat</strong></td>
		<td width="250"><strong>Keterangan</strong></td>
		</tr>';

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

			$nomx = $nomx + 1;
			$kuti_kd = nosql($rkuti['sekd']);
			$kuti_ekstra = balikin($rkuti['ekstra']);
			$kuti_predikat = nosql($rkuti['predikat']);
			$kuti_ket = balikin($rkuti['ket']);

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$kuti_ekstra.'</td>
			<td>
			'.$kuti_predikat.'
			</td>
			<td>
			'.$kuti_ket.'
			</td>
			</tr>';
			}
		while ($rkuti = mysqli_fetch_assoc($qkuti));

		echo '</table>';
		}
	else
		{
		echo '<h4>
		<font color="#FF0000"><strong>Belum Punya EKSTRA...!</strong></font>
		</h4>';
		}


	echo '<hr>
	</p>
	<br>

	<p>
	<big>
	<strong>Ketidakhadiran / Absensi :</strong>
	</big>
	<br>';

	//absensi
	$qabs = mysqli_query($koneksi, "SELECT * FROM m_absensi ".
							"ORDER BY absensi ASC");
	$rabs = mysqli_fetch_assoc($qabs);
	$tabs = mysqli_num_rows($qabs);

	//nek ada
	if ($tabs != 0)
		{
		echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="5"><strong>No.</strong></td>
		<td><strong>Nama Absensi</strong></td>
		<td width="75"><strong>Jml. Hari</strong></td>
		</tr>';

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

			$nomxy = $nomxy + 1;
			$abs_kd = nosql($rabs['kd']);
			$abs_absensi = balikin($rabs['absensi']);

			//jml. absensi...
			$qbsi = mysqli_query($koneksi, "SELECT * FROM siswa_absensi ".
									"WHERE kd_siswa_kelas = '$skkd' ".
									"AND kd_absensi = '$abs_kd'");
			$rbsi = mysqli_fetch_assoc($qbsi);
			$tbsi = mysqli_num_rows($qbsi);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input name="kd'.$nomx.'" type="hidden" value="'.$abs_kd.'">
			'.$nomxy.'
			</td>
			<td>
			'.$abs_absensi.'
			</td>
			<td>
			'.$tbsi.'
			</td>
			</tr>';
			}
		while ($rabs = mysqli_fetch_assoc($qabs));

		echo '</table>';
		}

	echo '<hr>
	</p>
	<br>

	<p>
	<big>
	<strong>Kepribadian :</strong>
	</big>
	<br>';

	//daftar pribadi
	$qpri = mysqli_query($koneksi, "SELECT * FROM m_pribadi ".
							"ORDER BY pribadi ASC");
	$rpri = mysqli_fetch_assoc($qpri);
	$tpri = mysqli_num_rows($qpri);

	echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="5"><strong>No.</strong></td>
	<td><strong>Nama Kepribadian</strong></td>
	<td width="50"><strong>Predikat</strong></td>
	<td width="250"><strong>Keterangan</strong></td>
	</tr>';

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

		$nomxz = $nomxz + 1;
		$pri_kd = nosql($rpri['kd']);
		$pri_pribadi = balikin($rpri['pribadi']);

		//pribadinya...
		$qprix = mysqli_query($koneksi, "SELECT * FROM siswa_pribadi ".
								"WHERE kd_siswa_kelas = '$skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_pribadi = '$pri_kd'");
		$rprix = mysqli_fetch_assoc($qprix);
		$tprix = mysqli_num_rows($qprix);
		$prix_predikat = nosql($rprix['predikat']);
		$prix_ket = balikin($rprix['ket']);

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		'.$nomxz.'.
		</td>
		<td>'.$pri_pribadi.'</td>
		<td>
		'.$prix_predikat.'
		</td>
		<td>
		'.$prix_ket.'
		</td>
		</tr>';
		}
	while ($rpri = mysqli_fetch_assoc($qpri));

	echo '</table>
	<hr>
	</p>
	<br>

	<p>
	<big><strong>Catatan Wali Kelas :</strong></big>
	<br>';

	//catatan...
	$qcatx = mysqli_query($koneksi, "SELECT * FROM siswa_catatan ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd'");
	$rcatx = mysqli_fetch_assoc($qcatx);
	$tcatx = mysqli_num_rows($qcatx);
	$catx_catatan = balikin($rcatx['catatan']);

	echo '<textarea name="catatan" cols="50" rows="5" wrap="virtual">'.$catx_catatan.'</textarea>
	<br>
	<input name="btnSMP5" type="submit" value="SIMPAN">
	<hr>
	</p>
	<br>

	<p>
	<big><strong>Saran Wali Kelas :</strong></big>
	<br>';

	//catatan...
	$qcatx = mysqli_query($koneksi, "SELECT * FROM siswa_saran ".
							"WHERE kd_siswa_kelas = '$skkd' ".
							"AND kd_smt = '$smtkd'");
	$rcatx = mysqli_fetch_assoc($qcatx);
	$tcatx = mysqli_num_rows($qcatx);
	$catx_catatan = balikin($rcatx['saran']);

	echo '<textarea name="saran" cols="50" rows="5" wrap="virtual">'.$catx_catatan.'</textarea>
	<br>
	<input name="btnSMP6" type="submit" value="SIMPAN">
	<hr>
	</p>
	<br>';



	//jika kenaikan kelas (X, XI)
	if ((($btxno == "1") OR ($btxno == "2")) AND ($stx_no  == "2"))
		{
		//terjemahkan tapel
		$tpy_thn1 = $tpx_thn1 + 1;
		$tpy_thn2 = $tpx_thn2 + 1;

		$qtpf = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
								"WHERE tahun1 = '$tpy_thn1' ".
								"AND tahun2 = '$tpy_thn2'");
		$rtpf = mysqli_fetch_assoc($qtpf);
		$tpf_kd = nosql($rtpf['kd']);

		//terjemahkan kelas
		$qbf = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
								"WHERE kd = '$kelkd'");
		$rbf = mysqli_fetch_assoc($qbf);
		$bf_no = nosql($rbf['no']);
		$bf_nox = $bf_no + 1;
		$bf_noy = $bf_no - 1;

		echo '<br>
		<p>
		<big><strong>Keterangan Naik/Tinggal Kelas :</strong></big>
		<br>

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
	    	<td>
		<input name="tpfkd" type="hidden" value="'.$tpf_kd.'">
		<input name="swkd" type="hidden" value="'.$stdx_skkd.'">
		<input name="tpfthn1" type="hidden" value="'.$tpy_thn1.'">
		<input name="tpfthn2" type="hidden" value="'.$tpy_thn2.'">
		Tahun Pelajaran Baru : <strong>'.$tpy_thn1.'/'.$tpy_thn2.'</strong>,
		Kelas Baru : ';

		//naik...?
		$qnuk = mysqli_query($koneksi, "SELECT siswa_naik.*, m_kelas.* ".
								"FROM siswa_naik, m_kelas ".
								"WHERE siswa_naik.kd_kelas = m_kelas.kd ".
								"AND siswa_naik.kd_siswa_kelas = '$skkd' ".
								"AND siswa_naik.kd_tapel = '$tpf_kd'");
		$rnuk = mysqli_fetch_assoc($qnuk);
		$nuk_kelas = nosql($rnuk['kelas']);
		$nuk_naik = nosql($rnuk['naik']);


		if ($nuk_naik == "true")
			{
			$nuk_naik_ket = "Naik Kelas : $nuk_kelas";
			}
		else if ($nuk_naik == "false")
			{
			$nuk_naik_ket = "Tinggal Kelas : $nuk_kelas";
			}
		else
			{
			$nuk_naik_ket = "-";
			}

		echo '<select name="kelasx">
		<option value="'.$nuk_naik.'" selected>'.$nuk_naik_ket.'</option>';

		$qbt = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
								"WHERE no <= '$bf_nox' ".
								"AND no > '$bf_noy' ".
								"ORDER BY round(no) DESC");
		$rowbt = mysqli_fetch_assoc($qbt);

		do
			{
			$btkd = nosql($rowbt['kd']);
			$btno = nosql($rowbt['no']);
			$btkelas = nosql($rowbt['kelas']);

			//tinggal kelas
			if ($btno == $btxno)
				{
				$kel_ket = "Tinggal Kelas : $btkelas";
				}

			//naik kelas
			else
				{
				$kel_ket = "Naik Kelas : $btkelas";
				}

			echo '<option value="'.$btkd.'">'.$kel_ket.'</option>';
			}
		while ($rowbt = mysqli_fetch_assoc($qbt));

		echo '</select>
    		<input name="btnSMP6" type="submit" value="SIMPAN">
		</td>
		</tr>
		</table>
		</p>';
		}

	//jika kelulusan
	else if (($btxno == "3") AND ($stx_no  == "2"))
		{
		//terjemahkan tapel
		$tpy_thn1 = $tpx_thn1 + 1;
		$tpy_thn2 = $tpx_thn2 + 1;

		//tapel baru
		$qtpf = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
								"WHERE tahun1 = '$tpy_thn1' ".
								"AND tahun2 = '$tpy_thn2'");
		$rtpf = mysqli_fetch_assoc($qtpf);
		$tpf_kd = nosql($rtpf['kd']);


		//status kelulusan
		$qlus = mysqli_query($koneksi, "SELECT * FROM siswa_lulus ".
								"WHERE kd_tapel = '$tpf_kd' ".
								"AND kd_siswa_kelas = '$skkd'");
		$rlus = mysqli_fetch_assoc($qlus);
		$lus_nilai = nosql($rlus['lulus']);

		//lulus ato tidal
		if ($lus_nilai == "true")
			{
			$lus_ket = "Lulus";
			}
		else if ($lus_nilai == "false")
			{
			$lus_ket = "Tidak Lulus";
			}

		echo '<br>
		<p>
		<big><strong>Keterangan Lulus/Tidak Lulus :</strong></big>
		<br>

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
	    	<td>
		<input name="tpfkd" type="hidden" value="'.$tpf_kd.'">
		<input name="swkd" type="hidden" value="'.$stdx_skkd.'">
		<input name="tpfthn1" type="hidden" value="'.$tpy_thn1.'">
		<input name="tpfthn2" type="hidden" value="'.$tpy_thn2.'">
		Tahun Pelajaran Baru : <strong>'.$tpy_thn1.'/'.$tpy_thn2.'</strong>,
		<select name="lulus">
		<option value="'.$lus_nilai.'" selected>'.$lus_ket.'</option>
		<option value="true">Lulus</option>
		<option value="false">Tidak Lulus</option>
		</select>
   		<input name="btnSMP7" type="submit" value="SIMPAN">
		</td>
		</tr>
		</table>
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