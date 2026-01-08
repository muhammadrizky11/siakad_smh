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
$filenya = "thn.php";
$judul = "Nilai Akhir Tahun";
$judulku = "[PENILAIAN MAPEL]. $judul";
$judulx = $judul;
$tapelkd = cegah($_REQUEST['tapelkd']);
$kelkd = cegah($_REQUEST['kelkd']);
$mjenis = cegah($_REQUEST['mjenis']);
$mkode = cegah($_REQUEST['mkode']);
$mnama = cegah($_REQUEST['mnama']);
$s = cegah($_REQUEST['s']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mjenis=$mjenis&mkode=$mkode&mnama=$mnama&page=$page";





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
	$tapelkd2 = balikin($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$mjenis = cegah($_POST['mjenis']);
	$mkode = cegah($_POST['mkode']);
	$page = nosql($_POST['page']);

	
	$pecahku = explode("/", $tapelkd2);
	$etahun1 = balikin($pecahku[0]);
	$etahun2 = balikin($pecahku[1]);
	
	
	
	//pecah tapel
	if ($smt == 1)
		{	
		$etahunku = $etahun1;
		}
		
	else if ($smt == 2)
		{	
		$etahunku = $etahun2;
		}
		
		
		
		
	
	
	//terpilih
	$qbtx = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
										"WHERE kode = '$mkode'");
	$rowbtx = mysqli_fetch_assoc($qbtx);
	$mno = cegah($rowbtx['no']);
	$mnama = cegah($rowbtx['nama']);
		
	

	//hapus dulu, sebelum entri
	mysqli_query($koneksi, "DELETE FROM siswa_nilai_thn ".
								"WHERE tapel = '$tapelkd' ".
								"AND kelas = '$kelkd' ".
								"AND jenis = '$mjenis' ".
								"AND mapel_kode = '$mkode'");	
					
	
	
	
	for($i=1;$i<=$limit;$i++)
		{
		//ambil nilai
		$kd = "kdnya";
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
			



		$abs = "p_pas_smt1_";
		$abs1 = "$abs$i";
		$p_pas_smt1 = cegah($_POST["$abs1"]);
		
		
		//jika null
		if (empty($p_pas_smt1))
			{
			$p_pas_smt1 = "0";
			}	



		$abs = "k_pas_smt1_";
		$abs1 = "$abs$i";
		$k_pas_smt1 = cegah($_POST["$abs1"]);
		
		
		//jika null
		if (empty($k_pas_smt1))
			{
			$k_pas_smt1 = "0";
			}	



		$abs = "p_pas_smt2_";
		$abs1 = "$abs$i";
		$p_pas_smt2 = cegah($_POST["$abs1"]);
		
		
		//jika null
		if (empty($p_pas_smt2))
			{
			$p_pas_smt2 = "0";
			}	




		$abs = "k_pas_smt2_";
		$abs1 = "$abs$i";
		$k_pas_smt2 = cegah($_POST["$abs1"]);
		
		
		//jika null
		if (empty($k_pas_smt2))
			{
			$k_pas_smt2 = "0";
			}	



		$abs = "pat_p";
		$abs1 = "$abs$i";
		$pat_p = cegah($_POST["$abs1"]);
		
		
		//jika null
		if (empty($pat_p))
			{
			$pat_p = "0";
			}	



		$abs = "pat_k";
		$abs1 = "$abs$i";
		$pat_k = cegah($_POST["$abs1"]);
		
		
		//jika null
		if (empty($pat_k))
			{
			$pat_k = "0";
			}	





		$na_p = round(($p_pas_smt1 + $p_pas_smt2 + (2 * $pat_p)) / 4); 
		$na_k = round(($k_pas_smt1 + $k_pas_smt2 + (2 * $pat_k)) / 4); 



		$na_p_predikat = xpredikat($na_p);
		$na_k_predikat = xpredikat($na_k);






		//entri baru
		$xyz = md5("$tapelkd$smt$kelkd$nisnya$mkode$i");
				
				
		//jika ada
		if (!empty($swnama))
			{
			//query
			mysqli_query($koneksi, "INSERT INTO siswa_nilai_thn(kd, siswa_kode, siswa_nama, ".
										"tapel, kelas, ".
										"jenis, mapel_no, mapel_kode, ".
										"mapel_nama, p_na_smt1, p_na_smt2, ".
										"k_na_smt1, k_na_smt2, p_pat_nilai, ".
										"k_pat_nilai, p_na, p_na_pred, ".
										"k_na, k_na_pred, postdate) VALUES ".
										"('$xyz', '$nisnya', '$swnama', ".
										"'$tapelkd', '$kelkd', ".
										"'$mjenis', '$mno', '$mkode', ".
										"'$mnama', '$p_pas_smt1', '$p_pas_smt2', ".
										"'$k_pas_smt1', '$k_pas_smt2', '$pat_p', ".
										"'$pat_k', '$na_p', '$na_p_predikat', ".
										"'$na_k', '$na_k_predikat', '$today')");
			}
			


			
		}


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mjenis=$mjenis&mkode=$mkode&mnama=$mnama&&page=$page";
	xloc($ke);
	exit();
	}











