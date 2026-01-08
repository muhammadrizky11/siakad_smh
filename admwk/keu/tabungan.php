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
require("../../inc/cek/admwk.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admwk.html");








//nilai
$filenya = "tabungan.php";
$judul = "[KEUANGAN SISWA] Lunas";
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









//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}

//jika export
//export
if ($_POST['btnEX'])
	{
	//query
	$limit = 1000000;
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT siswa_tabungan.* ".
					"FROM siswa_tabungan, m_walikelas ".
					"WHERE m_walikelas.peg_kd = '$kd3_session' ".
					"AND siswa_tabungan.tapel = m_walikelas.tapel_nama ".
					"AND siswa_tabungan.kelas = m_walikelas.kelas_nama ".
					"ORDER BY siswa_tabungan.tapel DESC, ".
					"siswa_tabungan.kelas ASC, ".
					"siswa_tabungan.siswa_nama ASC, ".
					"siswa_tabungan.postdate DESC";
	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);


	$fileku = "tabungan.xls";





	
	//isi *START
	ob_start();
	

	

	echo '<div class="table-responsive">
	<h3>DAFTAR TABUNGAN SISWA</h3>
	
	<table class="table" border="1">
	    <thead>
			
			<tr bgcolor="'.$warnaheader.'">
			<td width="50" align="center"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
			<td width="100" align="center"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
			<td align="center"><strong><font color="'.$warnatext.'">SISWA</font></strong></td>
			<td width="100" align="center"><strong><font color="'.$warnatext.'">TANGGAL</font></strong></td>
			<td width="150" align="center"><strong><font color="'.$warnatext.'">DEBET/KREDIT</font></strong></td>
			<td width="150" align="center"><strong><font color="'.$warnatext.'">NOMINAL</font></strong></td>
			<td width="150" align="center"><strong><font color="'.$warnatext.'">SALDO</font></strong></td>
			<td width="100" align="center"><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
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
		$e_swnis = balikin($data['siswa_nis']);
		$e_swnama = balikin($data['siswa_nama']);
		$e_tapel = balikin($data['tapel']);
		$e_kelas = balikin($data['kelas']);
		$e_nominal = balikin($data['nilai']);
		$e_debetx = balikin($data['debet']);
		$e_tgl = balikin($data['tgl']);
		$e_postdate = balikin($data['postdate']);
		$e_saldo = balikin($data['saldo']);


		$e_siswa = "$e_swnama <br>NIS:$e_swnis";

		//jika debet
		if ($e_debetx == "true")
			{
			$e_debetx = "DEBET";
			}
			
		else if ($e_debetx == "false")
			{
			$e_debetx = "KREDIT";
			}

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td align="center">'.$e_tapel.'</td>
		<td align="center">'.$e_kelas.'</td>
		<td align="left">'.$e_siswa.'</td>
		<td>'.$e_tgl.'</td>
		<td align="center">'.$e_debetx.'</td>
		<td align="center">'.xduit3($e_nominal).'</td>
		<td align="center">'.xduit3($e_saldo).'</td>
		<td align="center">'.$e_postdate.'</td>
        </tr>';
		}
	while ($data = mysqli_fetch_assoc($result));
	}


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
	
	$sqlcount = "SELECT siswa_tabungan.* ".
					"FROM siswa_tabungan, m_walikelas ".
					"WHERE m_walikelas.peg_kd = '$kd3_session' ".
					"AND siswa_tabungan.tapel = m_walikelas.tapel_nama ".
					"AND siswa_tabungan.kelas = m_walikelas.kelas_nama ".
					"AND (siswa_tabungan.tapel LIKE '%$kunci%' ".
					"OR siswa_tabungan.kelas LIKE '%$kunci%' ".
					"OR siswa_tabungan.tgl LIKE '%$kunci%' ".
					"OR siswa_tabungan.siswa_nama LIKE '%$kunci%' ".
					"OR siswa_tabungan.siswa_nis LIKE '%$kunci%' ".
					"OR siswa_tabungan.siswa_nama LIKE '%$kunci%') ".
					"ORDER BY siswa_tabungan.tapel DESC, ".
					"siswa_tabungan.kelas ASC, ".
					"siswa_tabungan.siswa_nama ASC, ".
					"siswa_tabungan.postdate DESC";
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
	
	$sqlcount = "SELECT siswa_tabungan.* ".
					"FROM siswa_tabungan, m_walikelas ".
					"WHERE m_walikelas.peg_kd = '$kd3_session' ".
					"AND siswa_tabungan.tapel = m_walikelas.tapel_nama ".
					"AND siswa_tabungan.kelas = m_walikelas.kelas_nama ".
					"ORDER BY siswa_tabungan.tapel DESC, ".
					"siswa_tabungan.kelas ASC, ".
					"siswa_tabungan.siswa_nama ASC, ".
					"siswa_tabungan.postdate DESC";
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
$qyuk2 = mysqli_query($koneksi, "SELECT SUM(siswa_tabungan.nilai) AS totalnya ".
									"FROM siswa_tabungan, m_walikelas ".
									"WHERE m_walikelas.peg_kd = '$kd3_session' ".
									"AND siswa_tabungan.debet = 'true'");
