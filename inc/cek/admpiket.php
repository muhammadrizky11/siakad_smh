<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd33_session = nosql($_SESSION['kd33_session']);
$tipe_session = balikin2($_SESSION['tipe_session']);
$xkd33_session = nosql($_SESSION['xkd33_session']);
$nip33_session = nosql($_SESSION['nip33_session']);
$nm33_session = balikin2($_SESSION['nm33_session']);
$username33_session = nosql($_SESSION['username33_session']);
$piket_session = nosql($_SESSION['piket_session']);
$pass33_session = nosql($_SESSION['pass33_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$janiskd = "admpiket";


$qbw = mysqli_query($koneksi, "SELECT kd FROM m_piket ".
						"WHERE kd = '$kd33_session' ".
						"AND usernamex = '$username33_session' ".
						"AND passwordx = '$pass33_session'");
$rbw = mysqli_fetch_assoc($qbw);
$tbw = mysqli_num_rows($qbw);

if (($tbw == 0) OR (empty($kd33_session))
	OR (empty($username33_session))
	OR (empty($pass33_session))
	OR (empty($piket_session))
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
$kuz_kd = $kd33_session;
$kuz_kode = $nip33_session;
$kuz_nama = $nm33_session;
$kuz_posisi = "Piket";
$kuz_jabatan = "Piket";
//kasi log entri ///////////////////////////////////////////////////////////////////////////////////















//isi *START
ob_start();



//jml notif
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_entri ".
									"WHERE user_jabatan = 'PIKET' ".
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
									"WHERE user_jabatan = 'PIKET' ".
									"AND dibaca = 'false'");
$jml_notif = mysqli_num_rows($qyuk);

echo $jml_notif;


//isi
$i_loker2 = ob_get_contents();
ob_end_clean();









//isi *START
ob_start();




//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM user_presensi ".
									"WHERE dibaca = 'false'");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_p_baru = mysqli_num_rows($qtyk);

echo $jml_p_baru;


//isi
$i_loker3 = ob_get_contents();
ob_end_clean();










//isi *START
ob_start();




//query
$qtyk = mysqli_query($koneksi, "SELECT kd FROM siswa_pelanggaran ".
									"WHERE sahya = 'false'");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_p_baru = mysqli_num_rows($qtyk);

echo $jml_p_baru;


//isi
$i_loker4 = ob_get_contents();
ob_end_clean();














//isi *START
ob_start();



//jml notif
$jml_notif = $i_loker1 + $i_loker2 + $i_loker3 + $i_loker4;
echo $jml_notif;


//isi
$i_loker = ob_get_contents();
ob_end_clean();

















//kasi log entri ///////////////////////////////////////////////////////////////////////////////////
$kuz_kd = $kd71_session;
$kuz_kode = $username71_session;
$kuz_nama = $nama71_session;
$kuz_jabatan = "PIKET";

$kuz_ket = cegah("MENU : $judulku");			
//kasi log entri ///////////////////////////////////////////////////////////////////////////////////
?>