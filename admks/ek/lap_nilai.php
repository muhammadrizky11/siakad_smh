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
$filenya = "lap_nilai.php";
$judul = "[EKSTRA]. Lap. Per Siswa";
$judulku = "$judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$kd = nosql($_REQUEST['kd']);

$kunci = cegah($_REQUEST['kunci']);
$kunci2 = balikin($_REQUEST['kunci']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}
	
















//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek excel
if ($_POST['btnEX'])
	{
	//nilai
	$fileku = "lap_nilai.xls";



	
	//isi *START
	ob_start();
	

	$limit = 10000;
	$sqlcount = "SELECT * FROM siswa_ekstra ".
					"ORDER BY tapel DESC, ".
					"kelas ASC, ".
					"smt ASC";
	//query
	$p = new Pager();
	$start = $p->findStart($limit);
	
	$sqlresult = $sqlcount;
	
	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);
	



	echo '<div class="table-responsive">
	<h3>LAPORAN PER SISWA</h3>
	                   
	<table class="table" border="1">
	<thead>

		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="50"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">SMT</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
		<td><strong><font color="'.$warnatext.'">SISWA</font></strong></td>
		<td><strong><font color="'.$warnatext.'">NAMA EKSTRA</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">PREDIKAT</font></strong></td>
		<td><strong><font color="'.$warnatext.'">KETERANGAN</font></strong></td>
		</tr>
		</thead>
		<tbody>';
		
		if ($count != 0)
			{
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
				$i_kd = nosql($data['kd']);
				$i_tapel = balikin($data['tapel']);
				$i_kelas = balikin($data['kelas']);
				$i_smt = balikin($data['smt']);
				$i_swnis = balikin($data['siswa_nis']);
				$i_swnama = balikin($data['siswa_nama']);
				$i_nama = balikin($data['ekstra_nama']);
				$i_predikat = balikin($data['predikat']);
				$i_ket = balikin($data['ket']);
				
		
		
				
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>'.$i_tapel.'</td>
				<td>'.$i_smt.'</td>
				<td>'.$i_kelas.'</td>
				<td>
				'.$i_swnama.'
				<br>
				NIS:'.$i_swnis.'
				</td>
				<td>'.$i_nama.'</td>
				<td>'.$i_predikat.'</td>
				<td>'.$i_ket.'</td>
		        </tr>';
				}
			while ($data = mysqli_fetch_assoc($result));
			}

						
		echo '</tbody>
	
	  </table>';
	

	




	
	//isi
	$isiku = ob_get_contents();
	ob_end_clean();


	
	
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$fileku");
	echo $isiku;


	exit();
	}	








//jika cari
if ($_POST['btnCARI'])
	{
	//nilai
	$kunci = cegah($_POST['kunci']);


	//re-direct
	$ke = "$filenya?kunci=$kunci";
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
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//isi *START
ob_start();

//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>


	<script>
	$(document).ready(function() {
	  		
		$.noConflict();
	    
	});
	</script>
	  
	

<?php
//jika null
if (empty($kunci))
	{
	$sqlcount = "SELECT * FROM siswa_ekstra ".
					"ORDER BY tapel DESC, ".
					"kelas ASC, ".
					"smt ASC";
	}
	
else
	{
	$sqlcount = "SELECT * FROM siswa_ekstra ".
					"WHERE siswa_nis LIKE '%$kunci%' ".
					"OR siswa_nama LIKE '%$kunci%' ".
					"OR tapel LIKE '%$kunci%' ".
					"OR kelas LIKE '%$kunci%' ".
					"OR smt LIKE '%$kunci%' ".
					"OR ekstra_nama LIKE '%$kunci%' ".
					"OR predikat LIKE '%$kunci%' ".
					"OR ket LIKE '%$kunci%' ".
					"ORDER BY tapel DESC, ".
					"kelas ASC, ".
					"smt ASC";
	}
	
	

//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlresult = $sqlcount;

$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysqli_fetch_array($result);




echo '<form action="'.$filenya.'" method="post" name="formx3">

<input name="btnEX" type="submit" value="EXPORT EXCEL >>" class="btn btn-danger">
</form>
<hr>




<form action="'.$filenya.'" method="post" name="formx">
<p>
<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
</p>
	

<div class="table-responsive">          
<table class="table" border="1">
<thead>

<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="50"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">SMT</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
<td><strong><font color="'.$warnatext.'">SISWA</font></strong></td>
<td><strong><font color="'.$warnatext.'">NAMA EKSTRA</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">PREDIKAT</font></strong></td>
<td><strong><font color="'.$warnatext.'">KETERANGAN</font></strong></td>
</tr>
</thead>
<tbody>';

if ($count != 0)
	{
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
		$i_kd = nosql($data['kd']);
		$i_tapel = balikin($data['tapel']);
		$i_kelas = balikin($data['kelas']);
		$i_smt = balikin($data['smt']);
		$i_swnis = balikin($data['siswa_nis']);
		$i_swnama = balikin($data['siswa_nama']);
		$i_nama = balikin($data['ekstra_nama']);
		$i_predikat = balikin($data['predikat']);
		$i_ket = balikin($data['ket']);
		


		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_tapel.'</td>
		<td>'.$i_smt.'</td>
		<td>'.$i_kelas.'</td>
		<td>
		'.$i_swnama.'
		<br>
		NIS:'.$i_swnis.'
		</td>
		<td>'.$i_nama.'</td>
		<td>'.$i_predikat.'</td>
		<td>'.$i_ket.'</td>
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
<br>

<input name="jml" type="hidden" value="'.$count.'">
<input name="s" type="hidden" value="'.$s.'">
<input name="kd" type="hidden" value="'.$kdx.'">
<input name="page" type="hidden" value="'.$page.'">
</td>
</tr>
</table>
</form>';



//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//null-kan
xfree($qbw);
xclose($koneksi);
exit();
?>