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
$filenya = "nil_proyek.php";
$judul = "Nilai Proyek";
$judulku = "[PENILAIAN KURMER]. $judul";
$judulx = $judul;
$tapelkd = cegah($_REQUEST['tapelkd']);
$kelkd = cegah($_REQUEST['kelkd']);
$pkd = cegah($_REQUEST['pkd']);
$pno = cegah($_REQUEST['pno']);
$fkd = cegah($_REQUEST['fkd']);
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
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$pno = cegah($_POST['pno']);
	$pkd = cegah($_POST['pkd']);

	

	//hapus
	mysqli_query($koneksi, "DELETE FROM kurmer_nilai_proyek ".
								"WHERE tapel = '$tapelkd' ".
								"AND kelas = '$kelkd' ".
								"AND proyek_kode = '$pno'");	

	
	for($i=1;$i<=$limit;$i++)
		{
		//ambil nilai
		$kd = "kd";
		$kd1 = "$kd$i";
		$kdx = nosql($_POST["$kd1"]);

		$abs = "nisnya";
		$abs1 = "$abs$i";
		$nisnya = cegah($_POST["$abs1"]);

		
		//terpilih
		$qbtx = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
											"WHERE kode = '$nisnya'");
		$rowbtx = mysqli_fetch_assoc($qbtx);
		$swnama = cegah($rowbtx['nama']);
		



		
		//list
		$qjuk2 = mysqli_query($koneksi, "SELECT * FROM kurmer_proyek_detail ".
											"WHERE proyek_no = '$pno' ".
											"AND capaian_fase <> '' ".
											"ORDER BY round(no) ASC");
		$rjuk2 = mysqli_fetch_assoc($qjuk2);
		
		do
			{
			//nilai
			$juk2_no = balikin($rjuk2['no']);
			$juk2_dimensi = balikin($rjuk2['dimensi']);
			$juk2_elemen = balikin($rjuk2['elemen']);
			$juk2_sub_elemen = balikin($rjuk2['sub_elemen']);
			$juk2_capaian_fase = balikin($rjuk2['capaian_fase']);
		
	
			$kodenya = "bb";
			$abs = "$juk2_no$kodenya";
			$abs1 = "$abs$i";
			$nil_bb = cegah($_POST["$abs1"]);
	
			$kodenya = "mb";
			$abs = "$juk2_no$kodenya";
			$abs1 = "$abs$i";
			$nil_mb = cegah($_POST["$abs1"]);
		
			$kodenya = "bsh";
			$abs = "$juk2_no$kodenya";
			$abs1 = "$abs$i";
			$nil_bsh = cegah($_POST["$abs1"]);
	
			$kodenya = "sb";
			$abs = "$juk2_no$kodenya";
			$abs1 = "$abs$i";
			$nil_sb = cegah($_POST["$abs1"]);
	
	
			//jika ada
			if (!empty($nil_bb))
				{
				$i_nilai = "bb";
				}
				
			else if (!empty($nil_mb))
				{
				$i_nilai = "mb";
				}
				
			else if (!empty($nil_bsh))
				{
				$i_nilai = "bsh";
				}
				
			else if (!empty($nil_sb))
				{
				$i_nilai = "sb";
				}
				
			else 
				{
				$i_nilai = "";
				}
			
	
			//entri baru
			$xyz = md5("$tapelkd$kelkd$pno$i$juk2_no");
	
	

			//jika ada
			if (!empty($swnama))
				{
				//query
				mysqli_query($koneksi, "INSERT INTO kurmer_nilai_proyek(kd, siswa_kode, siswa_nama, ".
											"tapel, kelas, proyek_kode, ".
											"dimensi_kode, nilai, postdate) VALUES ".
											"('$xyz', '$nisnya', '$swnama', ".
											"'$tapelkd', '$kelkd', '$pno', ".
											"'$juk2_no', '$i_nilai', '$today')");
				}
			}
		while ($rjuk2 = mysqli_fetch_assoc($qjuk2));
		}



	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&pkd=$pkd&pno=$pno&s=detail&page=$page";
	xloc($ke);
	exit();
	}











