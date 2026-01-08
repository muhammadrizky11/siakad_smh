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
$filenya = "m_proyek.php";
$judul = "Data Proyek";
$judulku = "[PENILAIAN KURMER]. $judul";
$judulx = $judul;
$tapelkd = cegah($_REQUEST['tapelkd']);
$kelkd = cegah($_REQUEST['kelkd']);
$pkd = cegah($_REQUEST['pkd']);
$pno = cegah($_REQUEST['pno']);
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


	//hapus dulu, sebelum insert
	mysqli_query($koneksi, "DELETE FROM kurmer_proyek ".
								"WHERE tapel = '$tapelkd' ".
								"AND kelas = '$kelkd'");	
	

	$limit = 3;
		
	for($i=1;$i<=$limit;$i++)
		{
		//ambil nilai
		$kd = "kd";
		$kd1 = "$kd$i";
		$kdx = nosql($_POST["$kd1"]);



		$abs = "enama";
		$abs1 = "$abs$i";
		$enama = cegah($_POST["$abs1"]);

		$abs = "eisi";
		$abs1 = "$abs$i";
		$eisi = cegah($_POST["$abs1"]);



		//entri baru
		$xyz = md5("$tapelkd$kelkd$i");
		
		

		//query
		mysqli_query($koneksi, "INSERT INTO kurmer_proyek(kd, tapel, kelas, ".
									"no, judul, isi, postdate) VALUES ".
									"('$xyz', '$tapelkd', '$kelkd', ".
									"'$i', '$enama', '$eisi', '$today')");

		}


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
	xloc($ke);
	exit();
	}













//jika simpan
if ($_POST['btnSMP2'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$pkd = cegah($_POST['pkd']);
	$pno = cegah($_POST['pno']);


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
		




	//hapus dulu, sebelum insert
	mysqli_query($koneksi, "DELETE FROM kurmer_proyek_detail ".
								"WHERE tapel = '$tapelkd' ".
								"AND kelas = '$kelkd' ".
								"AND proyek_no = '$pno'");	
	

	$limit = 10;
		
	for($i=1;$i<=$limit;$i++)
		{
		//ambil nilai
		$kd = "kd";
		$kd1 = "$kd$i";
		$kdx = nosql($_POST["$kd1"]);



		$abs = "edimensi";
		$abs1 = "$abs$i";
		$edimensi = cegah($_POST["$abs1"]);

		$abs = "eelemen";
		$abs1 = "$abs$i";
		$eelemen = cegah($_POST["$abs1"]);

		$abs = "esub";
		$abs1 = "$abs$i";
		$esub = cegah($_POST["$abs1"]);
		
		$abs = "efase";
		$abs1 = "$abs$i";
		$efase = cegah($_POST["$abs1"]);




		//entri baru
		$xyz = md5("$tapelkd$kelkd$juk_no$i");
		
		

		//insert
		mysqli_query($koneksi, "INSERT INTO kurmer_proyek_detail(kd, tapel, kelas, ".
									"proyek_no, proyek_judul, proyek_isi, ".
									"no, dimensi, elemen, sub_elemen, capaian_fase, postdate) VALUES ".
									"('$xyz', '$tapelkd', '$kelkd', ".
									"'$juk_no2', '$juk_judul2', '$juk_isi2', ".
									"'$i', '$edimensi', '$eelemen', '$esub', '$efase', '$today')");
		}


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&s=detail&pkd=$pkd";
	xloc($ke);
	exit();
	}





















//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);


	//hapus
	mysqli_query($koneksi, "DELETE FROM kurmer_proyek ".
								"WHERE tapel = '$tapelkd' ".
								"AND kelas = '$kelkd'");	


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
	xloc($ke);
	exit();
	}
	
	









