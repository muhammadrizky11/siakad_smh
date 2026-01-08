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



//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adminv.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/adminv.html");





//nilai
$filenya = "sarpras.php";
$judul = "K.I.B";
$judulku = "[INVENTARIS] $judul";
$juduli = $judul;
$s = cegah($_REQUEST['s']);
$katkd = cegah($_REQUEST['katkd']);
$kunci = cegah($_REQUEST['kunci']);
$kunci2 = balikin($_REQUEST['kunci']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}









//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika import
if ($_POST['btnIM'])
	{
	//nilai
	$katkd = cegah($_POST['katkd']);

	//re-direct
	$ke = "$filenya?katkd=$katkd&s=import";
	xloc($ke);
	exit();
	}







//import sekarang
if ($_POST['btnIMX'])
	{
	//nilai
	$katkd = cegah($_POST['katkd']);
	$filex_namex2 = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex2))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?katkd=$katkd&s=import";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .xls
		$ext_filex = substr($filex_namex2, -4);

		if ($ext_filex == ".csv")
			{
			//nilai
			$path1 = "../../filebox";
			$path2 = "../../filebox/excel";
			chmod($path1,0777);
			chmod($path2,0777);

			//nama file import, diubah menjadi baru...
			$filex_namex2 = "kib-$katkd.csv";

			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex2");

			//chmod
            $path3 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0755);
			chmod($path2,0777);
			chmod($path3,0777);

			//file-nya...
			$uploadfile = $path3;


			
			
			
			//jika kib-A ///////////////////////////////////////////////////////////////////////////////
			if ($katkd == "A")
				{
				if (($handle = fopen($uploadfile, "r")) !== FALSE) {
					$row = 1;
				    while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
							  $i_no = $i_no + 1;
						      $i_no = cegah(strip_tags($data[0]));
						      $i_kode = cegah(strip_tags($data[1]));
						      $i_nama = cegah(strip_tags($data[2]));
						      $i_register = cegah(strip_tags($data[3]));
						      $i_luas = cegah(strip_tags($data[4]));
						      $i_tahun = cegah(strip_tags($data[5]));
						      $i_alamat = cegah(strip_tags($data[6]));
						      $i_status_hak = cegah(strip_tags($data[7]));
						      $i_sertifikat_tgl = cegah(strip_tags($data[8]));
						      $i_sertifikat_no = cegah(strip_tags($data[9]));
						      $i_penggunaan = cegah(strip_tags($data[10]));
						      $i_asal_usul = cegah(strip_tags($data[11]));
						      $i_harga = cegah(strip_tags($data[12]));
						      $i_ket = cegah(strip_tags($data[13]));
							  	$i_x1 = md5($i_kode);
								$i_xyz = "$sekkd83_session$i_x1";

							  
								//insert
								mysqli_query($koneksi, "INSERT INTO inv_kib_a(kd, per_tahun, barang_kode, barang_nama, ".
												"register, luas, tahun_ada, ".
												"alamat, status_hak, status_sertifikat_tgl, ".
												"status_sertifikat_nomor, penggunaan, asal_usul, ".
												"harga, ket, postdate) VALUES ".
												"('$i_xyz', '$sekkd83_session', '$e_sekkode', '$e_seknama', ".
												"'$tahun', '$i_kode', '$i_nama', ".
												"'$i_register', '$i_luas', '$i_tahun', ".
												"'$i_alamat', '$i_status_hak', '$i_sertifikat_tgl', ".
												"'$i_sertifikat_no', '$i_penggunaan', '$i_asal_usul', ".
												"'$i_harga', '$i_ket', '$today')");
							  
						
	
							}
					}			
			    } 


						
			//jika kib-B ///////////////////////////////////////////////////////////////////////////////
			else if ($katkd == "B")
				{
				if (($handle = fopen($uploadfile, "r")) !== FALSE) {
					$row = 1;
				    while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
							  $i_no = $i_no + 1;
						      $i_no = cegah(strip_tags($data[0]));
						      $i_kode = cegah(strip_tags($data[1]));
						      $i_nama = cegah(strip_tags($data[2]));
						      $i_register = cegah(strip_tags($data[3]));
						      $i_jumlah = cegah(strip_tags($data[4]));
						      $i_satuan = cegah(strip_tags($data[5]));
						      $i_merk = cegah(strip_tags($data[6]));
						      $i_ukuran_cc = cegah(strip_tags($data[7]));
						      $i_bahan = cegah(strip_tags($data[8]));
						      $i_tahun_beli = cegah(strip_tags($data[9]));
						      $i_no_pabrik = cegah(strip_tags($data[10]));
						      $i_no_rangka = cegah(strip_tags($data[11]));
						      $i_no_mesin = cegah(strip_tags($data[12]));
						      $i_no_polisi = cegah(strip_tags($data[13]));
						      $i_no_bpkb = cegah(strip_tags($data[14]));

						      $i_asal_usul = cegah(strip_tags($data[15]));
						      $i_harga = cegah(strip_tags($data[16]));
						      $i_ket = cegah(strip_tags($data[17]));
							  	$i_x1 = md5($i_kode);
								$i_xyz = "$sekkd83_session$i_x1";

							  
								//insert
								mysqli_query($koneksi, "INSERT INTO inv_kib_b(kd, per_tahun, barang_kode, barang_nama, ".
												"register, jumlah, satuan, ".
												"merk_type, ukuran_cc, bahan, ".
												"tahun_beli, nomor_pabrik, nomor_rangka, ".
												"nomor_mesin, nomor_polisi, nomor_bpkb, ".
												"asal_usul, harga, ket, postdate) VALUES ".
												"('$i_xyz', '$sekkd83_session', '$e_sekkode', '$e_seknama', ".
												"'$tahun', '$i_kode', '$i_nama', ".
												"'$i_register', '$i_jumlah', '$i_satuan', ".
												"'$i_merk', '$i_ukuran_cc', '$i_bahan', ".
												"'$i_tahun_beli', '$i_no_pabrik', '$i_no_rangka', ".
												"'$i_no_mesin', '$i_no_polisi', '$i_no_bpkb', ".
												"'$i_asal_usul', '$i_harga', '$i_ket', '$today')");
							  
						
	
							}
					}			
			    } 
			
			
			








						
			//jika kib-C ///////////////////////////////////////////////////////////////////////////////
			else if ($katkd == "C")
				{
				if (($handle = fopen($uploadfile, "r")) !== FALSE) {
					$row = 1;
				    while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
							  $i_no = $i_no + 1;
						      $i_no = cegah(strip_tags($data[0]));
						      $i_kode = cegah(strip_tags($data[1]));
						      $i_nama = cegah(strip_tags($data[2]));
						      $i_register = cegah(strip_tags($data[3]));

								$i_kondisi = cegah(strip_tags($data[4]));
								$i_kontruksi_tingkat = cegah(strip_tags($data[5]));
								$i_kontruksi_beton = cegah(strip_tags($data[6]));
								$i_luas_lantai = cegah(strip_tags($data[7]));
								$i_alamat = cegah(strip_tags($data[8]));
								$i_dokumen_tgl = cegah(strip_tags($data[9]));
								$i_dokumen_nomor = cegah(strip_tags($data[10]));
								$i_tanah_luas = cegah(strip_tags($data[11]));
								$i_tanah_status = cegah(strip_tags($data[12]));
								$i_tanah_kode = cegah(strip_tags($data[13]));
								$i_asal_usul = cegah(strip_tags($data[14]));
								$i_tahun_ada = cegah(strip_tags($data[15]));
					

						      	$i_harga = cegah(strip_tags($data[16]));
						      	$i_ket = cegah(strip_tags($data[17]));
							  	$i_x1 = md5($i_kode);
								$i_xyz = "$sekkd83_session$i_x1";
							  
								//insert
								mysqli_query($koneksi, "INSERT INTO inv_kib_c(kd, per_tahun, barang_kode, barang_nama, ".
												"register, kondisi, kontruksi_tingkat, ".
												"kontruksi_beton, luas_lantai, alamat, ".
												"dokumen_tgl, dokumen_nomor, tanah_luas, ".
												"tanah_status, tanah_kode, tahun_ada, ".
												"asal_usul, harga, ket, postdate) VALUES ".
												"('$i_xyz', '$sekkd83_session', '$e_sekkode', '$e_seknama', ".
												"'$tahun', '$i_kode', '$i_nama', ".
												"'$i_register', '$i_kondisi', '$i_kontruksi_tingkat', ".
												"'$i_kontruksi_beton', '$i_luas_lantai', '$i_alamat', ".
												"'$i_dokumen_tgl', '$i_dokumen_nomor', '$i_tanah_luas', ".
												"'$i_tanah_status', '$i_tanah_kode', '$i_tahun_ada', ".
												"'$i_asal_usul', '$i_harga', '$i_ket', '$today')");
							  
						
	
							}
					}			
			    } 
			
			










						
			//jika kib-D ///////////////////////////////////////////////////////////////////////////////
			else if ($katkd == "D")
				{
				if (($handle = fopen($uploadfile, "r")) !== FALSE) {
					$row = 1;
				    while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
							  $i_no = $i_no + 1;
						      $i_no = cegah(strip_tags($data[0]));
						      $i_kode = cegah(strip_tags($data[1]));
						      $i_nama = cegah(strip_tags($data[2]));
						      $i_register = cegah(strip_tags($data[3]));

								$i_kontruksi = cegah(strip_tags($data[4]));
								$i_panjang = cegah(strip_tags($data[5]));
								$i_lebar = cegah(strip_tags($data[6]));
								$i_luas = cegah(strip_tags($data[7]));
								$i_lokasi = cegah(strip_tags($data[8]));
								$i_dokumen_tgl = cegah(strip_tags($data[9]));
								$i_dokumen_nomor = cegah(strip_tags($data[10]));
								$i_tanah_status = cegah(strip_tags($data[11]));
								$i_tanah_kode = cegah(strip_tags($data[12]));
								$i_asal_usul = cegah(strip_tags($data[13]));
								$i_tahun_ada = cegah(strip_tags($data[14]));
								$i_harga = cegah(strip_tags($data[15]));
								$i_kondisi = cegah(strip_tags($data[16]));

						      	$i_ket = cegah(strip_tags($data[17]));
							  	$i_x1 = md5($i_kode);
								$i_xyz = "$sekkd83_session$i_x1";
							  
								//insert
								mysqli_query($koneksi, "INSERT INTO inv_kib_d(kd, per_tahun, barang_kode, barang_nama, ".
												"register, kontruksi, panjang, ".
												"lebar, luas, lokasi, dokumen_tgl, ".
												"dokumen_nomor, tanah_status, tanah_kode, ".
												"asal_usul, tahun_ada, harga, kondisi, ket, postdate) VALUES ".
												"('$i_xyz', '$sekkd83_session', '$e_sekkode', '$e_seknama', ".
												"'$tahun', '$i_kode', '$i_nama', ".
												"'$i_register', '$i_kontruksi', '$i_panjang', ".
												"'$i_lebar', '$i_luas', '$i_lokasi', '$i_dokumen_tgl', ".
												"'$i_dokumen_nomor', '$i_tanah_status', '$i_tanah_kode', ".
												"'$i_asal_usul', '$i_tahun_ada', '$i_harga', '$i_kondisi', '$i_ket', '$today')");
							  
						
	
							}
					}			
			    } 
			
			






						
			//jika kib-E ///////////////////////////////////////////////////////////////////////////////
			else if ($katkd == "E")
				{
				if (($handle = fopen($uploadfile, "r")) !== FALSE) {
					$row = 1;
				    while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
							  $i_no = $i_no + 1;
						      $i_no = cegah(strip_tags($data[0]));
						      $i_kode = cegah(strip_tags($data[1]));
						      $i_nama = cegah(strip_tags($data[2]));
						      $i_register = cegah(strip_tags($data[3]));

								$i_buku_judul = cegah(strip_tags($data[4]));
								$i_buku_spek = cegah(strip_tags($data[5]));
								$i_corak_asal = cegah(strip_tags($data[6]));
								$i_corak_pencipta = cegah(strip_tags($data[7]));
								$i_corak_bahan = cegah(strip_tags($data[8]));
								$i_hewan_jenis = cegah(strip_tags($data[9]));
								$i_hewan_ukuran = cegah(strip_tags($data[10]));
								$i_jumlah = cegah(strip_tags($data[11]));
								$i_tahun_cetak = cegah(strip_tags($data[12]));
								$i_asal_usul = cegah(strip_tags($data[13]));
								$i_tahun_beli = cegah(strip_tags($data[14]));
								$i_harga = cegah(strip_tags($data[15]));
						      	$i_ket = cegah(strip_tags($data[16]));
							  	$i_x1 = md5($i_kode);
								$i_xyz = "$sekkd83_session$i_x1";
							  
								//insert
								mysqli_query($koneksi, "INSERT INTO inv_kib_e(kd, per_tahun, barang_kode, barang_nama, ".
												"register, buku_judul, buku_spek, ".
												"corak_asal, corak_pencipta, corak_bahan, ".
												"hewan_jenis, hewan_ukuran, jumlah, ".
												"tahun_cetak, asal_usul, tahun_beli, harga, ket, postdate) VALUES ".
												"('$i_xyz', '$sekkd83_session', '$e_sekkode', '$e_seknama', ".
												"'$tahun', '$i_kode', '$i_nama', ".
												"'$i_register', '$i_buku_judul', '$i_buku_spek', ".
												"'$i_corak_asal', '$i_corak_pencipta', '$i_corak_bahan', ".
												"'$i_hewan_jenis', '$i_hewan_ukuran', '$i_jumlah', ".
												"'$i_tahun_cetak', '$i_asal_usul', '$i_tahun_beli', '$i_harga', '$i_ket', '$today')");
							  
						
	
							}
					}			
			    } 
			
			







						
			//jika kib-F ///////////////////////////////////////////////////////////////////////////////
			else if ($katkd == "F")
				{
				if (($handle = fopen($uploadfile, "r")) !== FALSE) {
					$row = 1;
				    while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
							  $i_no = $i_no + 1;
						      $i_no = cegah(strip_tags($data[0]));
						      $i_kode = cegah(strip_tags($data[1]));
						      $i_nama = cegah(strip_tags($data[2]));
						      $i_register = cegah(strip_tags($data[3]));

								$i_kontruksi_tingkat = cegah(strip_tags($data[4]));
								$i_kontruksi_beton = cegah(strip_tags($data[5]));
								$i_luas = cegah(strip_tags($data[6]));
								$i_alamat = cegah(strip_tags($data[7]));
								$i_dokumen_tgl = cegah(strip_tags($data[8]));
								$i_dokumen_nomor = cegah(strip_tags($data[9]));
								$i_mulai_tgl = cegah(strip_tags($data[10]));
								$i_tanah_status = cegah(strip_tags($data[11]));
								$i_tanah_kode = cegah(strip_tags($data[12]));
								$i_asal_usul = cegah(strip_tags($data[13]));
																
								$i_harga = cegah(strip_tags($data[14]));
						      	$i_ket = cegah(strip_tags($data[15]));
							  	$i_x1 = md5($i_kode);
								$i_xyz = "$sekkd83_session$i_x1";
							  
								//insert
								mysqli_query($koneksi, "INSERT INTO inv_kib_f(kd, per_tahun, barang_kode, barang_nama, ".
												"register, kontruksi_tingkat, kontruksi_beton, ".
												"luas, alamat, dokumen_tgl, dokumen_nomor, ".
												"mulai_tgl, tanah_status, tanah_kode, ".
												"asal_usul, harga, ket, postdate) VALUES ".
												"('$i_xyz', '$sekkd83_session', '$e_sekkode', '$e_seknama', ".
												"'$tahun', '$i_kode', '$i_nama', ".
												"'$i_register', '$i_kontruksi_tingkat', '$i_kontruksi_beton', ".
												"'$i_luas', '$i_alamat', '$i_dokumen_tgl', '$i_dokumen_nomor', ".
												"'$i_mulai_tgl', '$i_tanah_status', '$i_tanah_kode', ".
												"'$i_asal_usul', '$i_harga', '$i_ket', '$today')");
							  
						
	
							}
					}			
			    } 
			
			








			
						
			
			//end while
			fclose($handle);


			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0777);
			unlink ($path1);





	
		
			
			
			
			//re-direct
			$pesan = "IMPORT Berhasil.";
			$ke = "$filenya?katkd=$katkd";
			pekem($pesan,$ke);
			
			exit();
			}
		else
			{
			//salah
			$pesan = "Bukan File .csv . Harap Diperhatikan...!!";
			$ke = "$filenya?katkd=$katkd&s=import";
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
	$katkd = cegah($_POST['katkd']);
	
	
	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');


	//nama file e...
	$i_filename = "kib-$katkd.xls";
	$i_judul = "kib-$katkd";
	



	//header file
	function HeaderingExcel($i_filename)
		{
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=$i_filename");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public");
		}

	
	
	
	
	//jika kib-A ///////////////////////////////////////////////////////////////////////////////////////
	if ($katkd == "A")
		{
		//bikin...
		HeaderingExcel($i_filename);
		$workbook = new Workbook("-");
		$worksheet1 =& $workbook->add_worksheet($i_judul);
		$worksheet1->write_string(0,0,"NO.");
		$worksheet1->write_string(0,1,"KODE");
		$worksheet1->write_string(0,2,"NAMA");
		$worksheet1->write_string(0,3,"REGISTER");
		$worksheet1->write_string(0,4,"LUAS");
		$worksheet1->write_string(0,5,"TAHUN_PENGADAAN");
		$worksheet1->write_string(0,6,"LETAK/ALAMAT");
		$worksheet1->write_string(0,7,"STATUS_HAK");
		$worksheet1->write_string(0,8,"SERTIFIKAT_TGL");
		$worksheet1->write_string(0,9,"SERTIFIKAT_NOMOR");
		$worksheet1->write_string(0,10,"PENGGUNAAN");
		$worksheet1->write_string(0,11,"ASAL_USUL");
		$worksheet1->write_string(0,12,"HARGA");
		$worksheet1->write_string(0,13,"KET");
	
	
		//data
		$qdt = mysqli_query($koneksi, "SELECT * FROM inv_kib_a ".
										"ORDER BY round(barang_kode) ASC");
		$rdt = mysqli_fetch_assoc($qdt);
	
		do
			{
			//nilai
			$dt_nox = $dt_nox + 1;
			$i_kode = balikin($rdt['barang_kode']);
			$i_nama = balikin($rdt['barang_nama']);
			$i_register = balikin($rdt['register']);
			$i_luas = balikin($rdt['luas']);
			$i_tahun_ada = balikin($rdt['tahun_ada']);
			$i_alamat = balikin($rdt['alamat']);
			$i_status_hak = balikin($rdt['status_hak']);
			$i_sertifikat_tgl = balikin($rdt['status_sertifikat_tgl']);
			$i_sertifikat_nomor = balikin($rdt['status_sertifikat_nomor']);
			$i_penggunaan = balikin($rdt['penggunaan']);
			$i_asal_usul = balikin($rdt['asal_usul']);
			$i_harga = balikin($rdt['harga']);
			$i_ket = balikin($rdt['ket']);
	
	
			//ciptakan
			$worksheet1->write_string($dt_nox,0,$dt_nox);
			$worksheet1->write_string($dt_nox,1,$i_kode);
			$worksheet1->write_string($dt_nox,2,$i_nama);
			$worksheet1->write_string($dt_nox,3,$i_register);
			$worksheet1->write_string($dt_nox,4,$i_luas);
			$worksheet1->write_string($dt_nox,5,$i_tahun_ada);
			$worksheet1->write_string($dt_nox,6,$i_alamat);
			$worksheet1->write_string($dt_nox,7,$i_status_hak);
			$worksheet1->write_string($dt_nox,8,$i_sertifikat_tgl);
			$worksheet1->write_string($dt_nox,9,$i_sertifikat_nomor);
			$worksheet1->write_string($dt_nox,10,$i_penggunaan);
			$worksheet1->write_string($dt_nox,11,$i_asal_usul);
			$worksheet1->write_string($dt_nox,12,$i_harga);
			$worksheet1->write_string($dt_nox,13,$i_ket);
			}
		while ($rdt = mysqli_fetch_assoc($qdt));
		}








	
	//jika kib-B ///////////////////////////////////////////////////////////////////////////////////////
	else if ($katkd == "B")
		{
		//bikin...
		HeaderingExcel($i_filename);
		$workbook = new Workbook("-");
		$worksheet1 =& $workbook->add_worksheet($i_judul);
		$worksheet1->write_string(0,0,"NO.");
		$worksheet1->write_string(0,1,"KODE");
		$worksheet1->write_string(0,2,"NAMA");
		$worksheet1->write_string(0,3,"REGISTER");
		$worksheet1->write_string(0,4,"JUMLAH");
		$worksheet1->write_string(0,5,"SATUAN");
		$worksheet1->write_string(0,6,"MERK/TYPE");
		$worksheet1->write_string(0,7,"UKURAN CC");
		$worksheet1->write_string(0,8,"BAHAN");
		$worksheet1->write_string(0,9,"TAHUN_BELI");
		$worksheet1->write_string(0,10,"NOMOR_PABRIK");
		$worksheet1->write_string(0,11,"NOMOR_RANGKA");
		$worksheet1->write_string(0,12,"NOMOR_MESIN");
		$worksheet1->write_string(0,13,"NOMOR_POLISI");
		$worksheet1->write_string(0,14,"NOMOR_BPKB");
		$worksheet1->write_string(0,15,"ASAL_USUL");
		$worksheet1->write_string(0,16,"HARGA");
		$worksheet1->write_string(0,17,"KET");
	
	
		//data
		$qdt = mysqli_query($koneksi, "SELECT * FROM inv_kib_b ".
										"ORDER BY round(barang_kode) ASC");
		$rdt = mysqli_fetch_assoc($qdt);
	
		do
			{
			//nilai
			$dt_nox = $dt_nox + 1;
			$i_kode = balikin($rdt['barang_kode']);
			$i_nama = balikin($rdt['barang_nama']);
			$i_register = balikin($rdt['register']);

			$i_jumlah = balikin($rdt['jumlah']);
			$i_satuan = balikin($rdt['satuan']);
			$i_merk = balikin($rdt['merk_type']);
			$i_ukuran_cc = balikin($rdt['ukuran_cc']);
			$i_bahan = balikin($rdt['bahan']);
			$i_tahun_beli = balikin($rdt['tahun_beli']);
			$i_no_pabrik = balikin($rdt['nomor_pabrik']);
			$i_no_rangka = balikin($rdt['nomor_rangka']);
			$i_no_mesin = balikin($rdt['nomor_mesin']);
			$i_no_polisi = balikin($rdt['nomor_polisi']);
			$i_no_bpkb = balikin($rdt['nomor_bpkb']);
			$i_asal_usul = balikin($rdt['asal_usul']);
			$i_harga = balikin($rdt['harga']);
			$i_ket = balikin($rdt['ket']);
	
	
			//ciptakan
			$worksheet1->write_string($dt_nox,0,$dt_nox);
			$worksheet1->write_string($dt_nox,1,$i_kode);
			$worksheet1->write_string($dt_nox,2,$i_nama);
			$worksheet1->write_string($dt_nox,3,$i_register);
			$worksheet1->write_string($dt_nox,4,$i_jumlah);
			$worksheet1->write_string($dt_nox,5,$i_satuan);
			$worksheet1->write_string($dt_nox,6,$i_merk);
			$worksheet1->write_string($dt_nox,7,$i_ukuran_cc);
			$worksheet1->write_string($dt_nox,8,$i_bahan);
			$worksheet1->write_string($dt_nox,9,$i_tahun_beli);
			$worksheet1->write_string($dt_nox,10,$i_no_pabrik);
			$worksheet1->write_string($dt_nox,11,$i_no_rangka);
			$worksheet1->write_string($dt_nox,12,$i_no_mesin);
			$worksheet1->write_string($dt_nox,13,$i_no_polisi);
			$worksheet1->write_string($dt_nox,14,$i_no_bpkb);
			$worksheet1->write_string($dt_nox,15,$i_asal_usul);
			$worksheet1->write_string($dt_nox,16,$i_harga);
			$worksheet1->write_string($dt_nox,17,$i_ket);
			}
		while ($rdt = mysqli_fetch_assoc($qdt));
		}













	
	//jika kib-C ///////////////////////////////////////////////////////////////////////////////////////
	else if ($katkd == "C")
		{
		//bikin...
		HeaderingExcel($i_filename);
		$workbook = new Workbook("-");
		$worksheet1 =& $workbook->add_worksheet($i_judul);
		$worksheet1->write_string(0,0,"NO.");
		$worksheet1->write_string(0,1,"KODE");
		$worksheet1->write_string(0,2,"NAMA");
		$worksheet1->write_string(0,3,"REGISTER");
		$worksheet1->write_string(0,4,"KONDISI");
		$worksheet1->write_string(0,5,"KONTRUKSI_TINGKAT");
		$worksheet1->write_string(0,6,"KONTRUKSI_BETON");
		$worksheet1->write_string(0,7,"LUAS_LANTAI");
		$worksheet1->write_string(0,8,"ALAMAT");
		$worksheet1->write_string(0,9,"DOKUMEN_TGL");
		$worksheet1->write_string(0,10,"DOKUMEN_NOMOR");
		$worksheet1->write_string(0,11,"TANAH_LUAS");
		$worksheet1->write_string(0,12,"TANAH_STATUS");
		$worksheet1->write_string(0,13,"TANAH_KODE");
		$worksheet1->write_string(0,14,"TAHUN_PENGADAAN");
		$worksheet1->write_string(0,15,"ASAL_USUL");
		$worksheet1->write_string(0,16,"HARGA");
		$worksheet1->write_string(0,17,"KET");
	
	
		//data
		$qdt = mysqli_query($koneksi, "SELECT * FROM inv_kib_c ".
										"ORDER BY round(barang_kode) ASC");
		$rdt = mysqli_fetch_assoc($qdt);
	
		do
			{
			//nilai
			$dt_nox = $dt_nox + 1;
			$i_kode = balikin($rdt['barang_kode']);
			$i_nama = balikin($rdt['barang_nama']);
			$i_register = balikin($rdt['register']);

			$i_kondisi = balikin($rdt['kondisi']);
			$i_kontruksi_tingkat = balikin($rdt['kontruksi_tingkat']);
			$i_kontruksi_beton = balikin($rdt['kontruksi_beton']);
			$i_luas_lantai = balikin($rdt['luas_lantai']);
			$i_alamat = balikin($rdt['alamat']);
			$i_dokumen_tgl = balikin($rdt['dokumen_tgl']);
			$i_dokumen_nomor = balikin($rdt['dokumen_nomor']);
			$i_tanah_luas = balikin($rdt['tanah_luas']);
			$i_tanah_status = balikin($rdt['tanah_status']);
			$i_tanah_kode = balikin($rdt['tanah_kode']);
			$i_tahun_ada = balikin($rdt['tahun_ada']);
			$i_asal_usul = balikin($rdt['asal_usul']);

			$i_harga = balikin($rdt['harga']);
			$i_ket = balikin($rdt['ket']);
	
	
			//ciptakan
			$worksheet1->write_string($dt_nox,0,$dt_nox);
			$worksheet1->write_string($dt_nox,1,$i_kode);
			$worksheet1->write_string($dt_nox,2,$i_nama);
			$worksheet1->write_string($dt_nox,3,$i_register);
			$worksheet1->write_string($dt_nox,4,$i_kondisi);
			$worksheet1->write_string($dt_nox,5,$i_kontruksi_tingkat);
			$worksheet1->write_string($dt_nox,6,$i_kontruksi_beton);
			$worksheet1->write_string($dt_nox,7,$i_luas_lantai);
			$worksheet1->write_string($dt_nox,8,$i_alamat);
			$worksheet1->write_string($dt_nox,9,$i_dokumen_tgl);
			$worksheet1->write_string($dt_nox,10,$i_dokumen_nomor);
			$worksheet1->write_string($dt_nox,11,$i_tanah_luas);
			$worksheet1->write_string($dt_nox,12,$i_tanah_status);
			$worksheet1->write_string($dt_nox,13,$i_tanah_kode);
			$worksheet1->write_string($dt_nox,14,$i_tahun_ada);
			$worksheet1->write_string($dt_nox,15,$i_asal_usul);
			$worksheet1->write_string($dt_nox,16,$i_harga);
			$worksheet1->write_string($dt_nox,17,$i_ket);
			}
		while ($rdt = mysqli_fetch_assoc($qdt));
		}









	
	//jika kib-D ///////////////////////////////////////////////////////////////////////////////////////
	else if ($katkd == "D")
		{
		//bikin...
		HeaderingExcel($i_filename);
		$workbook = new Workbook("-");
		$worksheet1 =& $workbook->add_worksheet($i_judul);
		$worksheet1->write_string(0,0,"NO.");
		$worksheet1->write_string(0,1,"KODE");
		$worksheet1->write_string(0,2,"NAMA");
		$worksheet1->write_string(0,3,"REGISTER");
		$worksheet1->write_string(0,4,"KONTRUKSI");
		$worksheet1->write_string(0,5,"PANJANG");
		$worksheet1->write_string(0,6,"LEBAR");
		$worksheet1->write_string(0,7,"LUAS");
		$worksheet1->write_string(0,8,"LOKASI");
		$worksheet1->write_string(0,9,"DOKUMEN_TGL");
		$worksheet1->write_string(0,10,"DOKUMEN_NOMOR");
		$worksheet1->write_string(0,11,"TANAH_STATUS");
		$worksheet1->write_string(0,12,"TANAH_KODE");
		$worksheet1->write_string(0,13,"ASAL_USUL");
		$worksheet1->write_string(0,14,"TAHUN_PENGADAAN");
		$worksheet1->write_string(0,15,"HARGA");
		$worksheet1->write_string(0,16,"KONDISI");
		$worksheet1->write_string(0,17,"KET");
	
	
		//data
		$qdt = mysqli_query($koneksi, "SELECT * FROM inv_kib_d ".
										"ORDER BY round(barang_kode) ASC");
		$rdt = mysqli_fetch_assoc($qdt);
	
		do
			{
			//nilai
			$dt_nox = $dt_nox + 1;
			$i_kode = balikin($rdt['barang_kode']);
			$i_nama = balikin($rdt['barang_nama']);
			$i_register = balikin($rdt['register']);

				$i_kontruksi = balikin($rdt['kontruksi']);
				$i_panjang = balikin($rdt['panjang']);
				$i_lebar = balikin($rdt['lebar']);
				$i_luas = balikin($rdt['luas']);
				$i_lokasi = balikin($rdt['lokasi']);
				$i_dokumen_tgl = balikin($rdt['dokumen_tgl']);
				$i_dokumen_nomor = balikin($rdt['dokumen_nomor']);
				$i_tanah_status = balikin($rdt['tanah_status']);
				$i_tanah_kode = balikin($rdt['tanah_kode']);
				$i_asal_usul = balikin($rdt['asal_usul']);
				$i_tahun_ada = balikin($rdt['tahun_ada']);
				$i_harga = balikin($rdt['harga']);
				$i_kondisi = balikin($rdt['kondisi']);

			$i_ket = balikin($rdt['ket']);
	
	
			//ciptakan
			$worksheet1->write_string($dt_nox,0,$dt_nox);
			$worksheet1->write_string($dt_nox,1,$i_kode);
			$worksheet1->write_string($dt_nox,2,$i_nama);
			$worksheet1->write_string($dt_nox,3,$i_register);
			$worksheet1->write_string($dt_nox,4,$i_kontruksi);
			$worksheet1->write_string($dt_nox,5,$i_panjang);
			$worksheet1->write_string($dt_nox,6,$i_lebar);
			$worksheet1->write_string($dt_nox,7,$i_luas);
			$worksheet1->write_string($dt_nox,8,$i_lokasi);
			$worksheet1->write_string($dt_nox,9,$i_dokumen_tgl);
			$worksheet1->write_string($dt_nox,10,$i_dokumen_nomor);
			$worksheet1->write_string($dt_nox,11,$i_tanah_status);
			$worksheet1->write_string($dt_nox,12,$i_tanah_kode);
			$worksheet1->write_string($dt_nox,13,$i_asal_usul);
			$worksheet1->write_string($dt_nox,14,$i_tahun_ada);
			$worksheet1->write_string($dt_nox,15,$i_harga);
			$worksheet1->write_string($dt_nox,16,$i_kondisi);

			$worksheet1->write_string($dt_nox,17,$i_ket);
			}
		while ($rdt = mysqli_fetch_assoc($qdt));
		}











	
	//jika kib-E ///////////////////////////////////////////////////////////////////////////////////////
	else if ($katkd == "E")
		{
		//bikin...
		HeaderingExcel($i_filename);
		$workbook = new Workbook("-");
		$worksheet1 =& $workbook->add_worksheet($i_judul);
		$worksheet1->write_string(0,0,"NO.");
		$worksheet1->write_string(0,1,"KODE");
		$worksheet1->write_string(0,2,"NAMA");
		$worksheet1->write_string(0,3,"REGISTER");
		$worksheet1->write_string(0,4,"BUKU_JUDUL");
		$worksheet1->write_string(0,5,"BUKU_SPEK");
		$worksheet1->write_string(0,6,"CORAK_ASAL");
		$worksheet1->write_string(0,7,"CORAK_PENCIPTA");
		$worksheet1->write_string(0,8,"CORAK_BAHAN");
		$worksheet1->write_string(0,9,"HEWAN_JENIS");
		$worksheet1->write_string(0,10,"HEWAN_UKURAN");
		$worksheet1->write_string(0,11,"JUMLAH");
		$worksheet1->write_string(0,12,"TAHUN_CETAK");
		$worksheet1->write_string(0,13,"ASAL_USUL");
		$worksheet1->write_string(0,14,"TAHUN_BELI");
		$worksheet1->write_string(0,15,"HARGA");
		$worksheet1->write_string(0,16,"KET");
	
	
		//data
		$qdt = mysqli_query($koneksi, "SELECT * FROM inv_kib_e ".
										"ORDER BY round(barang_kode) ASC");
		$rdt = mysqli_fetch_assoc($qdt);
	
		do
			{
			//nilai
			$dt_nox = $dt_nox + 1;
			$i_kode = balikin($rdt['barang_kode']);
			$i_nama = balikin($rdt['barang_nama']);
			$i_register = balikin($rdt['register']);
			
				$i_buku_judul = balikin($rdt['buku_judul']);
				$i_buku_spek = balikin($rdt['buku_spek']);
				$i_corak_asal = balikin($rdt['corak_asal']);
				$i_corak_pencipta = balikin($rdt['corak_pencipta']);
				$i_corak_bahan = balikin($rdt['corak_bahan']);
				$i_hewan_jenis = balikin($rdt['hewan_jenis']);
				$i_hewan_ukuran = balikin($rdt['hewan_ukuran']);
				$i_jumlah = balikin($rdt['jumlah']);
				$i_tahun_cetak = balikin($rdt['tahun_cetak']);
				$i_asal_usul = balikin($rdt['asal_usul']);
				$i_tahun_beli = balikin($rdt['tahun_beli']);
				$i_harga = balikin($rdt['harga']);
			

			$i_ket = balikin($rdt['ket']);
	
	
			//ciptakan
			$worksheet1->write_string($dt_nox,0,$dt_nox);
			$worksheet1->write_string($dt_nox,1,$i_kode);
			$worksheet1->write_string($dt_nox,2,$i_nama);
			$worksheet1->write_string($dt_nox,3,$i_register);
			$worksheet1->write_string($dt_nox,4,$i_buku_judul);
			$worksheet1->write_string($dt_nox,5,$i_buku_spek);
			$worksheet1->write_string($dt_nox,6,$i_corak_asal);
			$worksheet1->write_string($dt_nox,7,$i_corak_pencipta);
			$worksheet1->write_string($dt_nox,8,$i_corak_bahan);
			$worksheet1->write_string($dt_nox,9,$i_hewan_jenis);
			$worksheet1->write_string($dt_nox,10,$i_hewan_ukuran);
			$worksheet1->write_string($dt_nox,11,$i_jumlah);
			$worksheet1->write_string($dt_nox,12,$i_tahun_cetak);
			$worksheet1->write_string($dt_nox,13,$i_asal_usul);
			$worksheet1->write_string($dt_nox,14,$i_tahun_beli);
			$worksheet1->write_string($dt_nox,15,$i_harga);
			$worksheet1->write_string($dt_nox,16,$i_ket);
			}
		while ($rdt = mysqli_fetch_assoc($qdt));
		}













	//jika kib-F ///////////////////////////////////////////////////////////////////////////////////////
	else if ($katkd == "F")
		{
		//bikin...
		HeaderingExcel($i_filename);
		$workbook = new Workbook("-");
		$worksheet1 =& $workbook->add_worksheet($i_judul);
		$worksheet1->write_string(0,0,"NO.");
		$worksheet1->write_string(0,1,"KODE");
		$worksheet1->write_string(0,2,"NAMA");
		$worksheet1->write_string(0,3,"REGISTER");
		$worksheet1->write_string(0,4,"KONTRUKSI_TINGKAT");
		$worksheet1->write_string(0,5,"KONTRUKSI_BETON");
		$worksheet1->write_string(0,6,"LUAS(M2)");
		$worksheet1->write_string(0,7,"ALAMAT");
		$worksheet1->write_string(0,8,"DOKUMEN_TANGGAL");
		$worksheet1->write_string(0,9,"DOKUMEN_NOMOR");
		$worksheet1->write_string(0,10,"TANGGAL_MULAI");
		$worksheet1->write_string(0,11,"TANAH_STATUS");
		$worksheet1->write_string(0,12,"TANAH_KODE");
		$worksheet1->write_string(0,13,"ASAL_USUL");
		$worksheet1->write_string(0,14,"HARGA");
		$worksheet1->write_string(0,15,"KET");
	
	
		//data
		$qdt = mysqli_query($koneksi, "SELECT * FROM inv_kib_f ".
										"ORDER BY round(barang_kode) ASC");
		$rdt = mysqli_fetch_assoc($qdt);
	
		do
			{
			//nilai
			$dt_nox = $dt_nox + 1;
			$i_kode = balikin($rdt['barang_kode']);
			$i_nama = balikin($rdt['barang_nama']);
			$i_register = balikin($rdt['register']);

				$i_kontruksi_tingkat = balikin($rdt['kontruksi_tingkat']);
				$i_kontruksi_beton = balikin($rdt['kontruksi_beton']);
				$i_luas = balikin($rdt['luas']);
				$i_alamat = balikin($rdt['alamat']);
				$i_dokumen_tgl = balikin($rdt['dokumen_tgl']);
				$i_dokumen_nomor = balikin($rdt['dokumen_nomor']);
				$i_mulai_tgl = balikin($rdt['mulai_tgl']);
				$i_tanah_status = balikin($rdt['tanah_status']);
				$i_tanah_kode = balikin($rdt['tanah_kode']);
				$i_asal_usul = balikin($rdt['asal_usul']);
			
			$i_harga = balikin($rdt['harga']);
			$i_ket = balikin($rdt['ket']);
	
	
			//ciptakan
			$worksheet1->write_string($dt_nox,0,$dt_nox);
			$worksheet1->write_string($dt_nox,1,$i_kode);
			$worksheet1->write_string($dt_nox,2,$i_nama);
			$worksheet1->write_string($dt_nox,3,$i_register);
			$worksheet1->write_string($dt_nox,4,$i_kontruksi_tingkat);
			$worksheet1->write_string($dt_nox,5,$i_kontruksi_beton);
			$worksheet1->write_string($dt_nox,6,$i_luas);
			$worksheet1->write_string($dt_nox,7,$i_alamat);
			$worksheet1->write_string($dt_nox,8,$i_dokumen_tgl);
			$worksheet1->write_string($dt_nox,9,$i_dokumen_nomor);
			$worksheet1->write_string($dt_nox,10,$i_mulai_tgl);
			$worksheet1->write_string($dt_nox,11,$i_tanah_status);
			$worksheet1->write_string($dt_nox,12,$i_tanah_kode);
			$worksheet1->write_string($dt_nox,13,$i_asal_usul);
			$worksheet1->write_string($dt_nox,14,$i_harga);
			$worksheet1->write_string($dt_nox,15,$i_ket);
			}
		while ($rdt = mysqli_fetch_assoc($qdt));
		}

















	//close
	$workbook->close();

	
	
	//re-direct
	$ke = "$filenya?katkd=$katkd";
	xloc($ke);
	exit();
	}










