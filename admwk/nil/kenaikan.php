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


//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admwk.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admwk.html");





//nilai
$filenya = "kenaikan.php";
$judul = "KENAIKAN KELAS/LULUS";
$judulku = "[RAPORT]. $judul";
$judulx = $judul;
$tapelkd = cegah($_REQUEST['tapelkd']);
$smt = cegah($_REQUEST['smt']);
$s = cegah($_REQUEST['s']);
$kunci = cegah($_REQUEST['kunci']);
$kunci2 = balikin($_REQUEST['kunci']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}


$ke = "$filenya?tapelkd=$tapelkd&smt=$smt&kunci=$kunci&page=$page";


$limit = 10;




//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}

else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();";
	}





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$tapelkd2 = balikin($tapelkd);
	$smt = cegah($_POST['smt']);
	$e_nis = nosql($_POST['e_nis']);
	$e_status = nosql($_POST['e_status']);

	
	
	
	//pecah tapel
	$pecahku = explode("/", $tapelkd2);
	$etahun1 = balikin($pecahku[0]);
	$etahun21 = $etahun1 + 1;
	$etahun22 = $etahun1 + 2;
	$tapelbaru = cegah("$etahun21/$etahun22");
	
	
	

	
	//terpilih
	$qbtx = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
										"WHERE kode = '$e_nis' ".
										"AND tapel = '$tapelkd'");
	$rowbtx = mysqli_fetch_assoc($qbtx);
	$tbtx = mysqli_num_rows($qbtx); 
	$swnama = cegah($rowbtx['nama']);
	$swkelas = cegah($rowbtx['kelas']);
	$swkelas2 = balikin($swkelas);
	
	
	
	
	//pecah kelas
	$pecahku = explode(" ", $swkelas2);
	$ekelas1 = balikin($pecahku[0]);
	
	//jika naik kelas ///////////////////////////////////////////////
	if (($e_status == "Naik Kelas") AND (($ekelas1 == "X") OR ($ekelas1 == "XI")))
		{
		//jika X
		if ($ekelas1 == "X")
			{
			$ekelas2 = "XI";
			}
		
		//jika XI
		else if ($ekelas1 == "XI")
			{
			$ekelas2 = "XII";
			}
		}
		
	else if ($e_status == "Tinggal Kelas")
		{
		$ekelas2 = $ekelas1;
		}
	//jika naik kelas ///////////////////////////////////////////////
		

		
		
		
		
		
	//jika lulus ///////////////////////////////////////////////
	if (($e_status == "Lulus") AND ($ekelas1 == "XII"))
		{
		//jika XII
		if ($ekelas1 == "XII")
			{
			$ekelas2 = "Lulus";
			}
		}
		
	else if ($e_status == "Tidak Lulus")
		{
		$ekelas2 = $ekelas1;
		}
	//jika lulus ///////////////////////////////////////////////
				
		
		
		
		
	$tapelbaru = cegah("$etahun21/$etahun22");
	
	
	
	
	
	
	//jika ada
	if (!empty($tbtx))
		{
		//hapus dulu, sebelum entri baru
		mysqli_query($koneksi, "DELETE FROM siswa_raport_kenaikan ".
									"WHERE tapel = '$tapelkd' ".
									"AND kelas = '$swkelas' ".
									"AND siswa_kode = '$e_nis'");
		
		
			
		//query
		mysqli_query($koneksi, "INSERT INTO siswa_raport_kenaikan(kd, siswa_kode, siswa_nama, ".
									"tapel, kelas, ".
									"status, baru_tapel, baru_kelas, postdate) VALUES ".
									"('$x', '$e_nis', '$swnama', ".
									"'$tapelkd', '$swkelas', ".
									"'$e_status', '$tapelbaru', '$ekelas2', '$today')");
		//diskonek
		xfree($qbw);
		xclose($koneksi);
	
		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&smt=$smt";
		xloc($ke);
		exit();
		}
		
	else
		{
		//re-direct
		$pesan = "NIS Tersebut Tidak Ditemukan...!!";
		$ke = "$filenya?tapelkd=$tapelkd&smt=$smt";
		pekem($pesan,$ke);
		exit();
		}

	}










//nek batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$smt = cegah($_POST['smt']);
	
	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smt=$smt";
	xloc($ke);
	exit();
	}





