<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMK_v6.78_(Code:Tekniknih)                     ///////
/////// (Sistem Informasi Sekolah untuk SMK)                    ///////
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


require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admgr.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admgr.html");





//nilai
$filenya = "absensi.php";
$judul = "[JURNAL MENGAJAR]. ABSENSI SISWA";
$judulku = $judul;
$judulx = $judul;

$jkd = nosql($_REQUEST['jkd']);
$pkd = nosql($_REQUEST['pkd']);
$s = nosql($_REQUEST['s']);
$m = nosql($_REQUEST['m']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
$ke = $filenya;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}





//PROSES ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}







//batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}
	
	
	
	
	
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$jkd = cegah($_POST['jkd']);
	$pkd = cegah($_POST['pkd']);
	$p_tgl = balikin($_POST['p_tgl']);
	
	
	
	//pecah tanggal
	$tgl1_pecah = balikin($p_tgl);
	$tgl1_pecahku = explode("-", $tgl1_pecah);
	$tgl1_tgl = trim($tgl1_pecahku[2]);
	$tgl1_bln = trim($tgl1_pecahku[1]);
	$tgl1_thn = trim($tgl1_pecahku[0]);
	$tgl_entry = "$tgl1_thn-$tgl1_bln-$tgl1_tgl";
	
	
	
	//ketahui jadwalnya
	$qyuk3 = mysqli_query($koneksi, "SELECT * FROM jadwal ".
										"WHERE kd = '$jkd'");
	$ryuk3 = mysqli_fetch_assoc($qyuk3);
	$tyuk3 = mysqli_num_rows($qyuk3);
	//nilai
	$yuk3_kd = balikin($ryuk3['kd']);
	$yuk3_tapel = balikin($ryuk3['tapel']);
	$yuk3_tapel2 = cegah($ryuk3['tapel']);
	$yuk3_smt = balikin($ryuk3['smt']);
	$yuk3_smt2 = cegah($ryuk3['smt']);
	$yuk3_kelas = balikin($ryuk3['kelas']);
	$yuk3_kelas2 = cegah($ryuk3['kelas']);
	$yuk3_jam = balikin($ryuk3['jam_ke']);
	$yuk3_jam2 = cegah($ryuk3['jam_ke']);
	$yuk3_hari = balikin($ryuk3['hari']);
	$yuk3_hari2 = cegah($ryuk3['hari']);
	$yuk3_mapel = balikin($ryuk3['mapel_nama']);
	$yuk3_mapel_kode = balikin($ryuk3['mapel_kode']);
		
	
	
	$peg_kd = cegah($_SESSION['kd1_session']);
	$peg_kode = cegah($_SESSION['nip1_session']);
	$peg_nama = cegah($_SESSION['nm1_session']);
	
	
	

	//hapus
	mysqli_query($koneksi, "DELETE FROM rev_guru_absensi ".
								"WHERE pegawai_kd = '$kd1_session' ".
								"AND tapel = '$yuk3_tapel2' ".
								"AND kelas = '$yuk3_kelas2' ".
								"AND smt = '$yuk3_smt2' ".
								"AND mapel_kode = '$yuk3_mapel_kode'");	

	
	for($i=1;$i<=$limit;$i++)
		{
		//ambil nilai
		$kd = "kd";
		$kd1 = "$kd$i";
		$kdx = nosql($_POST["$kd1"]);

		$abs = "nisnya";
		$abs1 = "$abs$i";
		$nisnya = cegah($_POST["$abs1"]);

		
		//terpilih
		$qbtx = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
											"WHERE kode = '$nisnya'");
		$rowbtx = mysqli_fetch_assoc($qbtx);
		$swnama = cegah($rowbtx['nama']);
		


		$kodenya = "h";
		$abs = "$kodenya";
		$abs1 = "$abs$i";
		$nil_h = cegah($_POST["$abs1"]);

		$kodenya = "i";
		$abs = "$kodenya";
		$abs1 = "$abs$i";
		$nil_i = cegah($_POST["$abs1"]);
	
		$kodenya = "s";
		$abs = "$kodenya";
		$abs1 = "$abs$i";
		$nil_s = cegah($_POST["$abs1"]);

		$kodenya = "a";
		$abs = "$kodenya";
		$abs1 = "$abs$i";
		$nil_a = cegah($_POST["$abs1"]);


		//jika ada
		if (!empty($nil_h))
			{
			$i_nilai = "H";
			}
			
		else if (!empty($nil_i))
			{
			$i_nilai = "I";
			}
			
		else if (!empty($nil_s))
			{
			$i_nilai = "S";
			}
			
		else if (!empty($nil_a))
			{
			$i_nilai = "A";
			}
			
		else 
			{
			$i_nilai = "";
			}
		

		//entri baru
		$xyz = md5("$x$i");


		//echo "$nisnya:$i_nilai <br>";


		//jika ada
		if (!empty($swnama))
			{
			//query
			mysqli_query($koneksi, "INSERT INTO rev_guru_absensi (kd, pegawai_kd, pegawai_kode, pegawai_nama, ".
										"tapel, kelas, smt, ".
										"mapel_kode, mapel_nama, tglnya, ".
										"siswa_nis, siswa_nama, absensi, postdate) VALUES ".
										"('$xyz', '$peg_kd', '$peg_kode', '$peg_nama', ".
										"'$yuk3_tapel2', '$yuk3_kelas2', '$yuk3_smt2', ".
										"'$yuk3_mapel_kode', '$yuk3_mapel', '$tgl_entry', ".
										"'$nisnya', '$swnama', '$i_nilai', '$today')");
			}
		}



	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?jkd=$jkd&pkd=$pkd";
	xloc($ke);
	exit();
	}











