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





//nilai
$filenya = "raport_pdf.php";
$judulku = "$judul";
$judulx = $judul;
$swkd = cegah($_REQUEST['swkd']);
$swnis = cegah($_REQUEST['swnis']);
$tapelkd = cegah($_REQUEST['tapelkd']);
$tapelkd2 = balikin($tapelkd);
$kelkd = cegah($_REQUEST['kelkd']);
$kelkd2 = balikin($kelkd);
$smt = cegah($_REQUEST['smt']);
$kunci = cegah($_REQUEST['kunci']);
$kunci2 = balikin($_REQUEST['kunci']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}
	






require_once("../../inc/class/dompdf/autoload.inc.php");

use Dompdf\Dompdf;
$dompdf = new Dompdf();


?>




<?php
//isi *START
ob_start();



//nilai
$qku = mysqli_query($koneksi, "SELECT * FROM m_ks");
$rku = mysqli_fetch_assoc($qku);
$ks_kode = balikin($rku['peg_kode']);
$ks_nama = balikin($rku['peg_nama']);




//nilai
$qku = mysqli_query($koneksi, "SELECT * FROM m_walikelas ".
									"WHERE tapel_nama = '$tapelkd' ".
									"AND kelas_nama = '$kelkd'");
$rku = mysqli_fetch_assoc($qku);
$wk_kode = balikin($rku['peg_kode']);
$wk_nama = balikin($rku['peg_nama']);




//detail siswa
$qku = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
								"WHERE kd = '$swkd'");
$rku = mysqli_fetch_assoc($qku);
$ku_nis = balikin($rku['kode']);
$ku_nama = balikin($rku['nama']);
$ku_nama2 = strip($ku_nama);



	
echo '<table width="630" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td width="100">Nama Sekolah</td>
		<td width="10">:</td>
		<td width="225">'.$sek_nama.'</td>
		<td width="100">Kelas</td>
		<td width="10">:</td>
		<td>'.$kelkd2.'</td>
	</tr>

	<tr valign="top">
		<td>Alamat</td>
		<td>:</td>
		<td>'.$sek_alamat.'</td>
		<td>Semester</td>
		<td>:</td>
		<td>'.$smt.'</td>
	</tr>
	

	<tr valign="top">
		<td>Nama</td>
		<td>:</td>
		<td>'.$ku_nama.'</td>
		<td>Tahun Pelajaran</td>
		<td>:</td>
		<td>'.$tapelkd2.'</td>
	</tr>

	<tr valign="top">
		<td>Nomor Induk/NIS</td>
		<td>:</td>
		<td>'.$ku_nis.'</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	
</table>

<hr>';


echo '<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="center"><h3>CAPAIAN HASIL BELAJAR</h3></td>
	</tr>
</table>';



echo '<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left"><b>A. SIKAP</b></td>
	</tr>
</table>';


//nilai
$qyuk = mysqli_query($koneksi, "SELECT * FROM siswa_raport_sikap ".
									"WHERE tapel = '$tapelkd' ".
									"AND kelas = '$kelkd' ".
									"AND smt = '$smt' ".
									"AND siswa_kode = '$swnis'");
$ryuk = mysqli_fetch_assoc($qyuk);
$yuk_sp_pred = balikin($ryuk['spiritual_predikat']);
$yuk_sp_isi = balikin($ryuk['spiritual_isi']);
$yuk_so_pred = balikin($ryuk['sosial_predikat']);
$yuk_so_isi = balikin($ryuk['sosial_isi']);

echo '<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left"><b>1. Sikap Spiritual</b></td>
	</tr>
</table>';


echo '<table width="528" cellpadding="3" cellspacing="0" border="1">
	<tr valign="top">
		<td align="center" width="100"><b>Predikat</b></td>
		<td align="center"><b>Deskripsi</b></td>
	</tr>
	<tr valign="top">
		<td align="center">'.$yuk_sp_pred.'</td>
		<td align="left">'.$yuk_sp_isi.'<br><br></td>
	</tr>