//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$mjenis = cegah($_POST['mjenis']);
	$mkode = cegah($_POST['mkode']);


	//hapus
	mysqli_query($koneksi, "DELETE FROM siswa_nilai_thn ".
								"WHERE tapel = '$tapelkd' ".
								"AND kelas = '$kelkd' ".
								"AND jenis = '$mjenis' ".
								"AND mapel_kode = '$mkode'");	


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mjenis=$mjenis&mkode=$mkode&mnama=$mnama";
	xloc($ke);
	exit();
	}
	
	
	
	
	
	
	
//jika import
if ($_POST['btnIM'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$mjenis = cegah($_POST['mjenis']);
	$mkode = cegah($_POST['mkode']);
	
	
	
	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mjenis=$mjenis&mkode=$mkode&mnama=$mnama&s=import";
	xloc($ke);
	exit();
	}












//import sekarang
if ($_POST['btnIMX'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$tapelkd2 = balikin($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$mjenis = cegah($_POST['mjenis']);
	$mkode = cegah($_POST['mkode']);

	$pecahku = explode("/", $tapelkd2);
	$etahun1 = balikin($pecahku[0]);
	$etahun2 = balikin($pecahku[1]);
	
	
	
	//pecah tapel
	if ($smt == 1)
		{	
		$etahunku = $etahun1;
		}
		
	else if ($smt == 2)
		{	
		$etahunku = $etahun2;
		}




		
	//terpilih
	$qbtx = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
										"WHERE kode = '$mkode'");
	$rowbtx = mysqli_fetch_assoc($qbtx);
	$mno = cegah($rowbtx['no']);
	$mnama = cegah($rowbtx['nama']);
		
	
	$filex_namex2 = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex2))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mjenis=$mjenis&mkode=$mkode&mnama=$mnama&s=import";
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
			$filex_namex2 = "mapel-akhir-tahun-$x.xls";

			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex2");

			//chmod
            $path3 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0755);
			chmod($path2,0777);
			chmod($path3,0777);

			//file-nya...
			$uploadfile = $path3;




			//hapus dulu, sebelum entri
			mysqli_query($koneksi, "DELETE FROM siswa_nilai_thn ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd' ".
										"AND jenis = '$mjenis' ".
										"AND mapel_kode = '$mkode'");	
							


			//require
			require('../../inc/class/PHPExcel.php');
			require('../../inc/class/PHPExcel/IOFactory.php');


			  // load excel
			  $load = PHPExcel_IOFactory::load($uploadfile);
			  $sheets = $load->getActiveSheet()->toArray(null,true,true,true);
			
			  $i = 1;
			  foreach ($sheets as $sheet) 
			  	{
			    // karena data yang di excel di mulai dari baris ke 7
			    // maka jika $i lebih dari 1 data akan di masukan ke database
			    if ($i > 7) 
			    	{
				      // nama ada di kolom A
				      // sedangkan alamat ada di kolom B
				      $i_xyz = md5("$x$i");
				      $i_no = cegah($sheet['A']);
				      $i_swnis = cegah($sheet['B']);
				      $i_swnama = cegah($sheet['C']);
				      
				      $i_pat_p = round(cegah($sheet['H']));
				      $i_pat_k = round(cegah($sheet['I']));
				      
				      
					  
					  //entri baru
					  $xyz = md5("$tapelkd$kelkd$i_swnis$mkode$i");
					
								
						//jika ada
						if (!empty($i_swnis))
							{
							//query
							mysqli_query($koneksi, "INSERT INTO siswa_nilai_thn(kd, siswa_kode, siswa_nama, ".
														"tapel, kelas, ".
														"jenis, mapel_no, mapel_kode, ".
														"mapel_nama, p_na_smt1, p_na_smt2, ".
														"k_na_smt1, k_na_smt2, p_pat_nilai, ".
														"k_pat_nilai, p_na, p_na_pred, ".
														"k_na, k_na_pred, postdate) VALUES ".
														"('$xyz', '$i_swnis', '$i_swnama', ".
														"'$tapelkd', '$kelkd', ".
														"'$mjenis', '$mno', '$mkode', ".
														"'$mnama', '$p_pas_smt1', '$p_pas_smt2', ".
														"'$k_pas_smt1', '$k_pas_smt2', '$i_pat_p', ".
														"'$i_pat_k', '$na_p', '$na_p_predikat', ".
														"'$na_k', '$na_k_predikat', '$today')");
							
							}
					
					  	
				    }


			    $i++;
			  }





			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0777);
			unlink ($path1);


			//re-direct
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mjenis=$mjenis&mkode=$mkode&mnama=$mnama";
			xloc($ke);
			exit();
			}
		else
			{
			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mjenis=$mjenis&mkode=$mkode&mnama=$mnama&s=import";
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
	$mjenis = cegah($_POST['mjenis']);
	$mkode = cegah($_POST['mkode']);
	$smt = cegah($_POST['smt']);
	$page = nosql($_POST['page']);

	
	//terpilih
	$qbtx = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
										"WHERE kode = '$mkode'");
	$rowbtx = mysqli_fetch_assoc($qbtx);
	$mno = cegah($rowbtx['no']);
	$mnama = cegah($rowbtx['nama']);

	$fileku = "nil_mapel-akhir-tahun-$mkode.xls";





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



	
	//terpilih
	$qbtx = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
										"WHERE kode = '$mkode'");
	$rowbtx = mysqli_fetch_assoc($qbtx);
	$mno = cegah($rowbtx['no']);
	$mnama = cegah($rowbtx['nama']);


	//nilai
	$qku = mysqli_query($koneksi, "SELECT * FROM siswa_nilai_thn ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd' ".
										"AND mapel_kode = '$mkode'");
	$rku = mysqli_fetch_assoc($qku);
	$i_postdate = balikin($rku['postdate']);





	
	//isi *START
	ob_start();
	

	

	echo '<div class="table-responsive">
	<h3>DAFTAR NILAI MAPEL AKHIR TAHUN</h3>

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

	Mata Pelajaran : ';
	
	//terpilih
	$qbtx = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd' ".
										"AND jenis = '$mjenis' ".
										"AND kode = '$mkode'");
	$rowbtx = mysqli_fetch_assoc($qbtx);
	$btxkd = nosql($rowbtx['kd']);
	$btxkelas1 = cegah($rowbtx['nama']);
	$btxkelas2 = balikin($rowbtx['nama']);

	echo '<b>'.$btxkelas2.' ['.$mkode.']</b>

	
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
			</td>

			<td colspan="2">
					<p align="center">
					<b>NA SMT 1</b>
					<br>
					Bobot:1
					</p>
			</td>

			<td colspan="2">
					<p align="center">
					<b>NA SMT 2</b>
					<br>
					Bobot:1
					</p>
			</td>

			<td colspan="2">
					<p align="center">
					<b>PAT</b>
					<br>
					Bobot:2
					</p>
			</td>
			
			<td colspan="4">
					<p align="center">
					<b>NA</b>
					<br>
					Raport
					</p>
			</td>
				
				
		</tr>
		<tr valign="top" bgcolor="'.$warnaheader.'">

			<td>
				<p align="center"><b>P</b></p>
			</td>
			<td>
				<p align="center"><b>K</b></p>
			</td>
		
			<td>
				<p align="center"><b>P</b></p>
			</td>
			<td>
				<p align="center"><b>K</b></p>
			</td>
		
			<td>
				<p align="center"><b>P</b></p>
			</td>
			<td>
				<p align="center"><b>K</b></p>
			</td>
		
			<td>
				<p align="center"><b>P</b></p>
			</td>
		
			<td>
				<p align="center"><b>Pred</b></p>
			</td>
			<td>
				<p align="center"><b>K</b></p>
			</td>
			<td>
				<p align="center"><b>Pred</b></p>
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
			$i_nis = nosql($data['kode']);
			$i_nis2 = cegah($data['kode']);
			$i_abs = nosql($data['nourut']);
			$i_nama = balikin2($data['nama']);
			$i_nama2 = cegah($data['nama']);



			//rata nya
			$qku = mysqli_query($koneksi, "SELECT p_na, k_na ".
											"FROM siswa_nilai_smt ".
											"WHERE tapel = '$tapelkd' ".
											"AND kelas = '$kelkd' ".
											"AND smt = '1' ".
											"AND siswa_kode = '$i_nis' ".
											"AND mapel_kode = '$mkode' ".
											"AND p_na <> '0'");
			$rku = mysqli_fetch_assoc($qku);
			$i_smt_1_p = round(balikin($rku['p_na']));
			$i_smt_1_k = round(balikin($rku['k_na']));
			
			
			
			
			//rata nya
			$qku = mysqli_query($koneksi, "SELECT p_na, k_na ".
											"FROM siswa_nilai_smt ".
											"WHERE tapel = '$tapelkd' ".
											"AND kelas = '$kelkd' ".
											"AND smt = '2' ".
											"AND siswa_kode = '$i_nis' ".
											"AND mapel_kode = '$mkode' ".
											"AND p_na <> '0'");
			$rku = mysqli_fetch_assoc($qku);
			$i_smt_2_p = round(balikin($rku['p_na']));
			$i_smt_2_k = round(balikin($rku['k_na']));
			

			
			
			//nilainya
			$qku = mysqli_query($koneksi, "SELECT * FROM siswa_nilai_thn ".
											"WHERE tapel = '$tapelkd' ".
											"AND kelas = '$kelkd' ".
											"AND siswa_kode = '$i_nis' ".
											"AND mapel_kode = '$mkode'");
			$rku = mysqli_fetch_assoc($qku);
			$i_pat_p = round(balikin($rku['p_pat_nilai']));
			$i_pat_k = round(balikin($rku['k_pat_nilai']));


			
			
			$i_na_p = round(((2 * $i_pat_p) + $i_smt_1_p + $i_smt_2_p) / 4); 
			$i_na_k = round(((2 * $i_pat_k) + $i_smt_1_k + $i_smt_2_k) / 4);   
	
	
	
			$i_na_p_pred = xpredikat($i_na_p);
			$i_na_k_pred = xpredikat($i_na_k);
	

			
					
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
					'.$i_abs.'.
				</td>
				<td>
					'.$i_nis.'
				</td>
				<td align="left">
					'.$i_nama.'
				</td>
				
				<td>'.$i_smt_1_p.'</td>
				<td>'.$i_smt_1_k.'</td>

				<td>'.$i_smt_2_p.'</td>
				<td>'.$i_smt_2_k.'</td>
				<td>'.$i_pat_p.'</td>
				<td>'.$i_pat_k.'</td>
				<td>'.$i_na_p.'</td>
				<td>'.$i_na_p_pred.'</td>
				<td>'.$i_na_k.'</td>
				<td>'.$i_na_k_pred.'</td>
				
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
</td>
</tr>