//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$jkd = cegah($_POST['jkd']);
	$pkd = cegah($_POST['pkd']);


	//ketahui jadwalnya
	$qyuk3 = mysqli_query($koneksi, "SELECT * FROM jadwal ".
										"WHERE kd = '$jkd'");
	$ryuk3 = mysqli_fetch_assoc($qyuk3);
	$tyuk3 = mysqli_num_rows($qyuk3);
	//nilai
	$yuk3_kd = balikin($ryuk3['kd']);
	$yuk3_tapel = balikin($ryuk3['tapel']);
	$yuk3_tapel2 = cegah($ryuk3['tapel']);
	$yuk3_smt = balikin($ryuk3['smt']);
	$yuk3_smt2 = cegah($ryuk3['smt']);
	$yuk3_kelas = balikin($ryuk3['kelas']);
	$yuk3_kelas2 = cegah($ryuk3['kelas']);
	$yuk3_jam = balikin($ryuk3['jam_ke']);
	$yuk3_jam2 = cegah($ryuk3['jam_ke']);
	$yuk3_hari = balikin($ryuk3['hari']);
	$yuk3_hari2 = cegah($ryuk3['hari']);
	$yuk3_mapel = balikin($ryuk3['mapel_nama']);
	$yuk3_mapel_kode = balikin($ryuk3['mapel_kode']);
		
	
	
	$peg_kd = cegah($_SESSION['kd1_session']);
	$peg_kode = cegah($_SESSION['nip1_session']);
	$peg_nama = cegah($_SESSION['nm1_session']);
	
	
	

	//hapus
	mysqli_query($koneksi, "DELETE FROM rev_guru_absensi ".
								"WHERE pegawai_kd = '$kd1_session' ".
								"AND tapel = '$yuk3_tapel2' ".
								"AND kelas = '$yuk3_kelas2' ".
								"AND smt = '$yuk3_smt2' ".
								"AND mapel_kode = '$yuk3_mapel_kode'");	


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?jkd=$jkd&pkd=$pkd";
	xloc($ke);
	exit();
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();




//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/js/swap.js");




?>


  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  
<?php		
//ketahui jadwalnya
$qyuk3 = mysqli_query($koneksi, "SELECT * FROM jadwal ".
									"WHERE kd = '$jkd'");
$ryuk3 = mysqli_fetch_assoc($qyuk3);
$tyuk3 = mysqli_num_rows($qyuk3);
//nilai
$yuk3_kd = balikin($ryuk3['kd']);
$yuk3_tapel = balikin($ryuk3['tapel']);
$yuk3_tapel2 = cegah($ryuk3['tapel']);
$yuk3_smt = balikin($ryuk3['smt']);
$yuk3_smt2 = cegah($ryuk3['smt']);
$yuk3_kelas = balikin($ryuk3['kelas']);
$yuk3_kelas2 = cegah($ryuk3['kelas']);
$yuk3_jam = balikin($ryuk3['jam_ke']);
$yuk3_jam2 = cegah($ryuk3['jam_ke']);
$yuk3_hari = balikin($ryuk3['hari']);
$yuk3_hari2 = cegah($ryuk3['hari']);
$yuk3_mapel = balikin($ryuk3['mapel_nama']);
$yuk3_mapel_kode = balikin($ryuk3['mapel_kode']);

	