</table>
<br>';





echo '<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left"><b>2. Sikap Sosial</b></td>
	</tr>
</table>';


echo '<table width="528" cellpadding="3" cellspacing="0" border="1">
	<tr valign="top">
		<td align="center" width="100"><b>Predikat</b></td>
		<td align="center"><b>Deskripsi</b></td>
	</tr>
	<tr valign="top">
		<td align="center">'.$yuk_so_pred.'</td>
		<td align="left">'.$yuk_so_isi.'<br><br></td>
	</tr>
</table>
<br>';







echo '<br>
<br>
<br>
<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left" width="350">&nbsp;</td>
		<td align="left">
		'.$sek_kota.', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'
		<br>
		Wali Kelas
		<br>
		<br>
		<br>
		<br>
		<br>
		<b><u>'.$wk_nama.'</u></b>
		<br>
		NIP.'.$wk_kode.'
		</td>
	</tr>
</table>';
?>


<style>
	#footer { position: fixed; right: 0px; bottom: 10px; text-align: center;border-top: 1px solid black;}
    
    #footer .page:after { content: counter(page, decimal); }
        
	@page { margin: 20px 30px 40px 50px; }
</style>


<div id="footer">
    <p class="page">Halaman </p>
  </div> 

<div style="page-break-before: always;"></div>




<?php
echo '<table width="630" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td width="100">Nama Sekolah</td>
		<td width="10">:</td>
		<td width="225">'.$sek_nama.'</td>
		<td width="100">Kelas</td>
		<td width="10">:</td>
		<td>'.$kelkd2.'</td>
	</tr>

	<tr valign="top">
		<td>Alamat</td>
		<td>:</td>
		<td>'.$sek_alamat.'</td>
		<td>Semester</td>
		<td>:</td>
		<td>'.$smt.'</td>
	</tr>
	

	<tr valign="top">
		<td>Nama</td>
		<td>:</td>
		<td>'.$ku_nama.'</td>
		<td>Tahun Pelajaran</td>
		<td>:</td>
		<td>'.$tapelkd2.'</td>
	</tr>

	<tr valign="top">
		<td>Nomor Induk/NIS</td>
		<td>:</td>
		<td>'.$ku_nis.'</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	
</table>

<hr>';



echo '<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left"><b>B. PENGETAHUAN</b></td>
	</tr>
</table>';

echo '<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left">Kriteria Ketuntasan Minimal = 75</td>
	</tr>
</table>';


echo '<table cellpadding="4" cellspacing="0" border="1">
	<tr valign="top">
		<td align="center" rowspan="2" width="22" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0.04in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
			<b>No</b>
		</td>
		<td align="center" rowspan="2" width="200" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0.04in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
			<b>Mata Pelajaran</b>
		</td>
		<td align="center" colspan="3" style="border: 1px solid #000000; padding: 0.04in">
			<b>Pengetahuan</b>
		</td>
	</tr>
	<tr valign="top">
		<td width="22" align="center" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
			<b>Nilai</b>
		</td>
		<td align="center" width="22" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
			<b>Predikat</b>
		</td>
		<td align="center" width="200" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0.04in">
			<b>Deskripsi</b>
		</td>
	</tr>';

	

	//list jenis
	$qjuk = mysqli_query($koneksi, "SELECT * FROM m_mapel_jns ".
										"ORDER BY jenis ASC");
	$rjuk = mysqli_fetch_assoc($qjuk);
	
	do
		{
		//nilai
		$juk_nama = balikin($rjuk['jenis']);
		
		
		echo '<tr>
			<td colspan="5" width="100%" valign="top" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0.04in">
				<b>'.$juk_nama.'</b>
			</td>
		</tr>';
		
		
		//list mapel
		$qjus = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
											"WHERE jenis = '$juk_nama' ".
											"AND tapel = '$tapelkd' ".
											"AND kelas = '$kelkd' ".
											"ORDER BY round(no) ASC");
		$rjus = mysqli_fetch_assoc($qjus);
		
		do
			{
			//nilai
			$jus_no = balikin($rjus['no']);
			$jus_kode = balikin($rjus['kode']);
			$jus_nama = balikin($rjus['nama']);
			
			
			
			//nilai
			$qku = mysqli_query($koneksi, "SELECT * FROM siswa_nilai_smt ".
												"WHERE tapel = '$tapelkd' ".
												"AND kelas = '$kelkd' ".
												"AND smt = '$smt' ".
												"AND siswa_kode = '$ku_nis' ".
												"AND mapel_kode = '$jus_kode'");
			$rku = mysqli_fetch_assoc($qku);
			$i_pnilai = balikin($rku['p_na']);
			$i_ppredikat = balikin($rku['p_na_pred']);
			$i_pket = balikin($rku['p_isi']);
			$i_knilai = balikin($rku['k_na']);
			$i_kpredikat = balikin($rku['k_na_pred']);
			$i_kket = balikin($rku['k_isi']);
			

		
		
			echo '<tr valign="top">
				<td align="center" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
					'.$jus_no.'
				</td>
				<td style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
					'.$jus_nama.'
				</td>
				<td align="center" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
					'.$i_pnilai.'
				</td>
				<td align="center" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
					'.$i_ppredikat.'
				</td>
				<td style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0.04in">
					'.$i_pket.'
				</td>
			</tr>';
			}
		while ($rjus = mysqli_fetch_assoc($qjus));
		
		
		
		}
	while ($rjuk = mysqli_fetch_assoc($qjuk));

