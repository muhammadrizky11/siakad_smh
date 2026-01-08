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
$tpl = LoadTpl("../../template/admin.html");





//nilai
$filenya = "lap_bln.php";
$judul = "[IJIN MASUK PULANG]. Lap. Per Bulan";
$judulku = "$judul";
$judulx = $judul;
$uthn = nosql($_REQUEST['uthn']);

$s = nosql($_REQUEST['s']);
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
	$uthn = balikin($_POST['uthn']);
	$fileku = "lap_per_bulan-$uthn.xls";



	
	//isi *START
	ob_start();
	

	

	echo '<div class="table-responsive">
	<h3>LAPORAN PER BULAN, '.$uthn.'</h3>

	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
	
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="150"><strong><font color="'.$warnatext.'">BULAN</font></strong></td>
	<td><strong><font color="'.$warnatext.'">JUMLAH IJIN</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">JUMLAH SISWA</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">JUMLAH GURU</font></strong></td>
	</tr>
	</thead>
	<tbody>';
	
	for ($k=1;$k<=12;$k++) 
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


		
		//jumlahnya 
		$qku2 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%m')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn'");
		$rku2 = mysqli_fetch_assoc($qku2);
		$tku2 = mysqli_num_rows($qku2);
		
		
		//jumlahnya siswa 
		$qku21 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%m')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'SISWA'");
		$rku21 = mysqli_fetch_assoc($qku21);
		$tku21 = mysqli_num_rows($qku21);
		
		
		//jumlahnya siswa 
		$qku21 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%m')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'SISWA' ".
										"AND status = 'IJIN MASUK'");
		$rku21 = mysqli_fetch_assoc($qku21);
		$tku21_imasuk = mysqli_num_rows($qku21);
		
		
		
		
		//jumlahnya siswa 
		$qku21 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%m')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'SISWA' ".
										"AND status = 'IJIN PULANG'");
		$rku21 = mysqli_fetch_assoc($qku21);
		$tku21_ipulang = mysqli_num_rows($qku21);
		
		
		
		

		
		//jumlahnya guru 
		$qku22 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%m')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'GURU'");
		$rku22 = mysqli_fetch_assoc($qku22);
		$tku22 = mysqli_num_rows($qku22);
		
		
		//jumlahnya guru 
		$qku22 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%m')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'GURU' ".
										"AND status = 'IJIN MASUK'");
		$rku22 = mysqli_fetch_assoc($qku22);
		$tku22_imasuk = mysqli_num_rows($qku22);
		
		
		
		//jumlahnya guru 
		$qku22 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%m')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'GURU' ".
										"AND status = 'IJIN PULANG'");
		$rku22 = mysqli_fetch_assoc($qku22);
		$tku22_ipulang = mysqli_num_rows($qku22);
		
		
		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$arrbln[$k].'</td>
		<td><font color="red">'.$tku2.'</font></td>
		<td>
		<font color="red">'.$tku21.'</font>
		<br>
		IJIN MASUK:<b>'.$tku21_imasuk.'</b>
		<br>
		IJIN PULANG:<b>'.$tku21_ipulang.'</b>
		
		</td>
		<td>
		<font color="red">'.$tku22.'</font>
		<br>
		IJIN MASUK:<b>'.$tku22_imasuk.'</b>
		<br>
		IJIN PULANG:<b>'.$tku22_ipulang.'</b>
		
		</td>
		</tr>';
		}
	
	
	


	//jumlahnya 
	$qku2 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
									"WHERE round(DATE_FORMAT(postdate, '%Y')) = '$uthn'");
	$rku2 = mysqli_fetch_assoc($qku2);
	$tku2 = mysqli_num_rows($qku2);
	


	//jumlahnya siswa 
	$qku21 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
									"WHERE round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
									"AND user_jabatan = 'SISWA'");
	$rku21 = mysqli_fetch_assoc($qku21);
	$tku21 = mysqli_num_rows($qku21);
	

	
	//jumlahnya guru 
	$qku22 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
									"WHERE round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
									"AND user_jabatan = 'GURU'");
	$rku22 = mysqli_fetch_assoc($qku22);
	$tku22 = mysqli_num_rows($qku22);
		
	
	
	
	echo '<tr valign="top" bgcolor="'.$warnaheader.'">
	<td>&nbsp;</td>
	<td><strong><font color="'.$warnatext.'">'.$tku2.'</font></strong></td>
	<td><strong><font color="'.$warnatext.'">'.$tku21.'</font></strong></td>
	<td><strong><font color="'.$warnatext.'">'.$tku22.'</font></strong></td>
	</tr>

	</tbody>
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
require("../../template/js/jumpmenu.js");
require("../../template/js/checkall.js");
require("../../template/js/swap.js");
?>
	
	
	  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  
<?php
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


echo '<form action="'.$filenya.'" method="post" name="formx">