//nek import
if ($_POST['btnIM'])
	{
	//nilai
	$katkd = cegah($_POST['katkd']);

	//re-direct
	$ke = "$filenya?katkd=$katkd";
	xloc($ke);
	exit();
	}












//nek batal
if ($_POST['btnBTL'])
	{
	//nilai
	$katkd = cegah($_POST['katkd']);

	//re-direct
	$ke = "$filenya?katkd=$katkd";
	xloc($ke);
	exit();
	}







//jika cari
if ($_POST['btnCARI'])
	{
	//nilai
	$katkd = cegah($_POST['katkd']);
	$kunci = cegah($_POST['kunci']);


	//re-direct
	$ke = "$filenya?katkd=$katkd&kunci=$kunci";
	xloc($ke);
	exit();
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$katkd = cegah($_POST['katkd']);
	$jml = nosql($_POST['jml']);
	$page = nosql($_POST['page']);
	$ke = "$filenya?katkd=$katkd&page=$page";


	//jika kib-A
	if ($katkd == "A")
		{
		//ambil semua
		for ($i=1; $i<=$jml;$i++)
			{
			//ambil nilai
			$yuk = "item";
			$yuhu = "$yuk$i";
			$kd = nosql($_POST["$yuhu"]);
	
			//del
			mysqli_query($koneksi, "DELETE FROM inv_kib_a ".
							"WHERE kd = '$kd'");
			}
		}
		
		
	//jika kib-B
	else if ($katkd == "B")
		{
		//ambil semua
		for ($i=1; $i<=$jml;$i++)
			{
			//ambil nilai
			$yuk = "item";
			$yuhu = "$yuk$i";
			$kd = nosql($_POST["$yuhu"]);
	
			//del
			mysqli_query($koneksi, "DELETE FROM inv_kib_b ".
							"WHERE kd = '$kd'");
			}
		}
		
		
		
		
	//jika kib-C
	else if ($katkd == "C")
		{
		//ambil semua
		for ($i=1; $i<=$jml;$i++)
			{
			//ambil nilai
			$yuk = "item";
			$yuhu = "$yuk$i";
			$kd = nosql($_POST["$yuhu"]);
	
			//del
			mysqli_query($koneksi, "DELETE FROM inv_kib_c ".
							"WHERE kd = '$kd'");
			}
		}
		
		
		
	
	
	
	//jika kib-D
	else if ($katkd == "D")
		{
		//ambil semua
		for ($i=1; $i<=$jml;$i++)
			{
			//ambil nilai
			$yuk = "item";
			$yuhu = "$yuk$i";
			$kd = nosql($_POST["$yuhu"]);
	
			//del
			mysqli_query($koneksi, "DELETE FROM inv_kib_d ".
							"WHERE kd = '$kd'");
			}
		}
		
		
	
	
		
		
		
		
	//jika kib-E
	else if ($katkd == "E")
		{
		//ambil semua
		for ($i=1; $i<=$jml;$i++)
			{
			//ambil nilai
			$yuk = "item";
			$yuhu = "$yuk$i";
			$kd = nosql($_POST["$yuhu"]);
	
			//del
			mysqli_query($koneksi, "DELETE FROM inv_kib_e ".
							"WHERE kd = '$kd'");
			}
		}
		
		
	
	
	
	
	
	//jika kib-F
	else if ($katkd == "F")
		{
		//ambil semua
		for ($i=1; $i<=$jml;$i++)
			{
			//ambil nilai
			$yuk = "item";
			$yuhu = "$yuk$i";
			$kd = nosql($_POST["$yuhu"]);
	
			//del
			mysqli_query($koneksi, "DELETE FROM inv_kib_f ".
							"WHERE kd = '$kd'");
			}
		}
		
		
	
	
	
		

	//auto-kembali
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<p>
Kartu Inventaris Barang (KIB) : ';
echo "<select name=\"e_kategori\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";

//terpilih
$qstx2 = mysqli_query($koneksi, "SELECT * FROM m_kib_jenis ".
						"WHERE kd = '$katkd'");
$rowstx2 = mysqli_fetch_assoc($qstx2);
$stx2_kd = nosql($rowstx2['kd']);
$stx2_nama1 = balikin($rowstx2['nama']);

echo '<option value="'.$stx2_kd.'" selected>'.$stx2_kd.'. '.$stx2_nama1.'</option>';
echo '<option value="'.$filenya.'?katkd="></option>';

$qst = mysqli_query($koneksi, "SELECT * FROM m_kib_jenis ".
						"ORDER BY round(kd) ASC");
$rowst = mysqli_fetch_assoc($qst);

do
	{
	$st_kd = nosql($rowst['kd']);
	$st_nama1 = balikin($rowst['nama']);

	echo '<option value="'.$filenya.'?katkd='.$st_kd.'">'.$st_kd.'. '.$st_nama1.'</option>';
	}
while ($rowst = mysqli_fetch_assoc($qst));

echo '</select>
</p>

<hr>';



//jika import
if ($s == "import")
	{
	?>
	<div class="row">

	<div class="col-md-12">
		
	<?php
	echo '<form action="'.$filenya.'" method="post" enctype="multipart/form-data" name="formxx2">
	
	<p>
	<b>File .csv dengan pembatas antar kolom tanda titik koma ;</b> 
	<br>
		<input name="filex_xls" type="file" size="30" accept=".csv" class="btn btn-warning">
	</p>

	<p>
		<input name="katkd" type="hidden" value="'.$katkd.'">
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
	//jika A /////////////////////////////////////////////////////////////////////////////////////////////
	if ($katkd == "A")
		{
		$warnatext = "white";
		
		//jika null
		if (empty($kunci))
			{
			$sqlcount = "SELECT * FROM inv_kib_a ".
							"ORDER BY round(barang_kode) ASC";
			}
			
		else
			{
			$sqlcount = "SELECT * FROM inv_kib_a ".
							"WHERE barang_kode LIKE '%$kunci%' ".
							"OR barang_nama LIKE '%$kunci%' ".
							"OR register LIKE '%$kunci%' ".
							"OR luas LIKE '%$kunci%' ".
							"OR tahun_ada LIKE '%$kunci%' ".
							"OR alamat LIKE '%$kunci%' ".
							"OR status_hak LIKE '%$kunci%' ".
							"OR status_sertifikat_tgl LIKE '%$kunci%' ".
							"OR status_sertifikat_nomor LIKE '%$kunci%' ".
							"OR penggunaan LIKE '%$kunci%' ".
							"OR asal_usul LIKE '%$kunci%' ".
							"OR harga LIKE '%$kunci%' ".
							"OR ket LIKE '%$kunci%' ".
							"ORDER BY round(barang_kode) ASC";
			}
			
			
		
		//query
		$target = "$filenya?katkd=$katkd";
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
		<input name="btnIM" type="submit" value="IMPORT DATA" class="btn btn-success">
		<input name="btnEX" type="submit" value="EXPORT DATA" class="btn btn-success">
		<input name="katkd" type="hidden" value="'.$katkd.'">
		</p>
		
		</form>
	
	
	
		<form action="'.$filenya.'" method="post" name="formx">
		<p>
		<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
		<input name="katkd" type="hidden" value="'.$katkd.'">
		<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
		<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
		</p>
			
		
		<div class="table-responsive">          
		<table class="table" border="1">
		<thead>
		
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="20">&nbsp;</td>
		<td><strong><font color="'.$warnatext.'">KODE</font></strong></td>
		<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
		<td><strong><font color="'.$warnatext.'">REGISTER</font></strong></td>
		<td><strong><font color="'.$warnatext.'">LUAS</font></strong></td>
		<td><strong><font color="'.$warnatext.'">TAHUN PENGADAAN</font></strong></td>
		<td><strong><font color="'.$warnatext.'">ALAMAT</font></strong></td>
		<td><strong><font color="'.$warnatext.'">STATUS HAK</font></strong></td>
		<td><strong><font color="'.$warnatext.'">SERTIFIKAT TANGGAL</font></strong></td>
		<td><strong><font color="'.$warnatext.'">SERTIFIKAT NOMOR</font></strong></td>
		<td><strong><font color="'.$warnatext.'">PENGGUNAAN</font></strong></td>
		<td><strong><font color="'.$warnatext.'">ASAL_USUL</font></strong></td>
		<td><strong><font color="'.$warnatext.'">HARGA</font></strong></td>
		<td><strong><font color="'.$warnatext.'">KET</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
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
				$i_kode = balikin($data['barang_kode']);
				$i_nama = balikin($data['barang_nama']);
				$i_register = balikin($data['register']);
				$i_luas = balikin($data['luas']);
				$i_tahun_ada = balikin($data['tahun_ada']);
				$i_alamat = balikin($data['alamat']);
				$i_status_hak = balikin($data['status_hak']);
				$i_sertifikat_tgl = balikin($data['status_sertifikat_tgl']);
				$i_sertifikat_nomor = balikin($data['status_sertifikat_nomor']);
				$i_penggunaan = balikin($data['penggunaan']);
				$i_asal_usul = balikin($data['asal_usul']);
				$i_harga = balikin($data['harga']);
				$i_ket = balikin($data['ket']);

				$i_postdate = balikin($data['postdate']);
	
				
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
		        </td>
				<td>'.$i_kode.'</td>
				<td>'.$i_nama.'</td>
				<td>'.$i_register.'</td>
				<td>'.$i_luas.'</td>
				<td>'.$i_tahun_ada.'</td>
				<td>'.$i_alamat.'</td>
				<td>'.$i_status_hak.'</td>
				<td>'.$i_sertifikat_tgl.'</td>
				<td>'.$i_sertifikat_nomor.'</td>
				<td>'.$i_penggunaan.'</td>
				<td>'.$i_asal_usul.'</td>
				<td>'.$i_harga.'</td>
				<td>'.$i_ket.'</td>
				<td>'.$i_postdate.'</td>
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
		
	
	
	
	//jika B /////////////////////////////////////////////////////////////////////////////////////////////
	else if ($katkd == "B")
		{
		$warnatext = "white";
		
		//jika null
		if (empty($kunci))
			{
			$sqlcount = "SELECT * FROM inv_kib_b ".
							"ORDER BY round(barang_kode) ASC";
			}
			
		else
			{
			$sqlcount = "SELECT * FROM inv_kib_b ".
							"WHERE barang_kode LIKE '%$kunci%' ".
							"OR barang_nama LIKE '%$kunci%' ".
							"OR register LIKE '%$kunci%' ".
							"OR jumlah LIKE '%$kunci%' ".
							"OR satuan LIKE '%$kunci%' ".
							"OR merk_type LIKE '%$kunci%' ".
							"OR ukuran_cc LIKE '%$kunci%' ".
							"OR bahan LIKE '%$kunci%' ".
							"OR tahun_beli LIKE '%$kunci%' ".
							"OR nomor_pabrik LIKE '%$kunci%' ".
							"OR nomor_rangka LIKE '%$kunci%' ".
							"OR nomor_mesin LIKE '%$kunci%' ".
							"OR nomor_polisi LIKE '%$kunci%' ".
							"OR nomor_bpkb LIKE '%$kunci%' ".
							"OR asal_usul LIKE '%$kunci%' ".
							"OR harga LIKE '%$kunci%' ".
							"OR ket LIKE '%$kunci%' ".
							"ORDER BY round(barang_kode) ASC";
			}
			
			
		
		//query
		$target = "$filenya?katkd=$katkd";
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
		<input name="btnIM" type="submit" value="IMPORT DATA" class="btn btn-success">
		<input name="btnEX" type="submit" value="EXPORT DATA" class="btn btn-success">
		<input name="katkd" type="hidden" value="'.$katkd.'">
		</p>
		
		</form>
	
	
	
		<form action="'.$filenya.'" method="post" name="formx">
		<p>
		<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
		<input name="katkd" type="hidden" value="'.$katkd.'">
		<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
		<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
		</p>
			
		
		<div class="table-responsive">          
		<table class="table" border="1">
		<thead>
		
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="20">&nbsp;</td>
		<td><strong><font color="'.$warnatext.'">KODE</font></strong></td>
		<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
		<td><strong><font color="'.$warnatext.'">REGISTER</font></strong></td>
		<td><strong><font color="'.$warnatext.'">JUMLAH</font></strong></td>
		<td><strong><font color="'.$warnatext.'">SATUAN</font></strong></td>
		<td><strong><font color="'.$warnatext.'">MERK/TYPE</font></strong></td>
		<td><strong><font color="'.$warnatext.'">UKURAN CC</font></strong></td>
		<td><strong><font color="'.$warnatext.'">BAHAN</font></strong></td>
		<td><strong><font color="'.$warnatext.'">TAHUN BELI</font></strong></td>
		<td><strong><font color="'.$warnatext.'">NOMOR PABRIK</font></strong></td>
		<td><strong><font color="'.$warnatext.'">NOMOR RANGKA</font></strong></td>
		<td><strong><font color="'.$warnatext.'">NOMOR MESIN</font></strong></td>
		<td><strong><font color="'.$warnatext.'">NOMOR POLISI</font></strong></td>
		<td><strong><font color="'.$warnatext.'">NOMOR BPKB</font></strong></td>
		<td><strong><font color="'.$warnatext.'">ASAL USUL</font></strong></td>
		<td><strong><font color="'.$warnatext.'">HARGA</font></strong></td>
		<td><strong><font color="'.$warnatext.'">KET</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
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
				$i_kode = balikin($data['barang_kode']);
				$i_nama = balikin($data['barang_nama']);
				$i_register = balikin($data['register']);
				$i_jumlah = balikin($data['jumlah']);
				$i_satuan = balikin($data['satuan']);
				$i_merk = balikin($data['merk_type']);
				$i_ukuran_cc = balikin($data['ukuran_cc']);
				$i_bahan = balikin($data['bahan']);
				$i_tahun_beli = balikin($data['tahun_beli']);
				$i_no_pabrik = balikin($data['nomor_pabrik']);
				$i_no_rangka = balikin($data['nomor_rangka']);
				$i_no_mesin = balikin($data['nomor_mesin']);
				$i_no_polisi = balikin($data['nomor_polisi']);
				$i_no_bpkb = balikin($data['nomor_bpkb']);
				$i_asal_usul = balikin($data['asal_usul']);
				$i_harga = balikin($data['harga']);
				$i_ket = balikin($data['ket']);

				$i_postdate = balikin($data['postdate']);
	
				
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
		        </td>
				<td>'.$i_kode.'</td>
				<td>'.$i_nama.'</td>
				<td>'.$i_register.'</td>
				<td>'.$i_jumlah.'</td>
				<td>'.$i_satuan.'</td>
				<td>'.$i_merk.'</td>
				<td>'.$i_ukuran_cc.'</td>
				<td>'.$i_bahan.'</td>
				<td>'.$i_tahun_beli.'</td>
				<td>'.$i_no_pabrik.'</td>
				<td>'.$i_no_rangka.'</td>
				<td>'.$i_no_mesin.'</td>
				<td>'.$i_no_polisi.'</td>
				<td>'.$i_no_bpkb.'</td>
				<td>'.$i_asal_usul.'</td>
				<td>'.$i_harga.'</td>
				<td>'.$i_ket.'</td>
				<td>'.$i_postdate.'</td>
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
		













	//jika C /////////////////////////////////////////////////////////////////////////////////////////////
	else if ($katkd == "C")
		{
		$warnatext = "white";
		
		//jika null
		if (empty($kunci))
			{
			$sqlcount = "SELECT * FROM inv_kib_c ".
							"ORDER BY round(barang_kode) ASC";
			}
			
		else
			{
			$sqlcount = "SELECT * FROM inv_kib_c ".
							"WHERE barang_kode LIKE '%$kunci%' ".
							"OR barang_nama LIKE '%$kunci%' ".
							"OR register LIKE '%$kunci%' ".
							"OR kondisi LIKE '%$kunci%' ".
							"OR kontruksi_tingkat LIKE '%$kunci%' ".
							"OR kontruksi_beton LIKE '%$kunci%' ".
							"OR luas_lantai LIKE '%$kunci%' ".
							"OR alamat LIKE '%$kunci%' ".
							"OR dokumen_tgl LIKE '%$kunci%' ".
							"OR dokumen_nomor LIKE '%$kunci%' ".
							"OR tanah_luas LIKE '%$kunci%' ".
							"OR tanah_status LIKE '%$kunci%' ".
							"OR tanah_kode LIKE '%$kunci%' ".
							"OR asal_usul LIKE '%$kunci%' ".
							"OR tahun_ada LIKE '%$kunci%' ".
							"OR harga LIKE '%$kunci%' ".
							"OR ket LIKE '%$kunci%' ".
							"ORDER BY round(barang_kode) ASC";
			}
			
			
		
		//query
		$target = "$filenya?katkd=$katkd";
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
		<input name="btnIM" type="submit" value="IMPORT DATA" class="btn btn-success">
		<input name="btnEX" type="submit" value="EXPORT DATA" class="btn btn-success">
		<input name="katkd" type="hidden" value="'.$katkd.'">
		</p>
		
		</form>
	
	
	
		<form action="'.$filenya.'" method="post" name="formx">
		<p>
		<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
		<input name="katkd" type="hidden" value="'.$katkd.'">
		<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
		<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
		</p>
			
		
		<div class="table-responsive">          
		<table class="table" border="1">
		<thead>
		
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="20">&nbsp;</td>
		<td><strong><font color="'.$warnatext.'">KODE</font></strong></td>
		<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
		<td><strong><font color="'.$warnatext.'">REGISTER</font></strong></td>
		<td><strong><font color="'.$warnatext.'">KONDISI</font></strong></td>
		<td><strong><font color="'.$warnatext.'">KONTRUKSI TINGKAT</font></strong></td>
		<td><strong><font color="'.$warnatext.'">KONTRUKSI BETON</font></strong></td>
		<td><strong><font color="'.$warnatext.'">LUAS LANTAI</font></strong></td>
		<td><strong><font color="'.$warnatext.'">ALAMAT</font></strong></td>
		<td><strong><font color="'.$warnatext.'">DOKUMEN TANGGAL</font></strong></td>
		<td><strong><font color="'.$warnatext.'">DOKUMEN NOMOR</font></strong></td>
		<td><strong><font color="'.$warnatext.'">TANAH LUAS</font></strong></td>
		<td><strong><font color="'.$warnatext.'">TANAH STATUS</font></strong></td>
		<td><strong><font color="'.$warnatext.'">TANAH KODE</font></strong></td>
		<td><strong><font color="'.$warnatext.'">TAHUN PENGADAAN</font></strong></td>
		<td><strong><font color="'.$warnatext.'">ASAL_USUL</font></strong></td>
		<td><strong><font color="'.$warnatext.'">HARGA</font></strong></td>
		<td><strong><font color="'.$warnatext.'">KET</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
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
				$i_kode = balikin($data['barang_kode']);
				$i_nama = balikin($data['barang_nama']);
				$i_register = balikin($data['register']);
				$i_kondisi = balikin($data['kondisi']);
				$i_kontruksi_tingkat = balikin($data['kontruksi_tingkat']);
				$i_kontruksi_beton = balikin($data['kontruksi_beton']);
				$i_luas_lantai = balikin($data['luas_lantai']);
				$i_alamat = balikin($data['alamat']);
				$i_dokumen_tgl = balikin($data['dokumen_tgl']);
				$i_dokumen_nomor = balikin($data['dokumen_nomor']);
				$i_tanah_luas = balikin($data['tanah_luas']);
				$i_tanah_status = balikin($data['tanah_status']);
				$i_tanah_kode = balikin($data['tanah_kode']);
				$i_tahun_ada = balikin($data['tahun_ada']);
				$i_asal_usul = balikin($data['asal_usul']);
				$i_harga = balikin($data['harga']);
				$i_ket = balikin($data['ket']);

				$i_postdate = balikin($data['postdate']);
	
				
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
		        </td>
				<td>'.$i_kode.'</td>
				<td>'.$i_nama.'</td>
				<td>'.$i_register.'</td>
				<td>'.$i_kondisi.'</td>
				<td>'.$i_kontruksi_tingkat.'</td>
				<td>'.$i_kontruksi_beton.'</td>
				<td>'.$i_luas_lantai.'</td>
				<td>'.$i_alamat.'</td>
				<td>'.$i_dokumen_tgl.'</td>
				<td>'.$i_dokumen_nomor.'</td>
				<td>'.$i_tanah_luas.'</td>
				<td>'.$i_tanah_status.'</td>
				<td>'.$i_tanah_kode.'</td>
				<td>'.$i_tahun_ada.'</td>
				<td>'.$i_asal_usul.'</td>
				<td>'.$i_harga.'</td>
				<td>'.$i_ket.'</td>
				<td>'.$i_postdate.'</td>
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










	//jika D /////////////////////////////////////////////////////////////////////////////////////////////
	else if ($katkd == "D")
		{
		$warnatext = "white";
		
		//jika null
		if (empty($kunci))
			{
			$sqlcount = "SELECT * FROM inv_kib_d ".
							"ORDER BY round(barang_kode) ASC";
			}
			
		else
			{
			$sqlcount = "SELECT * FROM inv_kib_d ".
							"WHERE barang_kode LIKE '%$kunci%' ".
							"OR barang_nama LIKE '%$kunci%' ".
							"OR register LIKE '%$kunci%' ".
							"OR kontruksi LIKE '%$kunci%' ".
							"OR panjang LIKE '%$kunci%' ".
							"OR lebar LIKE '%$kunci%' ".
							"OR luas LIKE '%$kunci%' ".
							"OR lokasi LIKE '%$kunci%' ".
							"OR dokumen_tgl LIKE '%$kunci%' ".
							"OR dokumen_nomor LIKE '%$kunci%' ".
							"OR tanah_status LIKE '%$kunci%' ".
							"OR tanah_kode LIKE '%$kunci%' ".
							"OR asal_usul LIKE '%$kunci%' ".
							"OR tahun_ada LIKE '%$kunci%' ".
							"OR kondisi LIKE '%$kunci%' ".
							"OR harga LIKE '%$kunci%' ".
							"OR ket LIKE '%$kunci%' ".
							"ORDER BY round(barang_kode) ASC";
			}
			
			
		
		//query
		$target = "$filenya?katkd=$katkd";
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
		<input name="btnIM" type="submit" value="IMPORT DATA" class="btn btn-success">
		<input name="btnEX" type="submit" value="EXPORT DATA" class="btn btn-success">
		<input name="katkd" type="hidden" value="'.$katkd.'">
		</p>
		
		</form>
	
	
	
		<form action="'.$filenya.'" method="post" name="formx">
		<p>
		<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
		<input name="katkd" type="hidden" value="'.$katkd.'">
		<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
		<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
		</p>
			
		
		<div class="table-responsive">          
		<table class="table" border="1">
		<thead>
		
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="20">&nbsp;</td>
		<td><strong><font color="'.$warnatext.'">KODE</font></strong></td>
		<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
		<td><strong><font color="'.$warnatext.'">REGISTER</font></strong></td>
		<td><strong><font color="'.$warnatext.'">KONTRUKSI</font></strong></td>
		<td><strong><font color="'.$warnatext.'">PANJANG (KM)</font></strong></td>
		<td><strong><font color="'.$warnatext.'">LEBAR (M)</font></strong></td>
		<td><strong><font color="'.$warnatext.'">LUAS (M2)</font></strong></td>
		<td><strong><font color="'.$warnatext.'">LETAK/LOKASI</font></strong></td>
		<td><strong><font color="'.$warnatext.'">DOKUMEN TANGGAL</font></strong></td>
		<td><strong><font color="'.$warnatext.'">DOKUMEN NOMOR</font></strong></td>
		<td><strong><font color="'.$warnatext.'">STATUS TANAH</font></strong></td>
		<td><strong><font color="'.$warnatext.'">KODE TANAH</font></strong></td>
		<td><strong><font color="'.$warnatext.'">ASAL_USUL</font></strong></td>
		<td><strong><font color="'.$warnatext.'">TAHUN PENGADAAN</font></strong></td>
		<td><strong><font color="'.$warnatext.'">HARGA (RP)</font></strong></td>
		<td><strong><font color="'.$warnatext.'">KONDISI (B,KB,RB)</font></strong></td>
		<td><strong><font color="'.$warnatext.'">KET</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
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
				$i_kode = balikin($data['barang_kode']);
				$i_nama = balikin($data['barang_nama']);
				$i_register = balikin($data['register']);
				$i_kontruksi = balikin($data['kontruksi']);
				$i_panjang = balikin($data['panjang']);
				$i_lebar = balikin($data['lebar']);
				$i_luas = balikin($data['luas']);
				$i_lokasi = balikin($data['lokasi']);
				$i_dokumen_tgl = balikin($data['dokumen_tgl']);
				$i_dokumen_nomor = balikin($data['dokumen_nomor']);
				$i_tanah_status = balikin($data['tanah_status']);
				$i_tanah_kode = balikin($data['tanah_kode']);
				$i_asal_usul = balikin($data['asal_usul']);
				$i_tahun_ada = balikin($data['tahun_ada']);
				$i_harga = balikin($data['harga']);
				$i_kondisi = balikin($data['kondisi']);
				$i_ket = balikin($data['ket']);

				$i_postdate = balikin($data['postdate']);
	
				
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
		        </td>
				<td>'.$i_kode.'</td>
				<td>'.$i_nama.'</td>
				<td>'.$i_register.'</td>
				<td>'.$i_kontruksi.'</td>
				<td>'.$i_panjang.'</td>
				<td>'.$i_lebar.'</td>
				<td>'.$i_luas.'</td>
				<td>'.$i_lokasi.'</td>
				<td>'.$i_dokumen_tgl.'</td>
				<td>'.$i_dokumen_nomor.'</td>
				<td>'.$i_tanah_status.'</td>
				<td>'.$i_tanah_kode.'</td>
				<td>'.$i_asal_usul.'</td>
				<td>'.$i_tahun_ada.'</td>
				<td>'.$i_harga.'</td>
				<td>'.$i_kondisi.'</td>
				<td>'.$i_ket.'</td>
				<td>'.$i_postdate.'</td>
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





	//jika E /////////////////////////////////////////////////////////////////////////////////////////////
	else if ($katkd == "E")
		{
		$warnatext = "white";
		
		//jika null
		if (empty($kunci))
			{
			$sqlcount = "SELECT * FROM inv_kib_e ".
							"ORDER BY round(barang_kode) ASC";
			}
			
		else
			{
			$sqlcount = "SELECT * FROM inv_kib_e ".
							"WHERE barang_kode LIKE '%$kunci%' ".
							"OR barang_nama LIKE '%$kunci%' ".
							"OR buku_judul LIKE '%$kunci%' ".
							"OR buku_spek LIKE '%$kunci%' ".
							"OR corak_asal LIKE '%$kunci%' ".
							"OR corak_pencipta LIKE '%$kunci%' ".
							"OR corak_bahan LIKE '%$kunci%' ".
							"OR hewan_jenis LIKE '%$kunci%' ".
							"OR hewan_ukuran LIKE '%$kunci%' ".
							"OR jumlah LIKE '%$kunci%' ".
							"OR tahun_cetak LIKE '%$kunci%' ".
							"OR asal_usul LIKE '%$kunci%' ".
							"OR tahun_beli LIKE '%$kunci%' ".
							"OR harga LIKE '%$kunci%' ".
							"OR ket LIKE '%$kunci%' ".
							"ORDER BY round(barang_kode) ASC";
			}
			
			
		
		//query
		$target = "$filenya?katkd=$katkd";
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
		<input name="btnIM" type="submit" value="IMPORT DATA" class="btn btn-success">
		<input name="btnEX" type="submit" value="EXPORT DATA" class="btn btn-success">
		<input name="katkd" type="hidden" value="'.$katkd.'">
		</p>
		
		</form>
	
	
	
		<form action="'.$filenya.'" method="post" name="formx">
		<p>
		<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
		<input name="katkd" type="hidden" value="'.$katkd.'">
		<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
		<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
		</p>
			
		
		<div class="table-responsive">          
		<table class="table" border="1">
		<thead>
		
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="20">&nbsp;</td>
		<td><strong><font color="'.$warnatext.'">KODE</font></strong></td>
		<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
		<td><strong><font color="'.$warnatext.'">REGISTER</font></strong></td>
		<td><strong><font color="'.$warnatext.'">BUKU_JUDUL</font></strong></td>
		<td><strong><font color="'.$warnatext.'">BUKU_SPEK</font></strong></td>
		<td><strong><font color="'.$warnatext.'">CORAK_ASAL</font></strong></td>
		<td><strong><font color="'.$warnatext.'">CORAK_PENCIPTA</font></strong></td>
		<td><strong><font color="'.$warnatext.'">CORAK_BAHAN</font></strong></td>
		<td><strong><font color="'.$warnatext.'">HEWAN_JENIS</font></strong></td>
		<td><strong><font color="'.$warnatext.'">HEWAN_UKURAN</font></strong></td>
		<td><strong><font color="'.$warnatext.'">JUMLAH</font></strong></td>
		<td><strong><font color="'.$warnatext.'">TAHUN CETAK</font></strong></td>
		<td><strong><font color="'.$warnatext.'">ASAL_USUL</font></strong></td>
		<td><strong><font color="'.$warnatext.'">TAHUN BELI</font></strong></td>
		<td><strong><font color="'.$warnatext.'">HARGA(RP)</font></strong></td>
		<td><strong><font color="'.$warnatext.'">KET</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
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
				$i_kode = balikin($data['barang_kode']);
				$i_nama = balikin($data['barang_nama']);
				$i_register = balikin($data['register']);
				$i_buku_judul = balikin($data['buku_judul']);
				$i_buku_spek = balikin($data['buku_spek']);
				$i_corak_asal = balikin($data['corak_asal']);
				$i_corak_pencipta = balikin($data['corak_pencipta']);
				$i_corak_bahan = balikin($data['corak_bahan']);
				$i_hewan_jenis = balikin($data['hewan_jenis']);
				$i_hewan_ukuran = balikin($data['hewan_ukuran']);
				$i_jumlah = balikin($data['jumlah']);
				$i_tahun_cetak = balikin($data['tahun_cetak']);
				$i_asal_usul = balikin($data['asal_usul']);
				$i_tahun_beli = balikin($data['tahun_beli']);
				$i_harga = balikin($data['harga']);
				$i_ket = balikin($data['ket']);

				$i_postdate = balikin($data['postdate']);
	
				
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
		        </td>
				<td>'.$i_kode.'</td>
				<td>'.$i_nama.'</td>
				<td>'.$i_register.'</td>
				<td>'.$i_buku_judul.'</td>
				<td>'.$i_buku_spek.'</td>
				<td>'.$i_corak_asal.'</td>
				<td>'.$i_corak_pencipta.'</td>
				<td>'.$i_corak_bahan.'</td>
				<td>'.$i_hewan_jenis.'</td>
				<td>'.$i_hewan_ukuran.'</td>
				<td>'.$i_jumlah.'</td>
				<td>'.$i_tahun_cetak.'</td>
				<td>'.$i_asal_usul.'</td>
				<td>'.$i_tahun_beli.'</td>
				<td>'.$i_harga.'</td>
				<td>'.$i_ket.'</td>
				<td>'.$i_postdate.'</td>
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







	//jika F /////////////////////////////////////////////////////////////////////////////////////////////
	else if ($katkd == "F")
		{
		$warnatext = "white";
		
		//jika null
		if (empty($kunci))
			{
			$sqlcount = "SELECT * FROM inv_kib_f ".
							"ORDER BY round(barang_kode) ASC";
			}
			
		else
			{
			$sqlcount = "SELECT * FROM inv_kib_f ".
							"WHERE barang_kode LIKE '%$kunci%' ".
							"OR barang_nama LIKE '%$kunci%' ".
							"OR kontruksi_tingkat LIKE '%$kunci%' ".
							"OR kontruksi_beton LIKE '%$kunci%' ".
							"OR luas LIKE '%$kunci%' ".
							"OR alamat LIKE '%$kunci%' ".
							"OR dokumen_tgl LIKE '%$kunci%' ".
							"OR dokumen_nomor LIKE '%$kunci%' ".
							"OR mulai_tgl LIKE '%$kunci%' ".
							"OR tanah_status LIKE '%$kunci%' ".
							"OR tanah_kode LIKE '%$kunci%' ".
							"OR asal_usul LIKE '%$kunci%' ".
							"OR harga LIKE '%$kunci%' ".
							"OR ket LIKE '%$kunci%' ".
							"ORDER BY round(barang_kode) ASC";
			}
			
			
		
		//query
		$target = "$filenya?katkd=$katkd";
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
		<input name="btnIM" type="submit" value="IMPORT DATA" class="btn btn-success">
		<input name="btnEX" type="submit" value="EXPORT DATA" class="btn btn-success">
		<input name="katkd" type="hidden" value="'.$katkd.'">
		</p>
		
		</form>
	
	
	
		<form action="'.$filenya.'" method="post" name="formx">
		<p>
		<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
		<input name="katkd" type="hidden" value="'.$katkd.'">
		<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
		<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
		</p>
			
		
		<div class="table-responsive">          
		<table class="table" border="1">
		<thead>
		
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="20">&nbsp;</td>
		<td><strong><font color="'.$warnatext.'">KODE</font></strong></td>
		<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
		<td><strong><font color="'.$warnatext.'">REGISTER</font></strong></td>
		<td><strong><font color="'.$warnatext.'">KONTRUKSI TINGKAT</font></strong></td>
		<td><strong><font color="'.$warnatext.'">KONTRUKSI BETON</font></strong></td>
		<td><strong><font color="'.$warnatext.'">LUAS(M2)</font></strong></td>
		<td><strong><font color="'.$warnatext.'">ALAMAT</font></strong></td>
		<td><strong><font color="'.$warnatext.'">DOKUMEN TANGGAL</font></strong></td>
		<td><strong><font color="'.$warnatext.'">DOKUMEN NOMOR</font></strong></td>
		<td><strong><font color="'.$warnatext.'">TANGGAL MULAI</font></strong></td>
		<td><strong><font color="'.$warnatext.'">TANAH STATUS</font></strong></td>
		<td><strong><font color="'.$warnatext.'">TAHUN KODE</font></strong></td>
		<td><strong><font color="'.$warnatext.'">ASAL_USUL</font></strong></td>
		<td><strong><font color="'.$warnatext.'">HARGA(RP)</font></strong></td>
		<td><strong><font color="'.$warnatext.'">KET</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
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
				$i_kode = balikin($data['barang_kode']);
				$i_nama = balikin($data['barang_nama']);
				$i_register = balikin($data['register']);
				$i_kontruksi_tingkat = balikin($data['kontruksi_tingkat']);
				$i_kontruksi_beton = balikin($data['kontruksi_beton']);
				$i_luas = balikin($data['luas']);
				$i_alamat = balikin($data['alamat']);
				$i_dokumen_tgl = balikin($data['dokumen_tgl']);
				$i_dokumen_nomor = balikin($data['dokumen_nomor']);
				$i_mulai_tgl = balikin($data['mulai_tgl']);
				$i_tanah_status = balikin($data['tanah_status']);
				$i_tanah_kode = balikin($data['tanah_kode']);
				$i_asal_usul = balikin($data['asal_usul']);
				$i_harga = balikin($data['harga']);
				$i_ket = balikin($data['ket']);

				$i_postdate = balikin($data['postdate']);
	
				
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
		        </td>
				<td>'.$i_kode.'</td>
				<td>'.$i_nama.'</td>
				<td>'.$i_register.'</td>
				<td>'.$i_kontruksi_tingkat.'</td>
				<td>'.$i_kontruksi_beton.'</td>
				<td>'.$i_luas.'</td>
				<td>'.$i_alamat.'</td>
				<td>'.$i_dokumen_tgl.'</td>
				<td>'.$i_dokumen_nomor.'</td>
				<td>'.$i_mulai_tgl.'</td>
				<td>'.$i_tanah_status.'</td>
				<td>'.$i_tanah_kode.'</td>
				<td>'.$i_asal_usul.'</td>
				<td>'.$i_harga.'</td>
				<td>'.$i_ket.'</td>
				<td>'.$i_postdate.'</td>
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






	else
		{
		//ketahui postdate terakhir
		$qku = mysqli_query($koneksi, "SELECT postdate FROM inv_kib_a ".
											"ORDER BY postdate DESC");
		$rku = mysqli_fetch_assoc($qku);
		$ku_kib_a = balikin($rku['postdate']);
		
		//ketahui postdate terakhir
		$qku = mysqli_query($koneksi, "SELECT postdate FROM inv_kib_b ".
											"ORDER BY postdate DESC");
		$rku = mysqli_fetch_assoc($qku);
		$ku_kib_b = balikin($rku['postdate']);
		
		//ketahui postdate terakhir
		$qku = mysqli_query($koneksi, "SELECT postdate FROM inv_kib_c ".
											"ORDER BY postdate DESC");
		$rku = mysqli_fetch_assoc($qku);
		$ku_kib_c = balikin($rku['postdate']);
		
		//ketahui postdate terakhir
		$qku = mysqli_query($koneksi, "SELECT postdate FROM inv_kib_d ".
											"ORDER BY postdate DESC");
		$rku = mysqli_fetch_assoc($qku);
		$ku_kib_d = balikin($rku['postdate']);
		
		//ketahui postdate terakhir
		$qku = mysqli_query($koneksi, "SELECT postdate FROM inv_kib_e ".
											"ORDER BY postdate DESC");
		$rku = mysqli_fetch_assoc($qku);
		$ku_kib_e = balikin($rku['postdate']);
		
		//ketahui postdate terakhir
		$qku = mysqli_query($koneksi, "SELECT postdate FROM inv_kib_f ".
											"ORDER BY postdate DESC");
		$rku = mysqli_fetch_assoc($qku);
		$ku_kib_f = balikin($rku['postdate']);
		
		?>
		
		<h3>UPDATE TERAKHIR :</h3>
			
		<div class="row">
			
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">KIB-A.TANAH</span>
                <span class="info-box-number"><?php echo $ku_kib_a;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">KIB-B.PERALATAN DAN MESIN</span>
                <span class="info-box-number"><?php echo $ku_kib_b;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">KIB-C.GEDUNG DAN BANGUNAN</span>
                <span class="info-box-number"><?php echo $ku_kib_c;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          



          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">KIB-D.JALAN,IRIGASI DAN JARINGAN</span>
                <span class="info-box-number"><?php echo $ku_kib_d;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          



          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">KIB-E.ASET TETAP LAINNYA</span>
                <span class="info-box-number"><?php echo $ku_kib_e;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          


          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">KIB-F.KONTRUKSI DALAM PENYELESAIAN</span>
                <span class="info-box-number"><?php echo $ku_kib_f;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          

          
          <!-- /.col -->
        </div>
        <!-- /.row -->

	<?php
		}
	}

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