echo '</table>';







echo '<br>
<br>
<br>
<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left" width="350">&nbsp;</td>
		<td align="left">
		'.$sek_kota.', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'
		<br>
		Wali Kelas
		<br>
		<br>
		<br>
		<br>
		<br>
		<b><u>'.$wk_nama.'</u></b>
		<br>
		NIP.'.$wk_kode.'
		</td>
	</tr>
</table>';
?>


<div style="page-break-before: always;"></div>


<?php
echo '<table width="630" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td width="100">Nama Sekolah</td>
		<td width="10">:</td>
		<td width="225">'.$sek_nama.'</td>
		<td width="100">Kelas</td>
		<td width="10">:</td>
		<td>'.$kelkd2.'</td>
	</tr>

	<tr valign="top">
		<td>Alamat</td>
		<td>:</td>
		<td>'.$sek_alamat.'</td>
		<td>Semester</td>
		<td>:</td>
		<td>'.$smt.'</td>
	</tr>
	

	<tr valign="top">
		<td>Nama</td>
		<td>:</td>
		<td>'.$ku_nama.'</td>
		<td>Tahun Pelajaran</td>
		<td>:</td>
		<td>'.$tapelkd2.'</td>
	</tr>

	<tr valign="top">
		<td>Nomor Induk/NIS</td>
		<td>:</td>
		<td>'.$ku_nis.'</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	
</table>

<hr>';




echo '<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left"><b>C. KETERAMPILAN</b></td>
	</tr>
</table>';

echo '<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left">Kriteria Ketuntasan Minimal = 75</td>
	</tr>
</table>';