//jika hapus
if ($_POST['btnHPS2'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$pkd = cegah($_POST['pkd']);
	$pno = cegah($_POST['pno']);


	//hapus
	mysqli_query($koneksi, "DELETE FROM kurmer_proyek_detail ".
								"WHERE tapel = '$tapelkd' ".
								"AND kelas = '$kelkd' ".
								"AND proyek_no = '$pno'");	


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&pkd=$pkd&pno=$pno&s=detail";
	xloc($ke);
	exit();
	}
	



	
	
	
	
	
//jika import
if ($_POST['btnIM'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	
	
	
	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&s=import";
	xloc($ke);
	exit();
	}











	
//jika import2
if ($_POST['btnIMM'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$pkd = cegah($_POST['pkd']);
	$pno = cegah($_POST['pno']);
	
	
	
	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&pkd=$pkd&pno=$pno&s=import2";
	xloc($ke);
	exit();
	}











//import sekarang
if ($_POST['btnIMX'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	

	$filex_namex2 = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex2))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&s=import";
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
			$filex_namex2 = "mproyek-$x.xls";

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
			mysqli_query($koneksi, "DELETE FROM kurmer_proyek ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd'");	


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
			    if ($i > 4) 
			    	{
				      // nama ada di kolom A
				      // sedangkan alamat ada di kolom B
				      $i_no = cegah($sheet['A']);
				      $i_nama = cegah($sheet['B']);
				      $i_isi = cegah($sheet['C']);
									  
						//entri baru
						$xyz = md5("$tapelkd$kelkd$i_no");

			
						//query
						mysqli_query($koneksi, "INSERT INTO kurmer_proyek(kd, tapel, kelas, ".
													"no, judul, isi, postdate) VALUES ".
													"('$xyz', '$tapelkd', '$kelkd', ".
													"'$i_no', '$i_nama', '$i_isi', '$today')");

					  
				    }
			
			    $i++;
			  }





			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0777);
			unlink ($path1);


			//re-direct
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smt=$smt";
			xloc($ke);
			exit();
			}
		else
			{
			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smt=$smt&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}













//import sekarang
if ($_POST['btnIMXX'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$pkd = cegah($_POST['pkd']);
	$pno = cegah($_POST['pno']);
	

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




	$filex_namex2 = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex2))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&pkd=$pkd&pno=$pno&s=import2";
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
			$filex_namex2 = "detail-proyek-$pno-$x.xls";

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
			mysqli_query($koneksi, "DELETE FROM kurmer_proyek_detail ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd' ".
										"AND proyek_no = '$pno'");	


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
			    if ($i > 4) 
			    	{
				      // nama ada di kolom A
				      // sedangkan alamat ada di kolom B
				      $i_no = cegah($sheet['A']);
				      $i_dimensi = cegah($sheet['B']);
				      $i_elemen = cegah($sheet['C']);
				      $i_sub_elemen = cegah($sheet['D']);
				      $i_capaian_fase = cegah($sheet['E']);
									  
						//entri baru
						$xyz = md5("$tapelkd$kelkd$pno$i_no");


						//insert
						mysqli_query($koneksi, "INSERT INTO kurmer_proyek_detail(kd, tapel, kelas, ".
													"proyek_no, proyek_judul, proyek_isi, ".
													"no, dimensi, elemen, sub_elemen, capaian_fase, postdate) VALUES ".
													"('$xyz', '$tapelkd', '$kelkd', ".
													"'$pno', '$juk_judul2', '$juk_isi2', ".
													"'$i_no', '$i_dimensi', '$i_elemen', '$i_sub_elemen', '$i_capaian_fase', '$today')");
				



					  
				    }
			
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
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&pkd=$pkd&pno=$pno&s=import2";
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

	
	
	$fileku = "data_proyek.xls";





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





	
	//isi *START
	ob_start();
	

	

	echo '<div class="table-responsive">
	<h3>DAFTAR PROYEK</h3>

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

	
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
		<tr valign="top" bgcolor="'.$warnaheader.'">
			<td width="5">
				<p align="center"><b>NO.</b></p>
			</td>
			<td>
				<p align="center"><b>NAMA</b></p>
			</td>
			<td>
				<p align="center"><b>ISI DESKRIPSI</b></p>
			</td>
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
			$i_no = balikin($data['no']);
			$i_nama = balikin($data['judul']);
			$i_isi = balikin($data['isi']);

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i_no.'.</td>
			<td align="left">'.$i_nama.'</td>
			<td align="left">'.$i_isi.'</td>
			</tr>';
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








