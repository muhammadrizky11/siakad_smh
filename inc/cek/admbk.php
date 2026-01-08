<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd11_session = nosql($_SESSION['kd11_session']);
$tipe_session = balikin2($_SESSION['tipe_session']);
$xkd11_session = nosql($_SESSION['xkd11_session']);
$nip11_session = nosql($_SESSION['nip11_session']);
$nm11_session = balikin2($_SESSION['nm11_session']);
$username11_session = nosql($_SESSION['username11_session']);
$bk_session = nosql($_SESSION['bk_session']);
$pass11_session = nosql($_SESSION['pass11_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admbk";


$qbw = mysqli_query($koneksi, "SELECT m_gurubk.kd ".
								"FROM m_gurubk, m_pegawai ".
								"WHERE m_gurubk.peg_kd = m_pegawai.kd ".
								"AND m_pegawai.kd = '$kd11_session' ".
								"AND m_pegawai.usernamex = '$username11_session' ".
								"AND m_pegawai.passwordx = '$pass11_session'");
$rbw = mysqli_fetch_assoc($qbw);
$tbw = mysqli_num_rows($qbw);

if (($tbw == 0) OR (empty($kd11_session))
	OR (empty($username11_session))
	OR (empty($pass11_session))
	OR (empty($bk_session))
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
$kuz_kd = $kd11_session;
$kuz_kode = $nip11_session;
$kuz_nama = $nm11_session;
$kuz_posisi = "Guru BK";
$kuz_jabatan = "Guru BK";
//kasi log entri ///////////////////////////////////////////////////////////////////////////////////

















//isi *START
ob_start();



//jml notif
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_entri ".
									"WHERE user_kd = '$kd11_session' ".
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
									"WHERE user_kd = '$kd11_session' ".
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