//jika cari
if ($_POST['btnCARI'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$smt = cegah($_POST['smt']);
	$kunci = cegah($_POST['kunci']);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smt=$smt&kunci=$kunci";
	xloc($ke);
	exit();
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$smt = cegah($_POST['smt']);
	
	$jml = nosql($_POST['jml']);
	$page = nosql($_POST['page']);
	$ke = "$filenya?tapelkd=$tapelkd&smt=$smt&page=$page";

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysqli_query($koneksi, "DELETE FROM siswa_raport_kenaikan ".
						"WHERE kd = '$kd'");
		}

	//auto-kembali
	xloc($ke);
	exit();
	}








//jika export
//export
if ($_POST['btnEX'])
	{
	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');


	//nama file e...
	$i_filename = "kenaikan.xls";
	$i_judul = "kenaikan";
	



	//header file
	function HeaderingExcel($i_filename)
		{
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=$i_filename");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public");
		}

	
	
	
	//bikin...
	HeaderingExcel($i_filename);
	$workbook = new Workbook("-");
	$worksheet1 =& $workbook->add_worksheet($i_judul);
	$worksheet1->write_string(0,0,"NO.");
	$worksheet1->write_string(0,1,"TAPEL");
	$worksheet1->write_string(0,2,"KELAS");
	$worksheet1->write_string(0,3,"NIS");
	$worksheet1->write_string(0,4,"NAMA");
	$worksheet1->write_string(0,5,"STATUS");



	//data
	$qdt = mysqli_query($koneksi, "SELECT siswa_raport_kenaikan.* ".
										"FROM siswa_raport_kenaikan, m_walikelas ".
										"WHERE m_walikelas.peg_kd = '$kd3_session' ".
										"AND siswa_raport_kenaikan.tapel = m_walikelas.tapel_nama ".
										"AND siswa_raport_kenaikan.kelas = m_walikelas.kelas_nama ".
										"ORDER BY siswa_raport_kenaikan.tapel DESC, ".
										"siswa_raport_kenaikan.kelas ASC, ".
										"siswa_raport_kenaikan.siswa_nama ASC");
	$rdt = mysqli_fetch_assoc($qdt);

	do
		{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_tapel = balikin($rdt['tapel']);
		$dt_kelas = balikin($rdt['kelas']);
		$dt_nip = balikin($rdt['siswa_kode']);
		$dt_nama = balikin($rdt['siswa_nama']);
		$dt_status = balikin($rdt['status']);
		$dt_baru_tapel = balikin($rdt['baru_tapel']);
		$dt_baru_kelas = balikin($rdt['baru_kelas']);
		$dt_statusnya = "$dt_status 
$dt_baru_tapel 
$dt_baru_kelas";


		//ciptakan
		$worksheet1->write_string($dt_nox,0,$dt_nox);
		$worksheet1->write_string($dt_nox,1,$dt_tapel);
		$worksheet1->write_string($dt_nox,2,$dt_kelas);
		$worksheet1->write_string($dt_nox,3,$dt_nip);
		$worksheet1->write_string($dt_nox,4,$dt_nama);
		$worksheet1->write_string($dt_nox,5,$dt_statusnya);
		}
	while ($rdt = mysqli_fetch_assoc($qdt));


	//close
	$workbook->close();

	
	
	//re-direct
	xloc($filenya);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
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
echo '<form name="formxx3" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";

//terpilih
$qtpx = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
						"WHERE nama = '$tapelkd'");
$rowtpx = mysqli_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = cegah($rowtpx['nama']);
$tpx_thn2 = balikin($rowtpx['nama']);

echo '<option value="'.$tpx_thn1.'" selected>'.$tpx_thn2.'</option>';

$qtp = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
								"WHERE nama <> '$tapelkd' ".
								"ORDER BY nama DESC");
$rowtp = mysqli_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = cegah($rowtp['nama']);
	$tpth2 = balikin($rowtp['nama']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpth1.'">'.$tpth2.'</option>';
	}
while ($rowtp = mysqli_fetch_assoc($qtp));

echo '</select>, 



Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
echo '<option value="'.$smt.'" selected>'.$smt.'</option>
<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smt=2">2</option>
</select> 


<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="smt" type="hidden" value="'.$smt.'">
</td>
</tr>
</table>

</form>
<br>';


//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($smt))
	{
	echo '<p>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
	</p>';
	}



