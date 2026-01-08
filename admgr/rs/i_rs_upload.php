<?php
sleep(1);
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admgr.php");



//ambil nilai
$e_judul = cegah($_POST['e_judul']);
$e_judul2 = balikin($_POST['e_judul']);
$e_kat = cegah($_POST['e_kat']);
$e_ket = cegah($_POST['e_ket']);
$pegkd = cegah($_POST['pegkd']);
$kd = cegah($_POST['kd']);



//detail pegawai
$qx2 = mysqli_query($koneksi, "SELECT * FROM m_pegawai ".
									"WHERE kd = '$pegkd'");
$rowx2 = mysqli_fetch_assoc($qx2);
$e_pegkode = balikin($rowx2['kode']);
$e_pegnama = balikin($rowx2['nama']);


$ukode = $e_pegkode;
$unama = $e_pegnama;
$uposisi = "GURU MAPEL";
$ujabatan = "GURU MAPEL";






$json = array();
if(!empty($_FILES['upl_file'])){ 
    $dir = "../../filebox/arsip/$pegkd/$kd/"; 
    $allowTypes = array('pdf', 'pdf'); 
    $fileName = basename($_FILES['upl_file']['name']);
	$fsize = $_FILES["upl_file"]["size"]; 
    
	
    $filePath = $dir.$fileName;
    
    //pecah ekstensinya
    $nilku = explode("/", $filePath);
	$nil5 = $nilku[5];
	
    
	//nama baru
    $nilkuy = explode(".", $nil5);
    $extku = $nilkuy[1];
	//$namabaru = "$kd.pdf";
	
	$e_namax = seo_friendly_url($e_pegnama);
	$e_judul2x = seo_friendly_url($e_judul2);
	$namabaru = "$e_pegkode-$e_namax-$e_judul2x.pdf"; 
	
	
	$filePath = $dir.$namabaru;
	
	
	//set ke 755
	$path1 = "../../filebox/arsip/$pegkd";
	chmod($path1,0755);
	
	
	
	//insert
	mysqli_query($koneksi, "INSERT INTO user_filebox(kd, user_kd, user_kode, ".
								"user_nama, user_posisi, kategori, ".
								"user_jabatan, judul, ket, filex, postdate) VALUES ".
								"('$kd', '$pegkd', '$ukode', ".
								"'$unama', '$uposisi', '$e_kat', ".
								"'$ujabatan', '$e_judul', '$e_ket', '$namabaru', '$today')");
	
    
    // Check whether file type is valid 
    $fileType = pathinfo($filePath, PATHINFO_EXTENSION); 
    if(in_array($fileType, $allowTypes)){
    	
		
		//jika kurang dari 10MB
		if($fsize < (10120*10120))
			{ 
	        // Upload file to the server 
	        if(move_uploaded_file($_FILES['upl_file']['tmp_name'], $filePath)){
				//kabarkan berhasil 
	            $json = 'BERHASIL';
				 
		        } else {
		            $json = 'Gagal';
		        }
			}
		else
			{
			$json = 'Gagal';
			}

		
		
        
        
		
		
    } 
}
header('Content-Type: application/json');
echo json_encode($json);
?>