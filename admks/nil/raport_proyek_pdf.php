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
$filenya = "raport_proyek_pdf.php";
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
		<td align="center"><h3>RAPOR PROYEK PENGUATAN<br>PROFIL PELAJAR PANCASILA</h3></td>
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
//list 
$qjuk = mysqli_query($koneksi, "SELECT * FROM kurmer_proyek ".
									"WHERE tapel = '$tapelkd' ".
									"AND kelas = '$kelkd' ".
									"ORDER BY round(no) ASC");
$rjuk = mysqli_fetch_assoc($qjuk);

do
	{
	//nilai
	$juk_no = balikin($rjuk['no']);
	$juk_nama = balikin($rjuk['judul']);
	
		
	
	echo '<b>PROYEK '.$juk_no.'</b>
	<br>
	<table cellpadding="4" width="528" cellspacing="0" border="1">
		<tr valign="top">
			<td align="left">'.$juk_nama.'</td>
		</tr>
	</table>
	<br>
	<br>';
	}
while ($rjuk = mysqli_fetch_assoc($qjuk));









//list 
$qjuk = mysqli_query($koneksi, "SELECT * FROM kurmer_proyek ".
									"WHERE tapel = '$tapelkd' ".
									"AND kelas = '$kelkd' ".
									"ORDER BY round(no) ASC");
$rjuk = mysqli_fetch_assoc($qjuk);

do
	{
	//nilai
	$juk_no = balikin($rjuk['no']);
	$juk_nama = balikin($rjuk['judul']);
	
		
	
	echo '<table cellpadding="4" width="528" cellspacing="0" border="1">
		<tr valign="top" bgcolor="grey">
			<td align="left"><b>PROYEK '.$juk_no.'</b></td>
			<td align="center" width="10">BB</td>
			<td align="center" width="10">MB</td>
			<td align="center" width="10">BSH</td>
			<td align="center" width="10">SB</td>
		</tr>';
		
		
					
		//list
		$qjuk2 = mysqli_query($koneksi, "SELECT * FROM kurmer_proyek_detail ".
											"WHERE proyek_no = '$juk_no' ".
											"AND capaian_fase <> '' ".
											"ORDER BY round(no) ASC");
		$rjuk2 = mysqli_fetch_assoc($qjuk2);
		
		do
			{
			//nilai
			$juk2_no = balikin($rjuk2['no']);
			$juk2_dimensi = balikin($rjuk2['dimensi']);
			$juk2_elemen = balikin($rjuk2['elemen']);
			$juk2_sub_elemen = balikin($rjuk2['sub_elemen']);
			$juk2_capaian_fase = balikin($rjuk2['capaian_fase']);

			
					
			//nilai
			$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_nilai_proyek ".
												"WHERE tapel = '$tapelkd' ".
												"AND kelas = '$kelkd' ".
												"AND proyek_kode = '$juk_no' ".
												"AND dimensi_kode = '$juk2_no' ".
												"AND siswa_kode = '$ku_nis' ".
												"AND nilai <> ''");
			$rku = mysqli_fetch_assoc($qku);
			$i_nilai = balikin($rku['nilai']);
			

			//jika BB
			if ($i_nilai == "bb")
				{
				$i_bb = "V";
				$i_mb = "";
				$i_bsh = "";
				$i_sb = "";
				}

			//jika MB
			else if ($i_nilai == "mb")
				{
				$i_mb = "V";
				$i_bb = "";
				$i_bsh = "";
				$i_sb = "";
				}
				
			//jika BSH
			else if ($i_nilai == "bsh")
				{
				$i_bsh = "V";
				$i_mb = "";
				$i_bb = "";
				$i_sb = "";
				}
				
				
			//jika SB
			else if ($i_nilai == "sb")
				{
				$i_sb = "V";
				$i_mb = "";
				$i_bb = "";
				$i_bsh = "";
				}

			else 
				{
				$i_sb = "";
				$i_mb = "";
				$i_bb = "";
				$i_bsh = "";
				}



			echo '<tr valign="top">
				<td align="left">'.$juk2_no.'. '.$juk2_dimensi.'<br>'.$juk2_capaian_fase.'</td>
				<td align="center"><b>'.$i_bb.'</b></td>
				<td align="center"><b>'.$i_mb.'</b></td>
				<td align="center"><b>'.$i_bsh.'</b></td>
				<td align="center"><b>'.$i_sb.'</b></td>
			</tr>';
			}
		while ($rjuk2 = mysqli_fetch_assoc($qjuk2));
		
		
	echo '</table>
	<br>';
	
	
	//proses
	$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_nilai_proyek_proses ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd' ".
										"AND proyek_kode = '$juk_no' ".
										"AND siswa_kode = '$ku_nis'");
	$rku = mysqli_fetch_assoc($qku);
	$i_isi = balikin($rku['catatan']);

	
	
	echo '<b>Catatan Proses : </b>
	<br>
	<table cellpadding="4" width="528" cellspacing="0" border="1">
		<tr valign="top">
			<td align="left">'.$i_isi.'</td>
		</tr>
	</table>
	<br>
	<br>';	
	}
while ($rjuk = mysqli_fetch_assoc($qjuk));




echo '<table cellpadding="4" width="528" cellspacing="0" border="0">
<tr valign="top">
	<td align="center"><b>KETERANGAN TINGKAT PENCAPAIAN SISWA</b></td>
</tr>
</table>


<table cellpadding="4" width="528" cellspacing="0" border="1">
<tr valign="top" bgcolor="grey">
	<td align="center"><b>BB</b></td>
	<td align="center"><b>MB</b></td>
	<td align="center"><b>BSH</b></td>
	<td align="center"><b>SB</b></td>
</tr>

<tr valign="top">
	<td align="center">Belum Berkembang</td>
	<td align="center">Mulai Berkembang</td>
	<td align="center">Berkembang Sesuai Harapan</td>
	<td align="center">Sangat Berkembang</td>
</tr>


<tr valign="top">
	<td align="center">Siswa masih membutuhkan bimbingan dalam mengembangkan kemampuan</td>
	<td align="center">Siswa mulai mengembangkan kemampuan namun masih belum ajek</td>
	<td align="center">Siswa telah mengembangkan kemampuan hingga berada dalam tahap ajek</td>
	<td align="center">Siswa mengembangkan kemampuannya melampaui harapan</td>
</tr>
</table>';






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
$dompdf->stream('raport-proyek-'.$ku_nis.'-'.$ku_nama2.'.pdf');
?>