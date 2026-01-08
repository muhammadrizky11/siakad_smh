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
require("../../inc/cek/admbdh.php");
$tpl = LoadTpl("../../template/admbdh.html");








//nilai
$judulku = "[KEUANGAN SISWA]. Cetak Nota";
$judul = $judulku;
$filenya = "nota_cetak.php";
$notakd = nosql($_REQUEST['notakd']);
$ke = "$filenya?notakd=$notakd";












//isi *START
ob_start();


//js
require("../../inc/js/jam.js");
require("../../inc/js/number.js");


echo '<form name="formxx" action="'.$ke.'" method="post">';


//nota-nya
$qntt = mysqli_query($koneksi, "SELECT * FROM siswa_bayar ".
									"WHERE kd = '$notakd'");
$rntt = mysqli_fetch_assoc($qntt);
$ntt_nota = nosql($rntt['kode']);
$ntt_mkode = balikin($rntt['siswa_kode']);
$ntt_mnama = balikin($rntt['siswa_nama']);
$ntt_mtapel = balikin($rntt['siswa_tapel']);
$ntt_mkelas = balikin($rntt['siswa_kelas']);




//total-nya
$qtuh = mysqli_query($koneksi, "SELECT SUM(nominal_bayar) AS nombax ".
									"FROM siswa_bayar_rincian ".
									"WHERE siswa_kode = '$ntt_mkode' ".
									"AND bayar_kode = '$ntt_nota'");
$rtuh = mysqli_fetch_assoc($qtuh);
$tuh_total = nosql($rtuh['nombax']);

//nek null
if (empty($tuh_total))
	{
	$tuh_total = "0";
	}








//ketahui total tunggakan
$qcob2 = mysqli_query($koneksi, "SELECT SUM(item_nominal) AS nomix ".
									"FROM siswa_bayar_tagihan ".
									"WHERE siswa_kode = '$ntt_mkode'");
$rcob2 = mysqli_fetch_assoc($qcob2);
$cob2_nominal = round(balikin($rcob2['nomix']));


$qcob2 = mysqli_query($koneksi, "SELECT SUM(nominal_bayar) AS nombax ".
									"FROM siswa_bayar_tagihan ".
									"WHERE siswa_kode = '$ntt_mkode'");
$rcob2 = mysqli_fetch_assoc($qcob2);
$cob2_bayar = round(balikin($rcob2['nombax']));
$cob2_tunggakan = round($cob2_nominal - $cob2_bayar);



$stu_subtotal = $cob2_bayar;







echo '<a href="nota.php?notakd='.$notakd.'" class="btn btn-primary"><< KEMBALI</a>
<a href="nota_pdf.php?notakd='.$notakd.'" target="_blank" class="btn btn-danger">PRINT PDF >></a>
<hr>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="top">

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td class="kasir1" width="100">No. Nota </td>
<td class="kasir1">: <b>'.$ntt_nota.'</b>
</td>
</tr>
<tr>
<td class="kasir1">Tanggal </td>
<td class="kasir1">: <b>'.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'</b>
</td>
</tr>
<tr>
<td class="kasir1">NIS</td>
<td class="kasir1">: <b>'.$ntt_mkode.'</b>
</td>
</tr>

<tr>
<td class="kasir1">Nama</td>
<td class="kasir1">: <b>'.$ntt_mnama.'</b>
</td>
</tr>

<tr>
<td class="kasir1">Kelas</td>
<td class="kasir1">: <b>'.$ntt_mkelas.'</b>
</td>
</tr>
</table>


</td>
<td valign="top" align="right">
Nominal Pembayaran : 
<h3>'.xduit3($tuh_total).'</h3>
<hr>
<font color="green">
TOTAL TERBAYAR : 
<b>'.xduit3($cob2_bayar).'</b> 
</font>
<br>

<font color="red">
TOTAL TUNGGAKAN :
<b>'.xduit3($cob2_tunggakan).'</b> 
</font>
<hr>

</td>
</tr>
</table>

<input name="notakdx" type="hidden" value="'.$notakd.'">
<input name="notakd" type="hidden" value="'.$notakd.'">
<input name="swkode" type="hidden" value="'.$ntt_mkode.'">
</form>';

