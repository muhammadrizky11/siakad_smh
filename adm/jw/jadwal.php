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
$filenya = "jadwal.php";
$judul = "Set Jadwal";
$judulku = "[JADWAL]. $judul";
$judulx = $judul;
$tapelkd = cegah($_REQUEST['tapelkd']);
$smt = cegah($_REQUEST['smt']);
$s = cegah($_REQUEST['s']);


$ke = "$filenya?tapelkd=$tapelkd&smt=$smt";

$limit = 1000;




//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}

else if (empty($smt))
	{
	$diload = "document.formx.smt.focus();";
	}





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$smt = cegah($_POST['smt']);



	//hapus dulu, sebelum insert
	mysqli_query($koneksi, "DELETE FROM jadwal ".
								"WHERE tapel = '$tapelkd' ".
								"AND smt = '$smt'");	
	

	

	//loop 
	$qjuk2 = mysqli_query($koneksi, "SELECT * FROM m_waktu_jadwal ".
										"ORDER BY round(hari_no) ASC, ".
										"round(nourut) ASC, ".
										"waktu ASC");
	$rjuk2 = mysqli_fetch_assoc($qjuk2);
	
	do
		{
		//nilai
		$juk2_hari_no = cegah($rjuk2['hari_no']);
		$juk2_hari_nama = cegah($rjuk2['hari_nama']);
		$juk2_jam = cegah($rjuk2['jam_ke']);
		$juk2_waktu = cegah($rjuk2['waktu']);
	
		
		//loop kelas
		$qjuk = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
											"ORDER BY round(no) ASC, ".
											"nama ASC");
		$rjuk = mysqli_fetch_assoc($qjuk);
		
		do
			{
			//nilai
			$juk_kd = cegah($rjuk['kd']);
			$juk_nama = cegah($rjuk['nama']);
			$juk_namax = md5($juk_nama);
				
			$abs = "nil";
			$abs1 = "$abs$juk2_hari_nama$juk2_jam$juk_namax";
			$pnilai = cegah($_POST["$abs1"]);
			
			$xyz = md5($abs1);



			//ketahui nama mapelnya
			$qcek = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
												"WHERE kode = '$pnilai'");
			$rcek = mysqli_fetch_assoc($qcek);
			$pnama = cegah($rcek['nama']);	



			
			//insert
			mysqli_query($koneksi, "INSERT INTO jadwal(kd, tapel, smt, ".
										"kelas, hari, hari_no, ".
										"jam_ke, waktu, mapel_kode, ".
										"mapel_nama, postdate) VALUES ".
										"('$xyz', '$tapelkd', '$smt', ".
										"'$juk_nama', '$juk2_hari_nama', '$juk2_hari_no', ".
										"'$juk2_jam', '$juk2_waktu', '$pnilai', ".
										"'$pnama', '$today')");
			}
		while ($rjuk = mysqli_fetch_assoc($qjuk));
		}
	while ($rjuk2 = mysqli_fetch_assoc($qjuk2));


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smt=$smt";
	xloc($ke);
	exit();
	}











//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$smt = cegah($_POST['smt']);


	//hapus 
	mysqli_query($koneksi, "DELETE FROM jadwal ".
								"WHERE tapel = '$tapelkd' ".
								"AND smt = '$smt'");	


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smt=$smt";
	xloc($ke);
	exit();
	}
	
	
	
	
	

