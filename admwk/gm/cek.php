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


//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admwk.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admwk.html");





//nilai
$filenya = "cek.php";
$judul = "Mengajar Hari Ini";
$judulku = "[GURU MENGAJAR]. $judul";
$judulx = $judul;
$s = cegah($_REQUEST['s']);
$jkd = cegah($_REQUEST['jkd']);






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ($_POST['btnSMPx'])
	{
	//nilai
	$akd = cegah($_REQUEST['akd']);
	$jkd = cegah($_REQUEST['jkd']);
	$e_pguru = cegah($_REQUEST['e_pguru']);
	$e_pguru_catatan = cegah($_REQUEST['e_pguru_catatan']);



	//update
	mysqli_query($koneksi, "UPDATE rev_guru_agenda SET wk_presensi = '$e_pguru', ".
								"wk_catatan = '$e_pguru_catatan', ".
								"wk_postdate = '$today' ".
								"WHERE kd = '$akd'");



	//re-direct
	$ke = "$filenya?jkd=$jkd&akd=$akd";
	xloc($ke);
	exit();
	}






	
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$jkd = cegah($_POST['jkd']);
	$p_tgl = "$tahun-$bulan-$tanggal";
	
	
	
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
		
	
	
	
	//ketahui gurunya...
	$qok2 = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
									"WHERE tapel LIKE '$yuk3_tapel2' ".
									"AND kelas = '$yuk3_kelas2' ".
									"AND kode = '$yuk3_mapel_kode' ".
									"ORDER BY tapel DESC");
	$rok2 = mysqli_fetch_assoc($qok2);
	$ok_peg_kd = balikin($rok2['pegawai_kd']);
	$ok_peg_kode = balikin($rok2['pegawai_kode']);
	$ok_peg_nama = balikin($rok2['pegawai_nama']);

	
	
	

	

	//hapus
	mysqli_query($koneksi, "DELETE FROM rev_guru_absensi ".
								"WHERE pegawai_kd = '$ok_peg_kd' ".
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
										"('$xyz', '$ok_peg_kd', '$ok_peg_kode', '$ok_peg_nama', ".
										"'$yuk3_tapel2', '$yuk3_kelas2', '$yuk3_smt2', ".
										"'$yuk3_mapel_kode', '$yuk3_mapel', '$tgl_entry', ".
										"'$nisnya', '$swnama', '$i_nilai', '$today')");
			}
		}



	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?jkd=$jkd&akd=$akd";
	xloc($ke);
	exit();
	}











//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$jkd = cegah($_POST['jkd']);
	$akd = cegah($_POST['akd']);


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
		
	

	
	
	//ketahui gurunya...
	$qok2 = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
									"WHERE tapel LIKE '$yuk3_tapel2' ".
									"AND kelas = '$yuk3_kelas2' ".
									"AND kode = '$yuk3_mapel_kode' ".
									"ORDER BY tapel DESC");
	$rok2 = mysqli_fetch_assoc($qok2);
	$ok_peg_kd = balikin($rok2['pegawai_kd']);
	$ok_peg_kode = balikin($rok2['pegawai_kode']);
	$ok_peg_nama = balikin($rok2['pegawai_nama']);

	
	
	

	//hapus
	mysqli_query($koneksi, "DELETE FROM rev_guru_absensi ".
								"WHERE pegawai_kd = '$ok_peg_kd' ".
								"AND tapel = '$yuk3_tapel2' ".
								"AND kelas = '$yuk3_kelas2' ".
								"AND smt = '$yuk3_smt2' ".
								"AND mapel_kode = '$yuk3_mapel_kode'");	


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?jkd=$jkd&akd=$akd";
	xloc($ke);
	exit();
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
?>


  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  
<?php
$tglnya = "$tahun-$bulan-$tanggal";

//pecah
$pecahnya = explode("-", $tglnya);
$p_thn = trim($pecahnya[0]);
$p_bln = trim($pecahnya[1]);
$p_bln2 = $arrbln1[$p_bln];
$p_tgl = trim($pecahnya[2]);

