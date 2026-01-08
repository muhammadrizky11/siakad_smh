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
require("../../inc/cek/admgr.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admgr.html");





//nilai
$filenya = "nil_sumatif.php";
$judul = "Nilai Sumatif";
$judulku = "[KURMER]. $judul";
$judulx = $judul;
$tapelkd = cegah($_REQUEST['tapelkd']);
$kelkd = cegah($_REQUEST['kelkd']);
$mkode = cegah($_REQUEST['mkode']);
$mnama = cegah($_REQUEST['mnama']);
$smt = cegah($_REQUEST['smt']);
$s = cegah($_REQUEST['s']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mkode=$mkode&mnama=$mnama&smt=$smt&page=$page";



$limit = 5;


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
	$mkode = cegah($_POST['mkode']);
	$smt = cegah($_POST['smt']);
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
	$mkkm = cegah($rowbtx['kkm']);
		

		
		
	//hapus dulu, sebelum entri
	mysqli_query($koneksi, "DELETE FROM kurmer_nilai_asesmen_sumatif ".
								"WHERE tapel = '$tapelkd' ".
								"AND kelas = '$kelkd' ".
								"AND smt = '$smt' ".
								"AND kode = '$mkode'");	
		
		
			

	//hapus dulu, sebelum entri
	mysqli_query($koneksi, "DELETE FROM kurmer_nilai_asesmen_sumatif_detail ".
								"WHERE tapel = '$tapelkd' ".
								"AND kelas = '$kelkd' ".
								"AND smt = '$smt' ".
								"AND kode = '$mkode'");	
					
	
	
	
	for($i=1;$i<=$limit;$i++)
		{
		//ambil nilai
		$kd = "kdnya";
		$kd1 = "$kd$i";
		$kdx = nosql($_POST["$kd1"]);

		$abs = "nisnya";
		$abs1 = "$abs$i";
		$nisnya = cegah($_POST["$abs1"]);



		$abs = "as_non_tes";
		$abs1 = "$abs$nisnya";
		$as_non_tesx = cegah($_POST["$abs1"]);


		$abs = "as_tes";
		$abs1 = "$abs$nisnya";
		$as_tesx = cegah($_POST["$abs1"]);



		
		//terpilih
		$qbtx = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
											"WHERE kode = '$nisnya' ".
											"ORDER BY tapel DESC");
		$rowbtx = mysqli_fetch_assoc($qbtx);
		$swkd = cegah($rowbtx['kd']);
		$swnama = cegah($rowbtx['nama']);
			








		//ketahui jumlah lm
		$qjuk = mysqli_query($koneksi, "SELECT * FROM kurmer_mapel_lm ".
											"WHERE tapel = '$tapelkd' ".
											"AND kelas = '$kelkd' ".
											"AND kode = '$mkode' ".
											"AND lm_nama <> '' ".
											"ORDER BY round(lm_kode) ASC");
		$rjuk = mysqli_fetch_assoc($qjuk);
		$tjuk = mysqli_num_rows($qjuk);
		
		do
			{
			//nilai
			$juk_kode = cegah($rjuk['lm_kode']);
			$juk_nama = cegah($rjuk['lm_nama']);
							


			$abs = "pnilai";
			$abs1 = "$abs$nisnya$juk_kode";
			$pnilaix = cegah($_POST["$abs1"]);
			

			//entri baru
			$xyz = md5("$tapelkd$smt$kelkd$nisnya$mkode$juk_kode");
				
				
			//jika ada
			if (!empty($swnama))
				{
				//query
				mysqli_query($koneksi, "INSERT INTO kurmer_nilai_asesmen_sumatif_detail(kd, siswa_kd, siswa_nis, siswa_nama, ".
											"tapel, kelas, smt, ".
											"kode, nama, kktp, ".
											"lm_kode, lm_nama, lm_nilai, postdate) VALUES ".
											"('$xyz', '$swkd', '$nisnya', '$swnama', ".
											"'$tapelkd', '$kelkd', '$smt', ".
											"'$mkode', '$mnama', '$mkkm', ".
											"'$juk_kode', '$juk_nama', '$pnilaix', '$today')");
				}


			}
		while ($rjuk = mysqli_fetch_assoc($qjuk));
		
		
		
		
		
		
		
		
		

		//hitung rata
		$qyuk = mysqli_query($koneksi, "SELECT AVG(lm_nilai) AS ratanya ".
											"FROM kurmer_nilai_asesmen_sumatif_detail ".
											"WHERE siswa_kd = '$swkd' ".
											"AND siswa_nis = '$nisnya' ".
											"AND tapel = '$tapelkd' ".
											"AND kelas = '$kelkd' ".
											"AND smt = '$smt' ".
											"AND kode = '$mkode' ".
											"AND lm_nilai <> ''");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$yuk_rata = round(balikin($ryuk['ratanya']));


		//jika gak null
		if ((!empty($as_tesx)) AND (!empty($as_non_tesx)))
			{
			$as_na = round(($as_non_tesx + $as_tesx) / 2);
			$nil_raport = round(($yuk_rata + $as_na) / 2);
			}
			
		else
			{
			$as_na = 0;
			$nil_raport = 0;				
			}


		//entri baru
		$xyz = md5("$tapelkd$smt$kelkd$nisnya$mkode");
			
			
		//jika ada
		if (!empty($swnama))
			{
			//query
			mysqli_query($koneksi, "INSERT INTO kurmer_nilai_asesmen_sumatif(kd, siswa_kd, siswa_nis, siswa_nama, ".
										"tapel, kelas, smt, ".
										"kode, nama, kktp, lm_na, ".
										"as_non_tes, as_tes, as_na, ".
										"nil_raport, postdate) VALUES ".
										"('$xyz', '$swkd', '$nisnya', '$swnama', ".
										"'$tapelkd', '$kelkd', '$smt', ".
										"'$mkode', '$mnama', '$mkkm', '$yuk_rata', ".
										"'$as_non_tesx', '$as_tesx', '$as_na', ".
										"'$nil_raport', '$today')");
			}


		}

		
		
		
		
		
		
		
		


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mkode=$mkode&mnama=$mnama&smt=$smt&page=$page";
	xloc($ke);
	exit();
	}











