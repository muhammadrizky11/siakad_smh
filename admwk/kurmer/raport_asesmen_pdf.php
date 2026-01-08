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
$filenya = "raport_asesmen_pdf.php";
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


//ketahui nomor tingkat kelas
$qku = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
									"WHERE nama = '$kelkd'");
$rku = mysqli_fetch_assoc($qku);
$kelas_kode = balikin($rku['no']);

$e_fase = $arrrfase[$kelas_kode];




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
		<td>Fase</td>
		<td>:</td>
		<td>'.$e_fase.'</td>
	</tr>
	

	<tr valign="top">
		<td>Nama</td>
		<td>:</td>
		<td>'.$ku_nama.'</td>
		<td>Semester</td>
		<td>:</td>
		<td>'.$smt.'</td>
	</tr>

	<tr valign="top">
		<td>Nomor Induk/NIS</td>
		<td>:</td>
		<td>'.$ku_nis.'</td>
		<td>Tahun Pelajaran</td>
		<td>:</td>
		<td>'.$tapelkd2.'</td>
	</tr>
	
</table>

<hr>';


echo '<table width="528" cellpadding="3" cellspacing="0" border="0">
	<tr valign="top">
		<td align="center"><h3>LAPORAN HASIL BELAJAR (RAPOR)</h3></td>
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


<?php
echo '<table cellpadding="4" cellspacing="0" border="1">
	<tr valign="top" bgcolor="grey">
		<td align="center" width="22" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0.04in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
			<b>No</b>
		</td>
		<td align="center" width="200" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0.04in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
			<b>Mata Pelajaran</b>
		</td>
		<td width="10" align="center" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
			<b>Nilai Akhir</b>
		</td>
		<td align="center" width="250" style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0.04in">
			<b>Capaian Kompetensi</b>
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
			$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_nilai_asesmen_sumatif ".
												"WHERE tapel = '$tapelkd' ".
												"AND kelas = '$kelkd' ".
												"AND smt = '$smt' ".
												"AND siswa_nis = '$ku_nis' ".
												"AND kode = '$jus_kode'");
			$rku = mysqli_fetch_assoc($qku);
			$i_lm_na = balikin($rku['lm_na']);
			$i_as_non_tes = balikin($rku['as_non_tes']);
			$i_as_tes = balikin($rku['as_tes']);
			$i_as_na = balikin($rku['as_na']);
			$i_pnilai = balikin($rku['nil_raport']);
			



			//nilai
			$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_nilai_asesmen_formatif ".
												"WHERE tapel = '$tapelkd' ".
												"AND kelas = '$kelkd' ".
												"AND smt = '$smt' ".
												"AND siswa_nis = '$ku_nis' ".
												"AND kode = '$jus_kode'");
			$rku = mysqli_fetch_assoc($qku);
			$i_ptinggi = balikin($rku['desk_tinggi']);
			$i_prendah = balikin($rku['desk_rendah']);


			//jika ada
			if (!empty($i_ptinggi))
				{
				$i_pket = "$i_ptinggi<hr>$i_prendah";
				}
			else
				{
				$i_pket = "";
				}


		
		
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
				<td style="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0.04in">
					'.$i_pket.'
				</td>
			</tr>';
			}
		while ($rjus = mysqli_fetch_assoc($qjus));
		
		
		
		}
	while ($rjuk = mysqli_fetch_assoc($qjuk));

echo '</table>
<br>';




echo '<table width="528" cellpadding="3" cellspacing="0" border="1">
	<tr valign="top" bgcolor="grey">
		<td align="center" width="22" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0.04in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
			<b>No</b>
		</td>
		
		<td align="center" width="207" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0.04in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
			<b>Ekstrakurikuler</b>
		</td>
		
		<td align="center" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0.04in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
			<b>Keterangan</b>
		</td>
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
		<td align="left">'.$jus_ket.'</td>
		</tr>';
		}
	while ($rjus = mysqli_fetch_assoc($qjus));
	
echo '</table>
<br>';












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



echo '<table width="237" cellpadding="3" cellspacing="0" border="1">
	<tr valign="top" bgcolor="grey">
		<td align="center" colspan="2"><b>KETIDAKHADIRAN</b></td>
	</tr>
	
	<tr valign="top">
		<td width="150" align="left">Sakit</td>
		<td align="left">'.$ku_sakit.' hari</td>
	</tr>
	
	<tr valign="top">
		<td align="left">Ijin</td>
		<td align="left">'.$ku_ijin.' hari</td>
	</tr>
	
	<tr valign="top">
		<td align="left">Tanpa Keterangan</td>
		<td align="left">'.$ku_alpha.' hari</td>
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