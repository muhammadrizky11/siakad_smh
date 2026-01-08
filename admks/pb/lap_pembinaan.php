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
$filenya = "lap_pembinaan.php";
$judul = "[PEMBINAAN]. Lap. Per Pembinaan";
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
	$fileku = "lap_pembinaan.xls";



	
	//isi *START
	ob_start();
	

	echo '<div class="table-responsive">
	<h3>LAPORAN PER PEMBINAAN</h3>
	                   
	<table class="table" border="1">
	<thead>

		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="10"><strong><font color="'.$warnatext.'">NO.</font></strong></th>
		<td><strong><font color="'.$warnatext.'">NAMA PEMBINAAN</font></strong></th>
		<td width="50"><strong><font color="'.$warnatext.'">JUMLAH PEMBINAAN</font></strong></td>
		</tr>
	
	</thead>
	<tbody>';
	
	
	//list 
	$qku = mysqli_query($koneksi, "SELECT * FROM m_pembinaan ".
									"ORDER BY nama ASC");
	$rku = mysqli_fetch_assoc($qku);
	
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
	
	
		//nilai
		$ku_no = $ku_no + 1;
		$ku_kd = balikin($rku['kd']);
		$ku_pno = balikin($rku['no']);
		$ku_pnama = balikin($rku['nama']);
	
	
	
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$ku_no.'.</td>
		<td>'.$ku_pnama.'</td>';
		
		//jumlahnya 
		$qku2 = mysqli_query($koneksi, "SELECT bina_kd FROM siswa_pelanggaran ".
										"WHERE bina_kd = '$ku_kd'");
		$rku2 = mysqli_fetch_assoc($qku2);
		$tku2 = mysqli_num_rows($qku2);
		
	
			
		echo '<td align="left"><strong><font color="'.$warnatext.'">'.$tku2.'</font></strong></td>
		</tr>';
		}
	while ($rku = mysqli_fetch_assoc($qku));
	
	
	
	
	//jumlahnya 
	$qku2 = mysqli_query($koneksi, "SELECT bina_kd FROM siswa_pelanggaran ".
										"WHERE bina_kd IS NOT NULL");
	$rku2 = mysqli_fetch_assoc($qku2);
	$tku2 = mysqli_num_rows($qku2);
	
	
	echo '</tbody>	
		<tfoot>
	
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<th><strong><font color="'.$warnatext.'"></font></strong></th>
		<td align="right"><strong><font color="'.$warnatext.'">TOTAL PEMBINAAN</font></strong></td>
		<th><strong><font color="'.$warnatext.'">'.$tku2.'</font></strong></th>
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
	<td width="10"><strong><font color="'.$warnatext.'">NO.</font></strong></th>
	<td><strong><font color="'.$warnatext.'">NAMA PEMBINAAN</font></strong></th>
	<td width="50"><strong><font color="'.$warnatext.'">JUMLAH PEMBINAAN</font></strong></td>
	</tr>

</thead>
<tbody>';


//list 
$qku = mysqli_query($koneksi, "SELECT * FROM m_pembinaan ".
								"ORDER BY nama ASC");
$rku = mysqli_fetch_assoc($qku);

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


	//nilai
	$ku_no = $ku_no + 1;
	$ku_kd = balikin($rku['kd']);
	$ku_pno = balikin($rku['no']);
	$ku_pnama = balikin($rku['nama']);



	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$ku_no.'.</td>
	<td>'.$ku_pnama.'</td>';
	
	//jumlahnya 
	$qku2 = mysqli_query($koneksi, "SELECT bina_kd FROM siswa_pelanggaran ".
									"WHERE bina_kd = '$ku_kd'");
	$rku2 = mysqli_fetch_assoc($qku2);
	$tku2 = mysqli_num_rows($qku2);
	

		
	echo '<td align="left"><strong><font color="'.$warnatext.'">'.$tku2.'</font></strong></td>
	</tr>';
	}
while ($rku = mysqli_fetch_assoc($qku));




//jumlahnya 
$qku2 = mysqli_query($koneksi, "SELECT bina_kd FROM siswa_pelanggaran ".
									"WHERE bina_kd IS NOT NULL");
$rku2 = mysqli_fetch_assoc($qku2);
$tku2 = mysqli_num_rows($qku2);


echo '</tbody>	
	<tfoot>

	<tr valign="top" bgcolor="'.$warnaheader.'">
	<th><strong><font color="'.$warnatext.'"></font></strong></th>
	<td align="right"><strong><font color="'.$warnatext.'">TOTAL PEMBINAAN</font></strong></td>
	<th><strong><font color="'.$warnatext.'">'.$tku2.'</font></strong></th>
	</tr>
	
	</tfoot>

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