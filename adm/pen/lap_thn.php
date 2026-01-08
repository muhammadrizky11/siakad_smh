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
require("../../inc/cek/adm.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/adm.html");





//nilai
$filenya = "lap_thn.php";
$judul = "Lap. Akhir Tahun";
$judulku = "[PENILAIAN MAPEL]. $judul";
$judulx = $judul;
$tapelkd = cegah($_REQUEST['tapelkd']);
$kelkd = cegah($_REQUEST['kelkd']);
$s = cegah($_REQUEST['s']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&page=$page";






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
//jika export
//export
if ($_POST['btnEX'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$blnku = cegah($_POST['blnku']);
	$etahunku = cegah($_POST['etahunku']);
	$page = nosql($_POST['page']);
	
	$blnya = $arrbln[$blnku];

	$fileku = "lap_akhir_tahun-nilai-mapel.xls";





	//query
	$limit = 1000;
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM m_siswa ".
					"WHERE tapel = '$tapelkd' ".
					"AND kelas = '$kelkd' ".
					"ORDER BY round(nourut) ASC";
	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);





	
	//isi *START
	ob_start();
	

	

	echo '<div class="table-responsive">
	<h3>LAP.AKHIR TAHUN NILAI MATA PELAJARAN</h3>

	Tahun Pelajaran : ';
	
	//terpilih
	$qtpx = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
							"WHERE nama = '$tapelkd'");
	$rowtpx = mysqli_fetch_assoc($qtpx);
	$tpx_kd = nosql($rowtpx['kd']);
	$tpx_thn1 = cegah($rowtpx['nama']);
	$tpx_thn2 = balikin($rowtpx['nama']);

	echo '<b>'.$tpx_thn2.'</b>, 
	

	Kelas : ';
	
	//terpilih
	$qbtx = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
										"WHERE nama = '$kelkd'");
	$rowbtx = mysqli_fetch_assoc($qbtx);
	$btxkd = nosql($rowbtx['kd']);
	$btxkelas1 = cegah($rowbtx['nama']);
	$btxkelas2 = balikin($rowbtx['nama']);

	echo '<b>'.$btxkelas2.'</b>
	<br>
	
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
	
		<tr valign="top" bgcolor="'.$warnaheader.'">
			<td rowspan="2" width="5">
				<p align="center"><b>NO.</b></p>
			</td>
			<td rowspan="2" width="50">
				<p align="center"><b>NIS</b></p>
			</td>
			<td rowspan="2" width="200">
				<p align="center"><b>NAMA</b></p>
			</td>';

			
		
			
			//data
			$qdt = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
												"WHERE tapel = '$tapelkd' ".
												"AND kelas = '$kelkd' ".
												"ORDER BY round(no) ASC");
			$rdt = mysqli_fetch_assoc($qdt);
		
			do
				{
				//nilai
				$dt_nox = $dt_nox + 1;
				$dt_tapel = balikin($rdt['tapel']);
				$dt_kelas = balikin($rdt['kelas']);
				$dt_jenis = balikin($rdt['jenis']);
				$dt_mapel = balikin($rdt['nama']);
				$dt_singkatan = balikin($rdt['kode']);
				$dt_kkm = balikin($rdt['kkm']);
				$dt_nourut = balikin($rdt['no']);
		
		
				echo '<td colspan="2">
					<p align="center"><b>'.$dt_nourut.'. '.$dt_singkatan.'</b></p>
				</td>';
				}
			while ($rdt = mysqli_fetch_assoc($qdt));
		
						

		echo '</tr>

		<tr valign="top" bgcolor="'.$warnaheader.'">';

			//data
			$qdt = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
												"WHERE tapel = '$tapelkd' ".
												"AND kelas = '$kelkd' ".
												"ORDER BY round(no) ASC");
			$rdt = mysqli_fetch_assoc($qdt);
		
			do
				{
				//nilai
				$dt_nox = $dt_nox + 1;
				$dt_tapel = balikin($rdt['tapel']);
				$dt_kelas = balikin($rdt['kelas']);
				$dt_jenis = balikin($rdt['jenis']);
				$dt_mapel = balikin($rdt['nama']);
				$dt_singkatan = balikin($rdt['kode']);
				$dt_kkm = balikin($rdt['kkm']);
				$dt_nourut = balikin($rdt['no']);
		
		
				echo '<td>
				<p align="center"><b>P</b></p>
				</td>
				<td>
				<p align="center"><b>K</b></p>
				</td>';
				}
			while ($rdt = mysqli_fetch_assoc($qdt));
		
		echo '</tr>

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
			$i_nis = nosql($data['kode']);
			$i_nis2 = cegah($data['kode']);
			$i_abs = nosql($data['nourut']);
			$i_nama = balikin2($data['nama']);
			$i_nama2 = cegah($data['nama']);
	
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
					'.$i_abs.'.
				</td>
				<td>
					'.$i_nis.'
				</td>
				<td align="left">
					'.$i_nama.'
				</td>';



			//data
			$qdt = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
												"WHERE tapel = '$tapelkd' ".
												"AND kelas = '$kelkd' ".
												"ORDER BY round(no) ASC");
			$rdt = mysqli_fetch_assoc($qdt);
		
			do
				{
				//nilai
				$dt_nox = $dt_nox + 1;
				$dt_tapel = balikin($rdt['tapel']);
				$dt_kelas = balikin($rdt['kelas']);
				$dt_jenis = balikin($rdt['jenis']);
				$dt_mapel = balikin($rdt['nama']);
				$dt_singkatan = balikin($rdt['kode']);
				$dt_kkm = balikin($rdt['kkm']);
				$dt_nourut = balikin($rdt['no']);

	
				//nil.p
				$qku = mysqli_query($koneksi, "SELECT p_na FROM siswa_nilai_thn ".
													"WHERE tapel = '$tapelkd' ".
													"AND kelas = '$kelkd' ".
													"AND siswa_kode = '$i_nis' ".
													"AND mapel_kode = '$dt_singkatan' ".
													"AND p_na <> '0'");
				$rku = mysqli_fetch_assoc($qku);
				$i_nilai_p = round(balikin($rku['p_na']));
				
		
				//nil.k
				$qku = mysqli_query($koneksi, "SELECT k_na FROM siswa_nilai_thn ".
													"WHERE tapel = '$tapelkd' ".
													"AND kelas = '$kelkd' ".
													"AND siswa_kode = '$i_nis' ".
													"AND mapel_kode = '$dt_singkatan' ".
													"AND k_na <> '0'");
				$rku = mysqli_fetch_assoc($qku);
				$i_nilai_k = round(balikin($rku['k_na']));
		
				echo '<td>
				<p align="center"><b>'.$i_nilai_p.'</b></p>
				</td>
				<td>
				<p align="center"><b>'.$i_nilai_k.'</b></p>
				</td>';
				}
			while ($rdt = mysqli_fetch_assoc($qdt));


				
			echo '</tr>';
			}
		while ($data = mysqli_fetch_assoc($result));
	


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
echo '<form name="formxx" method="post" action="'.$filenya.'">
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