//agenda
$qyuk31 = mysqli_query($koneksi, "SELECT * FROM rev_guru_agenda ".
									"WHERE pegawai_kd = '$kd1_session' ".
									"AND tapel = '$yuk3_tapel2' ".
									"AND kelas = '$yuk3_kelas2' ".
									"AND smt = '$yuk3_smt2' ".
									"AND mapel_kode = '$yuk3_mapel_kode' ".
									"AND kd = '$pkd'");
$ryuk31 = mysqli_fetch_assoc($qyuk31);
$tyuk31 = mysqli_num_rows($qyuk31);
$yuk31_no = balikin($ryuk31['pertemuan_ke']);
$yuk31_namanya = balikin($ryuk31['namanya']);
$yuk31_tglnya = balikin($ryuk31['tglnya']);


		
		
		
//pecah
$pecahnya = explode("-", $yuk31_tglnya);
$p_thn = trim($pecahnya[0]);
$p_bln = trim($pecahnya[1]);
$p_tgl = trim($pecahnya[2]);

$tanggalnya = "$p_thn-$p_bln-$p_tgl";


$dayya = date('D', strtotime($tanggalnya));
$dayList = array(
    'Sun' => 'Minggu',
    'Mon' => 'Senin',
    'Tue' => 'Selasa',
    'Wed' => 'Rabu',
    'Thu' => 'Kamis',
    'Fri' => 'Jumat',
    'Sat' => 'Sabtu'
);

$dinone = $dayList[$dayya];
		
		
		
		

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="agenda.php?jkd='.$jkd.'" class="btn btn-danger"><< DAFTAR AGENDA LAINNYA</a>
<hr>';
?>

	
<div class="row">

            
  <!-- /.col -->
  <div class="col-md-2 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-info"><i class="far fa-flag"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Tahun Pelajaran</span>
        <span class="info-box-number"><?php echo $yuk3_tapel;?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-2 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-info"><i class="fa fa-building-o"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Kelas</span>
        <span class="info-box-number"><?php echo $yuk3_kelas;?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-md-2 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-info"><i class="fa fa-briefcase"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Semester</span>
        <span class="info-box-number"><?php echo $yuk3_smt;?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  
  <!-- /.col -->
  <div class="col-md-2 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-info"><i class="fa fa-tasks"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Hari</span>
        <span class="info-box-number"><?php echo $yuk3_hari;?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  
  <!-- /.col -->
  <div class="col-md-2 col-sm-6 col-12">
    <div class="info-box">
      <span class="info-box-icon bg-info"><i class="fa fa-clock-o"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Jam Ke-</span>
        <span class="info-box-number"><?php echo $yuk3_jam;?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

	
  <!-- /.col -->
  <div class="col-md-4 col-sm-6 col-12">
	
	<div class="info-box mb-3 bg-info">
      <span class="info-box-icon"><i class="fa fa-book"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">MATA PELAJARAN</span>
        <span class="info-box-number"><?php echo $yuk3_mapel;?></span>
      </div>
      <!-- /.info-box-content -->
    </div>

	</div>
	
  <!-- /.col -->
  <div class="col-md-8 col-sm-6 col-12">
	
	<div class="info-box mb-3 bg-primary">
      <span class="info-box-icon"><i class="fa fa-tasks"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">KD/Materi/Pokok Bahasan</span>
        <span class="info-box-number"><?php echo $yuk31_namanya;?></span>
      </div>
      <!-- /.info-box-content -->
    </div>

	</div>

	
	              
</div>





