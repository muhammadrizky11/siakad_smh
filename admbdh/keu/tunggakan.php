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
require("../../inc/class/paging.php");
require("../../inc/cek/admbdh.php");
$tpl = LoadTpl("../../template/admbdh.html");








//nilai
$filenya = "tunggakan.php";
$judul = "[KEUANGAN SISWA] Tunggakan Siswa";
$judulku = "$judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}





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
	
	
		//hapus dulu, sebelum entri lagi..
		mysqli_query($koneksi, "DELETE FROM siswa_bayar_tagihan ".
									"WHERE kd = '$xyz'");
		
		//insert
		mysqli_query($koneksi, "INSERT INTO siswa_bayar_tagihan(kd, item_tapel, item_smt, ".
									"item_kelas, item_thn, item_bln, ".
									"item_kd, item_nama, item_nominal, ".
									"nominal_bayar, nominal_kurang, ".
									"siswa_kd, siswa_kode, siswa_nama, ".
									"siswa_tapel, siswa_kelas, postdate) VALUES ".
									"('$xyz', '$e_tapel', '$e_smt', ".
									"'$e_kelas', '$e_tahun', '$e_bulan', ".
									"'$e_kd', '$e_nama', '$e_nominal', ".
									"'0', '$e_nominal', ".
									"'$swkd', '$swnis', '$swnama', ".
									"'$swtapel', '$swkelas', '$today')");
		}
	while ($ryuk = mysqli_fetch_assoc($qyuk));	
	
	}
while ($rjuk = mysqli_fetch_assoc($qjuk));
//entri tunggakan ////////////////////////////////////////////////////















//nek cari
if ($_POST['btnCARI'])
	{
	//nilai
	$kunci = cegah($_POST['e_kunci']);
	
	$ke = "$filenya?kunci=$kunci";
	
	
	//re-direct
	xloc($ke);
	exit();
	}









//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}



//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$page = nosql($_POST['page']);
	$e_kd = nosql($_POST['e_kd']);
	$e_tapel = cegah($_POST['e_tapel']);
	$e_smt = cegah($_POST['e_smt']);
	$e_kelas = cegah($_POST['e_kelas']);
	$e_tahun = cegah($_POST['e_tahun']);
	$e_bulan = cegah($_POST['e_bulan']);
	$e_nama = cegah($_POST['e_nama']);
	$e_nominal = cegah($_POST['e_nominal']);

	
	


	//nek null
	if (empty($e_nama))
		{
		//re-direct
		$pesan = "Belum Ditulis. Harap Diulangi...!!";
		$ke = "$filenya?s=$s&kd=$e_kd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika baru
		if ($s == "baru")
			{
			//cek
			$qcc = mysqli_query($koneksi, "SELECT * FROM siswa_bayar_tagihan ".
												"WHERE tapel = '$e_tapel' ".
												"AND smt = '$e_smt' ".
												"AND kelas = '$e_kelas' ".
												"AND tahun = '$e_tahun' ".
												"AND bulan = '$e_bulan' ".
												"AND nama = '$e_nama'");
			$rcc = mysqli_fetch_assoc($qcc);
			$tcc = mysqli_num_rows($qcc);
			
			//nek ada
			if ($tcc != 0)
				{
				//re-direct
				$pesan = "Sudah Ada. Silahkan Ganti Yang Lain...!!";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//insert
				mysqli_query($koneksi, "INSERT INTO siswa_bayar_tagihan(kd, tapel, smt, ".
											"kelas, thn, bln, ".
											"nama, nominal, postdate) VALUES ".
											"('$e_kd', '$e_tapel', '$e_smt', ".
											"'$e_kelas', '$e_tahun', '$e_bulan', ".
											"'$e_nama', '$e_nominal', '$today')");
	

				//re-direct
				xloc($filenya);
				exit();
				}
			}
			
			
				
				
		//jika update
		else if ($s == "edit")
			{
			mysqli_query($koneksi, "UPDATE siswa_bayar_tagihan SET nama = '$e_nama', ".
									"tapel = '$e_tapel', ".
									"smt = '$e_smt', ".
									"kelas = '$e_kelas', ".
									"thn = '$e_tahun', ".
									"bln = '$e_bulan', ".
									"nama = '$e_nama', ".
									"nominal = '$e_nominal', ".
									"postdate = '$today' ".
									"WHERE kd = '$e_kd'");
	
	
			//re-direct
			xloc($filenya);
			exit();
			}
		}
	}	
	
	
	
	
	
	

