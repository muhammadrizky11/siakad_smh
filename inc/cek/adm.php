<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd6_session = nosql($_SESSION['kd6_session']);
$username6_session = nosql($_SESSION['username6_session']);
$tipe_session = balikin2($_SESSION['tipe_session']);
$adm_session = nosql($_SESSION['adm_session']);
$pass6_session = nosql($_SESSION['pass6_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysqli_query($koneksi, "SELECT kd FROM adminx ".
						"WHERE kd = '$kd6_session' ".
						"AND usernamex = '$username6_session' ".
						"AND passwordx = '$pass6_session'");
$rbw = mysqli_fetch_assoc($qbw);
$tbw = mysqli_num_rows($qbw);

if (($tbw == 0) OR (empty($kd6_session))
	OR (empty($username6_session))
	OR (empty($pass6_session))
	OR (empty($adm_session))
	OR (empty($hajirobe_session)))
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$pesan = "ANDA BELUM LOGIN. SILAHKAN LOGIN DAHULU...!!!";
	pekem($pesan, $sumber);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////











//isi *START
ob_start();



//jml notif
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_entri ".
									"WHERE dibaca = 'false'");
$jml_notif = mysqli_num_rows($qyuk);

echo $jml_notif;


//isi
$i_loker1 = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();



//jml notif
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_login ".
									"WHERE dibaca = 'false'");
$jml_notif = mysqli_num_rows($qyuk);

echo $jml_notif;


//isi
$i_loker2 = ob_get_contents();
ob_end_clean();














//isi *START
ob_start();





//jml notif
$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
									"WHERE round(DATE_FORMAT(postdate, '%d')) = '$tanggal' ".
									"AND round(DATE_FORMAT(postdate, '%m')) = '$bulan' ".
									"AND round(DATE_FORMAT(postdate, '%Y')) = '$tahun'");
$jml_notif = mysqli_num_rows($qyuk);

echo $jml_notif;


//isi
$i_loker3 = ob_get_contents();
ob_end_clean();












//isi *START
ob_start();





//jml notif
$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_absensi ".
									"WHERE round(DATE_FORMAT(tanggal, '%d')) = '$tanggal' ".
									"AND round(DATE_FORMAT(tanggal, '%m')) = '$bulan' ".
									"AND round(DATE_FORMAT(tanggal, '%Y')) = '$tahun'");
$jml_notif = mysqli_num_rows($qyuk);

echo $jml_notif;


//isi
$i_loker4 = ob_get_contents();
ob_end_clean();











//jml notif
$qyuk = mysqli_query($koneksi, "SELECT kd AS totalnya ".
								"FROM siswa_bayar_tagihan ".
								"WHERE nominal_kurang > 0");
$jml_notif = mysqli_num_rows($qyuk);

echo $jml_notif;


//isi
$i_loker5 = ob_get_contents();
ob_end_clean();






									
									
									
									

















//isi *START
ob_start();



//jml notif
$jml_notif = $i_loker1 + $i_loker2 + $i_loker3 + $i_loker4 + $i_loker5;
echo $jml_notif;


//isi
$i_loker = ob_get_contents();
ob_end_clean();













//kasi log entri ///////////////////////////////////////////////////////////////////////////////////
$kuz_kd = "ADMIN";
$kuz_kode = "ADMIN";
$kuz_nama = "ADMIN";
$kuz_posisi = "ADMIN";
$kuz_jabatan = "ADMIN";

$kuz_ket = cegah("MENU : $judulku");			
//kasi log entri ///////////////////////////////////////////////////////////////////////////////////
?>