//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$pkd = cegah($_POST['pkd']);
	$pno = cegah($_POST['pno']);


	//hapus
	mysqli_query($koneksi, "DELETE FROM kurmer_nilai_proyek ".
								"WHERE tapel = '$tapelkd' ".
								"AND kelas = '$kelkd' ".
								"AND proyek_kode = '$pno'");	


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&pkd=$pkd&s=detail";
	xloc($ke);
	exit();
	}
	
	
	
	
	
	
	
//jika import
if ($_POST['btnIM'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$pkd = cegah($_POST['pkd']);
	$pno = cegah($_POST['pno']);
	
	
	
	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&pkd=$pkd&pno=$pno&s=import";
	xloc($ke);
	exit();
	}












//import sekarang
if ($_POST['btnIMX'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$pkd = cegah($_POST['pkd']);
	$pno = cegah($_POST['pno']);
	

	$filex_namex2 = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex2))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&pkd=$pkd&pno=$pno&s=import";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .xls
		$ext_filex = substr($filex_namex2, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox";
			$path2 = "../../filebox/excel";
			chmod($path1,0777);
			chmod($path2,0777);

			//nama file import, diubah menjadi baru...
			$filex_namex2 = "proyek-$pno-$x.xls";

			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex2");

			//chmod
            $path3 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0755);
			chmod($path2,0777);
			chmod($path3,0777);

			//file-nya...
			$uploadfile = $path3;



			//hapus
			mysqli_query($koneksi, "DELETE FROM kurmer_nilai_proyek ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd' ".
										"AND proyek_kode = '$pno'");	
		
			

			//require
			require('../../inc/class/PHPExcel.php');
			require('../../inc/class/PHPExcel/IOFactory.php');


			  // load excel
			  $load = PHPExcel_IOFactory::load($uploadfile);
			  $sheets = $load->getActiveSheet()->toArray(null,true,true,true);
			
			  $i = 1;
			  foreach ($sheets as $sheet) 
			  	{
			    // karena data yang di excel di mulai dari baris ke 5
			    // maka jika $i lebih dari 1 data akan di masukan ke database
			    if ($i > 6) 
			    	{
				      // nama ada di kolom A
				      // sedangkan alamat ada di kolom B
				      $i_xyz = md5("$x$i");
				      $i_no = cegah($sheet['A']);
				      $i_swnis = cegah($sheet['B']);
				      $i_swnama = cegah($sheet['C']);

				      
					  
					  
			
						//list
						$qjuk2 = mysqli_query($koneksi, "SELECT * FROM kurmer_proyek_detail ".
															"WHERE proyek_no = '$pno' ".
															"AND capaian_fase <> '' ".
															"ORDER BY round(no) ASC");
						$rjuk2 = mysqli_fetch_assoc($qjuk2);
						
						do
							{
							//nilai
							$juk2_no = cegah($rjuk2['no']);
							$juk2_dimensi = cegah($rjuk2['dimensi']);
							$juk2_elemen = cegah($rjuk2['elemen']);
							$juk2_sub_elemen = cegah($rjuk2['sub_elemen']);
							$juk2_capaian_fase = cegah($rjuk2['capaian_fase']);
						


							for($k=1;$k<=4;$k++)
								{
								$knomer = $knomer + 1;
								
	
								//mulai D
								$knomerku = $knomer + 3;
								
								$i_hurufnya = $arrrkoloma[$knomerku];
							  	$pnilaix = cegah($sheet[$i_hurufnya]);				
								
								
								//echo "$pnilaix <br>";		
						
	
								//entri baru
								$xyz = md5("$tapelkd$kelkd$pno$i$juk2_no");
						
						
								//jika ada
								if (!empty($pnilaix))
									{
									//jika ada
									if (!empty($i_swnama))
										{
										//jika 1:bb
										if ($knomer == 1)
											{
											$pnilaix = "bb";
											}
											
										//jika 2:mb
										else if ($knomer == 2)
											{
											$pnilaix = "mb";
											}
											
										//jika 3:bsh
										else if ($knomer == 3)
											{
											$pnilaix = "bsh";
											}
											
										//jika 4:sb
										else if ($knomer == 4)
											{
											$pnilaix = "sb";
											}
											
										//echo "$knomer:$pnilaix <br>";

										//query
										mysqli_query($koneksi, "INSERT INTO kurmer_nilai_proyek(kd, siswa_kode, siswa_nama, ".
																	"tapel, kelas, proyek_kode, ".
																	"dimensi_kode, nilai, postdate) VALUES ".
																	"('$xyz', '$i_swnis', '$i_swnama', ".
																	"'$tapelkd', '$kelkd', '$pno', ".
																	"'$juk2_no', '$pnilaix', '$today')");
										}
									}

								}


							}
						while ($rjuk2 = mysqli_fetch_assoc($qjuk2));




				    }
			
			
				$knomer = 0;
			    $i++;
			  }






			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0777);
			unlink ($path1);


			//re-direct
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&pkd=$pkd&pno=$pno&s=detail";
			xloc($ke);
			exit();
			}
		else
			{
			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&pkd=$pkd&pno=$pno&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}




