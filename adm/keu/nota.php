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
$tpl = LoadTpl("../../template/adm.html");








//nilai
$judulku = "[KEUANGAN SISWA]. Pembayaran";
$judul = $judulku;
$filenya = "nota.php";
$ikd = nosql($_REQUEST['ikd']);
$siswanya = cegah($_REQUEST['siswanya']);
$notakd = nosql($_REQUEST['notakd']);
$s = nosql($_REQUEST['s']);
$set = nosql($_REQUEST['set']);
$ke = "$filenya?notakd=$notakd";


//default jumlah
if ($ikod != "")
	{
	$ijml = "1";
	}


//today
$xtgl1 = nosql($tanggal);
$xbln1 = nosql($bulan);
$xthn1 = nosql($tahun);



//atrribut
if (empty($notakd))
	{
	$attribut = "disabled";
	}





//nota baru /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($s == "baru")
	{
	//nilai
	$notakd = nosql($_REQUEST['notakd']);
	$siswanyax = cegah($_REQUEST['siswanya']);
	$notakode = "$tahun$bulan$tanggal$jam$menit$detik$siswanyax";

	
	//jika null
	if (empty($siswanyax))
		{
		//nilai
		$pesan = "NIS Siswa Belum Dimasukkan...!!";
		pekem($pesan,$filenya);
		exit();			
		}
	
	else
		{
		//cek lg
		$qcc = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
										"WHERE kode = '$siswanyax' ".
										"ORDER BY tapel DESC");
		$rcc = mysqli_fetch_assoc($qcc);
		$tcc = mysqli_num_rows($qcc);
		$cc_kd = cegah($rcc['kd']);
		$cc_nama = cegah($rcc['nama']);
		$cc_tapel = cegah($rcc['tapel']);
		$cc_kelas = cegah($rcc['kelas']);
	
	
	
	
		//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//entri tunggakan ////////////////////////////////////////////////////
		$qjuk = mysqli_query($koneksi, "SELECT * FROM m_keu_siswa ".
											"ORDER BY tapel DESC, ".
											"smt ASC, ".
											"thn DESC, ".
											"round(bln) ASC, ".
											"kelas ASC, ".
											"nama ASC");
		$rjuk = mysqli_fetch_assoc($qjuk);
		
		
		do
			{
			//nilai
			$e_kd = cegah($rjuk['kd']);
			$e_tapel = cegah($rjuk['tapel']);
			$e_smt = cegah($rjuk['smt']);
			$e_kelas = cegah($rjuk['kelas']);
			$e_tahun = cegah($rjuk['thn']);
			$e_bulan = cegah($rjuk['bln']);
			$e_nama = cegah($rjuk['nama']);
			$e_nominal = cegah($rjuk['nominal']);
		
				
			
			
			//list siswa
			$qyuk = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
												"WHERE tapel = '$e_tapel' ".
												"AND kelas = '$e_kelas' ".
												"AND kode = '$siswanyax' ".
												"ORDER BY kode ASC");
			$ryuk = mysqli_fetch_assoc($qyuk);
			
			do
				{
				//nilai
				$swkd = cegah($ryuk['kd']);
				$swnis = cegah($ryuk['kode']);
				$swnama = cegah($ryuk['nama']);
				$swtapel = cegah($ryuk['tapel']);
				$swkelas = cegah($ryuk['kelas']);
				
				
				$xyz = md5("$swnis$e_tapel$e_smt$e_kelas$e_tahun$e_bulan$e_nama");
			
			
				//hapus dulu, sebelum entri
				mysqli_query($koneksi, "DELETE FROM siswa_bayar_tagihan ".
											"WHERE kd = '$xyz'");
			
				
				//insert
				mysqli_query($koneksi, "INSERT INTO siswa_bayar_tagihan(kd, item_tapel, item_smt, ".
											"item_kelas, item_thn, item_bln, ".
											"item_kd, item_nama, item_nominal, ".
											"siswa_kd, siswa_kode, siswa_nama, ".
											"siswa_tapel, siswa_kelas, postdate) VALUES ".
											"('$xyz', '$e_tapel', '$e_smt', ".
											"'$e_kelas', '$e_tahun', '$e_bulan', ".
											"'$e_kd', '$e_nama', '$e_nominal', ".
											"'$swkd', '$swnis', '$swnama', ".
											"'$swtapel', '$swkelas', '$today')");
				}
			while ($ryuk = mysqli_fetch_assoc($qyuk));	
			
			}
		while ($rjuk = mysqli_fetch_assoc($qjuk));
		//entri tunggakan ////////////////////////////////////////////////////
		//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
	

		
	
	
		//jika gak ada
		if (empty($tcc))
			{
			//nilai
			$pesan = "NIS Siswa Tidak Ditemukan...!!";
			pekem($pesan,$filenya);
			exit();
			}
		else
			{
			//insert-kan...
			mysqli_query($koneksi, "INSERT INTO siswa_bayar(kd, siswa_kd, siswa_kode, ".
									"siswa_nama, siswa_tapel, siswa_kelas, ".
									"tgl_bayar, kode, postdate) VALUES ".
									"('$notakd', '$cc_kd', '$siswanyax', ".
									"'$cc_nama', '$cc_tapel', '$cc_kelas', ".
									"'$today', '$notakode', '$today')");

			//null-kan
			xclose($koneksi);
		
			//re-direct
			$ke = "$filenya?notakd=$notakd";
			xloc($ke);
			exit();
			}
		}
	}












