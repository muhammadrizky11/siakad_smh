<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd42_session = nosql($_SESSION['kd42_session']);
$tipe_session = balikin2($_SESSION['tipe_session']);
$xkd42_session = nosql($_SESSION['xkd42_session']);
$nip42_session = nosql($_SESSION['nip42_session']);
$nm42_session = balikin2($_SESSION['nm42_session']);
$username42_session = nosql($_SESSION['username42_session']);
$bdh_session = nosql($_SESSION['bdh_session']);
$pass42_session = nosql($_SESSION['pass42_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admbdh";


$qbw = mysqli_query($koneksi, "SELECT m_bendahara.kd ".
								"FROM m_bendahara, m_pegawai ".
								"WHERE m_bendahara.peg_kd = m_pegawai.kd ".
								"AND m_pegawai.kd = '$kd42_session' ".
								"AND m_pegawai.usernamex = '$username42_session' ".
								"AND m_pegawai.passwordx = '$pass42_session'");
$rbw = mysqli_fetch_assoc($qbw);
$tbw = mysqli_num_rows($qbw);

if (($tbw == 0) OR (empty($kd42_session))
	OR (empty($username42_session))
	OR (empty($pass42_session))
	OR (empty($bdh_session))
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
$kuz_kd = $kd42_session;
$kuz_kode = $nip42_session;
$kuz_nama = $nm42_session;
$kuz_posisi = "Bendahara";
$kuz_jabatan = "Bendahara";
//kasi log entri ///////////////////////////////////////////////////////////////////////////////////

















//isi *START
ob_start();



//jml notif
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_entri ".
									"WHERE user_kd = '$kd42_session' ".
									"AND user_posisi = '$kuz_posisi' ".
									"AND dibaca = 'false'");
$jml_notif = mysqli_num_rows($qyuk);

//jika null
if (empty($jml_notif))
	{
	$jml_notif = 0;
	}
	
echo $jml_notif;


//isi
$i_loker1 = ob_get_contents();
ob_end_clean();





//isi *START
ob_start();



//jml notif
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_login ".
									"WHERE user_kd = '$kd42_session' ".
									"AND user_posisi = '$kuz_posisi' ".
									"AND dibaca = 'false'");
$jml_notif = mysqli_num_rows($qyuk);

//jika null
if (empty($jml_notif))
	{
	$jml_notif = 0;
	}
	
echo $jml_notif;


//isi
$i_loker2 = ob_get_contents();
ob_end_clean();










//jml notif
$qyuk = mysqli_query($koneksi, "SELECT kd AS totalnya ".
								"FROM siswa_bayar_tagihan ".
								"WHERE nominal_kurang > 0");
$jml_notif = mysqli_num_rows($qyuk);

//jika null
if (empty($jml_notif))
	{
	$jml_notif = 0;
	}
	
	
echo $jml_notif;


//isi
$i_loker3 = ob_get_contents();
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