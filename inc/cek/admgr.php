<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd1_session = nosql($_SESSION['kd1_session']);
$tipe_session = balikin2($_SESSION['tipe_session']);
$nip1_session = nosql($_SESSION['nip1_session']);
$nm1_session = balikin2($_SESSION['nm1_session']);
$username1_session = nosql($_SESSION['username1_session']);
$guru_session = nosql($_SESSION['guru_session']);
$pass1_session = nosql($_SESSION['pass1_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admgr";



$qbw = mysqli_query($koneksi, "SELECT kd FROM m_pegawai ".
								"WHERE kd = '$kd1_session' ".
								"AND usernamex = '$username1_session' ".
								"AND passwordx = '$pass1_session'");
$rbw = mysqli_fetch_assoc($qbw);
$tbw = mysqli_num_rows($qbw);

if (($tbw == 0) OR (empty($kd1_session))
	OR (empty($username1_session))
	OR (empty($pass1_session))
	OR (empty($guru_session))
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














//kasi log entri ///////////////////////////////////////////////////////////////////////////////////
$kuz_kd = $kd1_session;
$kuz_kode = $nip1_session;
$kuz_nama = $nm1_session;
$kuz_posisi = "GURU MAPEL";
$kuz_jabatan = "GURU MAPEL";
//kasi log entri ///////////////////////////////////////////////////////////////////////////////////



















//isi *START
ob_start();



//jml notif
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_entri ".
						"WHERE user_kd = '$kd1_session' ".
						"AND user_posisi = '$kuz_posisi' ".
						"AND dibaca = 'false'");
$jml_notif = mysqli_num_rows($qyuk);

echo $jml_notif;


//isi
$i_loker1 = ob_get_contents();
ob_end_clean();








//isi *START
ob_start();



//jml notif
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_login ".
						"WHERE user_kd = '$kd1_session' ".
						"AND user_posisi = '$kuz_posisi' ".
						"AND dibaca = 'false'");
$jml_notif = mysqli_num_rows($qyuk);

echo $jml_notif;


//isi
$i_loker2 = ob_get_contents();
ob_end_clean();











//isi *START
ob_start();



//jml notif
$jml_notif = $i_loker1 + $i_loker2;
echo $jml_notif;


//isi
$i_loker = ob_get_contents();
ob_end_clean();
?>