<div class="card card-primary card-tabs">
  <div class="card-header p-0 pt-1">
    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">ENTRI ABSENSI SISWA, PERTEMUAN KE-<?php echo $yuk31_no;?> :  
        	<?php
        	echo '<b>'.$dinone.', '.$p_tgl.' '.$arrbln1[$p_bln].' '.$p_thn.'</b>';
			?>
        </a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-one-tabContent">
      <div class="tab-pane show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">


		<?php
		//query
		$limit = 100;
		$p = new Pager();
		$start = $p->findStart($limit);
	
		$sqlcount = "SELECT * FROM m_siswa ".
						"WHERE tapel = '$yuk3_tapel2' ".
						"AND kelas = '$yuk3_kelas2' ".
						"ORDER BY round(nourut) ASC";
		$sqlresult = $sqlcount;
	
		$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
	
	
		

		//nilai
		$qku = mysqli_query($koneksi, "SELECT * FROM rev_guru_absensi ".
										"WHERE pegawai_kd = '$kd1_session' ".
										"AND tapel = '$yuk3_tapel2' ".
										"AND kelas = '$yuk3_kelas2' ".
										"AND smt = '$yuk3_smt2' ".
										"AND mapel_kode = '$yuk3_mapel_kode' ".
										"ORDER BY postdate DESC");
		$rku = mysqli_fetch_assoc($qku);
		$i_postdate = balikin($rku['postdate']);
	
	

	
		//nek ada
		if ($count != 0)
			{
			echo '<form name="formxx" method="post" action="'.$filenya.'">
			Update Terakhir : <b>'.$i_postdate.'</b>
			<br>
			<div class="table-responsive">          
			<table class="table" border="1">
			<thead>
				<tr valign="top" bgcolor="'.$warnaheader.'">
					<td width="5" align="center"><b>NO.</b></td>
					<td width="50" align="center"><b>NIS</b></td>
					<td align="center"><b>NAMA</b></td>
					<td width="5" align="center"><b>HADIR</b></td>
					<td width="5" align="center"><b>IJIN</b></td>
					<td width="5" align="center"><b>SAKIT</b></td>
					<td width="5" align="center"><b>ALPHA</b></td>
					</tr>
				
			</thead>
			<tbody>';
			
				do
		  			{
					if ($warna_set ==0)
						{
						$warna = $warna01;
						$warna_set = 1;
						}
					else
						{
						$warna = $warna02;
						$warna_set = 0;
						}
		
					$nomer = $nomer + 1;
		
					$i_kd = nosql($data['kd']);
					$i_nis = nosql($data['kode']);
					$i_nis2 = cegah($data['kode']);
					$i_abs = nosql($data['nourut']);
					$i_nama = balikin2($data['nama']);
					$i_nama2 = cegah($data['nama']);
		

		
					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td>
							'.$i_abs.'.
						</td>
						<td>
							'.$i_nis.'
							<input name="nisnya'.$nomer.'" type="hidden" value="'.$i_nis.'">
						</td>
						<td>
							'.$i_nama.'
						</td>';
						
						//nilai
						$qku = mysqli_query($koneksi, "SELECT * FROM rev_guru_absensi ".
															"WHERE pegawai_kd = '$kd1_session' ".
															"AND tapel = '$yuk3_tapel2' ".
															"AND kelas = '$yuk3_kelas2' ".
															"AND smt = '$yuk3_smt2' ".
															"AND mapel_kode = '$yuk3_mapel_kode' ".
															"AND absensi <> '' ".
															"AND siswa_nis = '$i_nis'");
						$rku = mysqli_fetch_assoc($qku);
						$i_nilai = balikin($rku['absensi']);
	
						//jika H
						if ($i_nilai == "H")
							{
							$i_h = "V";
							$i_i = "";
							$i_s = "";
							$i_a = "";
							}
	
						//jika I
						else if ($i_nilai == "I")
							{
							$i_h = "";
							$i_i = "V";
							$i_s = "";
							$i_a = "";
							}
	
						//jika S
						else if ($i_nilai == "S")
							{
							$i_h = "";
							$i_i = "";
							$i_s = "V";
							$i_a = "";
							}
	
						//jika A
						else if ($i_nilai == "A")
							{
							$i_h = "";
							$i_i = "";
							$i_s = "";
							$i_a = "V";
							}
	
	
						else 
							{
							$i_h = "";
							$i_i = "";
							$i_s = "";
							$i_a = "";
							}

				
						echo '<td>
						<input name="h'.$nomer.'" id="h'.$nomer.'" type="text" size="1" value="'.$i_h.'" 
						onclick="document.getElementById(\'h'.$nomer.'\').value = \'V\';
						document.getElementById(\'i'.$nomer.'\').value = \'\';
						document.getElementById(\'s'.$nomer.'\').value = \'\';
						document.getElementById(\'a'.$nomer.'\').value = \'\';" 
						class="btn btn-warning">
						</td>
						<td>
						<input name="i'.$nomer.'" id="i'.$nomer.'" type="text" size="1" value="'.$i_i.'" 
						onclick="document.getElementById(\'h'.$nomer.'\').value = \'\';
						document.getElementById(\'i'.$nomer.'\').value = \'V\';
						document.getElementById(\'s'.$nomer.'\').value = \'\';
						document.getElementById(\'a'.$nomer.'\').value = \'\';" 
						class="btn btn-warning">
						</td>
						
						<td>
						<input name="s'.$nomer.'" id="s'.$nomer.'" type="text" size="1" value="'.$i_s.'" 
						onclick="document.getElementById(\'h'.$nomer.'\').value = \'\';
						document.getElementById(\'i'.$nomer.'\').value = \'\';
						document.getElementById(\'s'.$nomer.'\').value = \'V\';
						document.getElementById(\'a'.$nomer.'\').value = \'\';" 
						class="btn btn-warning">
						</td>
						
						<td>
						<input name="a'.$nomer.'" id="a'.$nomer.'" type="text" size="1" value="'.$i_a.'" 
						onclick="document.getElementById(\'h'.$nomer.'\').value = \'\';
						document.getElementById(\'i'.$nomer.'\').value = \'\';
						document.getElementById(\'s'.$nomer.'\').value = \'\';
						document.getElementById(\'a'.$nomer.'\').value = \'V\';" 
						class="btn btn-warning">
						</td>';
							
							
						//netralkan
						$juk2_no = "";


					echo '</tr>';
					}
				while ($data = mysqli_fetch_assoc($result));
				

				//nilai
				$qku = mysqli_query($koneksi, "SELECT * FROM rev_guru_absensi ".
													"WHERE pegawai_kd = '$kd1_session' ".
													"AND tapel = '$yuk3_tapel2' ".
													"AND kelas = '$yuk3_kelas2' ".
													"AND smt = '$yuk3_smt2' ".
													"AND mapel_kode = '$yuk3_mapel_kode' ".
													"AND absensi = 'H'");
				$t_hadir = mysqli_num_rows($qku);



				//nilai
				$qku = mysqli_query($koneksi, "SELECT * FROM rev_guru_absensi ".
													"WHERE pegawai_kd = '$kd1_session' ".
													"AND tapel = '$yuk3_tapel2' ".
													"AND kelas = '$yuk3_kelas2' ".
													"AND smt = '$yuk3_smt2' ".
													"AND mapel_kode = '$yuk3_mapel_kode' ".
													"AND absensi = 'I'");
				$t_ijin = mysqli_num_rows($qku);



				//nilai
				$qku = mysqli_query($koneksi, "SELECT * FROM rev_guru_absensi ".
													"WHERE pegawai_kd = '$kd1_session' ".
													"AND tapel = '$yuk3_tapel2' ".
													"AND kelas = '$yuk3_kelas2' ".
													"AND smt = '$yuk3_smt2' ".
													"AND mapel_kode = '$yuk3_mapel_kode' ".
													"AND absensi = 'S'");
				$t_sakit = mysqli_num_rows($qku);

				
				//nilai
				$qku = mysqli_query($koneksi, "SELECT * FROM rev_guru_absensi ".
													"WHERE pegawai_kd = '$kd1_session' ".
													"AND tapel = '$yuk3_tapel2' ".
													"AND kelas = '$yuk3_kelas2' ".
													"AND smt = '$yuk3_smt2' ".
													"AND mapel_kode = '$yuk3_mapel_kode' ".
													"AND absensi = 'A'");
				$t_alpha = mysqli_num_rows($qku);
				
				
				echo '<tr valign="top" bgcolor="'.$warnaheader.'">
					<td width="5" align="center">&nbsp;</td>
					<td width="50" align="center">&nbsp;</td>
					<td align="right"><b>TOTAL</b></td>
					<td width="5" align="center"><b>'.$t_hadir.'</b></td>
					<td width="5" align="center"><b>'.$t_ijin.'</b></td>
					<td width="5" align="center"><b>'.$t_sakit.'</b></td>
					<td width="5" align="center"><b>'.$t_alpha.'</b></td>
					</tr>
				
				</tbody>
			</table>
			</div>
	
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td>
			<strong><font color="#FF0000">'.$count.'</font></strong> Data.
			<br>
			<br>
		
			<input name="jml" type="hidden" value="'.$count.'">
			<input name="s" type="hidden" value="'.$s.'">
			<input name="kd" type="hidden" value="'.$kdx.'">
			<input name="page" type="hidden" value="'.$page.'">
			<input name="jkd" type="hidden" value="'.$jkd.'">
			<input name="pkd" type="hidden" value="'.$pkd.'">
			<input name="p_tgl" type="hidden" value="'.$tanggalnya.'">
			<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
			<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-primary">
			
			<a href="absensi_pdf.php?jkd='.$jkd.'&pkd='.$pkd.'" class="btn btn-success" target="_blank">CETAK PDF >></a>
			
			</td>
			</tr>
			</table>
			</form>';
			}
	
		else
			{
			echo '<p>
			<font color="red"><strong>TIDAK ADA DATA.</strong></font>
			</p>';
			}
							

		
		?>

 
		</div>


 
                  </div>

            </div>
          </div>
          
          
          <!-- /.card -->
        </div>



<?php
//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>