//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$ke = $filenya;

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysqli_query($koneksi, "DELETE FROM siswa_bayar_tagihan ".
						"WHERE kd = '$kd'");
		}


	//auto-kembali
	xloc($ke);
	exit();
	}
	
	
	
	
	

//jika export
//export
if ($_POST['btnEX'])
	{
	//query
	$limit = 10000;
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM siswa_bayar_tagihan ".
					"WHERE nominal_kurang > 0 ".
					"ORDER BY item_tapel DESC, ".
					"item_smt ASC, ".
					"item_thn DESC, ".
					"round(item_bln) ASC, ".
					"item_kelas ASC, ".
					"item_nama ASC";
	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);


	$fileku = "tunggakan_siswa.xls";





	
	//isi *START
	ob_start();
	

	

	echo '<div class="table-responsive">
	<h3>DAFTAR ITEM KEUANGAN SISWA</h3>
	
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>

		<tr bgcolor="'.$warnaheader.'">
		<td width="50" align="center"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
		<td width="50" align="center"><strong><font color="'.$warnatext.'">SMT</font></strong></td>
		<td width="100" align="center"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
		<td width="50" align="center"><strong><font color="'.$warnatext.'">TAHUN</font></strong></td>
		<td width="50" align="center"><strong><font color="'.$warnatext.'">BULAN</font></strong></td>
		<td width="200" align="center"><strong><font color="'.$warnatext.'">SISWA</font></strong></td>
		<td align="center"><strong><font color="'.$warnatext.'">NAMA TAGIHAN</font></strong></td>
		<td width="150" align="center"><strong><font color="'.$warnatext.'">NOMINAL</font></strong></td>
		</tr>

	</thead>
	<tbody>';
	
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

			$nomer = $nomer + 1;

			$e_kd = nosql($data['kd']);
			$e_swkd = balikin($data['siswa_kd']);
			$e_swnis = balikin($data['siswa_kode']);
			$e_swnama = balikin($data['siswa_nama']);
			$e_tapel = balikin($data['item_tapel']);
			$e_smt = balikin($data['item_smt']);
			$e_kelas = balikin($data['item_kelas']);
			$e_tahun = balikin($data['item_thn']);
			$e_bulan = balikin($data['item_bln']);
			$e_nama = balikin($data['item_nama']);
			$e_nominal = balikin($data['nominal_kurang']);

			$e_siswa = "$e_swnama <br>NIS:$e_swnis";

			
	
	
	
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td align="center">'.$e_tapel.'</td>
			<td align="center">'.$e_smt.'</td>
			<td align="center">'.$e_kelas.'</td>
			<td align="center">'.$e_tahun.'</td>
			<td align="center">'.$e_bulan.'</td>
			<td align="left">'.$e_siswa.'</td>
			<td>'.$e_nama.'</td>
			<td align="center">'.xduit3($e_nominal).'</td>
	        </tr>';

			}
		while ($data = mysqli_fetch_assoc($result));



	echo '</tbody>
	  </table>
	  </div>';



	
	//isi
	$isiku = ob_get_contents();
	ob_end_clean();


	
	
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$fileku");
	echo $isiku;
	
	

	exit();
	}	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();


?>


  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  
  
  
<?php
//require
require("../../template/js/jumpmenu.js");
require("../../template/js/checkall.js");
require("../../template/js/swap.js");
require("../../inc/js/number.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<div class="row">

<div class="col-md-12">
<div class="box">

<div class="box-body">
<div class="row">


<div class="col-md-12">';


//jika kunci cari
if (!empty($kunci))
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);
	
	$sqlcount = "SELECT * FROM siswa_bayar_tagihan ".
					"WHERE nominal_kurang > 0 ".
					"AND (item_tapel LIKE '%$kunci%' ".
					"OR item_smt LIKE '%$kunci%' ".
					"OR item_kelas LIKE '%$kunci%' ".
					"OR item_thn LIKE '%$kunci%' ".
					"OR item_bln LIKE '%$kunci%' ".
					"OR item_nama LIKE '%$kunci%' ".
					"OR item_nominal LIKE '%$kunci%' ".
					"OR siswa_kode LIKE '%$kunci%' ".
					"OR siswa_nama LIKE '%$kunci%') ".
					"ORDER BY nama ASC";
	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);
	}