echo '<table cellpadding="4" cellspacing="0" border="1">
	<tr valign="top">
		<td align="center" rowspan="2" width="22" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0.04in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
			<b>No</b>
		</td>
		<td align="center" rowspan="2" width="200" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0.04in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
			<b>Mata Pelajaran</b>
		</td>
		<td align="center" colspan="3" style="border: 1px solid #000000; padding: 0.04in">
			<b>Keterampilan</b>
		</td>
	</tr>
	<tr valign="top">
		<td width="22" align="center" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
			<b>Nilai</b>
		</td>
		<td align="center" width="22" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
			<b>Predikat</b>
		</td>
		<td align="center" width="200" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0.04in">
			<b>Deskripsi</b>
		</td>
	</tr>';

	

	//list jenis
	$qjuk = mysqli_query($koneksi, "SELECT * FROM m_mapel_jns ".
										"ORDER BY jenis ASC");
	$rjuk = mysqli_fetch_assoc($qjuk);
	
	do
		{
		//nilai
		$juk_nama = balikin($rjuk['jenis']);
		
		
		echo '<tr>
			<td colspan="5" width="100%" valign="top" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0.04in">
				<b>'.$juk_nama.'</b>
			</td>
		</tr>';
		
		
		//list mapel
		$qjus = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
											"WHERE jenis = '$juk_nama' ".
											"AND tapel = '$tapelkd' ".
											"AND kelas = '$kelkd' ".
											"ORDER BY round(no) ASC");
		$rjus = mysqli_fetch_assoc($qjus);
		
		do
			{
			//nilai
			$jus_no = balikin($rjus['no']);
			$jus_kode = balikin($rjus['kode']);
			$jus_nama = balikin($rjus['nama']);
			
			
			
			//nilai
			$qku = mysqli_query($koneksi, "SELECT * FROM siswa_nilai_smt ".
												"WHERE tapel = '$tapelkd' ".
												"AND kelas = '$kelkd' ".
												"AND smt = '$smt' ".
												"AND siswa_kode = '$ku_nis' ".
												"AND mapel_kode = '$jus_kode'");
			$rku = mysqli_fetch_assoc($qku);
			$i_pnilai = balikin($rku['p_na']);
			$i_ppredikat = balikin($rku['p_na_pred']);
			$i_pket = balikin($rku['p_isi']);
			$i_knilai = balikin($rku['k_na']);
			$i_kpredikat = balikin($rku['k_na_pred']);
			$i_kket = balikin($rku['k_isi']);
			

		
		
			echo '<tr valign="top">
				<td align="center" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
					'.$jus_no.'
				</td>
				<td style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
					'.$jus_nama.'
				</td>
				<td align="center" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
					'.$i_knilai.'
				</td>
				<td align="center" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
					'.$i_kpredikat.'
				</td>
				<td style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0.04in">
					'.$i_kket.'
				</td>
			</tr>';
			}
		while ($rjus = mysqli_fetch_assoc($qjus));
		
		
		
		}
	while ($rjuk = mysqli_fetch_assoc($qjuk));

echo '</table>';








echo '<br>
<br>
<br>
<table width="630" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left" width="350">&nbsp;</td>
		<td align="left">
		'.$sek_kota.', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'
		<br>
		Wali Kelas
		<br>
		<br>
		<br>
		<br>
		<br>
		<b><u>'.$wk_nama.'</u></b>
		<br>
		NIP.'.$wk_kode.'
		</td>
	</tr>
</table>';
?>


<div style="page-break-before: always;"></div>


<?php
echo '<table width="630" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td width="100">Nama Sekolah</td>
		<td width="10">:</td>
		<td width="225">'.$sek_nama.'</td>
		<td width="100">Kelas</td>
		<td width="10">:</td>
		<td>'.$kelkd2.'</td>
	</tr>

	<tr valign="top">
		<td>Alamat</td>
		<td>:</td>
		<td>'.$sek_alamat.'</td>
		<td>Semester</td>
		<td>:</td>
		<td>'.$smt.'</td>
	</tr>
	

	<tr valign="top">
		<td>Nama</td>
		<td>:</td>
		<td>'.$ku_nama.'</td>
		<td>Tahun Pelajaran</td>
		<td>:</td>
		<td>'.$tapelkd2.'</td>
	</tr>

	<tr valign="top">
		<td>Nomor Induk/NIS</td>
		<td>:</td>
		<td>'.$ku_nis.'</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	
</table>

<hr>';

echo '<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left"><b>D. EKSTRAKURIKULER</b></td>
	</tr>
</table>';



