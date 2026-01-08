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
$filenya = "smt.php";
$judul = "Nilai Semester";
$judulku = "[PENILAIAN MAPEL]. $judul";
$judulx = $judul;
$tapelkd = cegah($_REQUEST['tapelkd']);
$kelkd = cegah($_REQUEST['kelkd']);
$mjenis = cegah($_REQUEST['mjenis']);
$mkode = cegah($_REQUEST['mkode']);
$mnama = cegah($_REQUEST['mnama']);
$smt = cegah($_REQUEST['smt']);
$s = cegah($_REQUEST['s']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mjenis=$mjenis&mkode=$mkode&mnama=$mnama&smt=$smt&page=$page";





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
	$smt = cegah($_POST['smt']);
	$kat = cegah($_POST['kat']);
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
	mysqli_query($koneksi, "DELETE FROM siswa_nilai_smt ".
								"WHERE tapel = '$tapelkd' ".
								"AND kelas = '$kelkd' ".
								"AND smt = '$smt' ".
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
			



		$abs = "ph_p";
		$abs1 = "$abs$i";
		$ph_p = cegah($_POST["$abs1"]);
		
		
		//jika null
		if (empty($ph_p))
			{
			$ph_p = "0";
			}	





		$abs = "ph_k";
		$abs1 = "$abs$i";
		$ph_k = cegah($_POST["$abs1"]);
		
		
		//jika null
		if (empty($ph_k))
			{
			$ph_k = "0";
			}	




		$abs = "pts_p";
		$abs1 = "$abs$i";
		$pts_p = cegah($_POST["$abs1"]);
		
		
		//jika null
		if (empty($pts_p))
			{
			$pts_p = "0";
			}	
			
			
		$abs = "pts_k";
		$abs1 = "$abs$i";
		$pts_k = cegah($_POST["$abs1"]);
		
		
		//jika null
		if (empty($pts_k))
			{
			$pts_k = "0";
			}	
			

			

		$abs = "pas_p";
		$abs1 = "$abs$i";
		$pas_p = cegah($_POST["$abs1"]);
		
		
		//jika null
		if (empty($pas_p))
			{
			$pas_p = "0";
			}	
						




		$abs = "pas_k";
		$abs1 = "$abs$i";
		$pas_k = cegah($_POST["$abs1"]);
		
		
		//jika null
		if (empty($pas_k))
			{
			$pas_k = "0";
			}	






					
		$na_p = round(((2 * $ph_p) + $pts_p + $pts_k) / 4); 
		$na_k = round(((2 * $ph_k) + $pts_p + $pts_k) / 4);   



		$na_p_predikat = xpredikat($na_p);
		$na_k_predikat = xpredikat($na_k);




			

		//entri baru
		$xyz = md5("$tapelkd$smt$kelkd$nisnya$mkode$i");
				
				
		//jika ada
		if (!empty($swnama))
			{
			//query
			mysqli_query($koneksi, "INSERT INTO siswa_nilai_smt(kd, siswa_kode, siswa_nama, ".
										"tapel, kelas, smt, ".
										"jenis, mapel_no, mapel_kode, ".
										"mapel_nama, p_ph_nilai, k_ph_nilai, ".
										"p_pts_nilai, k_pts_nilai, p_pas_nilai, ".
										"k_pas_nilai, p_na, p_na_pred, ".
										"k_na, k_na_pred, postdate) VALUES ".
										"('$xyz', '$nisnya', '$swnama', ".
										"'$tapelkd', '$kelkd', '$smt', ".
										"'$mjenis', '$mno', '$mkode', ".
										"'$mnama', '$ph_p', '$ph_k', ".
										"'$pts_p', '$pts_k', '$pas_p', ".
										"'$pas_k', '$na_p', '$na_p_predikat', ".
										"'$na_k', '$na_k_predikat', '$today')");
			}
			


			
		}


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mjenis=$mjenis&mkode=$mkode&mnama=$mnama&smt=$smt&kat=$kat&page=$page";
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
	$smt = cegah($_POST['smt']);
	$kat = cegah($_POST['kat']);


	//hapus
	mysqli_query($koneksi, "DELETE FROM siswa_nilai_smt ".
								"WHERE tapel = '$tapelkd' ".
								"AND kelas = '$kelkd' ".
								"AND smt = '$smt' ".
								"AND jenis = '$mjenis' ".
								"AND mapel_kode = '$mkode'");	


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mjenis=$mjenis&mkode=$mkode&mnama=$mnama&smt=$smt";
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
	$smt = cegah($_POST['smt']);
	$kat = cegah($_POST['kat']);
	
	
	
	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mjenis=$mjenis&mkode=$mkode&mnama=$mnama&smt=$smt&kat=$kat&s=import";
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
	$smt = cegah($_POST['smt']);

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
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mjenis=$mjenis&mkode=$mkode&mnama=$mnama&smt=$smt&s=import";
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
			$filex_namex2 = "mapel-$smt-$x.xls";

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
			mysqli_query($koneksi, "DELETE FROM siswa_nilai_smt ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd' ".
										"AND smt = '$smt' ".
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
				      
				      $i_pts_p = round(cegah($sheet['F']));
				      $i_pts_k = round(cegah($sheet['G']));
				      $i_pas_p = round(cegah($sheet['H']));
				      $i_pas_k = round(cegah($sheet['I']));
				      
				      
					  
					  //entri baru
					  $xyz = md5("$tapelkd$smt$kelkd$i_swnis$mkode$i");
					
								
						//jika ada
						if (!empty($i_swnis))
							{
							//query
							mysqli_query($koneksi, "INSERT INTO siswa_nilai_smt(kd, siswa_kode, siswa_nama, ".
														"tapel, kelas, smt, ".
														"jenis, mapel_no, mapel_kode, ".
														"mapel_nama, p_ph_nilai, k_ph_nilai, ".
														"p_pts_nilai, k_pts_nilai, p_pas_nilai, ".
														"k_pas_nilai, p_na, p_na_pred, ".
														"k_na, k_na_pred, postdate) VALUES ".
														"('$xyz', '$i_swnis', '$i_swnama', ".
														"'$tapelkd', '$kelkd', '$smt', ".
														"'$mjenis', '$mno', '$mkode', ".
														"'$mnama', '$ph_p', '$ph_k', ".
														"'$i_pts_p', '$i_pts_k', '$i_pas_p', ".
														"'$i_pas_k', '$na_p', '$na_p_predikat', ".
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
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mjenis=$mjenis&mkode=$mkode&mnama=$mnama&smt=$smt&kat=$kat";
			xloc($ke);
			exit();
			}
		else
			{
			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mjenis=$mjenis&mkode=$mkode&mnama=$mnama&smt=$smt&s=import";
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

	$fileku = "nil_mapel-$mkode-smt-$smt.xls";





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
	$qku = mysqli_query($koneksi, "SELECT * FROM siswa_nilai_smt ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd' ".
										"AND smt = '$smt' ".
										"AND mapel_kode = '$mkode'");
	$rku = mysqli_fetch_assoc($qku);
	$i_postdate = balikin($rku['postdate']);





	
	//isi *START
	ob_start();
	

	

	echo '<div class="table-responsive">
	<h3>DAFTAR NILAI MAPEL PER SEMESTER</h3>

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

	echo '<b>'.$btxkelas2.' ['.$mkode.']</b>, 
	
	
	Semester : <b>'.$smt.'</b>
	
	
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
					<b>PH</b>
					<br>
					Bobot:2
					</p>
			</td>

			<td colspan="2">
					<p align="center">
					<b>PTS</b>
					<br>
					Bobot:1
					</p>
			</td>

			<td colspan="2">
					<p align="center">
					<b>PAS</b>
					<br>
					Bobot:1
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
			$qku = mysqli_query($koneksi, "SELECT AVG(nilai) AS ratanya ".
											"FROM siswa_nilai_bln ".
											"WHERE tapel = '$tapelkd' ".
											"AND kelas = '$kelkd' ".
											"AND smt = '$smt' ".
											"AND siswa_kode = '$i_nis' ".
											"AND mapel_kode = '$mkode' ".
											"AND kategori = 'PENGETAHUAN' ".
											"AND nilai <> '0'");
			$rku = mysqli_fetch_assoc($qku);
			$i_ph_p = round(balikin($rku['ratanya']));
			
			
			//rata nya
			$qku = mysqli_query($koneksi, "SELECT AVG(nilai) AS ratanya ".
											"FROM siswa_nilai_bln ".
											"WHERE tapel = '$tapelkd' ".
											"AND kelas = '$kelkd' ".
											"AND smt = '$smt' ".
											"AND siswa_kode = '$i_nis' ".
											"AND mapel_kode = '$mkode' ".
											"AND kategori = 'KETERAMPILAN' ".
											"AND nilai <> '0'");
			$rku = mysqli_fetch_assoc($qku);
			$i_ph_k = round(balikin($rku['ratanya']));
			


			//nilainya
			$qku = mysqli_query($koneksi, "SELECT * FROM siswa_nilai_smt ".
											"WHERE tapel = '$tapelkd' ".
											"AND kelas = '$kelkd' ".
											"AND smt = '$smt' ".
											"AND siswa_kode = '$i_nis' ".
											"AND mapel_kode = '$mkode'");
			$rku = mysqli_fetch_assoc($qku);
			$i_pts_p = round(balikin($rku['p_pts_nilai']));
			$i_pts_k = round(balikin($rku['k_pts_nilai']));
			$i_pas_p = round(balikin($rku['p_pas_nilai']));
			$i_pas_k = round(balikin($rku['k_pas_nilai']));
			

			$i_na_p = round(balikin($rku['p_na']));
			$i_na_p_pred = balikin($rku['p_na_pred']);
			$i_na_k = round(balikin($rku['k_na']));
			$i_na_k_pred = balikin($rku['k_na_pred']);

			
			
					
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
					'.$i_abs.'.
				</td>
				<td>
					'.$i_nis.'
				</td>
				<td>
					'.$i_nama.'
				</td>
				
				<td>'.$i_ph_p.'</td>
				<td>'.$i_ph_k.'</td>

				<td>'.$i_pts_p.'</td>
				<td>'.$i_pts_k.'</td>
				<td>'.$i_pas_p.'</td>
				<td>'.$i_pas_k.'</td>
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



Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
echo '<option value="'.$smt.'" selected>'.$smt.'</option>
<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smt=1">1</option>
<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smt=2">2</option>
</select>, 


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

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smt='.$smt.'&kelkd='.$btkelas1.'">'.$btkelas2.'</option>';
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

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smt='.$smt.'&kelkd='.$kelkd.'&mjenis='.$btkelas1.'">'.$btkelas2.'</option>';
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

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smt='.$smt.'&kelkd='.$kelkd.'&mjenis='.$mjenis.'&mnama='.$btkelas1.'&mkode='.$btkode.'">'.$btkelas2.' ['.$btkode.']</option>';
	}
while ($rowbt = mysqli_fetch_assoc($qbt));

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="mjenis" type="hidden" value="'.$mjenis.'">
<input name="mnama" type="hidden" value="'.$mnama.'">
<input name="mkode" type="hidden" value="'.$mkode.'">
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
			<input name="smt" type="hidden" value="'.$smt.'">
			<input name="kat" type="hidden" value="'.$kat.'">
					
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
		<input name="smt" type="hidden" value="'.$smt.'">
				
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
		$target = "$filenya?tapelkd=$tapelkd&smt=$smt&kelkd=$kelkd&mjenis=$mjenis&mnama=$mnama&mkode=$mkode";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
	
	
	
		
		//terpilih
		$qbtx = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
											"WHERE kode = '$mkode'");
		$rowbtx = mysqli_fetch_assoc($qbtx);
		$mno = cegah($rowbtx['no']);
		$mnama = cegah($rowbtx['nama']);
	
	
		//nilai
		$qku = mysqli_query($koneksi, "SELECT * FROM siswa_nilai_smt ".
											"WHERE tapel = '$tapelkd' ".
											"AND kelas = '$kelkd' ".
											"AND smt = '$smt' ".
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
							<b>PH</b>
							<br>
							Bobot:2
							</p>
					</td>

					<td colspan="2">
							<p align="center">
							<b>PTS</b>
							<br>
							Bobot:1
							</p>
					</td>

					<td colspan="2">
							<p align="center">
							<b>PAS</b>
							<br>
							Bobot:1
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
					$qku = mysqli_query($koneksi, "SELECT AVG(nilai) AS ratanya ".
													"FROM siswa_nilai_bln ".
													"WHERE tapel = '$tapelkd' ".
													"AND kelas = '$kelkd' ".
													"AND smt = '$smt' ".
													"AND siswa_kode = '$i_nis' ".
													"AND mapel_kode = '$mkode' ".
													"AND kategori = 'PENGETAHUAN' ".
													"AND nilai <> '0'");
					$rku = mysqli_fetch_assoc($qku);
					$i_ph_p = round(balikin($rku['ratanya']));
					
					
					//rata nya
					$qku = mysqli_query($koneksi, "SELECT AVG(nilai) AS ratanya ".
													"FROM siswa_nilai_bln ".
													"WHERE tapel = '$tapelkd' ".
													"AND kelas = '$kelkd' ".
													"AND smt = '$smt' ".
													"AND siswa_kode = '$i_nis' ".
													"AND mapel_kode = '$mkode' ".
													"AND kategori = 'KETERAMPILAN' ".
													"AND nilai <> '0'");
					$rku = mysqli_fetch_assoc($qku);
					$i_ph_k = round(balikin($rku['ratanya']));
					


					//nilainya
					$qku = mysqli_query($koneksi, "SELECT * FROM siswa_nilai_smt ".
													"WHERE tapel = '$tapelkd' ".
													"AND kelas = '$kelkd' ".
													"AND smt = '$smt' ".
													"AND siswa_kode = '$i_nis' ".
													"AND mapel_kode = '$mkode'");
					$rku = mysqli_fetch_assoc($qku);
					$i_pts_p = round(balikin($rku['p_pts_nilai']));
					$i_pts_k = round(balikin($rku['k_pts_nilai']));
					$i_pas_p = round(balikin($rku['p_pas_nilai']));
					$i_pas_k = round(balikin($rku['k_pas_nilai']));


					
					
					$i_na_p = round(((2 * $i_ph_p) + $i_pts_p + $i_pts_p) / 4); 
					$i_na_k = round(((2 * $i_ph_k) + $i_pts_k + $i_pts_k) / 4);   
			
			
			
					$i_na_p_pred = xpredikat($i_na_p);
					$i_na_k_pred = xpredikat($i_na_k);
			
					$i_ph_p2 = $i_ph_p;
					$i_ph_k2 = $i_ph_k;
					
					
			
					//update kan
					mysqli_query($koneksi, "UPDATE siswa_nilai_smt SET p_bln_rata = '$i_ph_p', ".
												"k_bln_rata = '$i_ph_k', ".
												"p_ph_nilai = '$i_ph_p2', ".
												"k_ph_nilai = '$i_ph_k2', ".
												"p_na = '$i_na_p', ".
												"p_na_pred = '$i_na_p_pred', ".
												"k_na = '$i_na_k', ".
												"k_na_pred = '$i_na_k_pred' ".
												"WHERE tapel = '$tapelkd' ".
												"AND kelas = '$kelkd' ".
												"AND smt = '$smt' ".
												"AND siswa_kode = '$i_nis' ".
												"AND mapel_kode = '$mkode'");
					
						
												
					/*
					$i_na_p = round(balikin($rku['p_na']));
					$i_na_p_pred = balikin($rku['p_na_pred']);
					$i_na_k = round(balikin($rku['k_na']));
					$i_na_k_pred = balikin($rku['k_na_pred']);
					*/
					
					
							
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
						<input name="ph_p'.$nomer.'" type="text" value="'.$i_ph_p.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-default" readonly>
						</td>
						<td>
						<input name="ph_k'.$nomer.'" type="text" value="'.$i_ph_k.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-default" readonly>
						</td>

						<td>
						<input name="pts_p'.$nomer.'" type="text" value="'.$i_pts_p.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-warning">
						</td>
						<td>
						<input name="pts_k'.$nomer.'" type="text" value="'.$i_pts_k.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-warning">
						</td>
						<td>
						<input name="pas_p'.$nomer.'" type="text" value="'.$i_pas_p.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-warning">
						</td>
						<td>
						<input name="pas_k'.$nomer.'" type="text" value="'.$i_pas_k.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-warning">
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