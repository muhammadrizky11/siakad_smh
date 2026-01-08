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
require("../../inc/cek/adm.php");




//nilai
$filenya = "piket_pdf.php";
$judul = "Data petugas piket";
$judulku = "$judul";
$judulx = $judul;
$kd = nosql($_REQUEST['kd']);


require_once("../../inc/class/dompdf/autoload.inc.php");

use Dompdf\Dompdf;
$dompdf = new Dompdf();





//detail
$qku = mysqli_query($koneksi, "SELECT * FROM m_piket ".
								"WHERE kd = '$kd'");
$rku = mysqli_fetch_assoc($qku);
$ku_kode = balikin($rku['kode']);
$ku_nama = balikin($rku['nama']);
$ku_jabatan = balikin($rku['jabatan']);



$ku_nama2 = seo_friendly_url($ku_nama);





//isi *START
ob_start();




//file image qrcode
$fileku = "$sumber/filebox/qrcode/$ku_kode.png";
?>



<table width="200" cellpadding="1" cellspacing="0" border="1">
	<tr valign="top">
		<td width="200" align="center">


			<img src="<?php echo $fileku;?>" width="150" />
			
			<table width="200" cellpadding="1" cellspacing="0">
				<tr valign="top">
					<td width="200" align="center">
						<font face="Sans, sans-serif"><font size="2" style="font-size: 14pt">
							<b>KARTU PETUGAS PIKET</b>
							</font></font>
						<hr>
					</td>
				</tr>
			</table>	
			
			<table width="200" cellpadding="1" cellspacing="0">
				<tr valign="top">
					<td width="75">
						<font face="Sans, sans-serif"><font size="2" style="font-size: 10pt">
							Nomor Induk
							</font></font>
					</td>
					<td width="125">
						<font face="Sans, sans-serif"><font size="2" style="font-size: 10pt">: 
							<?php echo $ku_kode;?>
						</font></font>
					</td>
				</tr>
				<tr valign="top">
					<td width="75">
						<font face="Sans, sans-serif"><font size="2" style="font-size: 10pt">NAMA</font></font>
						
					</td>
					<td width="125">
						<font face="Sans, sans-serif"><font size="2" style="font-size: 10pt">: <?php echo $ku_nama;?></font></font>
					</td>
				</tr>
				
				<tr valign="top">
					<td width="75">
						<font face="Sans, sans-serif"><font size="2" style="font-size: 10pt">JABATAN</font></font>
						
					</td>
					<td width="125">
						<font face="Sans, sans-serif"><font size="2" style="font-size: 10pt">: <?php echo $ku_jabatan;?></font></font>
					</td>
				</tr>
			</table>

		</td>
	</tr>
</table>



<?php
//isi
$isi = ob_get_contents();
ob_end_clean();



//echo $isi;





$dompdf->loadHtml($isi);
$dompdf->set_option('isRemoteEnabled', true);

// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
//$dompdf->stream('raport-$nis-$ku_nama2.pdf');
$dompdf->stream('piket-'.$ku_kode.'-'.$ku_nama2.'.pdf');
?>
