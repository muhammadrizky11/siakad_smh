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
$filenya = "lap_mapel.php";
$judul = "[JADWAL]. Lap. Per Mapel";
$judulku = $judul;
$judulx = $judul;

$s = nosql($_REQUEST['s']);
$m = nosql($_REQUEST['m']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
$ke = $filenya;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//PROSES ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$kunci = cegah($_POST['kunci']);


	//cek
	if (empty($kunci))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?kunci=$kunci";
		xloc($ke);
		exit();
		}
	}



//batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}








//nek excel
if ($_POST['btnEX'])
	{
	//nilai
	$fileku = "lap_mapel.xls";



	
	//isi *START
	ob_start();
	

	echo '<div class="table-responsive">
	<h3>LAPORAN PER MAPEL</h3>
	                   
	<table class="table" border="1">
	<thead>
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="100"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">JENIS</font></strong></td>
		<td width="5"><strong><font color="'.$warnatext.'">NOURUT</font></strong></td>
		<td><strong><font color="'.$warnatext.'">NAMA MAPEL</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">SINGKATAN</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">KKM</font></strong></td>
		<td width="150" align="center"><strong><font color="'.$warnatext.'">JP</font></strong></td>
	
	</thead>
	<tbody>';
	
	
	//list 
	$qku = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
									"ORDER BY tapel ASC, ".
									"kelas ASC, ".
									"jenis ASC, ".
									"round(no) ASC");
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
		$i_kd = nosql($rku['kd']);
		$i_tapel = balikin($rku['tapel']);
		$i_tapel2 = cegah($i_tapel);
		$i_kelas = balikin($rku['kelas']);
		$i_kelas2 = cegah($i_kelas);
		$i_jenis = balikin($rku['jenis']);
		$i_mapel = balikin($rku['nama']);
		$i_kkm = balikin($rku['kkm']);
		$i_singkatan = balikin($rku['kode']);
		$i_nourut = balikin($rku['no']);
		$i_postdate = balikin($rku['postdate']);
		
		
		
		//ketahui jumlah pertemuan
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM jadwal ".
										"WHERE tapel = '$i_tapel2' ".
										"AND kelas = '$i_kelas2' ".
										"AND mapel_kode = '$i_singkatan' ".
										"AND smt = '1'");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$jp_smt1 = mysqli_num_rows($qyuk);
			
		
		//ketahui jumlah pertemuan
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM jadwal ".
										"WHERE tapel = '$i_tapel2' ".
										"AND kelas = '$i_kelas2' ".
										"AND mapel_kode = '$i_singkatan' ".
										"AND smt = '2'");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$jp_smt2 = mysqli_num_rows($qyuk);
		
	
	
	
					
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_tapel.'</td>
		<td>'.$i_kelas.'</td>
		<td>'.$i_jenis.'</td>
		<td>'.$i_nourut.'</td>
		<td>'.$i_mapel.'</td>
		<td>'.$i_singkatan.'</td>
		<td>'.$i_kkm.'</td>
		<td align="center">
		SMT 1 : <b>'.$jp_smt1.'</b> JAM
		<br>
		SMT 2 : <b>'.$jp_smt2.'</b> JAM
		</td>
        </tr>';

		}
	while ($rku = mysqli_fetch_assoc($qku));
	
	
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
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();




//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/js/swap.js");




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
//jika null
if (empty($kunci))
	{
	$sqlcount = "SELECT * FROM m_mapel ".
					"ORDER BY tapel ASC, ".
					"kelas ASC, ".
					"jenis ASC, ".
					"round(no) ASC";
	}
	
else
	{
	$sqlcount = "SELECT * FROM m_mapel ".
					"WHERE tapel LIKE '%$kunci%' ".
					"OR kelas LIKE '%$kunci%' ".
					"OR jenis LIKE '%$kunci%' ".
					"OR nama LIKE '%$kunci%' ".
					"OR kode LIKE '%$kunci%' ".
					"OR kkm LIKE '%$kunci%' ".
					"ORDER BY tapel ASC, ".
					"kelas ASC, ".
					"jenis ASC, ".
					"round(no) ASC";
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



echo '<form action="'.$filenya.'" method="post" name="formxx">
<p>
<input name="btnEX" type="submit" value="EXPORT" class="btn btn-success">
</p>

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
<td width="100"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">JENIS</font></strong></td>
<td width="5"><strong><font color="'.$warnatext.'">NOURUT</font></strong></td>
<td><strong><font color="'.$warnatext.'">NAMA MAPEL</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">SINGKATAN</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">KKM</font></strong></td>
<td width="150" align="center"><strong><font color="'.$warnatext.'">JP</font></strong></td>

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
		$i_tapel2 = cegah($i_tapel);
		$i_kelas = balikin($data['kelas']);
		$i_kelas2 = cegah($i_kelas);
		$i_jenis = balikin($data['jenis']);
		$i_mapel = balikin($data['nama']);
		$i_kkm = balikin($data['kkm']);
		$i_singkatan = balikin($data['kode']);
		$i_nourut = balikin($data['no']);
		$i_postdate = balikin($data['postdate']);
		
		
		
		//ketahui jumlah pertemuan
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM jadwal ".
										"WHERE tapel = '$i_tapel2' ".
										"AND kelas = '$i_kelas2' ".
										"AND mapel_kode = '$i_singkatan' ".
										"AND smt = '1'");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$jp_smt1 = mysqli_num_rows($qyuk);
			
		
		//ketahui jumlah pertemuan
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM jadwal ".
										"WHERE tapel = '$i_tapel2' ".
										"AND kelas = '$i_kelas2' ".
										"AND mapel_kode = '$i_singkatan' ".
										"AND smt = '2'");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$jp_smt2 = mysqli_num_rows($qyuk);
		
		
					
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_tapel.'</td>
		<td>'.$i_kelas.'</td>
		<td>'.$i_jenis.'</td>
		<td>'.$i_nourut.'</td>
		<td>'.$i_mapel.'</td>
		<td>'.$i_singkatan.'</td>
		<td>'.$i_kkm.'</td>
		<td align="center">
		SMT 1 : <b>'.$jp_smt1.'</b> JAM
		<br>
		SMT 2 : <b>'.$jp_smt2.'</b> JAM
		</td>
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


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>