//jika simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$notakd = nosql($_POST['notakd']);
	$jml = nosql($_POST['jml']);
	$ke = "$filenya?notakd=$notakd";



	//nota-nya
	$qntt = mysqli_query($koneksi, "SELECT * FROM siswa_bayar ".
										"WHERE kd = '$notakd'");
	$rntt = mysqli_fetch_assoc($qntt);
	$ntt_nota = cegah($rntt['kode']);
	$ntt_mkode = cegah($rntt['siswa_kode']);
	$ntt_mnama = cegah($rntt['siswa_nama']);
	$ntt_mtapel = cegah($rntt['siswa_tapel']);
	$ntt_mkelas = cegah($rntt['siswa_kelas']);




	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kdx = cegah($_POST["$yuhu"]);
		
		$yuk = "itemi";
		$yuhu = "$yuk$i";
		$kdxi = cegah($_POST["$yuhu"]);

		$yuk = "cobterbayar";
		$yuhu = "$yuk$i";
		$cobterbayarx = cegah($_POST["$yuhu"]);

		$yuk = "tapel";
		$yuhu = "$yuk$i";
		$tapelx = cegah($_POST["$yuhu"]);

		$yuk = "smt";
		$yuhu = "$yuk$i";
		$smtx = cegah($_POST["$yuhu"]);
			
		$yuk = "tahun";
		$yuhu = "$yuk$i";
		$tahunx = cegah($_POST["$yuhu"]);
		
		$yuk = "bulan";
		$yuhu = "$yuk$i";
		$bulanx = cegah($_POST["$yuhu"]);
		
		$yuk = "nm";
		$yuhu = "$yuk$i";
		$nmx = cegah($_POST["$yuhu"]);
		
		$yuk = "nominal";
		$yuhu = "$yuk$i";
		$cob_nominalx = cegah($_POST["$yuhu"]);
			
		$yuk = "terbayar";
		$yuhu = "$yuk$i";
		$cob_terbayarx = cegah($_POST["$yuhu"]);
		
		$yuk = "kurang";
		$yuhu = "$yuk$i";
		$cob_kurangx = cegah($_POST["$yuhu"]);
			
		$yuk = "hrg";
		$yuhu = "$yuk$i";
		$cob_hrgx = cegah($_POST["$yuhu"]);
		
		
		
		//jika LUNAS
		if ($cob_hrgx == "LUNAS")
			{
			$cob_hrgx = $cob_nominalx;		
			}	
			
			

		//jika null
		if (empty($cob_hrgx))
			{
			$cob_hrgx = 0;	
			}
			
			
			
			
		//jika null
		if (empty($cob_terbayarx))
			{
			$cob_terbayarx = '0';	
			}
			
			
			
		$cob_kurangx = round($cob_nominalx - $cob_terbayarx);
		
		
		//jika lunas
		if ($cob_kurangx == 0)
			{
			$lunas_status = 'true';				
			}
		else
			{
			$lunas_status = 'false';				
			}





		//jika ada
		if (!empty($cob_hrgx))
			{
			//update
			mysqli_query($koneksi, "UPDATE siswa_bayar_tagihan SET nominal_bayar = '$cob_terbayarx', ".
										"nominal_kurang = '$cob_kurangx', ".
										"lunas_status = '$lunas_status', ".
										"postdate = '$today' ".
										"WHERE item_tapel = '$tapelx' ".
										"AND kd = '$kdx' ".
										"AND item_smt = '$smtx' ".
										"AND item_thn = '$tahunx' ".
										"AND item_bln = '$bulanx'");
										
										
										
			//hapus dulu, sebelum entri lagi...
			mysqli_query($koneksi, "DELETE FROM siswa_bayar_rincian ".
										"WHERE kd = '$kdx'");
									
										
			//insert rincian
			mysqli_query($koneksi, "INSERT INTO siswa_bayar_rincian(kd, siswa_kode, ".
										"siswa_nama, siswa_tapel, siswa_kelas, ".
										"bayar_tgl, bayar_kd, bayar_kode, ".
										"item_kd, item_nama, ".
										"item_tapel, item_smt, item_kelas, ".
										"item_thn, item_bln, item_nominal, ".
										"nominal_bayar, postdate) VALUES ".
										"('$kdx', '$ntt_mkode', ".
										"'$ntt_mnama', '$ntt_mtapel', '$ntt_mkelas', ".
										"'$today', '$notakd', '$ntt_nota', ".
										"'$kdxi', '$nmx', ".
										"'$tapelx', '$smtx', '$ntt_mkelas', ".
										"'$tahunx', '$bulanx', '$cob_nominalx', ".
										"'$cob_hrgx', '$today')");

			}
		}



	//auto-kembali
	$ke = "nota_cetak.php?notakd=$notakd";
	xloc($ke);
	exit();
	}
	

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


























