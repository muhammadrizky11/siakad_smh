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
$filenya = "lap_telat.php";
$judul = "[PRESENSI]. Lap. Terlambat";
$judulku = "$judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$kd = nosql($_REQUEST['kd']);

















//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek excel
if ($_POST['btnEX'])
	{
	//nilai
	$fileku = "lap_telat.xls";



	
	//isi *START
	ob_start();
	

	$limit = 1000;
	$sqlcount = "SELECT * FROM user_presensi ".
					"WHERE telat_ket <> '-' ".
					"ORDER BY postdate DESC";
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
	<h3>LAPORAN TERLAMBAT</h3>
	                   
	<table class="table" border="1">
	<thead>
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="50"><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">JABATAN</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">TELAT</font></strong></td>
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
			$i_kd = nosql($data['kd']);
			$i_postdate = balikin($data['postdate']);
			$i_jabatan = balikin($data['user_jabatan']);
			$i_kode = balikin($data['user_kode']);
			$i_nama = balikin($data['user_nama']);
			$i_kelas = balikin($data['user_kelas']);
			$i_tapel = balikin($data['user_tapel']);
			$i_ket = balikin($data['ket']);
			$i_status = balikin($data['status']);
			$i_telat = balikin($data['telat_ket']);
	
			
			//jika SISWA
			if ($i_jabatan == "SISWA")
				{
				$i_namax = "NIS:$i_kode <br> $i_nama <br> $i_kelas";
				}
				
			else
				{
				$i_namax = "NIP:$i_kode <br> $i_nama";
				}	
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i_postdate.'</td>
			<td>'.$i_jabatan.'</td>
			<td>'.$i_namax.'</td>
			<td>'.$i_telat.'</td>
	        </tr>';
			}
		while ($data = mysqli_fetch_assoc($result));

						
		echo '</tfoot>
	
	  </table>';
	

	




	
	//isi
	$isiku = ob_get_contents();
	ob_end_clean();


	
	
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$fileku");
	echo $isiku;


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
	$sqlcount = "SELECT * FROM user_presensi ".
					"WHERE telat_ket <> '-' ".
					"ORDER BY postdate DESC";
	}
	
else
	{
	$sqlcount = "SELECT * FROM user_presensi ".
					"WHERE telat_ket <> '-' ".
					"AND (user_kode LIKE '%$kunci%' ".
					"OR user_nama LIKE '%$kunci%' ".
					"OR user_jabatan LIKE '%$kunci%' ".
					"OR user_kelas LIKE '%$kunci%' ".
					"OR user_tapel LIKE '%$kunci%' ".
					"OR tanggal LIKE '%$kunci%' ".
					"OR status LIKE '%$kunci%' ".
					"OR ket LIKE '%$kunci%' ".
					"OR telat LIKE '%$kunci%') ".
					"ORDER BY postdate DESC";
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
<td width="50"><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">JABATAN</font></strong></td>
<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
<td width="150"><strong><font color="'.$warnatext.'">TELAT</font></strong></td>
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
		$i_postdate = balikin($data['postdate']);
		$i_jabatan = balikin($data['user_jabatan']);
		$i_kode = balikin($data['user_kode']);
		$i_nama = balikin($data['user_nama']);
		$i_kelas = balikin($data['user_kelas']);
		$i_tapel = balikin($data['user_tapel']);
		$i_ket = balikin($data['ket']);
		$i_status = balikin($data['status']);
		$i_telat = balikin($data['telat_ket']);

		
		//jika SISWA
		if ($i_jabatan == "SISWA")
			{
			$i_namax = "NIS:$i_kode <br> $i_nama <br> $i_kelas";
			}
			
		else
			{
			$i_namax = "NIP:$i_kode <br> $i_nama";
			}	
		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_postdate.'</td>
		<td>'.$i_jabatan.'</td>
		<td>'.$i_namax.'</td>
		<td>'.$i_telat.'</td>
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