else
	{
	echo '<form name="formx2" method="post" action="'.$filenya.'">
	<p>
	NIS : 
	<input name="e_nis" type="text" value="'.$e_nis.'" size="5" onKeyPress="return numbersonly(this, event)" class="btn btn-warning" required>, 
	
	<select name="e_status" class="btn btn-warning" required>
	<option value="'.$e_status.'" selected>'.$e_status.'</option>
	<option value="Naik Kelas">Naik Kelas</option>
	<option value="Tinggal Kelas">Tinggal Kelas</option>
	<option value="Lulus">Lulus</option>
	<option value="Tidak Lulus">Tidak Lulus</option>

		
	<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
	<input name="smt" type="hidden" value="'.$smt.'">
	
	
	<input name="btnSMP" type="submit" value="SIMPAN >>" class="btn btn-danger">
	</form>
	<hr>';
	
	
	
	
	
	
	
	
	
	
	//jika null
	if (empty($kunci))
		{
		$sqlcount = "SELECT siswa_raport_kenaikan.* ".
						"FROM siswa_raport_kenaikan, m_walikelas ".
						"WHERE m_walikelas.peg_kd = '$kd3_session' ".
						"AND siswa_raport_kenaikan.tapel = m_walikelas.tapel_nama ".
						"AND siswa_raport_kenaikan.kelas = m_walikelas.kelas_nama ".
						"ORDER BY siswa_raport_kenaikan.tapel DESC, ".
						"siswa_raport_kenaikan.kelas ASC, ".
						"siswa_raport_kenaikan.siswa_nama ASC";
		}
		
	else
		{
		$sqlcount = "SELECT siswa_raport_kenaikan.* ".
						"FROM siswa_raport_kenaikan, m_walikelas ".
						"WHERE m_walikelas.peg_kd = '$kd3_session' ".
						"AND siswa_raport_kenaikan.tapel = m_walikelas.tapel_nama ".
						"AND siswa_raport_kenaikan.kelas = m_walikelas.kelas_nama ".
						"AND (siswa_kode LIKE '%$kunci%' ".
						"OR siswa_nama LIKE '%$kunci%' ".
						"OR status LIKE '%$kunci%' ".
						"OR tapel LIKE '%$kunci%' ".
						"OR kelas LIKE '%$kunci%' ".
						"OR baru_tapel LIKE '%$kunci%' ".
						"OR baru_kelas LIKE '%$kunci%') ".
						"ORDER BY siswa_raport_kenaikan.tapel DESC, ".
						"siswa_raport_kenaikan.kelas ASC, ".
						"siswa_raport_kenaikan.siswa_nama ASC";
		}
		
		
	
	//query
	$p = new Pager();
	$start = $p->findStart($limit);
	
	$sqlresult = $sqlcount;
	
	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?tapelkd=$tapelkd&smt=$smt&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);
	
	
	
	echo '<form action="'.$filenya.'" method="post" name="formxx">
	<p>
	<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
	<input name="smt" type="hidden" value="'.$smt.'">
	
	<input name="btnEX" type="submit" value="EXPORT" class="btn btn-success">
	</p>
	<br>
	
	</form>



	<form action="'.$filenya.'" method="post" name="formx">
	<p>
	<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
	<input name="smt" type="hidden" value="'.$smt.'">

	<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
	<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
	<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
	</p>
		
	
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
	
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="20">&nbsp;</td>
	<td width="100"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
	<td width="200"><strong><font color="'.$warnatext.'">STATUS</font></strong></td>
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
			$i_kode = balikin($data['siswa_kode']);
			$i_nama = balikin($data['siswa_nama']);
			$i_baru_tapel = balikin($data['baru_tapel']);
			$i_baru_kelas = balikin($data['baru_kelas']);
			$i_status = balikin($data['status']);


	
	
			
				
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
	        </td>
			<td>'.$i_tapel.'</td>
			<td>'.$i_kelas.'</td>
			<td>'.$i_kode.'</td>
			<td>'.$i_nama.'</td>
			<td>
			'.$i_status.'
			<br>
			'.$i_baru_tapel.'
			<br>
			'.$i_baru_kelas.'
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
	
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')" class="btn btn-primary">
	<input name="btnBTL" type="reset" value="BATAL" class="btn btn-warning">
	<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-danger">
	</td>
	</tr>
	</table>
	</form>';
	
	}

echo '<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>