echo '<table width="528" cellpadding="3" cellspacing="0" border="1">
	<tr valign="top">
		<td width="10" align="center"><b>No</b></td>
		<td width="200" align="center"><b>Kegiatan Ekstrakurikuler</b></td>
		<td width="20" align="center"><b>Predikat</b></td>
		<td align="center"><b>Keterangan</b></td>
	</tr>';

	//list 
	$qjus = mysqli_query($koneksi, "SELECT * FROM siswa_ekstra ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd' ".
										"AND smt = '$smt' ".
										"AND siswa_nis = '$ku_nis' ".
										"ORDER BY ekstra_nama ASC");
	$rjus = mysqli_fetch_assoc($qjus);
	
	do
		{
		//nilai
		$jus_nox = $jus_nox + 1; 
		$jus_nama = balikin($rjus['ekstra_nama']);
		$jus_predikat = balikin($rjus['predikat']);
		$jus_ket = balikin($rjus['ket']);

		echo '<tr valign="top">
		<td align="center">'.$jus_nox.'</td>
		<td align="left">'.$jus_nama.'</td>
		<td align="center">'.$jus_predikat.'</td>
		<td align="left">'.$jus_ket.'</td>
		</tr>';
		}
	while ($rjus = mysqli_fetch_assoc($qjus));
	
echo '</table>';










echo '<br>
<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left"><b>E. PRESTASI</b></td>
	</tr>
</table>';



echo '<table width="528" cellpadding="3" cellspacing="0" border="1">
	<tr valign="top">
		<td width="10" align="center"><b>No</b></td>
		<td width="200" align="center"><b>Jenis Prestasi</b></td>
		<td align="center"><b>Keterangan</b></td>
	</tr>';

	//list 
	$qjus = mysqli_query($koneksi, "SELECT * FROM siswa_prestasi ".
										"WHERE tapel_nama = '$tapelkd' ".
										"AND kelas_nama = '$kelkd' ".
										"AND siswa_nis = '$ku_nis' ".
										"ORDER BY point_nama ASC");
	$rjus = mysqli_fetch_assoc($qjus);
	
	do
		{
		//nilai
		$jus_noy = $jus_noy + 1; 
		$jus_nama = balikin($rjus['point_nama']);
		$jus_ket = balikin($rjus['point_ket']);

		echo '<tr valign="top">
		<td align="center">'.$jus_noy.'</td>
		<td align="left">'.$jus_nama.'</td>
		<td align="left">'.$jus_ket.'</td>
		</tr>';
		}
	while ($rjus = mysqli_fetch_assoc($qjus));
	
echo '</table>';
















echo '<br>
<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left"><b>F. KETIDAKHADIRAN</b></td>
	</tr>
</table>';


//nilai
$qceku = mysqli_query($koneksi, "SELECT COUNT(kd) AS jmlnya ".
									"FROM user_absensi ".
									"WHERE user_jabatan = 'SISWA' ".
									"AND user_kode = '$ku_nis' ".
									"AND ket = 'Sakit'");
$rceku = mysqli_fetch_assoc($qceku);
$ku_sakit = round(balikin($rceku['jmlnya']));


//nilai
$qceku = mysqli_query($koneksi, "SELECT COUNT(kd) AS jmlnya ".
									"FROM user_absensi ".
									"WHERE user_jabatan = 'SISWA' ".
									"AND user_kode = '$ku_nis' ".
									"AND ket = 'Ijin'");
$rceku = mysqli_fetch_assoc($qceku);
$ku_ijin = round(balikin($rceku['jmlnya']));


//nilai
$qceku = mysqli_query($koneksi, "SELECT COUNT(kd) AS jmlnya ".
									"FROM user_absensi ".
									"WHERE user_jabatan = 'SISWA' ".
									"AND user_kode = '$ku_nis' ".
									"AND ket = 'Alpha'");
$rceku = mysqli_fetch_assoc($qceku);
$ku_alpha = round(balikin($rceku['jmlnya']));



echo '<table width="528" cellpadding="3" cellspacing="0" border="1">
	<tr valign="top">
		<td width="15" align="center">1</td>
		<td width="200" align="left">Sakit</td>
		<td align="left">'.$ku_sakit.' hari</td>
	</tr>
	
	<tr valign="top">
		<td width="15" align="center">2</td>
		<td align="left">Ijin</td>
		<td align="left">'.$ku_ijin.' hari</td>
	</tr>
	
	<tr valign="top">
		<td width="15" align="center">3</td>
		<td align="left">Tanpa Keterangan</td>
		<td align="left">'.$ku_alpha.' hari</td>
	</tr>