$tanggalnya = "$p_thn-$p_bln-$p_tgl";
$tanggalnya2 = "$p_tgl $p_bln2 $p_thn";


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






//nilainya
$qok = mysqli_query($koneksi, "SELECT * FROM jadwal ".
								"WHERE kd = '$jkd'");
$rok = mysqli_fetch_assoc($qok);
$ok_tapel = balikin($rok['tapel']);
$ok_tapel2 = cegah($rok['tapel']);
$ok_smt = balikin($rok['smt']);
$ok_smt2 = cegah($rok['smt']);
$ok_kelas = balikin($rok['kelas']);
$ok_kelas2 = cegah($rok['kelas']);
$ok_hari = balikin($rok['hari']);
$ok_hari2 = cegah($rok['hari']);
$ok_jam = balikin($rok['jam_ke']);
$ok_jam2 = cegah($rok['jam_ke']);
$ok_waktu = balikin($rok['waktu']);
$ok_waktu2 = cegah($rok['waktu']);
$ok_mapel_kode = balikin($rok['mapel_kode']);
$ok_mapel_kode2 = cegah($rok['mapel_kode']);
$ok_mapel_nama = balikin($rok['mapel_nama']);
$ok_mapel_nama2 = cegah($rok['mapel_nama']);


//ketahui gurunya...
$qok2 = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
								"WHERE tapel LIKE '%$tahun%' ".
								"AND kelas = '$ok_kelas2' ".
								"AND kode = '$ok_mapel_kode' ".
								"ORDER BY tapel DESC");
$rok2 = mysqli_fetch_assoc($qok2);
$ok_peg_kd = balikin($rok2['pegawai_kd']);
$ok_peg_kode = balikin($rok2['pegawai_kode']);
$ok_peg_nama = balikin($rok2['pegawai_nama']);




//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formxx" method="post" action="'.$filenya.'">

<a href="jadwal.php" class="btn btn-danger"><< KEMBALI KE DAFTAR </a>
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">

<tr>
<td>
Tahun Pelajaran : <b>'.$ok_tapel.'</b>. 

Semester : <b>'.$ok_smt.'</b>.

Kelas : <b>'.$ok_kelas.'</b>.

Mata Pelajaran : <b>'.$ok_mapel_nama.'</b> 
</b>.
</td>
</tr>

<tr>
<td>
Hari, Tanggal : <b>'.$dinone.', '.$tanggalnya2.'</b>. 

Jam ke-<b>'.$ok_jam.'</b>. 

Waktu : <b>'.$ok_waktu.'</b>  
</td>
</tr>


</table>