//jika export
//export
if ($_POST['btnEX'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$tapelkd2 = balikin($tapelkd);
	$smt = cegah($_POST['smt']);



	$fileku = "jadwal-$tapelkd2-$smt.xls";





	
	//isi *START
	ob_start();
	

	

	echo '<div class="table-responsive">
	<h3>JADWAL PELAJARAN</h3>

	Tahun Pelajaran : ';
	
	//terpilih
	$qtpx = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
							"WHERE nama = '$tapelkd'");
	$rowtpx = mysqli_fetch_assoc($qtpx);
	$tpx_kd = nosql($rowtpx['kd']);
	$tpx_thn1 = cegah($rowtpx['nama']);
	$tpx_thn2 = balikin($rowtpx['nama']);

	echo '<b>'.$tpx_thn2.'</b>, 
	
	Semester : <b>'.$smt.'</b>

	
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
		<tr valign="top" bgcolor="'.$warnaheader.'">
			<td width="5" align="center"><b>NO.</b></td>
			<td width="50" align="center"><b>HARI</b></td>
			<td width="50" align="center"><b>JAM</b></td>
			<td width="120" align="center"><b>WAKTU</b></td>';
			
			//loop kelas
			$qjuk = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
												"ORDER BY round(no) ASC, ".
												"nama ASC");
			$rjuk = mysqli_fetch_assoc($qjuk);
			
			do
				{
				//nilai
				$juk_nama = balikin($rjuk['nama']);
				
				
				echo '<td align="center"><b>'.$juk_nama.'</b>';
				}
			while ($rjuk = mysqli_fetch_assoc($qjuk));
			
			
			
			
		echo '</tr>

	</thead>
	<tbody>';

			
		//query
		$p = new Pager();
		$start = $p->findStart($limit);
	
		$sqlcount = "SELECT * FROM m_waktu_jadwal ".
						"ORDER BY round(hari_no) ASC, ".
						"round(nourut) ASC, ".
						"waktu ASC";
		$sqlresult = $sqlcount;
	
		$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
	
		
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
			$i_hari_no = balikin($data['hari_no']);
			$i_hari = balikin($data['hari_nama']);
			$i_jam = balikin($data['jam_ke']);
			$i_waktu = balikin($data['waktu']);
			$i_ket = balikin($data['ket']);


			//jika istirahat
			if ($i_ket == "ISTIRAHAT")
				{
				$warna = "yellow";
				
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>'.$nomer.'.</td>
				<td>'.$i_hari.'</td>
				<td>'.$i_jam.'</td>
				<td align="right">'.$i_waktu.'</td>';
				
				//kelas
				$qjuk = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
													"ORDER BY round(no) ASC, ".
													"nama ASC");
				$rjuk = mysqli_fetch_assoc($qjuk);
				$tjuk = mysqli_num_rows($qjuk);

				echo '<td align="center" colspan="'.$tjuk.'"><font color="red"><b>'.$i_ket.'</b></font></td>
				</tr>';
				}
				
			else
				{
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>'.$nomer.'.</td>
				<td>'.$i_hari.'</td>
				<td>'.$i_jam.'</td>
				<td align="right">'.$i_waktu.'</td>';
				
				//loop kelas
				$qjuk = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
													"ORDER BY round(no) ASC, ".
													"nama ASC");
				$rjuk = mysqli_fetch_assoc($qjuk);
				
				do
					{
					//nilai
					$juk_kd = cegah($rjuk['kd']);
					$juk_nama = cegah($rjuk['nama']);
					$juk_namax = md5($juk_nama);
					
					//nilainya
					$qok = mysqli_query($koneksi, "SELECT * FROM jadwal ".
													"WHERE tapel = '$tapelkd' ".
													"AND smt = '$smt' ".
													"AND hari_no = '$i_hari_no' ".
													"AND jam_ke = '$i_jam' ".
													"AND kelas = '$juk_nama'");
					$rok = mysqli_fetch_assoc($qok);
					$ok_mapel_kode = balikin($rok['mapel_kode']);
					
					
					
					
					echo '<td align="center">'.$ok_mapel_kode.'</td>';
					}
				while ($rjuk = mysqli_fetch_assoc($qjuk));
				
				echo '</tr>';
				}


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



Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
echo '<option value="'.$smt.'" selected>'.$smt.'</option>
<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smt=1">1</option>
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
	echo '<form name="formx" method="post" action="'.$filenya.'">
	
	<div class="card card-primary card-tabs">
      <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">ENTRI JADWAL</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">DAFTAR KODE MAPEL</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
          <div class="tab-pane show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
			
			
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="smt" type="hidden" value="'.$smt.'">
			<input name="btnEX" type="submit" value="CETAK EXCEL >>" class="btn btn-success">
			<hr>';
			
			
			//query
			$p = new Pager();
			$start = $p->findStart($limit);
		
			$sqlcount = "SELECT * FROM m_waktu_jadwal ".
							"ORDER BY round(hari_no) ASC, ".
							"round(nourut) ASC, ".
							"waktu ASC";
			$sqlresult = $sqlcount;
		
			$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
		
		
		
			//nilai
			$qku = mysqli_query($koneksi, "SELECT postdate FROM jadwal ".
												"WHERE tapel = '$tapelkd' ".
												"AND smt = '$smt' ".
												"ORDER BY postdate DESC");
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
						<td width="5" align="center"><b>NO.</b></td>
						<td width="50" align="center"><b>HARI</b></td>
						<td width="50" align="center"><b>JAM</b></td>
						<td width="120" align="center"><b>WAKTU</b></td>';
						
						//loop kelas
						$qjuk = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
															"ORDER BY round(no) ASC, ".
															"nama ASC");
						$rjuk = mysqli_fetch_assoc($qjuk);
						
						do
							{
							//nilai
							$juk_nama = balikin($rjuk['nama']);
							
							
							echo '<td align="center"><b>'.$juk_nama.'</b>';
							}
						while ($rjuk = mysqli_fetch_assoc($qjuk));
						
						
						
						
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
						$i_hari_no = balikin($data['hari_no']);
						$i_hari = balikin($data['hari_nama']);
						$i_jam = balikin($data['jam_ke']);
						$i_waktu = balikin($data['waktu']);
						$i_ket = balikin($data['ket']);
		
			
						//jika istirahat
						if ($i_ket == "ISTIRAHAT")
							{
							$warna = "yellow";
							
							echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
							echo '<td>'.$nomer.'.</td>
							<td>'.$i_hari.'</td>
							<td>'.$i_jam.'</td>
							<td align="right">'.$i_waktu.'</td>';
							
							//kelas
							$qjuk = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
																"ORDER BY round(no) ASC, ".
																"nama ASC");
							$rjuk = mysqli_fetch_assoc($qjuk);
							$tjuk = mysqli_num_rows($qjuk);
		
							echo '<td align="center" colspan="'.$tjuk.'"><font color="red"><b>'.$i_ket.'</b></font></td>';
		
							
							echo '</tr>';
							
							}
							
						else
							{
							echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
							echo '<td>'.$nomer.'.</td>
							<td>'.$i_hari.'</td>
							<td>'.$i_jam.'</td>
							<td align="right">'.$i_waktu.'</td>';
							
							//loop kelas
							$qjuk = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
																"ORDER BY round(no) ASC, ".
																"nama ASC");
							$rjuk = mysqli_fetch_assoc($qjuk);
							
							do
								{
								//nilai
								$juk_kd = cegah($rjuk['kd']);
								$juk_nama = cegah($rjuk['nama']);
								$juk_namax = md5($juk_nama);
								
								//nilainya
								$qok = mysqli_query($koneksi, "SELECT * FROM jadwal ".
																"WHERE tapel = '$tapelkd' ".
																"AND smt = '$smt' ".
																"AND hari_no = '$i_hari_no' ".
																"AND jam_ke = '$i_jam' ".
																"AND kelas = '$juk_nama'");
								$rok = mysqli_fetch_assoc($qok);
								$ok_mapel_kode = balikin($rok['mapel_kode']);
								
								
								
								
								echo '<td align="center">
								<input name="nil'.$i_hari.''.$i_jam.''.$juk_namax.'" type="text" value="'.$ok_mapel_kode.'" size="2" maxlength="6" class="btn btn-warning">
								</td>';
								}
							while ($rjuk = mysqli_fetch_assoc($qjuk));
							
							echo '</tr>';
							}
		
		
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
				<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
				<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-primary">
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


          echo '</div>
          <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">';

			
			//query
			$q = mysqli_query($koneksi, "SELECT DISTINCT(kode) AS kodenya ".
											"FROM m_mapel ".
											"ORDER BY kode ASC");
			$row = mysqli_fetch_assoc($q);
			$total = mysqli_num_rows($q);


			echo '<div class="table-responsive">          
			<table class="table" border="1">
			<thead>
		
			<tr valign="top" bgcolor="'.$warnaheader.'">
			<td width="5"><strong><font color="'.$warnatext.'">KODE</font></strong></td>
			<td><strong><font color="'.$warnatext.'">NAMA MAPEL</font></strong></td>
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
				$e_kodenya = balikin($row['kodenya']);
				
				
				
				//detail e
				$qyes = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
													"WHERE kode = '$e_kodenya'");
				$ryes = mysqli_fetch_assoc($qyes);
				$e_nama = balikin($ryes['nama']);
		
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>'.$e_kodenya.'</td>
				<td>'.$e_nama.'</td>
		        </tr>';
				}
			while ($row = mysqli_fetch_assoc($q));
		
			echo '</tbody>
			</table>
			</div>';


        echo '</div>
      </div>
    </div>';
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