$ryuk2 = mysqli_fetch_assoc($qyuk2);
$yuk2_debet = balikin($ryuk2['totalnya']);


//ketahui totalnya
$qyuk2 = mysqli_query($koneksi, "SELECT SUM(siswa_tabungan.nilai) AS totalnya ".
									"FROM siswa_tabungan, m_walikelas ".
									"WHERE m_walikelas.peg_kd = '$kd3_session' ".
									"AND siswa_tabungan.debet = 'false'");
$ryuk2 = mysqli_fetch_assoc($qyuk2);
$yuk2_kredit = balikin($ryuk2['totalnya']);



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
	  
	  
[Total Debet : <b>'.xduit3($yuk2_debet).'</b>]. 
[Total Kredit : <b>'.xduit3($yuk2_kredit).'</b>]. 
<div class="table-responsive">          
	  <table class="table" border="1">
	    <thead>
			
			<tr bgcolor="'.$warnaheader.'">
			<td width="50" align="center"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
			<td width="100" align="center"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
			<td align="center"><strong><font color="'.$warnatext.'">SISWA</font></strong></td>
			<td width="100" align="center"><strong><font color="'.$warnatext.'">TANGGAL</font></strong></td>
			<td width="150" align="center"><strong><font color="'.$warnatext.'">DEBET/KREDIT</font></strong></td>
			<td width="150" align="center"><strong><font color="'.$warnatext.'">NOMINAL</font></strong></td>
			<td width="150" align="center"><strong><font color="'.$warnatext.'">SALDO</font></strong></td>
			<td width="100" align="center"><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
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
		$e_swnis = balikin($data['siswa_nis']);
		$e_swnama = balikin($data['siswa_nama']);
		$e_tapel = balikin($data['tapel']);
		$e_kelas = balikin($data['kelas']);
		$e_nominal = balikin($data['nilai']);
		$e_debetx = balikin($data['debet']);
		$e_tgl = balikin($data['tgl']);
		$e_postdate = balikin($data['postdate']);
		$e_saldo = balikin($data['saldo']);


		$e_siswa = "$e_swnama <br>NIS:$e_swnis";

		//jika debet
		if ($e_debetx == "true")
			{
			$e_debetx = "DEBET";
			}
			
		else if ($e_debetx == "false")
			{
			$e_debetx = "KREDIT";
			}

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td align="center">'.$e_tapel.'</td>
		<td align="center">'.$e_kelas.'</td>
		<td align="left">'.$e_siswa.'</td>
		<td>'.$e_tgl.'</td>
		<td align="center">'.$e_debetx.'</td>
		<td align="center">'.xduit3($e_nominal).'</td>
		<td align="center">'.xduit3($e_saldo).'</td>
		<td align="center">'.$e_postdate.'</td>
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