<tr>
<td>
Jenis : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";

//terpilih
$qbtx = mysqli_query($koneksi, "SELECT * FROM m_mapel_jns ".
									"WHERE jenis = '$mjenis'");
$rowbtx = mysqli_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkelas1 = cegah($rowbtx['jenis']);
$btxkelas2 = balikin($rowbtx['jenis']);

echo '<option value="'.$btxkelas1.'">'.$btxkelas2.'</option>';

$qbt = mysqli_query($koneksi, "SELECT * FROM m_mapel_jns ".
								"WHERE jenis <> '$mjenis' ".
								"ORDER BY jenis ASC");
$rowbt = mysqli_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas1 = cegah($rowbt['jenis']);
	$btkelas2 = balikin($rowbt['jenis']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&mjenis='.$btkelas1.'">'.$btkelas2.'</option>';
	}
while ($rowbt = mysqli_fetch_assoc($qbt));

echo '</select>, 


Mata Pelajaran : ';
echo "<select name=\"mapel\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";

//terpilih
$qbtx = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
									"WHERE tapel = '$tapelkd' ".
									"AND kelas = '$kelkd' ".
									"AND jenis = '$mjenis' ".
									"AND kode = '$mkode'");
$rowbtx = mysqli_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkelas1 = cegah($rowbtx['nama']);
$btxkelas2 = balikin($rowbtx['nama']);