//jika ada
if (!empty($notakd))
	{
	echo '<form name="formx" action="'.$ke.'" method="post">
	<table width="100%" border="1" cellpadding="3" cellspacing="0">
	<tr>
	<td width="75" align="center"><strong>TAPEL</strong></td>
	<td width="30" align="center"><strong>SMT</strong></td>
	<td width="30" align="center"><strong>TAHUN</strong></td>
	<td width="30" align="center"><strong>BULAN</strong></td>
	<td align="center"><strong>NAMA</strong></td>
	<td width="100" align="center"><strong>TERBAYAR</strong></td>
	<td width="100" align="center"><strong>KEKURANGAN</strong></td>
	</tr>';
	
	//data ne
	$qcob = mysqli_query($koneksi, "SELECT * FROM siswa_bayar_rincian ".
										"WHERE siswa_kode = '$ntt_mkode' ".
										"AND bayar_kode = '$ntt_nota' ".
										"ORDER BY siswa_tapel ASC, ".
										"item_smt ASC, ".
										"item_thn ASC, ".
										"round(item_bln) ASC, ".
										"siswa_kelas ASC");
	$rcob = mysqli_fetch_assoc($qcob);
	$tcob = mysqli_num_rows($qcob);
	
	//nek gak null
	if ($tcob != 0)
		{
		do
			{
			$nomerx = $nomerx + 1;
	
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
	
			//pageup ////////////////////////
			$nil = $nomerx - 1;
	
			if ($nil < 1)
				{
				$nil = 0;
				}
	
			if ($nil > $tcob)
				{
				$nil = $tcob;
				}
	
	
			//pagedown ////////////////////////
			$nild = $nomerx + 1;
	
			if ($nild < 1)
				{
				$nild = $nild + 1;
				}
	
			if ($nild > $tcob)
				{
				$nild = 0;
				}
	
			$cob_kd = nosql($rcob['kd']);
			$cob_ikd = balikin($rcob['item_kd']);
			$cob_tapel = balikin($rcob['item_tapel']);
			$cob_smt = balikin($rcob['item_smt']);
			$cob_tahun = balikin($rcob['item_thn']);
			$cob_bulan = balikin($rcob['item_bln']);
			$cob_nm = balikin($rcob['item_nama']);
			$cob_nominal = balikin($rcob['item_nominal']);
			$cob_terbayar = balikin($rcob['nominal_bayar']);
			$cob_kurang = balikin($rcob['nominal_kurang']);
			
			//jika null
			if (empty($cob_hrg))
				{
				$cob_hrg = 0;	
				}
				
				
				
				
			//jika null
			if (empty($cob_terbayar))
				{
				$cob_terbayar = '0';	
				}
				
				
				
			
			$cob_kurang = round($cob_nominal - $cob_terbayar);
	
	
	
			echo "<tr valign=\"top\" bgcolor=\"$warna\"
			onkeyup=\"this.bgColor='$warnaover';\"
			onkeydown=\"this.bgColor='$warna';\"
			onmouseover=\"this.bgColor='$warnaover';\"
			onmouseout=\"this.bgColor='$warna';\">";
			echo '<td align="center">'.$cob_tapel.'</td>
			<td align="center">'.$cob_smt.'</td>
			<td align="center">'.$cob_tahun.'</td>
			<td align="center">'.$cob_bulan.'</td>
			<td align="left">'.$cob_nm.'</td>
			<td align="right">'.xduit3($cob_terbayar).'</td>
			<td align="right">'.xduit3($cob_kurang).'</td>
			</tr>';
			}
		while ($rcob = mysqli_fetch_assoc($qcob));
		}
	
	echo '</table>
	<input name="jml" type="hidden" value="'.$tcob.'">
	<input name="notakdx" type="hidden" value="'.$notakd.'">
	<input name="notakd" type="hidden" value="'.$notakd.'">
	<input name="stotx" type="hidden" value="'.$cob2_bayar.'">
	</form>';
	}

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");

//null-kan
xclose($koneksi);
exit();
?>