Kelas : ';
echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";

//terpilih
$qbtx = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
									"WHERE nama = '$kelkd'");
$rowbtx = mysqli_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkelas1 = cegah($rowbtx['nama']);
$btxkelas2 = balikin($rowbtx['nama']);

echo '<option value="'.$btxkelas1.'">'.$btxkelas2.'</option>';

$qbt = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
								"WHERE nama <> '$kelkd' ".
								"ORDER BY round(no) ASC");
$rowbt = mysqli_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas1 = cegah($rowbt['nama']);
	$btkelas2 = balikin($rowbt['nama']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$btkelas1.'">'.$btkelas2.'</option>';
	}
while ($rowbt = mysqli_fetch_assoc($qbt));

echo '</select> 



<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
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

else if (empty($kelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>
	</p>';
	}



else
	{
	echo '<form name="formx" method="post" action="'.$filenya.'">
	
	<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
	<input name="kelkd" type="hidden" value="'.$kelkd.'">

	<input name="btnEX" type="submit" value="EXPORT" class="btn btn-success">
	<hr>';
	
	
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM m_siswa ".
					"WHERE tapel = '$tapelkd' ".
					"AND kelas = '$kelkd' ".
					"ORDER BY round(nourut) ASC";
	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?tapelkd=$tapelkd&smt=$smt&kelkd=$kelkd&blnku=$blnku";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);



	


	//nilai
	$qku = mysqli_query($koneksi, "SELECT * FROM siswa_nilai_thn ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd'");
	$rku = mysqli_fetch_assoc($qku);
	$i_postdate = balikin($rku['postdate']);




	//nek ada
	if ($count != 0)
		{
		echo '<p>
		Update Terakhir : <font color="red"><b>'.$i_postdate.'</b></font>
		</p>
		
		<div class="table-responsive">          
		<table class="table" border="1">
		<thead>
			<tr valign="top" bgcolor="'.$warnaheader.'">
				<td rowspan="2" width="5">
					<p align="center"><b>NO.</b></p>
				</td>
				<td rowspan="2" width="50">
					<p align="center"><b>NIS</b></p>
				</td>
				<td rowspan="2" width="200">
					<p align="center"><b>NAMA</b></p>
				</td>';

				
				
				//data
				$qdt = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
													"WHERE tapel = '$tapelkd' ".
													"AND kelas = '$kelkd' ".
													"ORDER BY round(no) ASC");
				$rdt = mysqli_fetch_assoc($qdt);
			
				do
					{
					//nilai
					$dt_nox = $dt_nox + 1;
					$dt_tapel = balikin($rdt['tapel']);
					$dt_kelas = balikin($rdt['kelas']);
					$dt_jenis = balikin($rdt['jenis']);
					$dt_mapel = balikin($rdt['nama']);
					$dt_singkatan = balikin($rdt['kode']);
					$dt_kkm = balikin($rdt['kkm']);
					$dt_nourut = balikin($rdt['no']);
			
			
					echo '<td colspan="2">
						<p align="center"><b>'.$dt_nourut.'. '.$dt_singkatan.'</b></p>
					</td>';
					}
				while ($rdt = mysqli_fetch_assoc($qdt));
			
							
	
			echo '</tr>

			<tr valign="top" bgcolor="'.$warnaheader.'">';

				//data
				$qdt = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
													"WHERE tapel = '$tapelkd' ".
													"AND kelas = '$kelkd' ".
													"ORDER BY round(no) ASC");
				$rdt = mysqli_fetch_assoc($qdt);
			
				do
					{
					//nilai
					$dt_nox = $dt_nox + 1;
					$dt_tapel = balikin($rdt['tapel']);
					$dt_kelas = balikin($rdt['kelas']);
					$dt_jenis = balikin($rdt['jenis']);
					$dt_mapel = balikin($rdt['nama']);
					$dt_singkatan = balikin($rdt['kode']);
					$dt_kkm = balikin($rdt['kkm']);
					$dt_nourut = balikin($rdt['no']);
			
			
					echo '<td>
					<p align="center"><b>P</b></p>
					</td>
					<td>
					<p align="center"><b>K</b></p>
					</td>';
					}
				while ($rdt = mysqli_fetch_assoc($qdt));
			
			echo '</tr>
						
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
				$i_nis = nosql($data['kode']);
				$i_nis2 = cegah($data['kode']);
				$i_abs = nosql($data['nourut']);
				$i_nama = balikin2($data['nama']);
				$i_nama2 = cegah($data['nama']);
	
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
						'.$i_abs.'.
					</td>
					<td>
						'.$i_nis.'
					</td>
					<td>
						'.$i_nama.'
					</td>';


					//data
					$qdt = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
														"WHERE tapel = '$tapelkd' ".
														"AND kelas = '$kelkd' ".
														"ORDER BY round(no) ASC");
					$rdt = mysqli_fetch_assoc($qdt);
				
					do
						{
						//nilai
						$dt_nox = $dt_nox + 1;
						$dt_tapel = balikin($rdt['tapel']);
						$dt_kelas = balikin($rdt['kelas']);
						$dt_jenis = balikin($rdt['jenis']);
						$dt_mapel = balikin($rdt['nama']);
						$dt_singkatan = balikin($rdt['kode']);
						$dt_kkm = balikin($rdt['kkm']);
						$dt_nourut = balikin($rdt['no']);

			
						//nil.p
						$qku = mysqli_query($koneksi, "SELECT p_na FROM siswa_nilai_thn ".
															"WHERE tapel = '$tapelkd' ".
															"AND kelas = '$kelkd' ".
															"AND siswa_kode = '$i_nis' ".
															"AND mapel_kode = '$dt_singkatan' ".
															"AND p_na <> '0'");
						$rku = mysqli_fetch_assoc($qku);
						$i_nilai_p = round(balikin($rku['p_na']));
						
				
						//nil.k
						$qku = mysqli_query($koneksi, "SELECT k_na FROM siswa_nilai_thn ".
															"WHERE tapel = '$tapelkd' ".
															"AND kelas = '$kelkd' ".
															"AND siswa_kode = '$i_nis' ".
															"AND mapel_kode = '$dt_singkatan' ".
															"AND k_na <> '0'");
						$rku = mysqli_fetch_assoc($qku);
						$i_nilai_k = round(balikin($rku['k_na']));
				
						echo '<td>
						<p align="center"><b>'.$i_nilai_p.'</b></p>
						</td>
						<td>
						<p align="center"><b>'.$i_nilai_k.'</b></p>
						</td>';
						}
					while ($rdt = mysqli_fetch_assoc($qdt));
	
	
						
					echo '</tr>';
					}
				while ($data = mysqli_fetch_assoc($result));
			
			
			echo '</tbody>
		</table>
		</div>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
		<br>
		<br>
	
		<input name="jml" type="hidden" value="'.$count.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="page" type="hidden" value="'.$page.'">
		</td>
		</tr>
		</table>
		</form>';
		}

	else
		{
		echo '<p>
		<font color="red"><strong>TIDAK ADA DATA.</strong></font>
		</p>';
		}
	}

echo '</form>
<br>
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