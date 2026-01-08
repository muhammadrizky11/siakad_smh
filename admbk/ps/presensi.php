<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_v7.00_(Code:SmartOffice)                       ///////
/////// (Sistem Informasi Sekolah)                              ///////
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
require("../../inc/class/paging.php");
require("../../inc/cek/admbk.php");
$tpl = LoadTpl("../../template/admbk.html");





//nilai
$filenya = "presensi.php";
$judul = "[PRESENSI]. Entri Presensi Harian";
$judulku = "[PRESENSI]. Entri Presensi Harian";
$judulx = $judul;
$artkd = nosql($_REQUEST['artkd']);
$kd = nosql($_REQUEST['kd']);
$s = nosql($_REQUEST['s']);
$kunci = cegah($_REQUEST['kunci']);
$kunci2 = balikin($_REQUEST['kunci']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}
	
	


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//jika cari
if ($_POST['btnCARI'])
	{
	//nilai
	$kunci = cegah($_POST['kunci']);


	//re-direct
	$ke = "$filenya?kunci=$kunci";
	xloc($ke);
	exit();
	}





/*
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$e_kode = cegah($_POST['e_kode']);

	
	
	//detail e
	$qyuk = mysqli_query($koneksi, "SELECT * FROM m_user ".
										"WHERE kode = '$e_kode'");
	$ryuk = mysqli_fetch_assoc($qyuk);
	$yuk_kd = cegah($ryuk['kd']);
	$yuk_nama = cegah($ryuk['nama']);
	$yuk_jabatan = cegah($ryuk['jabatan']);
	$yuk_kelas = cegah($ryuk['kelas']);
	$yuk_tapel = cegah($ryuk['tapel']);
	
	
	
	
	//waktu
	$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_waktu");
	$ryuk2 = mysqli_fetch_assoc($qyuk2);
	$yuk2_mjam = balikin($ryuk2['masuk_jam']);
	$yuk2_mmenit = balikin($ryuk2['masuk_menit']);
	
	
	
	
	
	
	$waktu_awal = strtotime("$tahun-$bulan-$tanggal $yuk2_mjam:$yuk2_mmenit:00");
	$waktu_akhir = strtotime("$tahun-$bulan-$tanggal $jam:$menit:$detik"); // bisa juga waktu sekarang now()
        

    //jika memang terlambat
    if ($waktu_awal < $waktu_akhir)
		{
		//menghitung selisih dengan hasil detik
		$diffnya = $waktu_akhir - $waktu_awal;
		
		//membagi detik menjadi jam
		$jamnya = floor($diffnya / (60 * 60));
		
		//membagi sisa detik setelah dikurangi $jam menjadi menit
		$menitnya = $diffnya - $jamnya * (60 * 60);
		
		//menampilkan / print hasil
		//echo 'Hasilnya adalah '.number_format($diff,0,",",".").' detik<br /><br />';
		//echo 'Sehingga Anda memiliki sisa waktu promosi selama: ' . $jamnya .  ' jam dan ' . floor( $menitnya / 60 ) . ' menit';
		
		$menitnya2 = floor($menitnya / 60);
		
		$nilku = "$jamnya Jam, $menitnya2 Menit";
		}
		
	else
		{
		$nilku = "-";
		$jamnya = "0";
		$menitnya2 = "0";
		}
	
	
	
	
							
	//kd
	$xyz = md5("$tahun:$bulan:$tanggal:$e_kode:MASUK");
	
	
	//jika ada
	if (!empty($yuk_kd))
		{
		//insert
		mysqli_query($koneksi, "INSERT INTO user_presensi(kd, user_kd, user_kode, ".
									"user_nama, user_jabatan, user_tapel, user_kelas, ".
									"tanggal, postdate, status, ".
									"ket, telat_ket, telat_jam, telat_menit) VALUES ".
									"('$xyz', '$yuk_kd', '$e_kode', ".
									"'$yuk_nama', '$yuk_jabatan', '$yuk_tapel', '$yuk_kelas', ".
									"'$today', '$today', 'MASUK', ".
									"'-', '$nilku', '$jamnya', '$menitnya2')");
		}	
	
	
	
	
	
	
					

	//total point nya
	$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
										"WHERE user_kd = '$yuk_kd'");
	$ryuk = mysqli_fetch_assoc($qyuk);
	$tyuk_subtotal = mysqli_num_rows($qyuk);

	

	//jika siswa
	if ($yuk_jabatan == "SISWA")
		{
		//update kan
		mysqli_query($koneksi, "UPDATE m_siswa SET jml_presensi = '$tyuk_subtotal' ".
									"WHERE tapel = '$yuk_tapel' ".
									"AND kode = '$e_kode'");
		}	
		
	else if ($yuk_jabatan == "GURU")
		{
		//update kan
		mysqli_query($koneksi, "UPDATE m_guru SET jml_presensi = '$tyuk_subtotal' ".
									"WHERE kode = '$e_kode'");
		}

	
	
	

	//re-direct
	xloc($filenya);
	exit();
	}
*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();


//require
require("../../template/js/jumpmenu.js");
require("../../template/js/checkall.js");
require("../../template/js/swap.js");
?>


  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  
<?php
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
echo '<form action="'.$filenya.'" method="post" name="formxx">
<p>
KODE : 
<input name="e_kode" type="text" value="'.$e_kode.'" size="10" class="btn btn-warning" required>
<input name="btnSMP" type="submit" value="SIMPAN >>" class="btn btn-danger">
</p>
<hr>

</form>';
*/


