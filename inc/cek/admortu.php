<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd21_session = nosql($_SESSION['kd21_session']);
$nis21_session = nosql($_SESSION['nis21_session']);
$tipe_session = balikin2($_SESSION['tipe_session']);
$username21_session = nosql($_SESSION['username21_session']);
$ortu_session = nosql($_SESSION['ortu_session']);
$nm21_session = balikin2($_SESSION['nm21_session']);
$pass21_session = nosql($_SESSION['pass21_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admsw";


$qbw = mysqli_query("SELECT * FROM m_siswa ".
					"WHERE kd = '$kd21_session' ".
					"AND usernamex = '$username21_session' ".
					"AND passwordx_ortu = '$pass21_session'");
$rbw = mysqli_fetch_assoc($qbw);
$tbw = mysqli_num_rows($qbw);

if (($tbw == 0) OR (empty($kd21_session))
	OR (empty($username21_session))
	OR (empty($nis21_session))
	OR (empty($pass21_session))
	OR (empty($ortu_session))
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
$kuz_kd = $kd21_session;
$kuz_kode = $nip21_session;
$kuz_nama = $nm21_session;
$kuz_posisi = "ORTU";
$kuz_jabatan = "ORTU";
//kasi log entri ///////////////////////////////////////////////////////////////////////////////////

















//isi *START
ob_start();



//jml notif
$qyuk = mysqli_query("SELECT * FROM user_log_entri ".
						"WHERE user_kd = '$kd21_session' ".
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
$qyuk = mysqli_query("SELECT * FROM user_log_login ".
						"WHERE user_kd = '$kd21_session' ".
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