//focus /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika blm ada nota, bikin aja...
if (empty($notakd))
	{
	$diload = "document.formxx.siswanya.focus();";
	}
	
else
	{
	//subtotal-nya...
	$qcob2 = mysqli_query($koneksi, "SELECT SUM(nominal_bayar) AS nombax ".
										"FROM siswa_bayar_tagihan ".
										"WHERE siswa_kode = '$ntt_mkode'");
	$rcob2 = mysqli_fetch_assoc($qcob2);
	$cob2_bayar = balikin($rcob2['nombax']);
		

	$diload = "document.formx.hrg1.focus();document.formx.stotx.value='$cob2_bayar';";
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi *START
ob_start();


//js
require("../../inc/js/jam.js");
require("../../inc/js/number.js");
?>

<style>
	.layar {
	BACKGROUND-COLOR: BLACK;
	COLOR: #00FF00;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	FONT-SIZE: 60px;
	FONT-WEIGHT: normal;
	border: 1px solid #996600;
}

</style>



<?php
//echo '<form name="formx" method="post">';
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
$cob2_nominal = balikin($rcob2['nomix']);

//jika null
if (empty($cob2_nominal))
	{
	$cob2_nominal = 0;
	}
else
	{
	$cob2_nominal = round(balikin($rcob2['nomix']));
	}


$qcob2 = mysqli_query($koneksi, "SELECT SUM(nominal_bayar) AS nombax ".
									"FROM siswa_bayar_tagihan ".
									"WHERE siswa_kode = '$ntt_mkode'");
$rcob2 = mysqli_fetch_assoc($qcob2);
$cob2_bayar = balikin($rcob2['nombax']);

//jika null
if (empty($cob2_bayar))
	{
	$cob2_bayar = 0;
	}
else
	{
	$cob2_bayar = round(balikin($rcob2['nombax']));
	}

$cob2_tunggakan = round($cob2_nominal - $cob2_bayar);



$stu_subtotal = $cob2_bayar;

//update kan
mysqli_query($koneksi, "UPDATE siswa_bayar SET nominal_tagihan = '$cob2_nominal', ".
							"nominal_bayar = '$cob2_bayar', ".
							"nominal_kurang = '$cob2_tunggakan' ".
							"WHERE kd = '$notakd' ".
							"AND siswa_kode = '$ntt_mkode'");







echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="top">

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td class="kasir1">No. Nota </td>
<td class="kasir1">:
<input name="nota" type="text" value="'.$ntt_nota.'" size="20" class="btn btn-default" readonly>
</td>
</tr>
<tr>
<td class="kasir1">Tanggal </td>
<td class="kasir1">:
<input name="xtglx" type="text" value="'.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'" size="20" class="btn btn-default" readonly>
</td>
</tr>
<tr>
<td class="kasir1">NIS</td>
<td class="kasir1">:
<input name="siswanya" type="text" value="'.$ntt_mkode.'" size="20" class="btn btn-warning"
onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	if (document.formxx.notakdx.value == \'\')
		{
		pelgx = document.formxx.siswanya.value;
		redir = \''.$filenya.'?s=baru&notakd='.$x.'&siswanya=\'+pelgx;
		location.href=redir;
		}
	else
		{
		pelgx = document.formxx.siswanya.value;
		redir = \''.$filenya.'?s=editp&notakd='.$notakd.'&siswanya=\'+pelgx;
		location.href=redir;
		}
	}">
</td>
</tr>
</table>


</td>
<td valign="top" align="right">
<input name="layar" id="layar" type="text" size="20" value="'.$tuh_total.'" class="layar" style="text-align:right;width:200;height:70" readonly>
<br>
<br>';
?>


<script>
$(document).ready( function() {
    $(document).on("keyup", ".hargaku", function() {
        var sum = 0;
        $(".hargaku").each(function(){
            sum += +$(this).val();
        });
        $('#layar').val(sum);
    });
});
</script>



<?php
//jika ada
if (!empty($notakd))
	{
	echo '<font color="green">
	[TOTAL TERBAYAR : <b>'.xduit3($cob2_bayar).'</b>]. 
	</font>
	  
	<font color="red">
	[TOTAL TUNGGAKAN : <b>'.xduit3($cob2_tunggakan).'</b>]. 
	</font>';
	}
	
echo '</td>
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
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	Nama Siswa : <b>'.$ntt_mnama.'</b>. Kelas:<b>'.$ntt_mkelas.'</b>
	</td>
	<td align="right">

	<a href="'.$filenya.'" class="btn btn-primary">ENTRI BARU >></a>
	
	
	<input name="notakd" type="hidden" value="'.$notakd.'">
	<input name="swkode" type="hidden" value="'.$ntt_mkode.'">
	<input name="btnSMP" type="submit" value="SIMPAN DAN CETAK >>" class="btn btn-danger">
	<br> 
	</td>
	</tr>
	</table>
	
	<table width="100%" border="1" cellpadding="3" cellspacing="0">
	<tr>
	<td width="110" align="center"><strong>TAPEL</strong></td>
	<td width="50" align="center"><strong>SMT</strong></td>
	<td width="80" align="center"><strong>TAHUN</strong></td>
	<td width="50" align="center"><strong>BULAN</strong></td>
	<td align="center"><strong>NAMA</strong></td>
	<td width="150" align="center"><strong>NOMINAL</strong></td>
	<td width="150" align="center"><strong>TERBAYAR</strong></td>
	<td width="150" align="center"><strong>KEKURANGAN</strong></td>
	<td width="150" align="center"><strong>BAYAR</strong></td>
	</tr>';
	

	//data ne
	$qcob = mysqli_query($koneksi, "SELECT * FROM siswa_bayar_tagihan ".
										"WHERE siswa_kode = '$ntt_mkode' ".
										"ORDER BY lunas_status DESC, ".
										"siswa_tapel ASC, ".
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
			echo '<td>
			<input name="item'.$nomerx.'" type="hidden" value="'.$cob_kd.'">
			<input name="itemi'.$nomerx.'" type="hidden" value="'.$cob_ikd.'">
			<input name="cobterbayar'.$nomerx.'" type="hidden" value="'.$cob_terbayar.'">
			<input name="tapel'.$nomerx.'" type="text" value="'.$cob_tapel.'" class="btn btn-block btn-default" style="text-align:left" readonly>
			</td>
			<td>
			<input name="smt'.$nomerx.'" type="text" value="'.$cob_smt.'" size="5" class="btn btn-block btn-default" readonly>
			</td>
			<td>
			<input name="tahun'.$nomerx.'" type="text" value="'.$cob_tahun.'" size="10" class="btn btn-block btn-default" style="text-align:center" readonly>
			</td>
			<td>
			<input name="bulan'.$nomerx.'" type="text" value="'.$cob_bulan.'" size="10" class="btn btn-block btn-default" style="text-align:center" readonly>
			</td>
			<td>
			<input name="nm'.$nomerx.'" type="text" value="'.$cob_nm.'" size="10" class="btn btn-block btn-default" style="text-align:left" readonly>
			</td>
			<td>
			<input name="nominal'.$nomerx.'" type="text" value="'.$cob_nominal.'" size="10" class="btn btn-block btn-default" style="text-align:right" readonly>
			</td>
			<td>
			<input name="terbayar'.$nomerx.'" type="text" value="'.$cob_terbayar.'" size="10" class="btn btn-block btn-default" style="text-align:right" readonly>
			</td>
			
			<td>
			<input name="kurang'.$nomerx.'" type="text" value="'.$cob_kurang.'" size="10" class="btn btn-block btn-default" style="text-align:right" readonly>
			</td>
			<td>';
			
			//jika belum lunas
			if ($cob_terbayar != $cob_nominal)
				{
				echo '<input name="hrg'.$nomerx.'" type="text" value="'.$cob_hrg.'" size="5" class="hargaku btn btn-block btn-warning" style="text-align:right"
				onKeyPress="return numbersonly(this, event)" 
				onClick="document.formx.hrg'.$nomerx.'.value = \'\';" 
				onKeyUp="document.formxx.layar.value=document.formx.hrg'.$nomerx.'.value;
				document.formx.stotx.value=document.formx.hrg'.$nomerx.'.value;
				document.formx.terbayar'.$nomerx.'.value=parseInt(document.formx.hrg'.$nomerx.'.value) + parseInt(document.formx.cobterbayar'.$nomerx.'.value);
				document.formx.kurang'.$nomerx.'.value=parseInt(document.formx.nominal'.$nomerx.'.value) - parseInt(document.formx.terbayar'.$nomerx.'.value);
						
				if (document.formx.kurang'.$nomerx.'.value < 0)
					{
					alert(\'Ada Kesalahan...!!\');		
					document.formx.terbayar'.$nomerx.'.value=parseInt(document.formx.cobterbayar'.$nomerx.'.value);
					document.formx.kurang'.$nomerx.'.value=parseInt(document.formx.nominal'.$nomerx.'.value);			
					document.formx.hrg'.$nomerx.'.value=\'0\';			
					}" 
				   
				onKeyDown="var keyCode = event.keyCode;
				if (keyCode == 13)
					{
					document.formx.s.value = \'edit\';
					document.formx.kdx.value = document.formx.kd'.$nomerx.'.value;
					document.formx.kodex.value = document.formx.kode'.$nomerx.'.value;
					document.formx.hrgx.value = document.formx.hrg'.$nomerx.'.value;
					document.formx.stotx.value = document.formx.hrg'.$nomerx.'.value;
					document.formx.submit();
					}
		
		
				if (keyCode == 38)
					{
					document.formx.hrg'.$nil.'.focus();
					}
		
		
				if (keyCode == 40)
					{
					document.formx.hrg'.$nild.'.focus();
					}">';
				}
					
			else
				{
				echo '<input name="hrg'.$nomerx.'" type="text" value="LUNAS" size="10" class="btn btn-block btn-default" style="text-align:right" readonly>';
				}
					
				
				
			echo '</td>
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