//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$mkode = cegah($_POST['mkode']);
	$smt = cegah($_POST['smt']);


	//hapus
	mysqli_query($koneksi, "DELETE FROM kurmer_nilai_asesmen_sumatif ".
								"WHERE tapel = '$tapelkd' ".
								"AND kelas = '$kelkd' ".
								"AND smt = '$smt' ".
								"AND kode = '$mkode'");	

								
	//hapus
	mysqli_query($koneksi, "DELETE FROM kurmer_nilai_asesmen_sumatif_detail ".
								"WHERE tapel = '$tapelkd' ".
								"AND kelas = '$kelkd' ".
								"AND smt = '$smt' ".
								"AND kode = '$mkode'");	
								
								

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mkode=$mkode&mnama=$mnama&smt=$smt";
	xloc($ke);
	exit();
	}
	
	
	
	
	
	
	
//jika import
if ($_POST['btnIM'])
	{
	//nilai
	$tapelkd = cegah($_POST['tapelkd']);
	$kelkd = cegah($_POST['kelkd']);
	$mkode = cegah($_POST['mkode']);
	$smt = cegah($_POST['smt']);
	
	
	
	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mkode=$mkode&mnama=$mnama&smt=$smt&s=import";
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
	$mkkm = cegah($rowbtx['kkm']);
	$mnama = cegah($rowbtx['nama']);
	

		
	
	$filex_namex2 = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex2))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mkode=$mkode&mnama=$mnama&smt=$smt&s=import";
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


			//require
			require('../../inc/class/PHPExcel.php');
			require('../../inc/class/PHPExcel/IOFactory.php');



		
		
			//hapus dulu, sebelum entri
			mysqli_query($koneksi, "DELETE FROM kurmer_nilai_asesmen_sumatif ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd' ".
										"AND smt = '$smt' ".
										"AND kode = '$mkode'");	
				
				
					
		
			//hapus dulu, sebelum entri
			mysqli_query($koneksi, "DELETE FROM kurmer_nilai_asesmen_sumatif_detail ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd' ".
										"AND smt = '$smt' ".
										"AND kode = '$mkode'");	


			  // load excel
			  $load = PHPExcel_IOFactory::load($uploadfile);
			  $sheets = $load->getActiveSheet()->toArray(null,true,true,true);
			
			  $i = 1;
			  foreach ($sheets as $sheet) 
			  	{
			    // karena data yang di excel di mulai dari baris ke 6
			    // maka jika $i lebih dari 1 data akan di masukan ke database
			    if ($i > 7) 
			    	{
				      // nama ada di kolom A
				      // sedangkan alamat ada di kolom B
				      $i_xyz = md5("$x$i");
				      $i_no = cegah($sheet['A']);
				      $i_swnis = cegah($sheet['B']);
				      $i_swnama = cegah($sheet['C']);
				      

						//terpilih
						$qbtx = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
															"WHERE kode = '$i_swnis' ".
															"ORDER BY tapel DESC");
						$rowbtx = mysqli_fetch_assoc($qbtx);
						$swkd = cegah($rowbtx['kd']);

					
						

						//ketahui jumlah tp
						$qjuk = mysqli_query($koneksi, "SELECT * FROM kurmer_mapel_lm ".
															"WHERE tapel = '$tapelkd' ".
															"AND kelas = '$kelkd' ".
															"AND smt = '$smt' ".
															"AND kode = '$mkode' ".
															"AND lm_nama <> '' ".
															"ORDER BY round(lm_kode) ASC");
						$rjuk = mysqli_fetch_assoc($qjuk);
						$tjuk = mysqli_num_rows($qjuk);
						
						do
							{
							//nilai
							$juk_kode = cegah($rjuk['lm_kode']);
							$juk_nama = cegah($rjuk['lm_nama']);
											

									
							$knomer = $knomer + 1;
							

							//mulai D
							$knomerku = $knomer + 3;
							
							$i_hurufnya = $arrrkoloma[$knomerku];
						  	$pnilaix = cegah($sheet[$i_hurufnya]);				
									
								

							//entri baru
							$xyz = md5("$tapelkd$smt$kelkd$i_swnis$mkode$juk_kode");
							
				
							//jika ada
							if (!empty($i_swnama))
								{
								//query
								mysqli_query($koneksi, "INSERT INTO kurmer_nilai_asesmen_sumatif_detail(kd, siswa_kd, siswa_nis, siswa_nama, ".
															"tapel, kelas, smt, ".
															"kode, nama, kktp, ".
															"lm_kode, lm_nama, lm_nilai, postdate) VALUES ".
															"('$xyz', '$swkd', '$i_swnis', '$i_swnama', ".
															"'$tapelkd', '$kelkd', '$smt', ".
															"'$mkode', '$mnama', '$mkkm', ".
															"'$juk_kode', '$juk_nama', '$pnilaix', '$today')");
								}

							}
						while ($rjuk = mysqli_fetch_assoc($qjuk));







					$knomerku2 = $tjuk + 3 + 1;
					$i_hurufnya = $arrrkoloma[$knomerku2];
					$as_non_tesx = cegah($sheet[$i_hurufnya]);
			
					echo "$tjuk:$knomerku2:$i_hurufnya <br>";
			
					$knomerku2 = $tjuk + 3 + 2;
					$i_hurufnya = $arrrkoloma[$knomerku2];
					$as_tesx = cegah($sheet[$i_hurufnya]);


					//entri baru
					$xyz = md5("$tapelkd$smt$kelkd$i_swnis$mkode");

						

		
					
			
					//hitung rata
					$qyuk = mysqli_query($koneksi, "SELECT AVG(lm_nilai) AS ratanya ".
														"FROM kurmer_nilai_asesmen_sumatif_detail ".
														"WHERE siswa_kd = '$swkd' ".
														"AND siswa_nis = '$i_swnis' ".
														"AND tapel = '$tapelkd' ".
														"AND kelas = '$kelkd' ".
														"AND smt = '$smt' ".
														"AND kode = '$mkode' ".
														"AND lm_nilai <> ''");
					$ryuk = mysqli_fetch_assoc($qyuk);
					$yuk_rata = round(balikin($ryuk['ratanya']));
			
			
					//jika gak null
					if ((!empty($as_tesx)) AND (!empty($as_non_tesx)))
						{
						$as_na = round(($as_non_tesx + $as_tesx) / 2);
						$nil_raport = round(($yuk_rata + $as_na) / 2);
						}
						
					else
						{
						$as_na = 0;
						$nil_raport = 0;				
						}
			
			
					//entri baru
					$xyz = md5("$tapelkd$smt$kelkd$nisnya$mkode");
						
						
					//jika ada
					if (!empty($i_swnama))
						{
						//query
						mysqli_query($koneksi, "INSERT INTO kurmer_nilai_asesmen_sumatif(kd, siswa_kd, siswa_nis, siswa_nama, ".
													"tapel, kelas, smt, ".
													"kode, nama, kktp, lm_na, ".
													"as_non_tes, as_tes, as_na, ".
													"nil_raport, postdate) VALUES ".
													"('$xyz', '$swkd', '$i_swnis', '$i_swnama', ".
													"'$tapelkd', '$kelkd', '$smt', ".
													"'$mkode', '$mnama', '$mkkm', '$yuk_rata', ".
													"'$as_non_tesx', '$as_tesx', '$as_na', ".
													"'$nil_raport', '$today')");
						}
			



			
					$knomer2 = 0;
				    }


				$knomer = 0;
				echo "<br>";
			
			    $i++;
			  }





			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0777);
			unlink ($path1);


			//re-direct
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mkode=$mkode&mnama=$mnama&smt=$smt";
			xloc($ke);
			exit();
			}
		else
			{
			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&mkode=$mkode&mnama=$mnama&smt=$smt&s=import";
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
	$mkode = cegah($_POST['mkode']);
	$smt = cegah($_POST['smt']);
	$page = nosql($_POST['page']);

	
	//terpilih
	$qbtx = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
										"WHERE kode = '$mkode'");
	$rowbtx = mysqli_fetch_assoc($qbtx);
	$mno = cegah($rowbtx['no']);
	$mnama = cegah($rowbtx['nama']);

	$fileku = "asesmen_sumatif-$mkode.xls";





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
	$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_nilai_asesmen_sumatif_detail ".
										"WHERE tapel = '$tapelkd' ".
										"AND kelas = '$kelkd' ".
										"AND smt = '$smt' ".
										"AND kode = '$mkode'");
	$rku = mysqli_fetch_assoc($qku);
	$i_postdate = balikin($rku['postdate']);





	
	//isi *START
	ob_start();
	

	

	echo '<div class="table-responsive">
	<h3>DAFTAR NILAI ASESMEN SUMATIF</h3>

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
			</td>';
			
			//ketahui jumlah tp
			$qjuk = mysqli_query($koneksi, "SELECT * FROM kurmer_mapel_lm ".
												"WHERE tapel = '$tapelkd' ".
												"AND kelas = '$kelkd' ".
												"AND kode = '$mkode' ".
												"AND smt = '$smt' ".
												"AND lm_nama <> '' ".
												"ORDER BY round(lm_kode) ASC");
			$tjuk = mysqli_num_rows($qjuk);
			$tjukx = $tjuk + 1;

				echo '<td colspan="'.$tjukx.'">
					<p align="center"><b>Sumatif Akhir Lingkup Materi (Wajib)</b></p>
				</td>';


		echo '<td colspan="3">
				<p align="center"><b>Sumatif Akhir Semester (Tidak Wajib)</b></p>
		</td>
		
		<td rowspan="2" width="200">
			<p align="center"><b>NILAI RAPOR</b></p>
		</td>
		</tr>
		<tr valign="top" bgcolor="'.$warnaheader.'">';

			//ketahui jumlah tp
			$qjuk = mysqli_query($koneksi, "SELECT * FROM kurmer_mapel_lm ".
												"WHERE tapel = '$tapelkd' ".
												"AND kelas = '$kelkd' ".
												"AND kode = '$mkode' ".
												"AND smt = '$smt' ".
												"AND lm_nama <> '' ".
												"ORDER BY round(lm_kode) ASC");
			$rjuk = mysqli_fetch_assoc($qjuk);
			$tjuk = mysqli_num_rows($qjuk);
			
			do
				{
				//nilai
				$juk_kode = balikin($rjuk['lm_kode']);
				$juk_nama = balikin($rjuk['lm_nama']);
				
				
				echo '<td>
					<p align="center"><b>Sumatif<br>'.$juk_kode.'</b></p>
				</td>';
				}
			while ($rjuk = mysqli_fetch_assoc($qjuk));
		
		echo '<td>
		<p align="center"><b>NA Sumatif</b></p>
		</td>
				
		<td>
		<p align="center"><b>Non Tes</b></p>
		</td>
		<td>
		<p align="center"><b>Tes</b></p>
		</td>
		<td>
		<p align="center"><b>NA Sumatif Akhir Semester</b></p>
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



			//nilai
			$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_nilai_asesmen_sumatif ".
												"WHERE tapel = '$tapelkd' ".
												"AND kelas = '$kelkd' ".
												"AND smt = '$smt' ".
												"AND siswa_nis = '$i_nis' ".
												"AND kode = '$mkode'");
			$rku = mysqli_fetch_assoc($qku);
			$i_lm_na = balikin($rku['lm_na']);
			$i_as_non_tes = balikin($rku['as_non_tes']);
			$i_as_tes = balikin($rku['as_tes']);
			$i_as_na = balikin($rku['as_na']);
			$i_nil_raport = balikin($rku['nil_raport']);




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

				//ketahui jumlah lm
				$qjuk = mysqli_query($koneksi, "SELECT * FROM kurmer_mapel_lm ".
													"WHERE tapel = '$tapelkd' ".
													"AND kelas = '$kelkd' ".
													"AND kode = '$mkode' ".
													"AND smt = '$smt' ".
													"AND lm_nama <> '' ".
													"ORDER BY round(lm_kode) ASC");
				$rjuk = mysqli_fetch_assoc($qjuk);
				$tjuk = mysqli_num_rows($qjuk);
				
				do
					{
					//nilai
					$juk_kode = balikin($rjuk['lm_kode']);
					$juk_nama = balikin($rjuk['lm_nama']);
					

					//nilai
					$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_nilai_asesmen_sumatif_detail ".
														"WHERE tapel = '$tapelkd' ".
														"AND kelas = '$kelkd' ".
														"AND smt = '$smt' ".
														"AND siswa_nis = '$i_nis' ".
														"AND kode = '$mkode' ".
														"AND lm_kode = '$juk_kode'");
					$rku = mysqli_fetch_assoc($qku);
					$i_pnilai = balikin($rku['lm_nilai']);

		
					echo '<td>'.$i_pnilai.'</td>';								
					}
				while ($rjuk = mysqli_fetch_assoc($qjuk));
				
				
				
			echo '<td>'.$i_lm_na.'</td>
			<td>'.$i_as_non_tes.'</td>
			<td>'.$i_as_tes.'</td>
			<td>'.$i_as_na.'</td>
			<td>'.$i_nil_raport.'</td>
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

