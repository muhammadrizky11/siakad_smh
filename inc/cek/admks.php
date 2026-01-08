<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd4_session = nosql($_SESSION['kd4_session']);
$tipe_session = balikin2($_SESSION['tipe_session']);
$nip4_session = nosql($_SESSION['nip4_session']);
$username4_session = nosql($_SESSION['username4_session']);
$ks_session = nosql($_SESSION['ks_session']);
$nm4_session = balikin2($_SESSION['nm4_session']);
$pass4_session = nosql($_SESSION['pass4_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admks";


$qbw = mysqli_query($koneksi, "SELECT m_ks.kd ".
						"FROM m_ks, m_pegawai ".
						"WHERE m_ks.peg_kd = m_pegawai.kd ".
						"AND m_pegawai.kd = '$kd4_session' ".
						"AND m_pegawai.usernamex = '$username4_session' ".
						"AND m_pegawai.passwordx = '$pass4_session'");
$rbw = mysqli_fetch_assoc($qbw);
$tbw = mysqli_num_rows($qbw);

if (($tbw == 0) OR (empty($kd4_session))
	OR (empty($username4_session))
	OR (empty($pass4_session))
	OR (empty($ks_session))
	OR (empty($nip4_session))
	OR (empty($nm4_session))
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
$kuz_kd = $kd4_session;
$kuz_kode = $nip4_session;
$kuz_nama = $nm4_session;
$kuz_posisi = "Kepala Sekolah";
$kuz_jabatan = "Kepala Sekolah";
//kasi log entri ///////////////////////////////////////////////////////////////////////////////////
















//isi *START
ob_start();



//jml notif
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_entri ".
						"WHERE user_kd = '$kd4_session' ".
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
						"WHERE user_kd = '$kd4_session' ".
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