echo '<div class="row">

	<div class="col-md-6">
	
	
		<div class="card card-warning">
			<div class="card-header">
				<h3 class="card-title">Presensi QrCode Scanner</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
            </div>
            
            <div class="card-body">';
            ?>
            
            	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
				<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
				
				
				
				<video id="preview" width="100%" height="100%"></video>
				
				<script type="text/javascript">
				
				  let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
				
				  scanner.addListener('scan', function (content) {
				
				    //alert(content);
				    window.location.href = "cek.php?artkd="+content; 
				
				  });
				
				  Instascan.Camera.getCameras().then(function (cameras) {
				
				    if (cameras.length > 0) {
				
				      scanner.start(cameras[0]);
				
				    } else {
				
				      console.error('No cameras found.');
				
				    }
				
				  }).catch(function (e) {
				
				    console.error(e);
				
				  });
				
				</script>
				

        
        
		
			<?php		    
            echo '</div>
        </div>';
	?>
	
	   
	
	
	<?php
	echo '</div>
	


	<div class="col-md-6">
	
		<div class="callout callout-info">
			<h5>Hasil Scan QrCode</h5>
			<hr>

			<p>';

				//jika null
				if (empty($artkd))
					{	
					echo "<h3>
					<font color='red'>
					Silahkan Lakukan Scan QRCODE terlebih dahulu...!!!
					</font>
					</h3>";
					}
					
				//jika ada
				else if (!empty($artkd))
					{
					//query
					$q = mysqli_query($koneksi, "SELECT * FROM m_user ".
													"WHERE kd = '$artkd' ". 
													"OR kode = '$artkd'");
					$row = mysqli_fetch_assoc($q);
					$total = mysqli_num_rows($q);
					
					//cek 
					if (!empty($total))
						{
						//detail e
						$qyuk = mysqli_query($koneksi, "SELECT * FROM m_user ".
															"WHERE kd = '$artkd' ".
															"OR kode = '$artkd'");
						$ryuk = mysqli_fetch_assoc($qyuk);
						$yuk_kd = cegah($ryuk['kd']);
						$yuk_kode = cegah($ryuk['kode']);
						$yuk_kodex = balikin($ryuk['kode']);
						$yuk_nama = cegah($ryuk['nama']);
						$yuk_namax = balikin($ryuk['nama']);
						$yuk_jabatan = cegah($ryuk['jabatan']);
						$yuk_jabatanx = balikin($ryuk['jabatan']);
						$yuk_kelas = cegah($ryuk['kelas']);
						$yuk_kelasx = balikin($ryuk['kelas']);
						$yuk_tapel = cegah($ryuk['tapel']);
						
						
						
						
						//waktu
						$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_waktu");
						$ryuk2 = mysqli_fetch_assoc($qyuk2);
						$yuk2_mjam = balikin($ryuk2['masuk_jam']);
						$yuk2_mmenit = balikin($ryuk2['masuk_menit']);
						
						
						
						
						
						
						$waktu_awal = strtotime("$tahun-$bulan-$tanggal $yuk2_mjam:$yuk2_mmenit:00");
						$waktu_akhir = strtotime("$tahun-$bulan-$tanggal $jam:$menit:$detik"); // bisa juga waktu sekarang now()
					        
					
					    //jika memang terlambat
					    if ($waktu_awal < $waktu_akhir)
							{
							//menghitung selisih dengan hasil detik
							$diffnya = $waktu_akhir - $waktu_awal;
							
							//membagi detik menjadi jam
							$jamnya = floor($diffnya / (60 * 60));
							
							//membagi sisa detik setelah dikurangi $jam menjadi menit
							$menitnya = $diffnya - $jamnya * (60 * 60);
							
							//menampilkan / print hasil
							//echo 'Hasilnya adalah '.number_format($diff,0,",",".").' detik<br /><br />';
							//echo 'Sehingga Anda memiliki sisa waktu promosi selama: ' . $jamnya .  ' jam dan ' . floor( $menitnya / 60 ) . ' menit';
							
							$menitnya2 = floor($menitnya / 60);
							
							$nilku = "$jamnya Jam, $menitnya2 Menit";
							}
							
						else
							{
							$nilku = "-";
							$jamnya = "0";
							$menitnya2 = "0";
							}
						
						
						
						
												
						//kd
						$xyz = md5("$tahun:$bulan:$tanggal:$e_kode:MASUK");
						
						
						//jika ada
						if (!empty($yuk_kd))
							{
							//insert
							mysqli_query($koneksi, "INSERT INTO user_presensi(kd, user_kd, user_kode, ".
														"user_nama, user_jabatan, user_tapel, user_kelas, ".
														"tanggal, postdate, status, ".
														"ket, telat_ket, telat_jam, telat_menit) VALUES ".
														"('$xyz', '$yuk_kd', '$e_kode', ".
														"'$yuk_nama', '$yuk_jabatan', '$yuk_tapel', '$yuk_kelas', ".
														"'$today', '$today', 'MASUK', ".
														"'-', '$nilku', '$jamnya', '$menitnya2')");
							}	
						
						
						
						
						
						
										
					
						//total point nya
						$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
															"WHERE user_kd = '$yuk_kd'");
						$ryuk = mysqli_fetch_assoc($qyuk);
						$tyuk_subtotal = mysqli_num_rows($qyuk);
					
						
					
						//jika siswa
						if ($yuk_jabatan == "SISWA")
							{
							//update kan
							mysqli_query($koneksi, "UPDATE m_siswa SET jml_presensi = '$tyuk_subtotal' ".
														"WHERE tapel = '$yuk_tapel' ".
														"AND kode = '$e_kode'");
														
														
														
							$yuk_ket = "NIS:$yuk_kodex. Kelas:$yuk_kelasx";
							}	
							
						else if ($yuk_jabatan == "GURU")
							{
							//update kan
							mysqli_query($koneksi, "UPDATE m_guru SET jml_presensi = '$tyuk_subtotal' ".
														"WHERE kode = '$e_kode'");
														
							$yuk_ket = "NIP:$yuk_kodex";
							}

	
	
						echo "<p>
						[$today].
						<br>
						Selamat Datang, $yuk_namax.
						<hr> 
						$yuk_jabatanx. $yuk_ket.
						</p>";
						}
					else
						{
						echo "<h3>
						<font color='red'>
						QRCODE TIDAK DITEMUKAN atau SALAH. Silahkan Coba Lagi...!!!
						</font>
						</h3>";
						}
					/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////				
					}
				
						
			echo '</p>
		</div>';
	
	
	
	echo '</div>


</div>';







//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>