$qtp = mysqli_query($koneksi, "SELECT DISTINCT(tapel) AS tapelnya ".
								"FROM m_mapel ".
								"WHERE pegawai_kd = '$kd1_session' ".
								"ORDER BY tapel DESC");
$rowtp = mysqli_fetch_assoc($qtp);

do
	{
	$tpth1 = cegah($rowtp['tapelnya']);
	$tpth2 = balikin($rowtp['tapelnya']);

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

$qbt = mysqli_query($koneksi, "SELECT DISTINCT(kelas) AS kelasnya ".
								"FROM m_mapel ".
								"WHERE pegawai_kd = '$kd1_session' ".
								"ORDER BY kelas ASC");
$rowbt = mysqli_fetch_assoc($qbt);

do
	{
	$btkelas1 = cegah($rowbt['kelasnya']);
	$btkelas2 = balikin($rowbt['kelasnya']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smt='.$smt.'&kelkd='.$btkelas1.'">'.$btkelas2.'</option>';
	}
while ($rowbt = mysqli_fetch_assoc($qbt));

echo '</select>
</td>
</tr>

<tr>
<td>

Mata Pelajaran : ';
echo "<select name=\"mapel\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";

//terpilih
$qbtx = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
									"WHERE tapel = '$tapelkd' ".
									"AND kelas = '$kelkd' ".
									"AND kode = '$mkode'");
$rowbtx = mysqli_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkelas1 = cegah($rowbtx['nama']);
$btxkelas2 = balikin($rowbtx['nama']);

echo '<option value="'.$btxkelas1.'">'.$btxkelas2.' ['.$mkode.']</option>';

$qbt = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
								"WHERE pegawai_kd = '$kd1_session' ".
								"AND tapel = '$tapelkd' ".
								"AND kelas = '$kelkd' ".
								"ORDER BY nama ASC");
