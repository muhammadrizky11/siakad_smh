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
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admbdh.html");





//nilai
$filenya = "lap_thn.php";
$judul = "[KEUANGAN SISWA]. Lap. Per Tahun";
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
	$fileku = "lap_per_tahun.xls";



	
	//isi *START
	ob_start();
	

	echo '<div class="table-responsive">
	<h3>LAPORAN PER TAHUN</h3>
	          
	<table class="table" border="1">
	<thead>

	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="50"><strong><font color="'.$warnatext.'">TAHUN</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">SISWA</font></strong></td>
	<th><strong><font color="'.$warnatext.'">SUBTOTAL BAYAR</font></strong></th>
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
	
	

		//nilainya
		$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_kode) FROM siswa_bayar_rincian ".
											"WHERE round(DATE_FORMAT(bayar_tgl, '%Y')) = '$k'");
		$tyuk3 = mysqli_num_rows($qyuk3);
	
	
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$k.'</td>
		<td><b>'.$tyuk3.'</b> SISWA</td>';
		
	
	
		//nilainya
		$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nominal_bayar) AS totalnya ".
											"FROM siswa_bayar_rincian ".
											"WHERE round(DATE_FORMAT(bayar_tgl, '%Y')) = '$k'");
		$ryuk31 = mysqli_fetch_assoc($qyuk31);
		$yuk31_total = balikin($ryuk31['totalnya']);
	
	
		
		//jika ada
		if (!empty($tyuk3))
			{
			$yuk31_totalx = xduit3($yuk31_total);
			$tyuk3x = "<font color='green'>$tyuk3 SISWA <br>$yuk31_totalx</font>";
			}
	
		
		echo '<td align="left"><strong><font color="'.$warnatext.'">'.$yuk31_totalx.'</font></strong></td>
		</tr>';

		}
	
	
	
	echo '</tbody>	
		<tfoot>
	
		
			<tr valign="top" bgcolor="'.$warnaheader.'">
			<th><strong><font color="'.$warnatext.'">TOTAL</font></strong></th>';
			
			
		
			//nilainya
			$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_kode) FROM siswa_bayar_rincian");
			$tyuk3 = mysqli_num_rows($qyuk3);
		
			//nilainya
			$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nominal_bayar) AS totalnya ".
												"FROM siswa_bayar_rincian");
			$ryuk31 = mysqli_fetch_assoc($qyuk31);
			$yuk31_total = balikin($ryuk31['totalnya']);
		
		
			
			echo '<td align="left"><strong><font color="'.$warnatext.'">'.$tyuk3.'</font></strong> SISWA</td>
			<td align="left"><strong><font color="'.$warnatext.'">'.xduit3($yuk31_total).'</font></strong></td>
			</tr>';
	
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
echo '<form action="'.$filenya.'" method="post" name="formx">


<input name="btnEX" type="submit" value="EXPORT EXCEL >>" class="btn btn-danger">


<div class="table-responsive">          
<table class="table" border="1">
<thead>

	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="50"><strong><font color="'.$warnatext.'">TAHUN</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">SISWA</font></strong></td>
	<th><strong><font color="'.$warnatext.'">SUBTOTAL BAYAR</font></strong></th>
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




	//nilainya
	$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_kode) FROM siswa_bayar_rincian ".
										"WHERE round(DATE_FORMAT(bayar_tgl, '%Y')) = '$k'");
	$tyuk3 = mysqli_num_rows($qyuk3);


	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$k.'</td>
	<td><b>'.$tyuk3.'</b> SISWA</td>';
	


	//nilainya
	$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nominal_bayar) AS totalnya ".
										"FROM siswa_bayar_rincian ".
										"WHERE round(DATE_FORMAT(bayar_tgl, '%Y')) = '$k'");
	$ryuk31 = mysqli_fetch_assoc($qyuk31);
	$yuk31_total = balikin($ryuk31['totalnya']);


	
	//jika ada
	if (!empty($tyuk3))
		{
		$yuk31_totalx = xduit3($yuk31_total);
		$tyuk3x = "<font color='green'>$tyuk3 SISWA <br>$yuk31_totalx</font>";
		}

	
	echo '<td align="left"><strong><font color="'.$warnatext.'">'.$yuk31_totalx.'</font></strong></td>
	</tr>';
	}



echo '</tbody>	
	<tfoot>

	<tr valign="top" bgcolor="'.$warnaheader.'">
	<th><strong><font color="'.$warnatext.'">TOTAL</font></strong></th>';
	
	

	//nilainya
	$qyuk3 = mysqli_query($koneksi, "SELECT DISTINCT(siswa_kode) FROM siswa_bayar_rincian");
	$tyuk3 = mysqli_num_rows($qyuk3);

	//nilainya
	$qyuk31 = mysqli_query($koneksi, "SELECT SUM(nominal_bayar) AS totalnya ".
										"FROM siswa_bayar_rincian");
	$ryuk31 = mysqli_fetch_assoc($qyuk31);
	$yuk31_total = balikin($ryuk31['totalnya']);


	
	echo '<td align="left"><strong><font color="'.$warnatext.'">'.$tyuk3.'</font></strong> SISWA</td>
	<td align="left"><strong><font color="'.$warnatext.'">'.xduit3($yuk31_total).'</font></strong></td>
	</tr>';


	echo '</tfoot>

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