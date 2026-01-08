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
$filenya = "agenda.php";

$jkd = nosql($_REQUEST['jkd']);
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
	
	
	
	
	
	
	

//simpan pelanggaran
if ($_POST['btnSMPx2'])
	{
	//nilai
	$jkd = cegah($_POST['jkd']);
	$p_tgl = balikin($_POST['p_tgl']);
	
	
	
	//pecah tanggal
	$tgl1_pecah = balikin($p_tgl);
	$tgl1_pecahku = explode("-", $tgl1_pecah);
	$tgl1_tgl = trim($tgl1_pecahku[2]);
	$tgl1_bln = trim($tgl1_pecahku[1]);
	$tgl1_thn = trim($tgl1_pecahku[0]);
	$tgl_entry = "$tgl1_thn-$tgl1_bln-$tgl1_tgl";
	

	$e_no = cegah($_POST['e_no']);
	$e_nama = cegah($_POST['e_nama']);
	$e_indikator = cegah($_POST['e_indikator']);
	$e_catatan = cegah($_POST['e_catatan']);
	$e_lanjut = cegah($_POST['e_lanjut']);




	//ketahui jadwalnya
	$qyuk3 = mysqli_query($koneksi, "SELECT * FROM jadwal ".
										"WHERE kd = '$jkd'");
	$ryuk3 = mysqli_fetch_assoc($qyuk3);
	$yuk3_kd = balikin($ryuk3['kd']);
	$yuk3_tapel = cegah($ryuk3['tapel']);
	$yuk3_smt = cegah($ryuk3['smt']);
	$yuk3_kelas = cegah($ryuk3['kelas']);
	$yuk3_jam = cegah($ryuk3['jam_ke']);	
	$yuk3_waktu = balikin($ryuk3['waktu']);
	//$yuk3_jamnya = cegah("$yuk3_jam ($yuk3_waktu)");
	$yuk3_hari = cegah($ryuk3['hari']);
	$yuk3_mapel = cegah($ryuk3['mapel_nama']);
	$yuk3_mapel_kode = cegah($ryuk3['mapel_kode']);


	$peg_kd = cegah($_SESSION['kd1_session']);
	$peg_kode = cegah($_SESSION['nip1_session']);
	$peg_nama = cegah($_SESSION['nm1_session']);





	//cek
	if ((empty($e_nama)) OR (empty($e_indikator)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?jkd=$jkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//insert
		mysqli_query($koneksi, "INSERT INTO rev_guru_agenda (kd, pegawai_kd, pegawai_kode, pegawai_nama, ".
									"tapel, kelas, smt, ".
									"mapel_kode, mapel_nama, pertemuan_ke, tglnya, ".
									"jamnya, namanya, indikatornya, ".
									"catatan, tindak_lanjut, postdate) VALUES ".
									"('$x', '$peg_kd', '$peg_kode', '$peg_nama', ".
									"'$yuk3_tapel', '$yuk3_kelas', '$yuk3_smt', ".
									"'$yuk3_mapel_kode', '$yuk3_mapel', '$e_no', '$tgl_entry', ".
									"'$yuk3_jam', '$e_nama', '$e_indikator', ".
									"'$e_catatan', '$e_lanjut', '$today')");


		//re-direct
		$ke = "$filenya?jkd=$jkd";
		xloc($ke);
		exit();
		}
	}




//jika hapus daftar
if ($s == "hapus")
	{
	//nilai
	$pkd = cegah($_REQUEST['pkd']);
	$jkd = cegah($_REQUEST['jkd']);

	
	//hapus
	mysqli_query($koneksi, "DELETE FROM rev_guru_agenda ".
								"WHERE kd = '$pkd'");


	//re-direct
	$ke = "$filenya?jkd=$jkd";
	xloc($ke);
	exit();
	}
	
	
	
	
	
	
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$pkd = cegah($_REQUEST['pkd']);
	$jkd = cegah($_REQUEST['jkd']);


	
	
	for($i=1;$i<=$limit;$i++)
		{
		//ambil nilai
		$kd = "kdnya";
		$kd1 = "$kd$i";
		$kdx = nosql($_POST["$kd1"]);

		$abs = "e_no";
		$abs1 = "$abs$i";
		$e_no = cegah($_POST["$abs1"]);

		$abs = "e_nama";
		$abs1 = "$abs$i";
		$e_nama = cegah($_POST["$abs1"]);


		$abs = "e_indikatornya";
		$abs1 = "$abs$i";
		$e_indikatornya = cegah($_POST["$abs1"]);
		

		$abs = "e_catatan";
		$abs1 = "$abs$i";
		$e_catatan = cegah($_POST["$abs1"]);


		$abs = "e_lanjut";
		$abs1 = "$abs$i";
		$e_lanjut = cegah($_POST["$abs1"]);



		//update
		mysqli_query($koneksi, "UPDATE rev_guru_agenda SET namanya = '$e_nama', ".
									"pertemuan_ke = '$e_no', ".
									"indikatornya = '$e_indikatornya', ".
									"catatan = '$e_catatan', ".
									"tindak_lanjut = '$e_lanjut', ".
									"postdate = '$today' ".
									"WHERE kd = '$kdx'");

			
		}


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?jkd=$jkd";
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


$judul = "[JURNAL MENGAJAR]. DETAIL : $yuk3_mapel";
$judulku = $judul;
$judulx = $judul;

		

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="entri.php" class="btn btn-danger"><< DAFTAR LAINNYA</a>
<hr>';
?>

	
<div class="row">
	
	
	<div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="fa fa-book"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">MATA PELAJARAN</span>
                <span class="info-box-number"><?php echo $yuk3_mapel;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            
            
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
  
</div>





<div class="card card-primary card-tabs">
  <div class="card-header p-0 pt-1">
    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">ENTRI BARU</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">DAFTAR AGENDA</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-one-tabContent">
      <div class="tab-pane show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">


		<?php
		//entry
		echo '<form name="formx2" method="post" action="'.$filenya.'">
		<p>
		Pertemuan ke-:
		<br>
		<input name="e_no" type="text" value="'.$e_no.'" size="5" class="btn btn-warning" onKeyPress="return numbersonly(this, event)"> 
		</p>

		
		<p>
		Tanggal Pertemuan : 
		<br>
		<input type="date" name="p_tgl" id="p_tgl" value="'.$e_tgl.'" size="10" class="btn btn-warning">
		</p>

		<p>
		KD/Materi/Pokok Bahasan :
		<br>
		<textarea name="e_nama" cols="100%" rows="3" wrap="yes" class="btn-warning"></textarea>
		</p>



		<p>
		Sub Pokok Bahasan / Indikator Pencapaian Kompetensi :
		<br>
		<textarea name="e_indikator" cols="100%" rows="3" wrap="yes" class="btn-warning"></textarea>
		</p>
		

		<p>
		Catatan Kegiatan :
		<br>
		<textarea name="e_catatan" cols="100%" rows="3" wrap="yes" class="btn-warning"></textarea>
		</p>
		
		

		<p>
		Tindak Lanjut :
		<br>
		<textarea name="e_lanjut" cols="100%" rows="3" wrap="yes" class="btn-warning"></textarea>
		</p>
		


		<p>
		<input type="submit" name="btnSMPx2" value="SIMPAN >>" class="btn btn-danger">
		<input type="hidden" name="s" value="'.$s.'">
		<input type="hidden" name="jkd" value="'.$jkd.'">
		<input type="hidden" name="kdx" value="'.$kdx.'">
		</p>
		
		</form>';
		?>

 
		</div>
      <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">

			<?php
			//query
			$p = new Pager();
			$limit = 1000;
			$start = $p->findStart($limit);
			
			$sqlcount = "SELECT * FROM rev_guru_agenda ".
							"WHERE pegawai_kd = '$kd1_session' ".
							"AND tapel = '$yuk3_tapel2' ".
							"AND kelas = '$yuk3_kelas2' ".
							"AND smt = '$yuk3_smt2' ".
							"AND mapel_kode = '$yuk3_mapel_kode' ".
							"ORDER BY round(pertemuan_ke) ASC";
			$sqlresult = $sqlcount;
			
			$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?jkd=$jkd";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);




			//nilai
			$qku = mysqli_query($koneksi, "SELECT postdate FROM rev_guru_agenda ".
											"WHERE pegawai_kd = '$kd1_session' ".
											"AND tapel = '$yuk3_tapel2' ".
											"AND kelas = '$yuk3_kelas2' ".
											"AND smt = '$yuk3_smt2' ".
											"AND mapel_kode = '$yuk3_mapel_kode' ".
											"ORDER BY postdate DESC");
			$rku = mysqli_fetch_assoc($qku);
			$ku_postdate = balikin($rku['postdate']);
	
							
							
			//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			echo '<form name="formx" method="post" action="'.$filenya.'">
		
			<input type="hidden" name="s" value="'.$s.'">
			<input type="hidden" name="jkd" value="'.$jkd.'">
			<input type="hidden" name="kdx" value="'.$kdx.'">
			
			<div class="row">
			
				<div class="col-md-12">
					<div class="box">
					
						<div class="box-body">
						
						<p>
						[Jumlah Agenda : <b>'.$count.'</b>].
						</p>
	
							<div class="table-responsive">          
							<table class="table" border="1">
							<thead>
							
							<tr valign="top" bgcolor="'.$warnaheader.'">
							<td width="50"><strong><font color="'.$warnatext.'">PERTEMUAN KE-</font></strong></td>
							<td width="50"><strong><font color="'.$warnatext.'">TANGGAL</font></strong></td>
							<td><strong><font color="'.$warnatext.'">KD/Materi/Pokok Bahasan</font></strong></td>
							<td><strong><font color="'.$warnatext.'">Sub Pokok Bahasan / Indikator Pencapaian Kompetensi</font></strong></td>
							<td><strong><font color="'.$warnatext.'">Catatan Kegiatan</font></strong></td>
							<td><strong><font color="'.$warnatext.'">Tindak Lanjut</font></strong></td>
							<td><strong><font color="'.$warnatext.'">Siswa_Tidak_Hadir</font></strong></td>
							</tr>
							</thead>
							<tbody>';
							
							if ($count != 0)
								{
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
									$i_pke = balikin($data['pertemuan_ke']);
									$i_tgl = balikin($data['tglnya']);
									$i_nama = balikin($data['namanya']);
									$i_indikatornya = balikin($data['indikatornya']);
									$i_catatan = balikin($data['catatan']);
									$i_lanjut = balikin($data['tindak_lanjut']);
							
									echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
									echo '<td>
									<input name="e_no'.$nomer.'" type="text" value="'.$i_pke.'" size="5" class="btn btn-warning" onKeyPress="return numbersonly(this, event)">
									</td>
									<td>
									'.$i_tgl.'
									<input name="kdnya'.$nomer.'" type="hidden" value="'.$i_kd.'">
									<br>
									<a href="'.$filenya.'?jkd='.$jkd.'&s=hapus&pkd='.$i_kd.'" class="btn btn-block btn-danger">HAPUS >></a>
									<br>
									<br>
									
									<a href="agenda_pdf.php?jkd='.$jkd.'&pkd='.$i_kd.'" class="btn btn-block btn-success" target="_blank">CETAK PDF >></a>
									</td>
									<td>
									
									<textarea name="e_nama'.$nomer.'" cols="30" rows="5" wrap="yes" class="btn-warning">'.$i_nama.'</textarea>

									<hr>';
									
									//nilai
									$qku = mysqli_query($koneksi, "SELECT kd FROM rev_guru_absensi ".
																	"WHERE pegawai_kd = '$kd1_session' ".
																	"AND tapel = '$yuk3_tapel2' ".
																	"AND kelas = '$yuk3_kelas2' ".
																	"AND smt = '$yuk3_smt2' ".
																	"AND mapel_kode = '$yuk3_mapel_kode' ".
																	"AND tglnya = '$i_tgl' ".
																	"ORDER BY postdate DESC");
									$rku = mysqli_fetch_assoc($qku);
									$t_absensi = mysqli_num_rows($qku);
									
									
									

									
									echo '<a href="absensi.php?jkd='.$jkd.'&pkd='.$i_kd.'" class="btn btn-block btn-danger">ABSENSI SISWA ['.$t_absensi.'] >></a>
									<br>
									</td>
									<td>
									<textarea name="e_indikatornya'.$nomer.'" cols="30" rows="5" wrap="yes" class="btn-warning">'.$i_indikatornya.'</textarea>
									</td>
									<td>
									
									<textarea name="e_catatan'.$nomer.'" cols="30" rows="5" wrap="yes" class="btn-warning">'.$i_catatan.'</textarea>
									
									</td>
									<td>
									
									<textarea name="e_lanjut'.$nomer.'" cols="30" rows="5" wrap="yes" class="btn-warning">'.$i_lanjut.'</textarea>
									
									</td>
									
									<td>';
									
									//list tidak hadir
									$qku = mysqli_query($koneksi, "SELECT * FROM rev_guru_absensi ".
																		"WHERE pegawai_kd = '$kd1_session' ".
																		"AND tapel = '$yuk3_tapel2' ".
																		"AND kelas = '$yuk3_kelas2' ".
																		"AND smt = '$yuk3_smt2' ".
																		"AND mapel_kode = '$yuk3_mapel_kode' ".
																		"AND tglnya = '$i_tgl' ".
																		"AND absensi <> 'H' ".
																		"ORDER BY siswa_nama ASC");
									$rku = mysqli_fetch_assoc($qku);
									$tku = mysqli_num_rows($qku);
									
									//jika ada
									if (!empty($tku))
										{
										do
											{
											$j_no = $j_no + 1;
											$j_nis = balikin($rku['siswa_nis']);
											$j_nama = balikin($rku['siswa_nama']);
											
											echo "$j_no. $j_nama [NIS:$j_nis].  <br><br>";	
											}
										while ($rku = mysqli_fetch_assoc($qku));
										}
										
									
									echo '</td>
							        </tr>';
									}
								while ($data = mysqli_fetch_assoc($result));
								}
							
							
							echo '</tbody>
							  </table>
							  </div>
	
						</div>
					</div>
				</div>

				<br>
				<br>
				<input name="btnSMP" type="submit" value="SIMPAN >>" class="btn btn-block btn-danger">
				<br>
				<i>Update Terakhir : '.$ku_postdate.'</i>
				
				</form>';
				?>



 
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