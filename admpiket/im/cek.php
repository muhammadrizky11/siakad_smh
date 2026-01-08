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
require("../../inc/cek/admpiket.php");
$tpl = LoadTpl("../../template/admpiket.html");





//nilai
$filenya = "cek.php";
$judul = "[IJIN MASUK PULANG]. Cek QrCode Surat Ijin";
$judulku = "$judul";
$judulx = $judul;
$artkd = nosql($_REQUEST['artkd']);



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////










//isi *START
ob_start();



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<div class="row">

	<div class="col-md-4">
	
	
		<div class="card card-warning">
			<div class="card-header">
				<h3 class="card-title">Preview Camera Scan QrCode</h3>

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
	
	
	
	<div class="col-md-8">
	
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
					$q = mysqli_query($koneksi, "SELECT * FROM user_ijin ".
													"WHERE kd = '$artkd'");
					$row = mysqli_fetch_assoc($q);
					$total = mysqli_num_rows($q);
					
					//cek 
					if (!empty($total))
						{
						//detail 
						$qx = mysqli_query($koneksi, "SELECT * FROM user_ijin ".
														"WHERE kd = '$artkd'");
						$rowx = mysqli_fetch_assoc($qx);
						$e_swkode = balikin($rowx['user_kode']);
						$e_swnama = balikin($rowx['user_nama']);
						$e_swjabatan = balikin($rowx['user_jabatan']);
						$e_swkelas = balikin($rowx['user_kelas']);
						$e_tgl = balikin($rowx['tanggal']);
						$e_postdate = balikin($rowx['postdate']);
						$e_status = balikin($rowx['status']);
						$e_ket = balikin($rowx['ket']);
						
						
						
						
						//pecah
						$pecahnya = explode("-", $e_tgl);
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
						
						
						
						
						
						
						
						//pecah
						$pecahnya = explode(" ", $e_postdate);
						$p_jam = trim($pecahnya[1]);
						
						
						
						
						
						
						//jika masuk
						if ($e_status == "IJIN MASUK")
							{
							$e_status_ket = "JAM DATANG";
							} 
						
						else
							{
							$e_status_ket = "JAM PULANG";
							} 
						
						
						
						
												
												
				
				
						echo '<table width="100%" cellpadding="1" cellspacing="1" border="0">
						<tr valign="top">
						<td align="left">
							
							<font size="4">
							<u><b>SURAT '.$e_status.'</b></u>
							</font>
							
						</td>
						</tr>
						</table>
						
						<br>
						
						
						
						
						<table width="100%" cellpadding="1" cellspacing="1" border="0">';
							
						//jika siswa
						if ($e_swjabatan == "SISWA")
							{
							echo '<tr valign="top">
							<td align="left" width="10">
							a.
							</td>
							<td align="left" width="120">
							NIS
							</td>
							<td align="left" width="10">
							:
							</td>
							<td align="left">
							'.strtoupper($e_swkode).'
							</td>
							</tr>
							
							<tr valign="top">
							<td align="left" width="10">
							b.
							</td>
							<td align="left" width="120">
							NAMA
							</td>
							<td align="left" width="10">
							:
							</td>
							<td align="left">
							'.strtoupper($e_swnama).'
							</td>
							</tr>
							
							
							<tr valign="top">
							<td align="left" width="10">
							c.
							</td>
							<td align="left" width="120">
							KELAS
							</td>
							<td align="left" width="10">
							:
							</td>
							<td align="left">
							'.strtoupper($e_swkelas).'
							</td>
							</tr>
							
							
							<tr valign="top">
							<td align="left" width="10">
							d.
							</td>
							<td align="left" width="120">
							HARI, TANGGAL 
							</td>
							<td align="left" width="10">
							: 
							</td>
							<td align="left">
							'.$dinone.', '.$p_tgl.' '.$arrbln1[$p_bln].' '.$p_thn.'
							</td>
							</tr>
							
							
							<tr valign="top">
							<td align="left" width="10">
							e.
							</td>
							<td align="left" width="120">
							'.$e_status_ket.'
							</td>
							<td align="left" width="10">
							:
							</td>
							<td align="left">
							'.$p_jam.'
							</td>
							</tr>
							
							
							<tr valign="top">
							<td align="left" width="10">
							f.
							</td>
							<td align="left" width="120">
							KETERANGAN
							</td>
							<td align="left" width="10">
							:
							</td>
							<td align="left">
							'.$e_ket.'
							</td>
							</tr>';
							}
						
						else
							{
							echo '<tr valign="top">
							<td align="left" width="10">
							a.
							</td>
							<td align="left" width="120">
							NIP
							</td>
							<td align="left" width="10">
							:
							</td>
							<td align="left">
							'.strtoupper($e_swkode).'
							</td>
							</tr>
							
							<tr valign="top">
							<td align="left" width="10">
							b.
							</td>
							<td align="left" width="120">
							NAMA
							</td>
							<td align="left" width="10">
							:
							</td>
							<td align="left">
							'.strtoupper($e_swnama).'
							</td>
							</tr>
							
							
							<tr valign="top">
							<td align="left" width="10">
							c.
							</td>
							<td align="left" width="120">
							HARI, TANGGAL 
							</td>
							<td align="left" width="10">
							: 
							</td>
							<td align="left">
							'.$dinone.', '.$p_tgl.' '.$arrbln1[$p_bln].' '.$p_thn.'
							</td>
							</tr>
							
							
							<tr valign="top">
							<td align="left" width="10">
							d.
							</td>
							<td align="left" width="120">
							'.$e_status_ket.'
							</td>
							<td align="left" width="10">
							:
							</td>
							<td align="left">
							'.$p_jam.'
							</td>
							</tr>
							
							
							<tr valign="top">
							<td align="left" width="10">
							e.
							</td>
							<td align="left" width="120">
							KETERANGAN
							</td>
							<td align="left" width="10">
							:
							</td>
							<td align="left">
							'.$e_ket.'
							</td>
							</tr>';
							}
						
						
						
						echo '</table>
						<br>
						<br>';
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