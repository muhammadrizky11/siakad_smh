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
require("../../inc/cek/admbk.php");
$tpl = LoadTpl("../../template/admbk.html");





//nilai
$filenya = "lap_thn.php";
$judul = "[PRESENSI]. Lap. Per Tahun";
$judulku = "$judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$kd = nosql($_REQUEST['kd']);




$limit = 100;














//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek excel
if ($_POST['btnEX'])
	{
	//nilai
	$fileku = "lap_tahunan.xls";



	
	//isi *START
	ob_start();
	

	echo '<div class="table-responsive">
	<h3>LAPORAN TAHUNAN</h3>
	                   
	<table class="table" border="1">
	<thead>
	
	
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="50"><strong><font color="'.$warnatext.'">TAHUN</font></strong></th>
		<td><strong><font color="'.$warnatext.'">JUMLAH KEHADIRAN</font></strong></td>
		<td width="150"><strong><font color="'.$warnatext.'">JUMLAH SISWA</font></strong></th>
		<td width="150"><strong><font color="'.$warnatext.'">JUMLAH GURU</font></strong></th>
		</tr>
	
	</thead>
	<tbody>';
	
	
	
	for ($k=$tahun-1;$k<=$tahun;$k++)
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
	
	
	
	
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$k.'</td>';
		
		//jumlahnya 
		$qku2 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
										"WHERE round(DATE_FORMAT(postdate, '%Y')) = '$k'");
		$rku2 = mysqli_fetch_assoc($qku2);
		$tku2 = mysqli_num_rows($qku2);
		
		
		//jumlahnya siswa 
		$qku21 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
										"WHERE round(DATE_FORMAT(postdate, '%Y')) = '$k' ".
										"AND user_jabatan = 'SISWA'");
		$rku21 = mysqli_fetch_assoc($qku21);
		$tku21 = mysqli_num_rows($qku21);
		
		
		//jumlahnya 
		$qku22 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
										"WHERE round(DATE_FORMAT(postdate, '%Y')) = '$k' ".
										"AND user_jabatan = 'GURU'");
		$rku22 = mysqli_fetch_assoc($qku22);
		$tku22 = mysqli_num_rows($qku22);
		
		
		echo '<td align="left"><strong><font color="'.$warnatext.'">'.$tku2.'</font></strong></td>
		<td align="left"><strong><font color="'.$warnatext.'">'.$tku21.'</font></strong></td>
		<td align="left"><strong><font color="'.$warnatext.'">'.$tku22.'</font></strong></td>
		</tr>';
		}
	
	
	
	
		//jumlahnya 
		$qku2 = mysqli_query($koneksi, "SELECT kd FROM user_presensi");
		$rku2 = mysqli_fetch_assoc($qku2);
		$tku2 = mysqli_num_rows($qku2);
		
		
		//jumlahnya siswa 
		$qku21 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
										"WHERE user_jabatan = 'SISWA'");
		$rku21 = mysqli_fetch_assoc($qku21);
		$tku21 = mysqli_num_rows($qku21);
		
		
		//jumlahnya 
		$qku22 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
										"WHERE user_jabatan = 'GURU'");
		$rku22 = mysqli_fetch_assoc($qku22);
		$tku22 = mysqli_num_rows($qku22);
		
	
	
	echo '</tbody>	
		<tfoot>
	
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<th><strong><font color="'.$warnatext.'">TOTAL</font></strong></th>
		<th><strong><font color="'.$warnatext.'">'.$tku2.'</font></strong></th>
		<th><strong><font color="'.$warnatext.'">'.$tku21.'</font></strong></th>
		<th><strong><font color="'.$warnatext.'">'.$tku22.'</font></strong></th>
		</tr>				
		</tfoot>
	
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
echo '<form action="'.$filenya.'" method="post" name="formx">

<input name="btnEX" type="submit" value="EXPORT EXCEL >>" class="btn btn-danger">


<div class="table-responsive">          
<table class="table" border="1">
<thead>

	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="50"><strong><font color="'.$warnatext.'">TAHUN</font></strong></th>
	<td><strong><font color="'.$warnatext.'">JUMLAH KEHADIRAN</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">JUMLAH SISWA</font></strong></th>
	<td width="150"><strong><font color="'.$warnatext.'">JUMLAH GURU</font></strong></th>
	</tr>

</thead>
<tbody>';



for ($k=$tahun-1;$k<=$tahun;$k++)
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




	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$k.'</td>';
	
	//jumlahnya 
	$qku2 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
									"WHERE round(DATE_FORMAT(postdate, '%Y')) = '$k'");
	$rku2 = mysqli_fetch_assoc($qku2);
	$tku2 = mysqli_num_rows($qku2);
	
	
	//jumlahnya siswa 
	$qku21 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
									"WHERE round(DATE_FORMAT(postdate, '%Y')) = '$k' ".
									"AND user_jabatan = 'SISWA'");
	$rku21 = mysqli_fetch_assoc($qku21);
	$tku21 = mysqli_num_rows($qku21);
	
	
	//jumlahnya 
	$qku22 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
									"WHERE round(DATE_FORMAT(postdate, '%Y')) = '$k' ".
									"AND user_jabatan = 'GURU'");
	$rku22 = mysqli_fetch_assoc($qku22);
	$tku22 = mysqli_num_rows($qku22);
	
	
	echo '<td align="left"><strong><font color="'.$warnatext.'">'.$tku2.'</font></strong></td>
	<td align="left"><strong><font color="'.$warnatext.'">'.$tku21.'</font></strong></td>
	<td align="left"><strong><font color="'.$warnatext.'">'.$tku22.'</font></strong></td>
	</tr>';
	}




	//jumlahnya 
	$qku2 = mysqli_query($koneksi, "SELECT kd FROM user_presensi");
	$rku2 = mysqli_fetch_assoc($qku2);
	$tku2 = mysqli_num_rows($qku2);
	
	
	//jumlahnya siswa 
	$qku21 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
									"WHERE user_jabatan = 'SISWA'");
	$rku21 = mysqli_fetch_assoc($qku21);
	$tku21 = mysqli_num_rows($qku21);
	
	
	//jumlahnya 
	$qku22 = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
									"WHERE user_jabatan = 'GURU'");
	$rku22 = mysqli_fetch_assoc($qku22);
	$tku22 = mysqli_num_rows($qku22);
	


echo '</tbody>	
	<tfoot>

	<tr valign="top" bgcolor="'.$warnaheader.'">
	<th><strong><font color="'.$warnatext.'">TOTAL</font></strong></th>
	<th><strong><font color="'.$warnatext.'">'.$tku2.'</font></strong></th>
	<th><strong><font color="'.$warnatext.'">'.$tku21.'</font></strong></th>
	<th><strong><font color="'.$warnatext.'">'.$tku22.'</font></strong></th>
	</tr>
	
	</tfoot>

  </table>





<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
<input name="jml" type="hidden" value="'.$count.'">
</td>
</tr>
</table>


</div>



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