else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);
	
	$sqlcount = "SELECT * FROM siswa_bayar_tagihan ".
					"WHERE nominal_kurang > 0 ".
					"ORDER BY item_tapel DESC, ".
					"item_smt ASC, ".
					"item_thn DESC, ".
					"round(item_bln) ASC, ".
					"item_kelas ASC, ".
					"item_nama ASC";
	$sqlresult = $sqlcount;
	
	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);
	}




//detail
$e_kunci = balikin($kunci);



//ketahui totalnya
$qyuk2 = mysqli_query($koneksi, "SELECT SUM(nominal_kurang) AS totalnya ".
									"FROM siswa_bayar_tagihan ".
									"WHERE nominal_kurang > 0");
$ryuk2 = mysqli_fetch_assoc($qyuk2);
$yuk2_totalnya = balikin($ryuk2['totalnya']);


echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">

<p>
<input name="btnEX" type="submit" value="EXPORT" class="btn btn-success">
<hr>
</p>

<div class="table-responsive">          
	  <table class="table">
	    <thead>
			
		<tr valign="top">
		<td>
	
		<p>
		<input name="e_kunci" type="text" size="30" value="'.$e_kunci.'" class="btn btn-warning">
		
		<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
		
		<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
		</p>
	
	
	
		</td>

		</tr>
		</tbody>
	  </table>
	  </div>
	  
	  
Total Tunggakan : <b>'.xduit3($yuk2_totalnya).'</b> 
<div class="table-responsive">          
	  <table class="table" border="1">
	    <thead>
			
			<tr bgcolor="'.$warnaheader.'">
			<td width="1">&nbsp;</td>
			<td width="50" align="center"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
			<td width="100" align="center"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
			<td width="50" align="center"><strong><font color="'.$warnatext.'">SMT</font></strong></td>
			<td width="50" align="center"><strong><font color="'.$warnatext.'">TAHUN</font></strong></td>
			<td width="50" align="center"><strong><font color="'.$warnatext.'">BULAN</font></strong></td>
			<td width="200" align="center"><strong><font color="'.$warnatext.'">SISWA</font></strong></td>
			<td align="center"><strong><font color="'.$warnatext.'">NAMA TAGIHAN</font></strong></td>
			<td width="150" align="center"><strong><font color="'.$warnatext.'">NOMINAL</font></strong></td>
			</tr>

	    </thead>
	    <tbody>';

if ($count != 0)
	{
	do {
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

		$nomer = $nomer + 1;
		$e_kd = nosql($data['kd']);
		$e_swkd = balikin($data['siswa_kd']);
		$e_swnis = balikin($data['siswa_kode']);
		$e_swnama = balikin($data['siswa_nama']);
		$e_tapel = balikin($data['item_tapel']);
		$e_smt = balikin($data['item_smt']);
		$e_kelas = balikin($data['item_kelas']);
		$e_tahun = balikin($data['item_thn']);
		$e_bulan = balikin($data['item_bln']);
		$e_nama = balikin($data['item_nama']);
		$e_nominal = balikin($data['nominal_kurang']);
		$e_postdate = balikin($data['postdate']);


		$e_siswa = "$e_swnama <br>NIS:$e_swnis";


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		<input type="checkbox" name="item'.$nomer.'" value="'.$e_kd.'">
        </td>
		<td align="center">'.$e_tapel.'</td>
		<td align="center">'.$e_kelas.'</td>
		<td align="center">'.$e_smt.'</td>
		<td align="center">'.$e_tahun.'</td>
		<td align="center">'.$e_bulan.'</td>
		<td align="left">'.$e_siswa.'</td>
		<td>'.$e_nama.'</td>
		<td align="center">'.xduit3($e_nominal).'</td>
        </tr>';
		}
	while ($data = mysqli_fetch_assoc($result));
	}


echo '</tbody>
	  </table>
	  </div>
	  
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
<input name="jml" type="hidden" value="'.$count.'">
<br>
<br>

<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')" class="btn btn-primary">
<input name="btnBTL" type="reset" value="BATAL" class="btn btn-warning">
<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-danger">
</td>
</tr>
</table>';



echo '</form>';



echo '</div>
</div>
</div>
</div>
</div>
</div>';

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//null-kan
xclose($koneksi);
exit();
?>