//jika export
//export
if ($_POST['btnEX'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$pkd = cegah($_POST['pkd']);
	$pno = cegah($_POST['pno']);


	
	
	$fileku = "nil_proyek-$pno.xls";





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


	//nilai
	$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_nilai_proyek ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd' ".
										"AND proyek_kode = '$pno'");
	$rku = mysqli_fetch_assoc($qku);
	$i_postdate = balikin($rku['postdate']);




	//detailnya
	$qjuk = mysqli_query($koneksi, "SELECT * FROM kurmer_proyek ".
										"WHERE kd = '$pkd'");
	$rjuk = mysqli_fetch_assoc($qjuk);
	$juk_no = balikin($rjuk['no']);
	$juk_no2 = cegah($rjuk['no']);
	$juk_judul = balikin($rjuk['judul']);
	$juk_judul2 = cegah($rjuk['judul']);
	$juk_isi = balikin($rjuk['isi']);
	$juk_isi2 = cegah($rjuk['isi']);



	
	//isi *START
	ob_start();
	

	

	echo '<div class="table-responsive">
	<h3>DAFTAR NILAI PROYEK '.$pno.'</h3>

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

	echo '<b>'.$btxkelas2.'</b>, 
	
	Judul Proyek : <b>'.$juk_judul.'</b>

	
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
			<td rowspan="2">
				<p align="center"><b>NAMA</b></p>
			</td>';
			
	
			//list
			$qjuk2 = mysqli_query($koneksi, "SELECT * FROM kurmer_proyek_detail ".
												"WHERE proyek_no = '$juk_no' ".
												"AND capaian_fase <> '' ".
												"ORDER BY round(no) ASC");
			$rjuk2 = mysqli_fetch_assoc($qjuk2);
			
			do
				{
				//nilai
				$juk2_no = balikin($rjuk2['no']);
				$juk2_dimensi = balikin($rjuk2['dimensi']);
				$juk2_elemen = balikin($rjuk2['elemen']);
				$juk2_sub_elemen = balikin($rjuk2['sub_elemen']);
				$juk2_capaian_fase = balikin($rjuk2['capaian_fase']);
			
				echo '<td colspan="4" align="center">
				<b>'.$juk2_no.'. <br>'.$juk2_capaian_fase.'</b>
				</td>';
				}
			while ($rjuk2 = mysqli_fetch_assoc($qjuk2));
			
			
		echo '</tr>
		<tr valign="top" bgcolor="'.$warnaheader.'">';
		
			//list
			$qjuk2 = mysqli_query($koneksi, "SELECT * FROM kurmer_proyek_detail ".
												"WHERE proyek_no = '$juk_no' ".
												"AND capaian_fase <> '' ".
												"ORDER BY round(no) ASC");
			$rjuk2 = mysqli_fetch_assoc($qjuk2);
			
			do
				{
				//nilai
				$juk2_no = balikin($rjuk2['no']);
				$juk2_dimensi = balikin($rjuk2['dimensi']);
				$juk2_elemen = balikin($rjuk2['elemen']);
				$juk2_sub_elemen = balikin($rjuk2['sub_elemen']);
				$juk2_capaian_fase = balikin($rjuk2['capaian_fase']);
		
				echo '<td width="5" align="center"><b>BB</b></td>
				<td width="5" align="center"><b>MB</b></td>
				<td width="5" align="center"><b>BSH</b></td>
				<td width="5" align="center"><b>SB</b></td>';
				}
			while ($rjuk2 = mysqli_fetch_assoc($qjuk2));
		
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
			echo '<td>'.$i_abs.'.</td>
			<td>'.$i_nis.'</td>
			<td align="left">'.$i_nama.'</td>';
				

				//list
				$qjuk2 = mysqli_query($koneksi, "SELECT * FROM kurmer_proyek_detail ".
													"WHERE proyek_no = '$juk_no' ".
													"AND capaian_fase <> '' ".
													"ORDER BY round(no) ASC");
				$rjuk2 = mysqli_fetch_assoc($qjuk2);
				
				do
					{
					//nilai
					$juk2_no = balikin($rjuk2['no']);
					$juk2_dimensi = balikin($rjuk2['dimensi']);
					$juk2_elemen = balikin($rjuk2['elemen']);
					$juk2_sub_elemen = balikin($rjuk2['sub_elemen']);
					$juk2_capaian_fase = balikin($rjuk2['capaian_fase']);


					//nilai
					$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_nilai_proyek ".
														"WHERE tapel = '$tapelkd' ".
														"AND kelas = '$kelkd' ".
														"AND proyek_kode = '$juk_no' ".
														"AND dimensi_kode = '$juk2_no' ".
														"AND siswa_kode = '$i_nis' ".
														"AND nilai <> ''");
					$rku = mysqli_fetch_assoc($qku);
					$i_nilai = balikin($rku['nilai']);

					//jika BB
					if ($i_nilai == "bb")
						{
						$i_bb = "V";
						$i_mb = "";
						$i_bsh = "";
						$i_sb = "";
						}

					//jika MB
					else if ($i_nilai == "mb")
						{
						$i_mb = "V";
						$i_bb = "";
						$i_bsh = "";
						$i_sb = "";
						}
						
					//jika BSH
					else if ($i_nilai == "bsh")
						{
						$i_bsh = "V";
						$i_mb = "";
						$i_bb = "";
						$i_sb = "";
						}
						
						
					//jika SB
					else if ($i_nilai == "sb")
						{
						$i_sb = "V";
						$i_mb = "";
						$i_bb = "";
						$i_bsh = "";
						}

					else 
						{
						$i_sb = "";
						$i_mb = "";
						$i_bb = "";
						$i_bsh = "";
						}

			
					echo '<td>'.$i_bb.'</td>
					<td>'.$i_mb.'</td>
					<td>'.$i_bsh.'</td>
					<td>'.$i_sb.'</td>';
					
					//netralkan
					$juk2_no = "";
					}
				while ($rjuk2 = mysqli_fetch_assoc($qjuk2));
				

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
$qtpx = mysqli_query($koneksi, "SELECT * FROM m_walikelas ".
									"WHERE peg_kd = '$kd3_session' ".
									"AND tapel_nama = '$tapelkd'");