//jika export
//export
if ($_POST['btnEXX'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$pno = cegah($_POST['pno']);

	
	
	$fileku = "data_detail_proyek-$pno.xls";





	//query
	$limit = 10;
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM kurmer_proyek_detail ".
					"WHERE tapel = '$tapelkd' ".
					"AND kelas = '$kelkd' ".
					"AND proyek_no = '$pno' ".
					"ORDER BY round(no) ASC";
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
	<h3>DAFTAR DETAIL PROYEK '.$pno.'</h3>

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

	
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
		<tr valign="top" bgcolor="'.$warnaheader.'">
			<td width="5"><b>NO.</b></td>
			<td><b>DIMENSI</b></td>
			<td><b>ELEMEN</b></td>
			<td><b>SUB ELEMEN</b></td>
			<td><b>CAPAIAN FASE</b></td>
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
			$i_no = balikin($data['no']);
			$i_abs = nosql($data['no']);
			$i_dimensi = balikin($data['dimensi']);
			$i_elemen = balikin($data['elemen']);
			$i_sub_elemen = balikin($data['sub_elemen']);
			$i_capaian_fase = balikin($data['capaian_fase']);
		



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td align="center">'.$nomer.'.</td>
				<td align="left">'.$i_dimensi.'</td>
				<td align="left">'.$i_elemen.'</td>
				<td align="left">'.$i_sub_elemen.'</td>
				<td align="left">'.$i_capaian_fase.'</td>
			</tr>';

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
		echo '<form action="'.$filenya.'" method="post" enctype="multipart/form-data" name="formxx2">
		<p>
			<input name="filex_xls" type="file" size="30" class="btn btn-warning" required>
		</p>
	
		<p>
		
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">

					
			<input name="btnBTL" type="submit" value="BATAL" class="btn btn-info">
			<input name="btnIMX" type="submit" value="IMPORT >>" class="btn btn-danger">
		</p>
		
		
		</form>';	
		?>
			
	
	
		</div>
		
		</div>
	
	
		<?php
		}


	//jika import2
	else if ($s == "import2")
		{
		?>
		<div class="row">
	
		<div class="col-md-12">
			
		<?php
		echo '<form action="'.$filenya.'" method="post" enctype="multipart/form-data" name="formxx2">
		<p>
			<input name="filex_xls" type="file" size="30" class="btn btn-warning" required>
		</p>
	
		<p>
		
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="pkd" type="hidden" value="'.$pkd.'">
			<input name="pno" type="hidden" value="'.$pno.'">

					
			<input name="btnBTLL" type="submit" value="BATAL" class="btn btn-info">
			<input name="btnIMXX" type="submit" value="IMPORT >>" class="btn btn-danger">
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
		</p>';

		echo '<form name="formx" method="post" action="'.$filenya.'">
		
		<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		<input name="kelkd" type="hidden" value="'.$kelkd.'">
		<input name="pkd" type="hidden" value="'.$pkd.'">
		<input name="pno" type="hidden" value="'.$juk_no.'">
				
		<input name="btnIMM" type="submit" value="IMPORT" class="btn btn-primary">
		<input name="btnEXX" type="submit" value="EXPORT" class="btn btn-success">
		<hr>';

				
		//query
		$limit = 10;
		$p = new Pager();
		$start = $p->findStart($limit);
	
		$sqlcount = "SELECT * FROM kurmer_proyek_detail ".
						"WHERE tapel = '$tapelkd' ".
						"AND kelas = '$kelkd' ".
						"AND proyek_no = '$juk_no' ".
						"ORDER BY round(no) ASC";
		$sqlresult = $sqlcount;
	
		$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&s=detail&pkd=$pkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);

	
		//jika null, kasi contoh dulu
		if (empty($count))
			{
			for ($k=1;$k<=10;$k++)
				{
				$xyz = md5("$tapelkd$kelkd$juk_no$k");
				
				//insert
				mysqli_query($koneksi, "INSERT INTO kurmer_proyek_detail(kd, tapel, kelas, ".
											"proyek_no, proyek_judul, proyek_isi, ".
											"no, dimensi, elemen, sub_elemen, capaian_fase, postdate) VALUES ".
											"('$xyz', '$tapelkd', '$kelkd', ".
											"'$juk_no2', '$juk_judul2', '$juk_isi2', ".
											"'$k', '', '', '', '', '$today')");
				}
			}
						

						
						
						
						
						
						
						
		//query
		$limit = 10;
		$p = new Pager();
		$start = $p->findStart($limit);
	
		$sqlcount = "SELECT * FROM kurmer_proyek_detail ".
						"WHERE tapel = '$tapelkd' ".
						"AND kelas = '$kelkd' ".
						"AND proyek_no = '$juk_no' ".
						"ORDER BY round(no) ASC";
		$sqlresult = $sqlcount;
	
		$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
	
	
		
		//nek ada
		if ($count != 0)
			{
			echo '<div class="table-responsive">          
			<table class="table" border="1">
			<thead>
				<tr valign="top" bgcolor="'.$warnaheader.'">
					<td width="5"><b>NO.</b></td>
					<td><b>DIMENSI</b></td>
					<td><b>ELEMEN</b></td>
					<td><b>SUB ELEMEN</b></td>
					<td><b>CAPAIAN FASE</b></td>
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
					$i_dimensi = balikin($data['dimensi']);
					$i_elemen = balikin($data['elemen']);
					$i_sub_elemen = balikin($data['sub_elemen']);
					$i_capaian_fase = balikin($data['capaian_fase']);
				
	
		
		
					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td align="center">
							'.$nomer.'.
						</td>
						<td>
							<textarea cols="30" name="edimensi'.$nomer.'" rows="2" wrap="yes" class="btn-warning">'.$i_dimensi.'</textarea>
						</td>
						<td>
							<textarea cols="30" name="eelemen'.$nomer.'" rows="2" wrap="yes" class="btn-warning">'.$i_elemen.'</textarea>
						</td>
						<td>
							<textarea cols="30" name="esub'.$nomer.'" rows="2" wrap="yes" class="btn-warning">'.$i_sub_elemen.'</textarea>
						</td>
						<td>
							<textarea cols="30" name="efase'.$nomer.'" rows="2" wrap="yes" class="btn-warning">'.$i_capaian_fase.'</textarea>
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
			<input name="pkd" type="hidden" value="'.$pkd.'">
			<input name="btnSMP2" type="submit" value="SIMPAN" class="btn btn-danger">
			<input name="btnHPS2" type="submit" value="HAPUS" class="btn btn-primary">
			</td>
			</tr>
			</table>
			</form>';
			}
						
						
											
		}

	else
		{
		echo '<form name="formx" method="post" action="'.$filenya.'">
		
		<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		<input name="kelkd" type="hidden" value="'.$kelkd.'">
				
		<input name="btnIM" type="submit" value="IMPORT" class="btn btn-primary">
		<input name="btnEX" type="submit" value="EXPORT" class="btn btn-success">
		<hr>';
		
		
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
	
	
	
		//jika null, kasi contoh dulu
		if (empty($count))
			{
			for ($k=1;$k<=3;$k++)
				{
				$xyz = md5("$tapelkd$kelkd$k");
				
				//insert
				mysqli_query($koneksi, "INSERT INTO kurmer_proyek(kd, tapel, kelas, ".
											"no, judul, isi, postdate) VALUES ".
											"('$xyz', '$tapelkd', '$kelkd', ".
											"'$k', '', '', '$today')");
				}
			}
						
				
	
	

	
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
				
	
		
		
					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td align="center">
							'.$nomer.'.
						</td>
						<td>
							<textarea cols="60" name="enama'.$nomer.'" rows="2" wrap="yes" class="btn-warning">'.$i_nama.'</textarea>
						</td>
						<td>
							<textarea cols="60" name="eisi'.$nomer.'" rows="5" wrap="yes" class="btn-warning">'.$i_isi.'</textarea>
						</td>
						
						<td>
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