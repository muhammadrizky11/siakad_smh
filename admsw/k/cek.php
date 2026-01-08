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
require("../../inc/cek/admsw.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admsw.html");





//nilai
$filenya = "cek.php";
$judul = "Kelas Hari Ini";
$judulku = "$judul";
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
	$abskd = cegah($_REQUEST['abskd']);
	$e_pguru_catatan = cegah($_REQUEST['e_pguru_catatan']);



					
	//query
	mysqli_query($koneksi, "UPDATE rev_guru_absensi SET respon_siswa = '$e_pguru_catatan' ".
								"WHERE kd = '$abskd'");



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

<a href="hariini.php" class="btn btn-danger"><< KEMBALI KE DAFTAR </a>
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




	</div>
	
	
	
	
	<!-- /.col -->
    <div class="col-md-6">

		
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
			$yuk3_hari = cegah($ryuk3['hari']);
			$yuk3_mapel = cegah($ryuk3['mapel_nama']);
			$yuk3_mapel_kode = cegah($ryuk3['mapel_kode']);
		
			
			//ketahui gurunya...
			$qok2 = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
											"WHERE tapel LIKE '$yuk3_tapel' ".
											"AND kelas = '$yuk3_kelas' ".
											"AND kode = '$yuk3_mapel_kode' ".
											"ORDER BY tapel DESC");
			$rok2 = mysqli_fetch_assoc($qok2);
			$ok_peg_kd = balikin($rok2['pegawai_kd']);
			$ok_peg_kode = balikin($rok2['pegawai_kode']);
			$ok_peg_kode2 = cegah($rok2['pegawai_kode']);
			$ok_peg_nama = balikin($rok2['pegawai_nama']);
			$ok_peg_nama2 = cegah($rok2['pegawai_nama']);
		
							
			$tglnya = "$tahun-$bulan-$tanggal";
							
					
			
			$qku = mysqli_query($koneksi, "SELECT * FROM rev_guru_absensi ".
												"WHERE pegawai_kd = '$ok_peg_kd' ".
												"AND pegawai_kode = '$ok_peg_kode2' ".
												"AND tapel = '$yuk3_tapel' ".
												"AND kelas = '$yuk3_kelas' ".
												"AND smt = '$yuk3_smt' ".
												"AND mapel_kode = '$yuk3_mapel_kode' ".
												"AND tglnya = '$tglnya' ".
												"AND siswa_nis = '$nis2_session'");
			$rku = mysqli_fetch_assoc($qku);
			$i_pguru_kd = balikin($rku['kd']);
			$i_pguru_catatan = balikin($rku['respon_siswa']);
			
			
			
			//jika masih null
			if (empty($i_pguru_catatan))
				{
				echo '<form name="formxy" method="post" action="'.$filenya.'">
				<p>
				Uraian/Saran/Kritik :
				<br>
				
				<textarea name="e_pguru_catatan" cols="30" rows="5" wrap="yes" class="col-md-12 btn-warning">'.$i_pguru_catatan.'</textarea>
				</p>
				
				<p>
				<input type="hidden" name="jkd" value="'.$jkd.'">
				<input type="hidden" name="akd" value="'.$i_akd.'">
				<input type="hidden" name="abskd" value="'.$i_pguru_kd.'">
				<input name="btnSMPx" type="submit" value="KIRIM >>" class="btn btn-block btn-danger">
				</p>
				
				</form>';
				}
				
			else
				{
				echo "<p>
				<b>
				<i>$i_pguru_catatan</i>
				</b>
				</p>";		
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