$rowbt = mysqli_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkode = balikin($rowbt['kode']);
	$btkelas1 = cegah($rowbt['nama']);
	$btkelas2 = balikin($rowbt['nama']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&smt='.$smt.'&kelkd='.$kelkd.'&mnama='.$btkelas1.'&mkode='.$btkode.'">'.$btkelas2.' ['.$btkode.']</option>';
	}
while ($rowbt = mysqli_fetch_assoc($qbt));

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
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
			<input name="mnama" type="hidden" value="'.$mnama.'">
			<input name="mkode" type="hidden" value="'.$mkode.'">
			<input name="smt" type="hidden" value="'.$smt.'">
					
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
		$target = "$filenya?tapelkd=$tapelkd&smt=$smt&kelkd=$kelkd&mnama=$mnama&mkode=$mkode";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
	
	
	
		
		//terpilih
		$qbtx = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
											"WHERE kode = '$mkode'");
		$rowbtx = mysqli_fetch_assoc($qbtx);
		$mno = cegah($rowbtx['no']);
		$mnama = cegah($rowbtx['nama']);
	
	
		//nilai
		$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_nilai_asesmen_sumatif_detail ".
											"WHERE tapel = '$tapelkd' ".
											"AND kelas = '$kelkd' ".
											"AND smt = '$smt' ".
											"AND kode = '$mkode'");
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
					
					//ketahui jumlah tp
					$qjuk = mysqli_query($koneksi, "SELECT * FROM kurmer_mapel_lm ".
														"WHERE tapel = '$tapelkd' ".
														"AND kelas = '$kelkd' ".
														"AND kode = '$mkode' ".
														"AND smt = '$smt' ".
														"AND lm_nama <> '' ".
														"ORDER BY round(lm_kode) ASC");
					$tjuk = mysqli_num_rows($qjuk);
					$tjukx = $tjuk + 1;
		
						echo '<td colspan="'.$tjukx.'">
							<p align="center"><b>Sumatif Akhir Lingkup Materi (Wajib)</b></p>
						</td>';

		
				echo '<td colspan="3">
						<p align="center"><b>Sumatif Akhir Semester (Tidak Wajib)</b></p>
				</td>
				
				<td rowspan="2" width="200">
					<p align="center"><b>NILAI RAPOR</b></p>
				</td>
				</tr>
				<tr valign="top" bgcolor="'.$warnaheader.'">';

					//ketahui jumlah tp
					$qjuk = mysqli_query($koneksi, "SELECT * FROM kurmer_mapel_lm ".
														"WHERE tapel = '$tapelkd' ".
														"AND kelas = '$kelkd' ".
														"AND kode = '$mkode' ".
														"AND smt = '$smt' ".
														"AND lm_nama <> '' ".
														"ORDER BY round(lm_kode) ASC");
					$rjuk = mysqli_fetch_assoc($qjuk);
					$tjuk = mysqli_num_rows($qjuk);
					
					do
						{
						//nilai
						$juk_kode = balikin($rjuk['lm_kode']);
						$juk_nama = balikin($rjuk['lm_nama']);
						
						
						echo '<td>
							<p align="center"><b>Sumatif<br>'.$juk_kode.'</b></p>
						</td>';
						}
					while ($rjuk = mysqli_fetch_assoc($qjuk));
				
				echo '<td>
				<p align="center"><b>NA Sumatif</b></p>
				</td>
						
				<td>
				<p align="center"><b>Non Tes</b></p>
				</td>
				<td>
				<p align="center"><b>Tes</b></p>
				</td>
				<td>
				<p align="center"><b>NA Sumatif Akhir Semester</b></p>
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
		

		
					//nilai
					$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_nilai_asesmen_sumatif ".
														"WHERE tapel = '$tapelkd' ".
														"AND kelas = '$kelkd' ".
														"AND smt = '$smt' ".
														"AND siswa_nis = '$i_nis' ".
														"AND kode = '$mkode'");
					$rku = mysqli_fetch_assoc($qku);
					$i_lm_na = balikin($rku['lm_na']);
					$i_as_non_tes = balikin($rku['as_non_tes']);
					$i_as_tes = balikin($rku['as_tes']);
					$i_as_na = balikin($rku['as_na']);
					$i_nil_raport = balikin($rku['nil_raport']);
		


		
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
						</td>';

						//ketahui jumlah lm
						$qjuk = mysqli_query($koneksi, "SELECT * FROM kurmer_mapel_lm ".
															"WHERE tapel = '$tapelkd' ".
															"AND kelas = '$kelkd' ".
															"AND kode = '$mkode' ".
															"AND smt = '$smt' ".
															"AND lm_nama <> '' ".
															"ORDER BY round(lm_kode) ASC");
						$rjuk = mysqli_fetch_assoc($qjuk);
						$tjuk = mysqli_num_rows($qjuk);
						
						do
							{
							//nilai
							$juk_kode = balikin($rjuk['lm_kode']);
							$juk_nama = balikin($rjuk['lm_nama']);
							

							//nilai
							$qku = mysqli_query($koneksi, "SELECT * FROM kurmer_nilai_asesmen_sumatif_detail ".
																"WHERE tapel = '$tapelkd' ".
																"AND kelas = '$kelkd' ".
																"AND smt = '$smt' ".
																"AND siswa_nis = '$i_nis' ".
																"AND kode = '$mkode' ".
																"AND lm_kode = '$juk_kode'");
							$rku = mysqli_fetch_assoc($qku);
							$i_pnilai = balikin($rku['lm_nilai']);

				
							echo '<td>
							<input name="pnilai'.$i_nis.''.$juk_kode.'" type="text" value="'.$i_pnilai.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-warning">
							</td>';								
							}
						while ($rjuk = mysqli_fetch_assoc($qjuk));
						
						
						
					echo '<td>
					<input name="lm_na'.$i_nis.'" type="text" value="'.$i_lm_na.'" size="2" maxlength="5" class="btn btn-default" readonly>
					</td>
					<td>
					<input name="as_non_tes'.$i_nis.'" type="text" value="'.$i_as_non_tes.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-warning">
					</td>
					<td>
					<input name="as_tes'.$i_nis.'" type="text" value="'.$i_as_tes.'" size="2" maxlength="5" onKeyPress="return numbersonly(this, event)" class="btn btn-warning">
					</td>
					<td>
					<input name="as_na'.$i_nis.'" type="text" value="'.$i_as_na.'" size="2" maxlength="5" class="btn btn-default" readonly>
					</td>
					<td>
					<input name="raport'.$i_nis.'" type="text" value="'.$i_nil_raport.'" size="2" maxlength="5" class="btn btn-default" readonly>
					</td>';
					
						
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