$rowtpx = mysqli_fetch_assoc($qtpx);
$tpx_thn1 = cegah($rowtpx['tapel_nama']);
$tpx_thn2 = balikin($rowtpx['tapel_nama']);

echo '<option value="'.$tpx_thn1.'" selected>'.$tpx_thn2.'</option>';

$qtp = mysqli_query($koneksi, "SELECT * FROM m_walikelas ".
								"WHERE peg_kd = '$kd3_session' ".
								"ORDER BY tapel_nama DESC");
$rowtp = mysqli_fetch_assoc($qtp);

do
	{
	$tpth1 = cegah($rowtp['tapel_nama']);
	$tpth2 = balikin($rowtp['tapel_nama']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpth1.'">'.$tpth2.'</option>';
	}
while ($rowtp = mysqli_fetch_assoc($qtp));

echo '</select>, 




Kelas : ';
echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";

//terpilih
$qbtx = mysqli_query($koneksi, "SELECT * FROM m_walikelas ".
									"WHERE peg_kd = '$kd3_session' ".
									"AND kelas_nama = '$kelkd'");
$rowbtx = mysqli_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkelas1 = cegah($rowbtx['kelas_nama']);
$btxkelas2 = balikin($rowbtx['kelas_nama']);

echo '<option value="'.$btxkelas1.'">'.$btxkelas2.'</option>';

$qbt = mysqli_query($koneksi, "SELECT * FROM m_walikelas ".
								"WHERE peg_kd = '$kd3_session' ".
								"ORDER BY kelas_nama ASC");
$rowbt = mysqli_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas1 = cegah($rowbt['kelas_nama']);
	$btkelas2 = balikin($rowbt['kelas_nama']);

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
	//jika import
	if ($s == "import")
		{
		?>
		<div class="row">
	
		<div class="col-md-12">
			
		<?php		
		//detailnya
		$qjuk = mysqli_query($koneksi, "SELECT * FROM kurmer_proyek ".
											"WHERE kd = '$pkd'");
		$rjuk = mysqli_fetch_assoc($qjuk);
		$juk_no = balikin($rjuk['no']);
		$juk_no2 = cegah($rjuk['no']);
		$juk_judul = balikin($rjuk['judul']);
		$juk_judul2 = cegah($rjuk['judul']);
		$juk_isi = balikin($rjuk['isi']);
		$juk_isi2 = cegah($rjuk['isi']);
		
			
			
		echo '<a href="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&pkd='.$pkd.'&pno='.$pno.'&s=detail" class="btn btn-danger"><< DAFTAR NILAI</a>
		<hr>
		<p>
		Judul Proyek : <b>'.$juk_no.'. '.$juk_judul.'</b>
		</p>
		<hr>
		
		
		<form action="'.$filenya.'" method="post" enctype="multipart/form-data" name="formxx2">
		<p>
			<input name="filex_xls" type="file" size="30" class="btn btn-warning" required>
		</p>
	
		<p>
		
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="pkd" type="hidden" value="'.$pkd.'">
			<input name="pno" type="hidden" value="'.$pno.'">
			<input name="s" type="hidden" value="'.$s.'">

					
			<input name="btnBTL" type="submit" value="BATAL" class="btn btn-info">
			<input name="btnIMX" type="submit" value="IMPORT >>" class="btn btn-danger">
		</p>
		
		
		</form>';	
		?>
			
	
	
		</div>
		
		</div>
	
	
		<?php
		}
		
	else if ($s == "detail")
		{
		//detailnya
		$qjuk = mysqli_query($koneksi, "SELECT * FROM kurmer_proyek ".
											"WHERE kd = '$pkd'");
		$rjuk = mysqli_fetch_assoc($qjuk);
		$juk_no = balikin($rjuk['no']);
		$juk_no2 = cegah($rjuk['no']);
		$juk_judul = balikin($rjuk['judul']);
		$juk_judul2 = cegah($rjuk['judul']);
		$juk_isi = balikin($rjuk['isi']);
		$juk_isi2 = cegah($rjuk['isi']);
		
			
			
		echo '<a href="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'" class="btn btn-danger"><< DAFTAR PROYEK</a>
		<hr>
		<p>
		Judul Proyek : <b>'.$juk_no.'. '.$juk_judul.'</b>
		</p>
		<hr>

		
		<form name="formx" method="post" action="'.$filenya.'">
		
		<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		<input name="kelkd" type="hidden" value="'.$kelkd.'">
		<input name="pkd" type="hidden" value="'.$pkd.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="pno" type="hidden" value="'.$juk_no.'">';

				
				
	
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
		$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
	
	
	

		//nilai
		$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_nilai_proyek ".
											"WHERE tapel = '$tapelkd' ".
											"AND kelas = '$kelkd' ".
											"AND proyek_kode = '$juk_no'");
		$rku = mysqli_fetch_assoc($qku);
		$i_postdate = balikin($rku['postdate']);
	
	
	
	
		//nek ada
		if ($count != 0)
			{
			echo '<input name="btnIM" type="submit" value="IMPORT" class="btn btn-primary">
			<input name="btnEX" type="submit" value="EXPORT" class="btn btn-success">
			
			<p>
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
					<td rowspan="2">
						<p align="center"><b>NAMA</b></p>
					</td>';
					
			
					//list
					$qjuk2 = mysqli_query($koneksi, "SELECT * FROM kurmer_proyek_detail ".
														"WHERE proyek_no = '$juk_no' ".
														"AND capaian_fase <> '' ".
														"ORDER BY round(no) ASC");
					$rjuk2 = mysqli_fetch_assoc($qjuk2);
					
					do
						{
						//nilai
						$juk2_no = balikin($rjuk2['no']);
						$juk2_dimensi = balikin($rjuk2['dimensi']);
						$juk2_elemen = balikin($rjuk2['elemen']);
						$juk2_sub_elemen = balikin($rjuk2['sub_elemen']);
						$juk2_capaian_fase = balikin($rjuk2['capaian_fase']);
					
						echo '<td colspan="4" align="center">
						<b>'.$juk2_no.'. <br>'.$juk2_capaian_fase.'</b>
						</td>';
						}
					while ($rjuk2 = mysqli_fetch_assoc($qjuk2));
					
					
				echo '</tr>
				<tr valign="top" bgcolor="'.$warnaheader.'">';
				
					//list
					$qjuk2 = mysqli_query($koneksi, "SELECT * FROM kurmer_proyek_detail ".
														"WHERE proyek_no = '$juk_no' ".
														"AND capaian_fase <> '' ".
														"ORDER BY round(no) ASC");
					$rjuk2 = mysqli_fetch_assoc($qjuk2);
					
					do
						{
						//nilai
						$juk2_no = balikin($rjuk2['no']);
						$juk2_dimensi = balikin($rjuk2['dimensi']);
						$juk2_elemen = balikin($rjuk2['elemen']);
						$juk2_sub_elemen = balikin($rjuk2['sub_elemen']);
						$juk2_capaian_fase = balikin($rjuk2['capaian_fase']);
				
						echo '<td width="5" align="center"><b>BB</b></td>
						<td width="5" align="center"><b>MB</b></td>
						<td width="5" align="center"><b>BSH</b></td>
						<td width="5" align="center"><b>SB</b></td>';
						}
					while ($rjuk2 = mysqli_fetch_assoc($qjuk2));
				
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
							<input name="nisnya'.$nomer.'" type="hidden" value="'.$i_nis.'">
						</td>
						<td>
							'.$i_nama.'
						</td>';
						

						//list
						$qjuk2 = mysqli_query($koneksi, "SELECT * FROM kurmer_proyek_detail ".
															"WHERE proyek_no = '$juk_no' ".
															"AND capaian_fase <> '' ".
															"ORDER BY round(no) ASC");
						$rjuk2 = mysqli_fetch_assoc($qjuk2);
						
						do
							{
							//nilai
							$juk2_no = balikin($rjuk2['no']);
							$juk2_dimensi = balikin($rjuk2['dimensi']);
							$juk2_elemen = balikin($rjuk2['elemen']);
							$juk2_sub_elemen = balikin($rjuk2['sub_elemen']);
							$juk2_capaian_fase = balikin($rjuk2['capaian_fase']);

		
							//nilai
							$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_nilai_proyek ".
																"WHERE tapel = '$tapelkd' ".
																"AND kelas = '$kelkd' ".
																"AND proyek_kode = '$juk_no' ".
																"AND dimensi_kode = '$juk2_no' ".
																"AND siswa_kode = '$i_nis' ".
																"AND nilai <> ''");
							$rku = mysqli_fetch_assoc($qku);
							$i_nilai = balikin($rku['nilai']);
		
							//jika BB
							if ($i_nilai == "bb")
								{
								$i_bb = "V";
								$i_mb = "";
								$i_bsh = "";
								$i_sb = "";
								}
		
							//jika MB
							else if ($i_nilai == "mb")
								{
								$i_mb = "V";
								$i_bb = "";
								$i_bsh = "";
								$i_sb = "";
								}
								
							//jika BSH
							else if ($i_nilai == "bsh")
								{
								$i_bsh = "V";
								$i_mb = "";
								$i_bb = "";
								$i_sb = "";
								}
								
								
							//jika SB
							else if ($i_nilai == "sb")
								{
								$i_sb = "V";
								$i_mb = "";
								$i_bb = "";
								$i_bsh = "";
								}

							else 
								{
								$i_sb = "";
								$i_mb = "";
								$i_bb = "";
								$i_bsh = "";
								}

					
							echo '<td>
							<input name="'.$juk2_no.'bb'.$nomer.'" id="'.$juk2_no.'bb'.$nomer.'" type="text" size="1" value="'.$i_bb.'" 
							onclick="document.getElementById(\''.$juk2_no.'bb'.$nomer.'\').value = \'V\';
							document.getElementById(\''.$juk2_no.'mb'.$nomer.'\').value = \'\';
							document.getElementById(\''.$juk2_no.'bsh'.$nomer.'\').value = \'\';
							document.getElementById(\''.$juk2_no.'sb'.$nomer.'\').value = \'\';" 
							class="btn btn-warning">
							</td>
							<td>
							<input name="'.$juk2_no.'mb'.$nomer.'" id="'.$juk2_no.'mb'.$nomer.'" type="text" size="1" value="'.$i_mb.'" 
							onclick="document.getElementById(\''.$juk2_no.'bb'.$nomer.'\').value = \'\';
							document.getElementById(\''.$juk2_no.'mb'.$nomer.'\').value = \'V\';
							document.getElementById(\''.$juk2_no.'bsh'.$nomer.'\').value = \'\';
							document.getElementById(\''.$juk2_no.'sb'.$nomer.'\').value = \'\';" 
							class="btn btn-warning">
							</td>
							
							<td>
							<input name="'.$juk2_no.'bsh'.$nomer.'" id="'.$juk2_no.'bsh'.$nomer.'" type="text" size="1" value="'.$i_bsh.'" 
							onclick="document.getElementById(\''.$juk2_no.'bb'.$nomer.'\').value = \'\';
							document.getElementById(\''.$juk2_no.'mb'.$nomer.'\').value = \'\';
							document.getElementById(\''.$juk2_no.'bsh'.$nomer.'\').value = \'V\';
							document.getElementById(\''.$juk2_no.'sb'.$nomer.'\').value = \'\';" 
							class="btn btn-warning">
							</td>
							
							<td>
							<input name="'.$juk2_no.'sb'.$nomer.'" id="'.$juk2_no.'sb'.$nomer.'" type="text" size="1" value="'.$i_sb.'" 
							onclick="document.getElementById(\''.$juk2_no.'bb'.$nomer.'\').value = \'\';
							document.getElementById(\''.$juk2_no.'mb'.$nomer.'\').value = \'\';
							document.getElementById(\''.$juk2_no.'bsh'.$nomer.'\').value = \'\';
							document.getElementById(\''.$juk2_no.'sb'.$nomer.'\').value = \'V\';" 
							class="btn btn-warning">
							</td>';
							
							
							//netralkan
							$juk2_no = "";
							}
						while ($rjuk2 = mysqli_fetch_assoc($qjuk2));
						

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
							

		  
		}


	else
		{
		echo '<form name="formx" method="post" action="'.$filenya.'">
		
		<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		<input name="kelkd" type="hidden" value="'.$kelkd.'">';
		
		
		//query
		$limit = 3;
		$p = new Pager();
		$start = $p->findStart($limit);
	
		$sqlcount = "SELECT * FROM kurmer_proyek ".
						"WHERE tapel = '$tapelkd' ".
						"AND kelas = '$kelkd' ".
						"ORDER BY round(no) ASC";
		$sqlresult = $sqlcount;
	
		$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
	
	
	

		//nilai
		$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_proyek ".
											"WHERE tapel = '$tapelkd' ".
											"AND kelas = '$kelkd'");
		$rku = mysqli_fetch_assoc($qku);
		$i_postdate = balikin($rku['postdate']);
	
	


		
		//nek ada
		if ($count != 0)
			{
			echo '<div class="table-responsive">          
			<table class="table" border="1">
			<thead>
				<tr valign="top" bgcolor="'.$warnaheader.'">
					<td width="5"><b>NO.</b></td>
					<td><b>JUDUL</b></td>
					<td><b>ISI DESKRIPSI</b></td>
					<td width="5"><b>DETAIL</b></td>
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
					$i_abs = nosql($data['no']);
					$i_nama = balikin($data['judul']);
					$i_isi = balikin($data['isi']);
				
	
	
					//nilai
					$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_nilai_proyek ".
														"WHERE tapel = '$tapelkd' ".
														"AND kelas = '$kelkd' ".
														"AND proyek_kode = '$i_abs'");
					$rku = mysqli_fetch_assoc($qku);
					$i_postdate = balikin($rku['postdate']);
					
	
		
					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td align="center">'.$nomer.'.</td>
						<td>'.$i_nama.'</td>
						<td>'.$i_isi.'</td>
						<td>
						'.$i_postdate.'
						<a href="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&s=detail&pkd='.$i_kd.'" class="btn btn-danger"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"> DETAIL DIMENSI ELEMEN >>
						</a>
						</td>
	
					</tr>';
					}
				while ($data = mysqli_fetch_assoc($result));
				
				
				echo '</tbody>
			</table>
			</div>
	
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td>

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