</form>
<br>';
?>

	<!-- Info boxes -->
  <div class="row">

    <!-- /.col -->
    <div class="col-md-6">
        

        <div class="card">
          <div class="card-header border-transparent">
            <h3 class="card-title">AGENDA GURU MENGAJAR</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>


          <div class="card-footer">

			<?php
			$qku = mysqli_query($koneksi, "SELECT * FROM rev_guru_agenda ".
												"WHERE pegawai_kd = '$ok_peg_kd' ".
												"AND tapel = '$ok_tapel2' ".
												"AND kelas = '$ok_kelas2' ".
												"AND smt = '$ok_smt2' ".
												"AND mapel_kode = '$ok_mapel_kode2' ".
												"AND tglnya = '$tglnya'");
			$rku = mysqli_fetch_assoc($qku);
			$i_akd = balikin($rku['kd']);
			$i_kurikulum = balikin($rku['kurikulum']);
			$i_pke = balikin($rku['pertemuan_ke']);
			$i_nama = balikin($rku['namanya']);
			$i_indikatornya = balikin($rku['indikatornya']);
			$i_catatan = balikin($rku['catatan']);
			$i_lanjut = balikin($rku['tindak_lanjut']);
			
			
			$i_pguru = balikin($rku['wk_presensi']);
			$i_pguru_catatan = balikin($rku['wk_catatan']);
			$i_pguru_postdate = balikin($rku['wk_postdate']);
			
			
			//jika H
			if ($i_pguru == "H")
				{
				$i_pguru_ket = "Hadir";
				}
				
			else if ($i_pguru == "I")
				{
				$i_pguru_ket = "Ijin";
				}
				
			else if ($i_pguru == "S")
				{
				$i_pguru_ket = "Sakit";
				}
				
				
			else if ($i_pguru == "A")
				{
				$i_pguru_ket = "Alpha";
				}
			
			
			
			//jika ada
			if (!empty($i_pke))
				{
				//jika KUR13
				if ($i_kurikulum == "KUR13")
					{
					echo '<p>
					<b>PERTEMUAN KE-</b>
					<br>
					'.$i_pke.'
					</p>
					
					<p>
					<b>KD/Materi/Pokok Bahasan :</b> 
					<br>
					'.$i_nama.'
					
					</p>
					
					<p>
					<b>Sub Pokok Bahasan / Indikator Pencapaian Kompetensi :</b> 
					<br>
					'.$i_indikatornya.'
					</p>
					
					<p>
					<b>Catatan Kegiatan :</b> 
					<br>
					'.$i_catatan.'
					</p>
					
					<p>
					<b>Tindak Lanjut :</b>
					<br>
					'.$i_lanjut.'
					</p>';
					}
				else
					{
					echo '<p>
					<b>PERTEMUAN KE-</b>
					<br>
					'.$i_pke.'
					</p>
					
					<p>
					<b>Materi/Pokok Bahasan :</b> 
					<br>
					'.$i_nama.'
					
					</p>
					
					<p>
					<b>Lingkup Materi/Tujuan Pembelajaran :</b> 
					<br>
					'.$i_indikatornya.'
					</p>
					
					<p>
					<b>Catatan Kegiatan :</b> 
					<br>
					'.$i_catatan.'
					</p>
					
					<p>
					<b>Tindak Lanjut :</b>
					<br>
					'.$i_lanjut.'
					</p>';
					}
				}
				
			else
				{
				echo '<font color="red">
				<b>Belum Menuliskan Agenda Mengajar...</b>
				</font>';
				}
			?>
			
			

          </div>



          <!-- /.card-footer -->
        </div>
        <!-- /.card -->



        <div class="card">
          <div class="card-header border-transparent">
            <h3 class="card-title">FEEDBACK/RESPON SISWA</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>


          <div class="card-footer">

			<?php
			//query
			$limit = 100;
			$p = new Pager();
			$start = $p->findStart($limit);
		
			$sqlcount = "SELECT * FROM m_siswa ".
							"WHERE tapel = '$ok_tapel2' ".
							"AND kelas = '$ok_kelas2' ".
							"ORDER BY round(nourut) ASC";
			$sqlresult = $sqlcount;
		
			$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
		
		
			
	
			echo '<div class="table-responsive">          
			<table class="table" border="1">
			<thead>
				<tr valign="top" bgcolor="'.$warnaheader.'">
					<td width="5" align="center"><b>NO.</b></td>
					<td width="50" align="center"><b>NIS</b></td>
					<td align="center"><b>NAMA</b></td>
					<td><b>URAIAN</b></td>
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
															"WHERE pegawai_kd = '$ok_peg_kd' ".
															"AND tapel = '$ok_tapel2' ".
															"AND kelas = '$ok_kelas2' ".
															"AND smt = '$ok_smt2' ".
															"AND mapel_kode = '$ok_mapel_kode2' ".
															"AND absensi <> '' ".
															"AND siswa_nis = '$i_nis'");
						$rku = mysqli_fetch_assoc($qku);
						$i_nilai = balikin($rku['respon_siswa']);

						echo '<td>'.$i_nilai.'</td>';
					echo '</tr>';
					}
				while ($data = mysqli_fetch_assoc($result));
				

				
				echo '</tbody>
			</table>
			</div>';
			?>
          </div>



          <!-- /.card-footer -->
        </div>
        <!-- /.card -->




	</div>
	
	
	
	
	<!-- /.col -->
    <div class="col-md-6">

		
        <div class="card">
          <div class="card-header border-transparent">
            <h3 class="card-title">PRESENSI GURU</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>


          <div class="card-footer">

			<?php
			echo '<form name="formxy" method="post" action="'.$filenya.'">
			
			<p>
			<select name="e_pguru" class="btn btn-warning">
			<option value="'.$i_pguru.'" selected>'.$i_pguru_ket.'</option>
			<option value="H">Hadir</option>
			<option value="I">Ijin</option>
			<option value="S">Sakit</option>
			<option value="A">Alpha</option>
			</select>
			</p>
			
			<p>
			Catatan :
			<br>
			
			<textarea name="e_pguru_catatan" cols="30" rows="5" wrap="yes" class="col-md-12 btn-warning">'.$i_pguru_catatan.'</textarea>
			</p>
			
			<p>
			<input type="hidden" name="jkd" value="'.$jkd.'">
			<input type="hidden" name="akd" value="'.$i_akd.'">
			<input name="btnSMPx" type="submit" value="SIMPAN >>" class="btn btn-block btn-danger">
			</p>
			
			<i>[Postdate : <b>'.$i_pguru_postdate.'</b>]</i>
			</form>';
			?>
			
			
          </div>



          <!-- /.card-footer -->
        </div>
        <!-- /.card -->




        <div class="card">
          <div class="card-header border-transparent">
            <h3 class="card-title">PRESENSI SISWA</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>


          <div class="card-footer">

			<?php
						//query
			$limit = 100;
			$p = new Pager();
			$start = $p->findStart($limit);
		
			$sqlcount = "SELECT * FROM m_siswa ".
							"WHERE tapel = '$ok_tapel2' ".
							"AND kelas = '$ok_kelas2' ".
							"ORDER BY round(nourut) ASC";
			$sqlresult = $sqlcount;
		
			$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
		
		
			
	
		
			//nek ada
			if ($count != 0)
				{
				echo '<form name="formxx" method="post" action="'.$filenya.'">
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
																"WHERE pegawai_kd = '$ok_peg_kd' ".
																"AND tapel = '$ok_tapel2' ".
																"AND kelas = '$ok_kelas2' ".
																"AND smt = '$ok_smt2' ".
																"AND mapel_kode = '$ok_mapel_kode2' ".
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
														"WHERE pegawai_kd = '$ok_peg_kd' ".
														"AND tapel = '$ok_tapel2' ".
														"AND kelas = '$ok_kelas2' ".
														"AND smt = '$ok_smt2' ".
														"AND mapel_kode = '$ok_mapel_kode2' ".
														"AND absensi = 'H'");
					$t_hadir = mysqli_num_rows($qku);
	
	
	
					//nilai
					$qku = mysqli_query($koneksi, "SELECT * FROM rev_guru_absensi ".
														"WHERE pegawai_kd = '$ok_peg_kd' ".
														"AND tapel = '$ok_tapel2' ".
														"AND kelas = '$ok_kelas2' ".
														"AND smt = '$ok_smt2' ".
														"AND mapel_kode = '$ok_mapel_kode2' ".
														"AND absensi = 'I'");
					$t_ijin = mysqli_num_rows($qku);
	
	
	
					//nilai
					$qku = mysqli_query($koneksi, "SELECT * FROM rev_guru_absensi ".
														"WHERE pegawai_kd = '$ok_peg_kd' ".
														"AND tapel = '$ok_tapel2' ".
														"AND kelas = '$ok_kelas2' ".
														"AND smt = '$ok_smt2' ".
														"AND mapel_kode = '$ok_mapel_kode2' ".
														"AND absensi = 'S'");
					$t_sakit = mysqli_num_rows($qku);
	
					
					//nilai
					$qku = mysqli_query($koneksi, "SELECT * FROM rev_guru_absensi ".
														"WHERE pegawai_kd = '$ok_peg_kd' ".
														"AND tapel = '$ok_tapel2' ".
														"AND kelas = '$ok_kelas2' ".
														"AND smt = '$ok_smt2' ".
														"AND mapel_kode = '$ok_mapel_kode2' ".
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



          <!-- /.card-footer -->
        </div>
        <!-- /.card -->



	</div>
	
	
	
	

	</div>
</div>



            

<?php
echo '<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>