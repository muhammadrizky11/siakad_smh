<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd2_session = nosql($_SESSION['kd2_session']);
$tipe_session = balikin2($_SESSION['tipe_session']);
$nis2_session = nosql($_SESSION['nis2_session']);
$username2_session = nosql($_SESSION['username2_session']);
$siswa_session = nosql($_SESSION['siswa_session']);
$nm2_session = balikin2($_SESSION['nm2_session']);
$pass2_session = nosql($_SESSION['pass2_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admsw";


$qbw = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
						"WHERE kd = '$kd2_session' ".
						"AND usernamex = '$username2_session' ".
						"AND passwordx = '$pass2_session'");
$rbw = mysqli_fetch_assoc($qbw);
$tbw = mysqli_num_rows($qbw);

if (($tbw == 0) OR (empty($kd2_session))
	OR (empty($username2_session))
	OR (empty($nis2_session))
	OR (empty($pass2_session))
	OR (empty($siswa_session))
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
$kuz_kd = $kd2_session;
$kuz_kode = $nip2_session;
$kuz_nama = $nm2_session;
$kuz_posisi = "Siswa";
$kuz_jabatan = "Siswa";
//kasi log entri ///////////////////////////////////////////////////////////////////////////////////



















//isi *START
ob_start();



//jml notif
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_entri ".
									"WHERE user_kd = '$kd2_session' ".
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
									"WHERE user_kd = '$kd2_session' ".
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