echo '<option value="'.$btxkelas1.'">'.$btxkelas2.' ['.$mkode.']</option>';

$qbt = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
								"WHERE tapel = '$tapelkd' ".
								"AND kelas = '$kelkd' ".
								"AND jenis = '$mjenis' ".
								"ORDER BY nama ASC");
$rowbt = mysqli_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkode = balikin($rowbt['kode']);
	$btkelas1 = cegah($rowbt['nama']);
	$btkelas2 = balikin($rowbt['nama']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&mjenis='.$mjenis.'&mnama='.$btkelas1.'&mkode='.$btkode.'">'.$btkelas2.' ['.$btkode.']</option>';
	}
while ($rowbt = mysqli_fetch_assoc($qbt));

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="mjenis" type="hidden" value="'.$mjenis.'">
<input name="mnama" type="hidden" value="'.$mnama.'">
<input name="mkode" type="hidden" value="'.$mkode.'">
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


else if (empty($mjenis))
	{
	echo '<p>
	<font color="#FF0000"><strong>JENIS MAPEL Belum Dipilih...!</strong></font>
	</p>';
	}
	

else if (empty($mkode))
	{
	echo '<p>
	<font color="#FF0000"><strong>MAPEL Belum Dipilih...!</strong></font>
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
			<input name="mjenis" type="hidden" value="'.$mjenis.'">
			<input name="mnama" type="hidden" value="'.$mnama.'">
			<input name="mkode" type="hidden" value="'.$mkode.'">
					
			<input name="btnBTL" type="submit" value="BATAL" class="btn btn-info">
			<input name="btnIMX" type="submit" value="IMPORT >>" class="btn btn-danger">
		</p>
		
		
		</form>';	
		?>
			
	
	
		</div>
		
		</div>
	
	
		<?php
		}
	else
		{
		$pecahku = explode("/", $tpx_thn2);
		$etahun1 = balikin($pecahku[0]);
		$etahun2 = balikin($pecahku[1]);
		
		
		
		//pecah tapel
		if ($smt == 1)
			{	
			$etahunku = $etahun1;
			}
			
		else if ($smt == 2)
			{	
			$etahunku = $etahun2;
			}
				
		echo '<form name="formx" method="post" action="'.$filenya.'">
		
		<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		<input name="kelkd" type="hidden" value="'.$kelkd.'">
		<input name="mjenis" type="hidden" value="'.$mjenis.'">
		<input name="mnama" type="hidden" value="'.$mnama.'">
		<input name="mkode" type="hidden" value="'.$mkode.'">
				
		<input name="btnIM" type="submit" value="IMPORT" class="btn btn-primary">
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
		$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mjenis=$mjenis&mnama=$mnama&mkode=$mkode";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
	
	
	
		
		//terpilih
		$qbtx = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
											"WHERE kode = '$mkode'");
		$rowbtx = mysqli_fetch_assoc($qbtx);
		$mno = cegah($rowbtx['no']);
		$mnama = cegah($rowbtx['nama']);
	
	
		//nilai
		$qku = mysqli_query($koneksi, "SELECT * FROM siswa_nilai_thn ".
											"WHERE tapel = '$tapelkd' ".
											"AND kelas = '$kelkd' ".
											"AND mapel_kode = '$mkode'");
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
					</td>

					<td colspan="2">
							<p align="center">
							<b>NA SMT 1</b>
							<br>
							Bobot:1
							</p>
					</td>

					<td colspan="2">
							<p align="center">
							<b>NA SMT 2</b>
							<br>
							Bobot:1
							</p>
					</td>

					<td colspan="2">
							<p align="center">
							<b>PAT</b>
							<br>
							Bobot:2
							</p>
					</td>
					
					<td colspan="4">
							<p align="center">
							<b>NA</b>
							<br>
							Raport
							</p>
					</td>
						
						
				</tr>
				<tr valign="top" bgcolor="'.$warnaheader.'">

					<td>
						<p align="center"><b>P</b></p>
					</td>
					<td>
						<p align="center"><b>K</b></p>
					</td>
				
					<td>
						<p align="center"><b>P</b></p>
					</td>
					<td>
						<p align="center"><b>K</b></p>
					</td>
				
					<td>
						<p align="center"><b>P</b></p>
					</td>
					<td>
						<p align="center"><b>K</b></p>
					</td>
				
					<td>
						<p align="center"><b>P</b></p>
					</td>
				
					<td>
						<p align="center"><b>Pred</b></p>
					</td>
					<td>
						<p align="center"><b>K</b></p>
					</td>
					<td>
						<p align="center"><b>Pred</b></p>
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
					$i_nis = nosql($data['kode']);
					$i_nis2 = cegah($data['kode']);
					$i_abs = nosql($data['nourut']);
					$i_nama = balikin2($data['nama']);
					$i_nama2 = cegah($data['nama']);

					
					//rata nya
					$qku = mysqli_query($koneksi, "SELECT p_na, k_na ".
													"FROM siswa_nilai_smt ".
													"WHERE tapel = '$tapelkd' ".
													"AND kelas = '$kelkd' ".
													"AND smt = '1' ".
													"AND siswa_kode = '$i_nis' ".
													"AND mapel_kode = '$mkode' ".
													"AND p_na <> '0'");
					$rku = mysqli_fetch_assoc($qku);
					$i_smt_1_p = round(balikin($rku['p_na']));
					$i_smt_1_k = round(balikin($rku['k_na']));
					
					
					
					
					//rata nya
					$qku = mysqli_query($koneksi, "SELECT p_na, k_na ".
													"FROM siswa_nilai_smt ".
													"WHERE tapel = '$tapelkd' ".
													"AND kelas = '$kelkd' ".
													"AND smt = '2' ".
													"AND siswa_kode = '$i_nis' ".
													"AND mapel_kode = '$mkode' ".
													"AND p_na <> '0'");
					$rku = mysqli_fetch_assoc($qku);
					$i_smt_2_p = round(balikin($rku['p_na']));
					$i_smt_2_k = round(balikin($rku['k_na']));
					

					
					
					//nilainya
					$qku = mysqli_query($koneksi, "SELECT * FROM siswa_nilai_thn ".
													"WHERE tapel = '$tapelkd' ".
													"AND kelas = '$kelkd' ".
													"AND siswa_kode = '$i_nis' ".
													"AND mapel_kode = '$mkode'");
					$rku = mysqli_fetch_assoc($qku);
					$i_pat_p = round(balikin($rku['p_pat_nilai']));
					$i_pat_k = round(balikin($rku['k_pat_nilai']));


					
					
					$i_na_p = round(((2 * $i_pat_p) + $i_smt_1_p + $i_smt_2_p) / 4); 
					$i_na_k = round(((2 * $i_pat_k) + $i_smt_1_k + $i_smt_2_k) / 4);   
			
			
			
					$i_na_p_pred = xpredikat($i_na_p);
					$i_na_k_pred = xpredikat($i_na_k);
			
		
			
					//update kan
					mysqli_query($koneksi, "UPDATE siswa_nilai_thn SET p_na_smt_1 = '$i_smt_1_p', ".
												"k_na_smt_1 = '$i_smt_1_k', ".
												"p_na_smt_2 = '$i_smt_2_p', ".
												"k_na_smt_2 = '$i_smt_2_k', ".
												"p_na = '$i_na_p', ".
												"p_na_pred = '$i_na_p_pred', ".
												"k_na = '$i_na_k', ".
												"k_na_pred = '$i_na_k_pred' ".
												"WHERE tapel = '$tapelkd' ".
												"AND kelas = '$kelkd' ".
												"AND siswa_kode = '$i_nis' ".
												"AND mapel_kode = '$mkode'");
					
						
												

					
							
					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td>
							'.$i_abs.'.
						</td>
						<td>
							'.$i_nis.'
							<input name="kdnya'.$nomer.'" type="hidden" value="'.$i_kd.'">
							<input name="nisnya'.$nomer.'" type="hidden" value="'.$i_nis.'">
						</td>
						<td>
							'.$i_nama.'
						</td>
						
						<td>
						<input name="p_pas_smt1_'.$nomer.'" type="text" value="'.$i_smt_1_p.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-default" readonly>
						</td>
						<td>
						<input name="k_pas_smt1_'.$nomer.'" type="text" value="'.$i_smt_1_k.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-default" readonly>
						</td>

						<td>
						<input name="p_pas_smt2_'.$nomer.'" type="text" value="'.$i_smt_2_p.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-default" readonly>
						</td>
						<td>
						<input name="k_pas_smt2_'.$nomer.'" type="text" value="'.$i_smt_2_k.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-default" readonly>
						</td>
						<td>
						<input name="pat_p'.$nomer.'" type="text" value="'.$i_pat_p.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-warning">
						</td>
						<td>
						<input name="pat_k'.$nomer.'" type="text" value="'.$i_pat_k.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-warning">
						</td>
						<td>
						<input name="na_p'.$nomer.'" type="text" value="'.$i_na_p.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-default" readonly>
						</td>
						<td>
						<input name="na_p_pred'.$nomer.'" type="text" value="'.$i_na_p_pred.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-default" readonly>
						</td>
						<td>
						<input name="na_k'.$nomer.'" type="text" value="'.$i_na_k.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-default" readonly>
						</td>
						<td>
						<input name="na_k_pred'.$nomer.'" type="text" value="'.$i_na_k_pred.'" size="2" maxlength="5" class="btn btn-default" readonly>
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