</table>';












echo '<br>
<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left"><b>G. CATATAN WALI KELAS</b></td>
	</tr>
</table>';


//list 
$qjus = mysqli_query($koneksi, "SELECT * FROM siswa_raport_catatan ".
									"WHERE tapel = '$tapelkd' ".
									"AND kelas = '$kelkd' ".
									"AND siswa_kode = '$ku_nis' ".
									"AND smt = '$smt'");
$rjus = mysqli_fetch_assoc($qjus);
$jus_isi = balikin($rjus['isi']);

echo '<table width="528" cellpadding="3" cellspacing="0" border="1">
	<tr valign="top">
		<td align="left">
			'.$jus_isi.'
			<br>
			<br>
		</td>
	</tr>
</table>';









echo '<br>
<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="left"><b>H. TANGGAPAN ORANG TUA/WALI</b></td>
	</tr>
</table>';


echo '<table width="528" cellpadding="3" cellspacing="0" border="1">
	<tr valign="top">
		<td align="left">
			<br>
			<br>
			<br>
			<br>
		</td>
	</tr>
</table>';






//jika smt 2
if ($smt == "2")
	{
	//nilai
	$qku = mysqli_query($koneksi, "SELECT * FROM siswa_raport_kenaikan ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd' ".
										"AND siswa_kode = '$ku_nis'");
	$rku = mysqli_fetch_assoc($qku);
	$i_status = balikin($rku['status']);
	$i_baru_tapel = balikin($rku['baru_tapel']);
	$i_baru_kelas = balikin($rku['baru_kelas']);

	
	//jika kenaikan
	if (($i_status == "Naik Kelas") OR ($i_status == "Tinggal Kelas"))
		{
		echo '<br>
		<table width="528" cellpadding="3" cellspacing="0" border="0">
			<tr valign="top">
				<td align="center" width="210">
				</td>
				<td align="left">
					Keputusan :
					<br>
					Berdasarkan hasil yang dicapai pada
					<br>
					Semester 1 dan 2, peserta didik ditetapkan
					<br>
					<b>'.$i_status.' '.$i_baru_kelas.'</b>			
				</td>
			</tr>
		</table>';
		}
	else
		{
		echo '<br>
		<table width="528" cellpadding="3" cellspacing="0" border="0">
			<tr valign="top">
				<td align="center" width="210">
				</td>
				<td align="left">
					Keputusan :
					<br>
					Berdasarkan hasil yang dicapai pada
					<br>
					masa pendidikan, peserta didik ditetapkan
					<br>
					<b>'.$i_status.'</b>			
				</td>
			</tr>
		</table>';
		}
	}






echo '<br>
<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="center" width="33%">
			<br>
			<br>
			Orang Tua/Wali
			<br>
			<br>
			<br>
			<br>
			<br>
			.........................
		</td>
		<td align="center">
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			
			Kepala Sekolah
			<br>
			<br>
			<br>
			<br>
			<br>
			<b><u>'.$ks_nama.'</u></b>
			<br>
			NIP.'.$ks_kode.'
			
		</td>
		<td width="33%" align="center">
		'.$sek_kota.', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'
		<br>
		<br>
		Wali Kelas
		<br>
		<br>
		<br>
		<br>
		<br>
		<b><u>'.$wk_nama.'</u></b>
		<br>
		NIP.'.$wk_kode.'
		</td>
	</tr>
</table>';




 
//isi
$isi = ob_get_contents();
ob_end_clean();



//echo $isi;



$dompdf->loadHtml($isi);

// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
//$dompdf->stream('raport-$nis-$ku_nama2.pdf');
$dompdf->stream('raport-'.$ku_nis.'-'.$ku_nama2.'.pdf');
?>