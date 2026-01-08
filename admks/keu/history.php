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
require("../../inc/cek/admks.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admks.html");








//nilai
$filenya = "history.php";
$judul = "[KEUANGAN SISWA] History Pembayaran";
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




//jika export
//export
if ($_POST['btnEX'])
	{
	//query
	$limit = 10000;
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT DISTINCT(bayar_kode) AS kodenya ".
					"FROM siswa_bayar_rincian ".
					"WHERE nominal_bayar <> 0 ".
					"ORDER BY bayar_tgl DESC";
	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);


	$fileku = "history_bayar.xls";





	
	//isi *START
	ob_start();
	

	

	echo '<div class="table-responsive">
	<h3>HISTORY BAYAR</h3>
	
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>

			<tr bgcolor="'.$warnaheader.'">
			<td width="50" align="left"><strong><font color="'.$warnatext.'">TGl.BAYAR</font></strong></td>
			<td width="200" align="center"><strong><font color="'.$warnatext.'">SISWA</font></strong></td>
			<td width="150" align="center"><strong><font color="'.$warnatext.'">NOMINAL BAYAR</font></strong></td>
			<td align="left"><strong><font color="'.$warnatext.'">RINCIAN</font></strong></td>
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

			$e_kode = nosql($data['kodenya']);
		
		
			//rincian
			$qku = mysqli_query($koneksi, "SELECT * FROM siswa_bayar_rincian ".
												"WHERE bayar_kode = '$e_kode' ".
												"ORDER BY postdate DESC");
			$rku = mysqli_fetch_assoc($qku);
			$e_kd = nosql($rku['kd']);
			$e_swkd = balikin($rku['siswa_kd']);
			$e_swnis = balikin($rku['siswa_kode']);
			$e_swnama = balikin($rku['siswa_nama']);
	
			$e_tgl = balikin($rku['bayar_tgl']);
	
	
			$e_siswa = "$e_swnama <br>NIS:$e_swnis";
	
	
	
	
			//totalnya
			$qku2 = mysqli_query($koneksi, "SELECT SUM(nominal_bayar) AS totalnya ".
												"FROM siswa_bayar_rincian ".
												"WHERE bayar_kode = '$e_kode' ".
												"ORDER BY postdate DESC");
			$rku2 = mysqli_fetch_assoc($qku2);		
			$e_nominal = balikin($rku2['totalnya']);
			
			
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td align="center">
			'.$e_tgl.'
			</td>
			<td align="left">'.$e_siswa.'</td>
			<td align="right">'.xduit3($e_nominal).'</td>
			<td align="left">';
			
			//list
			$qjuk = mysqli_query($koneksi, "SELECT * FROM siswa_bayar_rincian ".
											"WHERE bayar_kode = '$e_kode' ".
											"ORDER BY item_tapel DESC, ".
											"item_smt ASC, ". 
											"item_thn DESC, ".
											"round(item_bln) ASC, ".
											"item_nama ASC, ".
											"item_kelas ASC");
			$rjuk = mysqli_fetch_assoc($qjuk);
			
			do
				{
				//nilai
				$juk_item_tapel = balikin($rjuk['item_tapel']);
				$juk_item_smt = balikin($rjuk['item_smt']);
				$juk_item_thn = balikin($rjuk['item_thn']);
				$juk_item_bln = balikin($rjuk['item_bln']);
				$juk_item_nama = balikin($rjuk['item_nama']);
				$juk_item_kelas = balikin($rjuk['item_kelas']);
				$juk_item_nominal = balikin($rjuk['item_nominal']);
				$juk_item_nbayar = xduit3(balikin($rjuk['nominal_bayar']));
					
				echo "TAPEL:<b>$juk_item_tapel</b>. SMT:<b>$juk_item_smt</b>. Bulan:<b>$arrbln[$juk_item_bln] $juk_item_thn</b>. Kelas:<b>$juk_item_kelas</b>
				<br>
				[<b>$juk_item_nbayar</b>]. <b>$juk_item_nama</b>
				<br>
				<br>";
				}
			while ($rjuk = mysqli_fetch_assoc($qjuk));
			
			
			echo '</td>
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




		//detail e
		$qjuk = mysqli_query($koneksi, "SELECT * FROM siswa_bayar_rincian ".
										"WHERE bayar_kode = '$kd' ".
										"ORDER BY item_tapel DESC, ".
										"item_smt ASC, ". 
										"item_thn DESC, ".
										"round(item_bln) ASC, ".
										"item_nama ASC, ".
										"item_kelas ASC");
		$rjuk = mysqli_fetch_assoc($qjuk);
		
		do
			{
			//nilai
			$juk_swkode = balikin($rjuk['siswa_kode']);
			$juk_item_kd = balikin($rjuk['item_kd']);
			$juk_item_tapel = balikin($rjuk['item_tapel']);
			$juk_item_smt = balikin($rjuk['item_smt']);
			$juk_item_thn = balikin($rjuk['item_thn']);
			$juk_item_bln = balikin($rjuk['item_bln']);
			$juk_item_nama = balikin($rjuk['item_nama']);
			$juk_item_kelas = balikin($rjuk['item_kelas']);
			$juk_item_nominal = balikin($rjuk['item_nominal']);
			$juk_item_nbayar = balikin($rjuk['nominal_bayar']);



			//ketahui tagihan
			$qyuk = mysqli_query($koneksi, "SELECT * FROM siswa_bayar_tagihan ".
												"WHERE siswa_kode = '$juk_swkode' ".
												"AND item_kd = '$juk_item_kd'");
			$ryuk = mysqli_fetch_assoc($qyuk);
			$yuk_bayar = balikin($ryuk['nominal_bayar']);
			
			$yuk_baru = $yuk_bayar - $juk_item_nbayar; 
			$yuk_kurang = $juk_item_nominal - $yuk_baru; 
			
			
			//update tunggakannya...
			mysqli_query($koneksi, "UPDATE siswa_bayar_tagihan SET nominal_bayar = '$yuk_baru', ".
										"nominal_kurang = '$yuk_kurang', ".
										"lunas_status = 'false' ".
										"WHERE siswa_kode = '$juk_swkode' ".
										"AND item_kd = '$juk_item_kd'");
			
			}
		while ($rjuk = mysqli_fetch_assoc($qjuk));
		
		

		
		
		
		//del
		mysqli_query($koneksi, "DELETE FROM siswa_bayar ".
									"WHERE kode = '$kd'");
									
									
		//del
		mysqli_query($koneksi, "DELETE FROM siswa_bayar_rincian ".
									"WHERE bayar_kode = '$kd'");
		}


	//auto-kembali
	xloc($ke);
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
	
	$sqlcount = "SELECT DISTINCT(bayar_kode) AS kodenya ".
					"FROM siswa_bayar_rincian ".
					"WHERE nominal_bayar <> 0 ".
					"AND (siswa_tapel LIKE '%$kunci%' ".
					"OR siswa_kelas LIKE '%$kunci%' ".
					"OR siswa_kode LIKE '%$kunci%' ".
					"OR siswa_nama LIKE '%$kunci%' ".
					"OR bayar_kode LIKE '%$kunci%' ".
					"OR bayar_tgl LIKE '%$kunci%' ".
					"OR item_nama LIKE '%$kunci%' ".
					"OR item_thn LIKE '%$kunci%' ".
					"OR item_bln LIKE '%$kunci%' ".
					"OR nominal_bayar LIKE '%$kunci%') ".
					"ORDER BY bayar_tgl DESC";
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
	
	$sqlcount = "SELECT DISTINCT(bayar_kode) AS kodenya ".
					"FROM siswa_bayar_rincian ".
					"WHERE nominal_bayar <> 0 ".
					"ORDER BY bayar_tgl DESC";
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
$qyuk2 = mysqli_query($koneksi, "SELECT SUM(nominal_bayar) AS totalnya ".
									"FROM siswa_bayar_rincian ".
									"WHERE nominal_bayar <> 0");
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
	  
	  
Total Pembayaran : <b>'.xduit3($yuk2_totalnya).'</b> 
<div class="table-responsive">          
	  <table class="table" border="1">
	    <thead>
			
			<tr bgcolor="'.$warnaheader.'">
			<td width="1">&nbsp;</td>
			<td width="50" align="left"><strong><font color="'.$warnatext.'">TGl.BAYAR</font></strong></td>
			<td width="200" align="center"><strong><font color="'.$warnatext.'">SISWA</font></strong></td>
			<td width="150" align="center"><strong><font color="'.$warnatext.'">NOMINAL BAYAR</font></strong></td>
			<td align="left"><strong><font color="'.$warnatext.'">RINCIAN</font></strong></td>
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
		$e_kode = nosql($data['kodenya']);
		
		
		//rincian
		$qku = mysqli_query($koneksi, "SELECT * FROM siswa_bayar_rincian ".
											"WHERE bayar_kode = '$e_kode' ".
											"ORDER BY postdate DESC");
		$rku = mysqli_fetch_assoc($qku);
		$e_kd = nosql($rku['kd']);
		$e_bkd = balikin($rku['bayar_kd']);
		$e_swkd = balikin($rku['siswa_kd']);
		$e_swnis = balikin($rku['siswa_kode']);
		$e_swnama = balikin($rku['siswa_nama']);

		$e_tgl = balikin($rku['bayar_tgl']);


		$e_siswa = "$e_swnama <br>NIS:$e_swnis";




		//totalnya
		$qku2 = mysqli_query($koneksi, "SELECT SUM(nominal_bayar) AS totalnya ".
											"FROM siswa_bayar_rincian ".
											"WHERE bayar_kode = '$e_kode' ".
											"ORDER BY postdate DESC");
		$rku2 = mysqli_fetch_assoc($qku2);		
		$e_nominal = balikin($rku2['totalnya']);
		
		
		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		<input type="checkbox" name="item'.$nomer.'" value="'.$e_kode.'">
        </td>
		<td align="left">
		'.$e_tgl.'
		<br>
		<br>
		
		Nota:
		<br>
		<b>'.$e_kode.'</b>
		<br>
		<br>
		<a href="nota_pdf.php?notakd='.$e_bkd.'" target="_blank" class="btn btn-block btn-danger">PRINT PDF >></a>
		</td>
		<td align="left">'.$e_siswa.'</td>
		<td align="right">'.xduit3($e_nominal).'</td>
		<td align="left">';
		
		//list
		$qjuk = mysqli_query($koneksi, "SELECT * FROM siswa_bayar_rincian ".
										"WHERE bayar_kode = '$e_kode' ".
										"ORDER BY item_tapel DESC, ".
										"item_smt ASC, ". 
										"item_thn DESC, ".
										"round(item_bln) ASC, ".
										"item_nama ASC, ".
										"item_kelas ASC");
		$rjuk = mysqli_fetch_assoc($qjuk);
		
		do
			{
			//nilai
			$juk_item_tapel = balikin($rjuk['item_tapel']);
			$juk_item_smt = balikin($rjuk['item_smt']);
			$juk_item_thn = balikin($rjuk['item_thn']);
			$juk_item_bln = balikin($rjuk['item_bln']);
			$juk_item_nama = balikin($rjuk['item_nama']);
			$juk_item_kelas = balikin($rjuk['item_kelas']);
			$juk_item_nominal = balikin($rjuk['item_nominal']);
			$juk_item_nbayar = xduit3(balikin($rjuk['nominal_bayar']));
				
			echo "TAPEL:<b>$juk_item_tapel</b>. SMT:<b>$juk_item_smt</b>. Bulan:<b>$arrbln[$juk_item_bln] $juk_item_thn</b>. Kelas:<b>$juk_item_kelas</b>
			<br>
			[<b>$juk_item_nbayar</b>]. <b>$juk_item_nama</b>
			<hr>";
			}
		while ($rjuk = mysqli_fetch_assoc($qjuk));
		
		
		
		
		
		
		echo '</td>
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