<div class="row">
	<div class="col-md-12">';
	

	echo "<p>
	Tahun : 
	<br>
	<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
	echo '<option value="'.$uthn.'" selected>'.$uthn.'</option>';
	
	for ($i=$tahun;$i<=$tahun+1;$i++)
		{
		echo '<option value="'.$filenya.'?uthn='.$i.'">'.$i.'</option>';
		}
				
	echo '</select>
	</p>		
	

	
	
	</div>
</div>

<hr>';


if (empty($uthn))
	{
	echo '<font color="red">
	<h3>TAHUN Belum Dipilih...!!</h3>
	</font>';
	}

	
else
	{
	echo '<input name="uthn" type="hidden" value="'.$uthn.'">
	<input name="btnEX" type="submit" value="EXPORT EXCEL >>" class="btn btn-danger">
	
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
	
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="150"><strong><font color="'.$warnatext.'">BULAN</font></strong></td>
	<td><strong><font color="'.$warnatext.'">JUMLAH IJIN</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">JUMLAH SISWA</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">JUMLAH GURU</font></strong></td>
	</tr>
	</thead>
	<tbody>';
	
	for ($k=1;$k<=12;$k++) 
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


		
		//jumlahnya 
		$qku2 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%m')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn'");
		$rku2 = mysqli_fetch_assoc($qku2);
		$tku2 = mysqli_num_rows($qku2);
		
		
		//jumlahnya siswa 
		$qku21 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%m')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'SISWA'");
		$rku21 = mysqli_fetch_assoc($qku21);
		$tku21 = mysqli_num_rows($qku21);
		
		
		//jumlahnya siswa 
		$qku21 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%m')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'SISWA' ".
										"AND status = 'IJIN MASUK'");
		$rku21 = mysqli_fetch_assoc($qku21);
		$tku21_imasuk = mysqli_num_rows($qku21);
		
		
		
		
		//jumlahnya siswa 
		$qku21 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%m')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'SISWA' ".
										"AND status = 'IJIN PULANG'");
		$rku21 = mysqli_fetch_assoc($qku21);
		$tku21_ipulang = mysqli_num_rows($qku21);
		
		
		
		

		
		//jumlahnya guru 
		$qku22 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%m')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'GURU'");
		$rku22 = mysqli_fetch_assoc($qku22);
		$tku22 = mysqli_num_rows($qku22);
		
		
		//jumlahnya guru 
		$qku22 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%m')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'GURU' ".
										"AND status = 'IJIN MASUK'");
		$rku22 = mysqli_fetch_assoc($qku22);
		$tku22_imasuk = mysqli_num_rows($qku22);
		
		
		
		//jumlahnya guru 
		$qku22 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%m')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'GURU' ".
										"AND status = 'IJIN PULANG'");
		$rku22 = mysqli_fetch_assoc($qku22);
		$tku22_ipulang = mysqli_num_rows($qku22);
		
		
		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$arrbln[$k].'</td>
		<td><font color="red">'.$tku2.'</font></td>
		<td>
		<font color="red">'.$tku21.'</font>
		<br>
		IJIN MASUK:<b>'.$tku21_imasuk.'</b>
		<br>
		IJIN PULANG:<b>'.$tku21_ipulang.'</b>
		
		</td>
		<td>
		<font color="red">'.$tku22.'</font>
		<br>
		IJIN MASUK:<b>'.$tku22_imasuk.'</b>
		<br>
		IJIN PULANG:<b>'.$tku22_ipulang.'</b>
		
		</td>
		</tr>';
		}
	
	
	


	//jumlahnya 
	$qku2 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
									"WHERE round(DATE_FORMAT(postdate, '%Y')) = '$uthn'");
	$rku2 = mysqli_fetch_assoc($qku2);
	$tku2 = mysqli_num_rows($qku2);
	


	//jumlahnya siswa 
	$qku21 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
									"WHERE round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
									"AND user_jabatan = 'SISWA'");
	$rku21 = mysqli_fetch_assoc($qku21);
	$tku21 = mysqli_num_rows($qku21);
	

	
	//jumlahnya guru 
	$qku22 = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
									"WHERE round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
									"AND user_jabatan = 'GURU'");
	$rku22 = mysqli_fetch_assoc($qku22);
	$tku22 = mysqli_num_rows($qku22);
		
	
	
	
	echo '<tr valign="top" bgcolor="'.$warnaheader.'">
	<td>&nbsp;</td>
	<td><strong><font color="'.$warnatext.'">'.$tku2.'</font></strong></td>
	<td><strong><font color="'.$warnatext.'">'.$tku21.'</font></strong></td>
	<td><strong><font color="'.$warnatext.'">'.$tku22.'</font></strong></td>
	</tr>

	</tbody>
	  </table>
	  </div>';

	}


echo '</form>';


//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>