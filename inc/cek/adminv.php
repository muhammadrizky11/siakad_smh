<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd41_session = nosql($_SESSION['kd41_session']);
$tipe_session = balikin2($_SESSION['tipe_session']);
$xkd41_session = nosql($_SESSION['xkd41_session']);
$nip41_session = nosql($_SESSION['nip41_session']);
$nm41_session = balikin2($_SESSION['nm41_session']);
$username41_session = nosql($_SESSION['username41_session']);
$sarpras_session = nosql($_SESSION['sarpras_session']);
$pass41_session = nosql($_SESSION['pass41_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "adminv";


$qbw = mysqli_query($koneksi, "SELECT m_sarpras.kd ".
								"FROM m_sarpras, m_pegawai ".
								"WHERE m_sarpras.peg_kd = m_pegawai.kd ".
								"AND m_pegawai.kd = '$kd41_session' ".
								"AND m_pegawai.usernamex = '$username41_session' ".
								"AND m_pegawai.passwordx = '$pass41_session'");
$rbw = mysqli_fetch_assoc($qbw);
$tbw = mysqli_num_rows($qbw);

if (($tbw == 0) OR (empty($kd41_session))
	OR (empty($username41_session))
	OR (empty($pass41_session))
	OR (empty($sarpras_session))
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
$kuz_kd = $kd41_session;
$kuz_kode = $nip41_session;
$kuz_nama = $nm41_session;
$kuz_posisi = "Sarpras";
$kuz_jabatan = "Sarpras";
//kasi log entri ///////////////////////////////////////////////////////////////////////////////////

















//isi *START
ob_start();



//jml notif
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_entri ".
									"WHERE user_kd = '$kd41_session' ".
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
									"WHERE user_kd = '$kd41_session' ".
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