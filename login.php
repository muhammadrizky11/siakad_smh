<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://github.com/hajirodeon                      ///////
///////     * http://gitlab.com/hajirodeon                      ///////
///////     * http://sisfokol.wordpress.com                     ///////
///////     * http://hajirodeon.wordpress.com                   ///////
///////     * http://yahoogroup.com/groups/sisfokol             ///////
///////     * https://www.youtube.com/@hajirodeon               ///////
///////////////////////////////////////////////////////////////////////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS/WA : 081-829-88-54                               ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////

session_start();


//ambil nilai
require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");
require("inc/class/paging.php");
$tpl = LoadTpl("template/cp_login.html");





//nilai
$filenya = "login.php";
$filenya_ke = $sumber;
$judul = "Login SISFOKOL";
$judulku = $judul;
$pesan = "Ada Kesalahan Username/Password. Silahkan Diperhatikan Lagi..!!";






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//kasi log login ///////////////////////////////////////////////////////////////////////////////////
$todayx = $today;
	


	//ketahui ip
function get_client_ip_env() {
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';
	
		return $ipaddress;
	}


$ipku = get_client_ip_env();


					
			
			
																	
				










//jika batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





if ($_POST['btnOK'])
	{
	//ambil nilai
	$tipe = nosql($_POST["tipe"]);
	$username = cegah($_POST["usernamex"]);
	$password = md5(cegah($_POST["passwordx"]));

	
	//cek null
	if ((empty($tipe)) OR (empty($username)) OR (empty($password)))
		{
		//diskonek
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//jika tp01 --> GURU ................................................................................
		if ($tipe == "tp01")
			{
			//query
			$q = mysqli_query($koneksi, "SELECT m_pegawai.*, m_pegawai.kd AS mpkd, m_mapel.* ".
											"FROM m_pegawai, m_mapel ".
											"WHERE m_mapel.pegawai_kd = m_pegawai.kd ".
											"AND m_pegawai.usernamex = '$username' ".
											"AND m_pegawai.passwordx = '$password'");
			$row = mysqli_fetch_assoc($q);
			$total = mysqli_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//bikin session
				$_SESSION['kd1_session'] = nosql($row['mpkd']);
				$_SESSION['tipe_session'] = "GURU MAPEL";
				$_SESSION['no1_session'] = nosql($row['kode']);
				$_SESSION['nip1_session'] = nosql($row['kode']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				$_SESSION['username1_session'] = $username;
				$_SESSION['pass1_session'] = $password;
				$_SESSION['guru_session'] = "GURU MAPEL";
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admgr";


				
				//detail
				$ku_yes = "GURU MAPEL";
				$ku_kd = cegah($row['mpkd']);
				$ku_kode = cegah($row['kode']);
				$ku_nama = cegah($row['nama']);
			
					
				
				
				//insert
				mysqli_query($koneksi, "INSERT INTO user_log_login(kd, user_kd, user_kode, user_nama, ".
											"user_posisi, user_jabatan, ipnya, lat_x, lat_y, postdate) VALUES ".
											"('$x', '$ku_kd', '$ku_kode', '$ku_nama', ".
											"'$ku_yes', '$ku_yes', '$ipku', '$nilx', '$nily', '$today')");
				//kasi log login ///////////////////////////////////////////////////////////////////////////////////







				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admgr/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................




		//jika tp02 --> SISWA ...............................................................................
		if ($tipe == "tp02")
			{
			//query
			$q = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
											"WHERE usernamex = '$username' ".
											"AND passwordx = '$password'");
			$row = mysqli_fetch_assoc($q);
			$total = mysqli_num_rows($q);


			//cek login
			if ($total != 0)
				{
				session_start();

				//bikin session
				$_SESSION['kd2_session'] = nosql($row['kd']);
				$_SESSION['nis2_session'] = nosql($row['kode']);
				$_SESSION['username2_session'] = $username;
				$_SESSION['pass2_session'] = $password;
				$_SESSION['siswa_session'] = "SISWA";
				$_SESSION['nm2_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['kd1_session'] = nosql($row['kd']);
				$_SESSION['tipe_session'] = "SISWA";
				$_SESSION['no1_session'] = nosql($row['kode']);
				$_SESSION['nis1_session'] = nosql($row['kode']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				$_SESSION['username1_session'] = $username;
				$_SESSION['pass1_session'] = $password;
				$_SESSION['janiskd'] = "admsw";




				
				//detail
				$ku_yes = "SISWA";
				$ku_kd = cegah($row['kd']);
				$ku_kode = cegah($row['kode']);
				$ku_nama = cegah($row['nama']);
			
					
				
				
				//insert
				mysqli_query($koneksi, "INSERT INTO user_log_login(kd, user_kd, user_kode, user_nama, ".
											"user_posisi, user_jabatan, ipnya, lat_x, lat_y, postdate) VALUES ".
											"('$x', '$ku_kd', '$ku_kode', '$ku_nama', ".
											"'$ku_yes', '$ku_yes', '$ipku', '$nilx', '$nily', '$today')");
				//kasi log login ///////////////////////////////////////////////////////////////////////////////////





				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admsw/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................








		//jika tp03 --> WALI KELAS ..........................................................................
		if ($tipe == "tp03")
			{
			//query
			$q = mysqli_query($koneksi, "SELECT m_walikelas.*, m_pegawai.*, m_pegawai.kd AS mpkd ".
											"FROM m_walikelas, m_pegawai ".
											"WHERE m_walikelas.peg_kd = m_pegawai.kd ".
											"AND m_pegawai.usernamex = '$username' ".
											"AND m_pegawai.passwordx = '$password'");
			$row = mysqli_fetch_assoc($q);
			$total = mysqli_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//bikin session
				$_SESSION['kd1_session'] = nosql($row['mpkd']);
				$_SESSION['tipe_session'] = "WALI KELAS";
				$_SESSION['no1_session'] = nosql($row['kode']);
				$_SESSION['nip1_session'] = nosql($row['kode']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
								
				$_SESSION['kd3_session'] = nosql($row['mpkd']);
				$_SESSION['nip3_session'] = nosql($row['kode']);
				$_SESSION['username3_session'] = $username;
				$_SESSION['pass3_session'] = $password;
				$_SESSION['wk_session'] = "WALI KELAS";
				$_SESSION['nm3_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admwk";

				
								
				//detail
				$ku_yes = "WALI KELAS";
				$ku_kd = cegah($row['mpkd']);
				$ku_kode = cegah($row['nip']);
				$ku_nama = cegah($row['nama']);
			
					
				
				
				//insert
				mysqli_query($koneksi, "INSERT INTO user_log_login(kd, user_kd, user_kode, user_nama, ".
											"user_posisi, user_jabatan, ipnya, lat_x, lat_y, postdate) VALUES ".
											"('$x', '$ku_kd', '$ku_kode', '$ku_nama', ".
											"'$ku_yes', '$ku_yes', '$ipku', '$nilx', '$nily', '$today')");
				//kasi log login ///////////////////////////////////////////////////////////////////////////////////

				
				
				
				
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admwk/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................





		//jika tp04 --> Kepala Sekolah ......................................................................
		if ($tipe == "tp04")
			{
			//query
			$q = mysqli_query($koneksi, "SELECT m_ks.*, m_pegawai.*, m_pegawai.kd AS akkd ".
											"FROM m_ks, m_pegawai ".
											"WHERE m_ks.peg_kd = m_pegawai.kd ".
											"AND m_pegawai.usernamex = '$username' ".
											"AND m_pegawai.passwordx = '$password'");
			$row = mysqli_fetch_assoc($q);
			$total = mysqli_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//bikin session
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Kepala Sekolah";
				$_SESSION['no1_session'] = nosql($row['kode']);
				$_SESSION['nip1_session'] = nosql($row['kode']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd4_session'] = nosql($row['akkd']);
				$_SESSION['nip4_session'] = nosql($row['kode']);
				$_SESSION['username4_session'] = $username;
				$_SESSION['pass4_session'] = $password;
				$_SESSION['ks_session'] = "Kepala Sekolah";
				$_SESSION['nm4_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admks";

				
								
				//detail
				$ku_yes = "KEPALA SEKOLAH";
				$ku_kd = cegah($row['akkd']);
				$ku_kode = cegah($row['kode']);
				$ku_nama = cegah($row['nama']);
			
					
				
				
				//insert
				mysqli_query($koneksi, "INSERT INTO user_log_login(kd, user_kd, user_kode, user_nama, ".
											"user_posisi, user_jabatan, ipnya, lat_x, lat_y, postdate) VALUES ".
											"('$x', '$ku_kd', '$ku_kode', '$ku_nama', ".
											"'$ku_yes', '$ku_yes', '$ipku', '$nilx', '$nily', '$today')");
				//kasi log login ///////////////////////////////////////////////////////////////////////////////////

				
				
				
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admks/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................







		//jika tp06 --> Administrator .......................................................................
		if ($tipe == "tp06")
			{
			//query
			$q = mysqli_query($koneksi, "SELECT * FROM adminx ".
											"WHERE usernamex = '$username' ".
											"AND passwordx = '$password'");
			$row = mysqli_fetch_assoc($q);
			$total = mysqli_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//bikin session
				$_SESSION['kd6_session'] = nosql($row['kd']);
				$_SESSION['username6_session'] = $username;
				$_SESSION['pass6_session'] = $password;
				$_SESSION['adm_session'] = "Administrator";
				$_SESSION['tipe_session'] = "Administrator";
				$_SESSION['hajirobe_session'] = $hajirobe;






				//kasi log login ///////////////////////////////////////////////////////////////////////////////////
				//detail
				$ku_yes = "ADMIN";
				$ku_kd = nosql($row['kd']);
				$ku_kode = $ku_yes;
				$ku_nama = $ku_yes;
			
					
				
				
				//insert
				mysqli_query($koneksi, "INSERT INTO user_log_login(kd, user_kd, user_kode, user_nama, ".
											"user_posisi, user_jabatan, ipnya, lat_x, lat_y, postdate) VALUES ".
											"('$x', '$ku_kd', '$ku_kode', '$ku_nama', ".
											"'$ku_yes', '$ku_yes', '$ipku', '$nilx', '$nily', '$today')");
				//kasi log login ///////////////////////////////////////////////////////////////////////////////////





				


				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "adm/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................







		
		
		//jika tp033 --> piket ..........................................................................
		if ($tipe == "tp033")
			{
			//query
			$q = mysqli_query($koneksi, "SELECT * FROM m_piket ".
											"WHERE usernamex = '$username' ".
											"AND passwordx = '$password'");
			$row = mysqli_fetch_assoc($q);
			$total = mysqli_num_rows($q);
	
			//cek login
			if ($total != 0)
				{
				session_start();
	
				//nilai
				$r_kd = cegah($row['kd']);
				$r_kode = cegah($row['kode']);
				$r_nama = cegah($row['nama']);
				$r_jabatan = cegah($row['jabatan']);
				$r_tglnya = "$tahun-$bulan-$tanggal";
				

				//nilai
				$_SESSION['kd1_session'] = nosql($row['kd']);
				$_SESSION['tipe_session'] = "Petugas Piket";
				$_SESSION['no1_session'] = nosql($row['kode']);
				$_SESSION['nip1_session'] = nosql($row['kode']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd33_session'] = nosql($row['kd']);
				$_SESSION['nip33_session'] = nosql($row['kode']);
				$_SESSION['username33_session'] = $username;
				$_SESSION['pass33_session'] = $password;
				$_SESSION['piket_session'] = "Petugas Piket";
				$_SESSION['nm33_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admpiket";

			
				
								
				//detail
				$ku_yes = "PIKET";
				$ku_kd = cegah($row['kd']);
				$ku_kode = cegah($row['kode']);
				$ku_nama = cegah($row['nama']);
			
					
				
				
				//insert
				mysqli_query($koneksi, "INSERT INTO user_log_login(kd, user_kd, user_kode, user_nama, ".
											"user_posisi, user_jabatan, ipnya, lat_x, lat_y, postdate) VALUES ".
											"('$x', '$ku_kd', '$ku_kode', '$ku_nama', ".
											"'$ku_yes', '$ku_yes', '$ipku', '$nilx', '$nily', '$today')");
				//kasi log login ///////////////////////////////////////////////////////////////////////////////////

				


				
				//re-direct
				$ke = "admpiket/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			//...................................................................................................				
			}
		//...................................................................................................
				






		
		
		//jika tp011 --> bk ..........................................................................
		if ($tipe == "tp011")
			{
			//query
			$q = mysqli_query($koneksi, "SELECT m_gurubk.*, m_pegawai.*, m_pegawai.kd AS akkd ".
											"FROM m_gurubk, m_pegawai ".
											"WHERE m_gurubk.peg_kd = m_pegawai.kd ".
											"AND m_pegawai.usernamex = '$username' ".
											"AND m_pegawai.passwordx = '$password'");
			$row = mysqli_fetch_assoc($q);
			$total = mysqli_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Guru BK";
				$_SESSION['no1_session'] = nosql($row['kode']);
				$_SESSION['nip1_session'] = nosql($row['kode']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd11_session'] = nosql($row['akkd']);
				$_SESSION['nip11_session'] = nosql($row['kode']);
				$_SESSION['username11_session'] = $username;
				$_SESSION['pass11_session'] = $password;
				$_SESSION['bk_session'] = "Guru BK";
				$_SESSION['nm11_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admbk";

				
				
								
				//detail
				$ku_yes = "Guru BK";
				$ku_kd = cegah($row['akkd']);
				$ku_kode = cegah($row['kode']);
				$ku_nama = cegah($row['nama']);
			
					
				
				
				//insert
				mysqli_query($koneksi, "INSERT INTO user_log_login(kd, user_kd, user_kode, user_nama, ".
											"user_posisi, user_jabatan, ipnya, lat_x, lat_y, postdate) VALUES ".
											"('$x', '$ku_kd', '$ku_kode', '$ku_nama', ".
											"'$ku_yes', '$ku_yes', '$ipku', '$nilx', '$nily', '$today')");
				//kasi log login ///////////////////////////////////////////////////////////////////////////////////

				
				
				
				
				
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admbk/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................
				





		
		
		//jika tp042 --> bendahara ..........................................................................
		if ($tipe == "tp042")
			{
			//query
			$q = mysqli_query($koneksi, "SELECT m_bendahara.*, m_pegawai.*, m_pegawai.kd AS akkd ".
											"FROM m_bendahara, m_pegawai ".
											"WHERE m_bendahara.peg_kd = m_pegawai.kd ".
											"AND m_pegawai.usernamex = '$username' ".
											"AND m_pegawai.passwordx = '$password'");
			$row = mysqli_fetch_assoc($q);
			$total = mysqli_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Bendahara";
				$_SESSION['no1_session'] = nosql($row['kode']);
				$_SESSION['nip1_session'] = nosql($row['kode']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd42_session'] = nosql($row['akkd']);
				$_SESSION['nip42_session'] = nosql($row['kode']);
				$_SESSION['username42_session'] = $username;
				$_SESSION['pass42_session'] = $password;
				$_SESSION['bdh_session'] = "Bendahara";
				$_SESSION['nm42_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "admbdh";

				
				
								
				//detail
				$ku_yes = "Bendahara";
				$ku_kd = cegah($row['akkd']);
				$ku_kode = cegah($row['kode']);
				$ku_nama = cegah($row['nama']);
			
					
				
				
				//insert
				mysqli_query($koneksi, "INSERT INTO user_log_login(kd, user_kd, user_kode, user_nama, ".
											"user_posisi, user_jabatan, ipnya, lat_x, lat_y, postdate) VALUES ".
											"('$x', '$ku_kd', '$ku_kode', '$ku_nama', ".
											"'$ku_yes', '$ku_yes', '$ipku', '$nilx', '$nily', '$today')");
				//kasi log login ///////////////////////////////////////////////////////////////////////////////////

				
				
				
				
				
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "admbdh/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................
				

				
				
				
				
				
				
		
		
		//jika tp041 --> sarpras ..........................................................................
		if ($tipe == "tp041")
			{
			//query
			$q = mysqli_query($koneksi, "SELECT m_sarpras.*, m_pegawai.*, m_pegawai.kd AS akkd ".
											"FROM m_sarpras, m_pegawai ".
											"WHERE m_sarpras.peg_kd = m_pegawai.kd ".
											"AND m_pegawai.usernamex = '$username' ".
											"AND m_pegawai.passwordx = '$password'");
			$row = mysqli_fetch_assoc($q);
			$total = mysqli_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['akkd']);
				$_SESSION['tipe_session'] = "Sarpras";
				$_SESSION['no1_session'] = nosql($row['kode']);
				$_SESSION['nip1_session'] = nosql($row['kode']);
				$_SESSION['nm1_session'] = balikin($row['nama']);
				
				$_SESSION['kd41_session'] = nosql($row['akkd']);
				$_SESSION['nip41_session'] = nosql($row['kode']);
				$_SESSION['username41_session'] = $username;
				$_SESSION['pass41_session'] = $password;
				$_SESSION['sarpras_session'] = "Sarpras";
				$_SESSION['nm41_session'] = balikin($row['nama']);
				$_SESSION['hajirobe_session'] = $hajirobe;
				$_SESSION['janiskd'] = "adminv";

				
				
								
				//detail
				$ku_yes = "Sarpras";
				$ku_kd = cegah($row['akkd']);
				$ku_kode = cegah($row['kode']);
				$ku_nama = cegah($row['nama']);
			
					
				
				
				//insert
				mysqli_query($koneksi, "INSERT INTO user_log_login(kd, user_kd, user_kode, user_nama, ".
											"user_posisi, user_jabatan, ipnya, lat_x, lat_y, postdate) VALUES ".
											"('$x', '$ku_kd', '$ku_kode', '$ku_nama', ".
											"'$ku_yes', '$ku_yes', '$ipku', '$nilx', '$nily', '$today')");
				//kasi log login ///////////////////////////////////////////////////////////////////////////////////

				
				
				
				
				
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				$ke = "adminv/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//diskonek
				xfree($q);
				xclose($koneksi);

				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................
				
				
						

												
		}

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//isi *START
ob_start();



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<div class="card card-primary card-tabs">
  <div class="card-header p-0 pt-1">
    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">LOGIN</a>
      </li>

    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-one-tabContent">
      <div class="tab-pane show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

		<?php
		echo '<form action="'.$filenya.'" method="post" name="formx">
		<p>
		<img src="'.$sumber.'/img/support.png" width="24" height="24" border="0">
		<br>
		<select name="tipe" class="btn btn-block btn-warning" required>
		<option value="" selected></option>
		<option value="tp02">Siswa</option>
		<option value="tp01">Guru Mapel</option>
		<option value="tp011">Guru BK</option>
		<option value="tp03">Wali Kelas</option>
		<option value="tp033">Piket</option>
		<option value="tp042">Bendahara</option>
		<option value="tp041">Sarpras</option>
		<option value="tp04">Kepala Sekolah</option>
		<option value="tp06">Administrator</option>
		</select>
		<br>
		
		
		
		Username :
		<br>
		<input name="usernamex" type="text" size="15" onKeyDown="var keyCode = event.keyCode;
		if (keyCode == 13)
			{
			document.formx.btnOK.focus();
			document.formx.btnOK.submit();
			}" class="btn btn-block btn-warning" required>
		<br>
		
		
		Password :
		<br>
		<input name="passwordx" type="password" size="15" onKeyDown="var keyCode = event.keyCode;
		if (keyCode == 13)
			{
			document.formx.btnOK.focus();
			document.formx.btnOK.submit();
			}" class="btn btn-block btn-warning" required>
		<br>
		
		<input name="kd" type="hidden" value="'.$x.'">
		<input name="btnOK" type="submit" value="MASUK &gt;&gt;&gt;" class="btn btn-block btn-danger">
		</p>
		
		
		</form>';
		?>


 
	  </div>



    </div>
  </div>
  <!-- /.card -->
</div>



<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>