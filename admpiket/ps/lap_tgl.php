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
require("../../inc/cek/admpiket.php");
$tpl = LoadTpl("../../template/admpiket.html");





//nilai
$filenya = "lap_tgl.php";
$judul = "[PRESENSI]. Lap. Per Tanggal";
$judulku = "$judul";
$judulx = $judul;
$ubln = nosql($_REQUEST['ubln']);
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
	$ubln = balikin($_POST['ubln']);
	$uthn = balikin($_POST['uthn']);
	$fileku = "lap_per_tanggal-$ubln-$uthn.xls";



	
	//isi *START
	ob_start();
	

	$month = round($ubln);
	$year = round($uthn);
	
	//tanggal terakhir  
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
		
	
	echo '<div class="table-responsive">
	<h3>LAPORAN PER TANGGAL, '.$arrbln[$ubln].' '.$uthn.'</h3>
	
	          
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
	
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="50"><strong><font color="'.$warnatext.'">TANGGAL</font></strong></td>
	<td><strong><font color="'.$warnatext.'">JUMLAH KEHADIRAN</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">JUMLAH SISWA</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">JUMLAH GURU</font></strong></td>
	</tr>
	</thead>
	<tbody>';
	
	for ($k=1;$k<=$days_in_month;$k++) 
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


		//jumlah 
		$qku3 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
										"WHERE round(DATE_FORMAT(postdate, '%d')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn'");
		$rku3 = mysqli_fetch_assoc($qku3);
		$tku3 = mysqli_num_rows($qku3);
		
		

		
		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$k.'.</td>
		<td><font color="red">'.$tku3.'</font></td>
		<td>';

		//rincian
		$qku31 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
										"WHERE round(DATE_FORMAT(postdate, '%d')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'SISWA'");
		$rku31 = mysqli_fetch_assoc($qku31);
		$tku31 = mysqli_num_rows($qku31);

		
		echo '<font color="red">'.$tku31.'</font></td>
		
		<td>';

		//rincian
		$qku31 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
										"WHERE round(DATE_FORMAT(postdate, '%d')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'GURU'");
		$rku31 = mysqli_fetch_assoc($qku31);
		$tku31 = mysqli_num_rows($qku31);

		
		echo '<font color="red">'.$tku31.'</font></td>
		</tr>';
		}
	








	//jumlah 
	$qku3 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
									"WHERE round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
									"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn'");
	$rku3 = mysqli_fetch_assoc($qku3);
	$tku3 = mysqli_num_rows($qku3);
	


	echo '<tr valign="top" bgcolor="'.$warnaheader.'">
	<td>&nbsp;</td>
	<td><font color="yellow">'.$tku3.'</font></td>
	<td>';

	//rincian
	$qku31 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
									"WHERE round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
									"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
									"AND user_jabatan = 'SISWA'");
	$rku31 = mysqli_fetch_assoc($qku31);
	$tku31 = mysqli_num_rows($qku31);

	
	echo '<font color="yellow">'.$tku31.'</font></td>
	<td>';

	//rincian
	$qku31 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
									"WHERE round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
									"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
									"AND user_jabatan = 'GURU'");
	$rku31 = mysqli_fetch_assoc($qku31);
	$tku31 = mysqli_num_rows($qku31);

	
	echo '<font color="yellow">'.$tku31.'</font></td>
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
	Bulan : 
	<br>
	<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
	echo '<option value="'.$ubln.'" selected>'.$arrbln[$ubln].'</option>';
	
	for ($i=1;$i<=12;$i++)
		{
		echo '<option value="'.$filenya.'?ubln='.$i.'">'.$arrbln[$i].'</option>';
		}
				
	echo '</select>';
	


	echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
	echo '<option value="'.$uthn.'" selected>'.$uthn.'</option>';
	
	for ($i=$tahun;$i<=$tahun+1;$i++)
		{
		echo '<option value="'.$filenya.'?ubln='.$ubln.'&uthn='.$i.'">'.$i.'</option>';
		}
				
	echo '</select>
	</p>		
	
	
	
	</div>
</div>

<hr>';


if (empty($ubln))
	{
	echo '<font color="red">
	<h3>BULAN Belum Dipilih...!!</h3>
	</font>';
	}


else if (empty($uthn))
	{
	echo '<font color="red">
	<h3>TAHUN Belum Dipilih...!!</h3>
	</font>';
	}
	
else
	{
	$month = round($ubln);
	$year = round($uthn);
	
	//tanggal terakhir  
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
		
	
	echo '<input name="ubln" type="hidden" value="'.$ubln.'">
	<input name="uthn" type="hidden" value="'.$uthn.'">
	<input name="btnEX" type="submit" value="EXPORT EXCEL >>" class="btn btn-danger">
	
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
	
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="50"><strong><font color="'.$warnatext.'">TANGGAL</font></strong></td>
	<td><strong><font color="'.$warnatext.'">JUMLAH KEHADIRAN</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">JUMLAH SISWA</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">JUMLAH GURU</font></strong></td>
	</tr>
	</thead>
	<tbody>';
	
	for ($k=1;$k<=$days_in_month;$k++) 
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


		//jumlah 
		$qku3 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
										"WHERE round(DATE_FORMAT(postdate, '%d')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn'");
		$rku3 = mysqli_fetch_assoc($qku3);
		$tku3 = mysqli_num_rows($qku3);
		
		

		
		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$k.'.</td>
		<td><font color="red">'.$tku3.'</font></td>
		<td>';

		//rincian
		$qku31 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
										"WHERE round(DATE_FORMAT(postdate, '%d')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'SISWA'");
		$rku31 = mysqli_fetch_assoc($qku31);
		$tku31 = mysqli_num_rows($qku31);

		
		echo '<font color="red">'.$tku31.'</font></td>
		
		<td>';

		//rincian
		$qku31 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
										"WHERE round(DATE_FORMAT(postdate, '%d')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
										"AND user_jabatan = 'GURU'");
		$rku31 = mysqli_fetch_assoc($qku31);
		$tku31 = mysqli_num_rows($qku31);

		
		echo '<font color="red">'.$tku31.'</font></td>
		</tr>';
		}
	








	//jumlah 
	$qku3 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
									"WHERE round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
									"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn'");
	$rku3 = mysqli_fetch_assoc($qku3);
	$tku3 = mysqli_num_rows($qku3);
	


	echo '<tr valign="top" bgcolor="'.$warnaheader.'">
	<td>&nbsp;</td>
	<td><font color="yellow">'.$tku3.'</font></td>
	<td>';

	//rincian
	$qku31 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
									"WHERE round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
									"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
									"AND user_jabatan = 'SISWA'");
	$rku31 = mysqli_fetch_assoc($qku31);
	$tku31 = mysqli_num_rows($qku31);

	
	echo '<font color="yellow">'.$tku31.'</font></td>
	<td>';

	//rincian
	$qku31 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
									"WHERE round(DATE_FORMAT(postdate, '%m')) = '$ubln' ".
									"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn' ".
									"AND user_jabatan = 'GURU'");
	$rku31 = mysqli_fetch_assoc($qku31);
	$tku31 = mysqli_num_rows($qku31);

	
	echo '<font color="yellow">'.$tku31.'</font></td>
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