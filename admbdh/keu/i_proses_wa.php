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




//detail e
$qku = mysqli_query($koneksi, "SELECT * FROM wa_tagihan_siswa ".
								"WHERE round(DATE_FORMAT(postdate, '%d')) = '$tanggal' ".
								"AND round(DATE_FORMAT(postdate, '%m')) = '$bulan' ".
								"AND round(DATE_FORMAT(postdate, '%Y')) = '$tahun' ".
								"ORDER BY RAND()");
$rku = mysqli_fetch_assoc($qku);
$tku_tagihan = mysqli_num_rows($qku);


//detail e
$qku = mysqli_query($koneksi, "SELECT * FROM wa_tagihan_siswa ".
								"WHERE round(DATE_FORMAT(postdate, '%d')) = '$tanggal' ".
								"AND round(DATE_FORMAT(postdate, '%m')) = '$bulan' ".
								"AND round(DATE_FORMAT(postdate, '%Y')) = '$tahun' ".
								"AND terkirim = 'false' ".
								"ORDER BY RAND()");
$rku = mysqli_fetch_assoc($qku);
$tku = mysqli_num_rows($qku);
$e_kd = balikin($rku['kd']);
$e_nowa = cegah($rku['siswa_nowa']);
$e_swnama = cegah($rku['siswa_nama']);
$e_swnama2 = balikin($rku['siswa_nama']);
$e_swnis = cegah($rku['siswa_nis']);
$e_kelas = cegah($rku['kelas']);
$e_kelas2 = balikin($rku['kelas']);
$cob_kurang = cegah($rku['nominal']);


//jika ada
if (!empty($tku))
	{
	//detail e
	$qku = mysqli_query($koneksi, "SELECT * FROM wa_tagihan_siswa ".
									"WHERE round(DATE_FORMAT(postdate, '%d')) = '$tanggal' ".
									"AND round(DATE_FORMAT(postdate, '%m')) = '$bulan' ".
									"AND round(DATE_FORMAT(postdate, '%Y')) = '$tahun' ".
									"AND terkirim = 'true' ".
									"ORDER BY RAND()");
	$rku = mysqli_fetch_assoc($qku);
	$tku_terkirim = mysqli_num_rows($qku);
	
	$tku_belum = $tku - $tku_terkirim;
	$tku_belum_persen = round(($tku_terkirim / $tku_tagihan) * 100);
	
	
	//update kan
	mysqli_query($koneksi, "UPDATE wa_tagihan_siswa SET terkirim = 'true' ".
								"WHERE kd = '$e_kd'");
	
	
	echo '<div class="row">
	 <div class="col-md-12 col-sm-6 col-12">
	            <div class="info-box bg-danger">
	              <span class="info-box-icon"><i class="fas fa-comments"></i></span>
	
	              <div class="info-box-content">
	                <span class="info-box-text">Pengiriman Message WA : +62'.$e_nowa.' ['.$e_swnama.'. NIS:'.$e_swnis.'. KELAS:'.$e_kelas.']</span>
	                <span class="info-box-number">'.$tku.' SISWA TAGIHAN</span>
	
	                <div class="progress">
	                  <div class="progress-bar" style="width: '.$tku_belum_persen.'%"></div>
	                </div>
	                <span class="progress-description">
	                  '.$tku_terkirim.' Message Siswa Terkirim. ['.$tku_belum_persen.'%].
	                </span>
	              </div>
	            </div>
	          </div>
	 </div>
	</div>';
	
	
	
	
	//jika ada
	if (!empty($e_nowa))
		{		
		//kirim wa
		$yuk_nowa = balikin($e_nowa);
		
		$tglnow = ''.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'';
		$rinciannya = 'TAGIHAN KEUANGAN SISWA
Per '.$tglnow.'

TOTAL TUNGGAKAN : 
'.xduit3($cob_kurang).'

Info Selengkapnya, Silahkan bisa hubungi Bendahara Sekolah. Terima kasih.';



$pesannya = "$tglnow
$e_swnama2
NIS:$e_swnis 
KELAS:$e_kelas2

$rinciannya

";
			 
		
		echo '<form name="formxku'.$e_swnis.'" id="formxku'.$e_swnis.'">
		<textarea id="pesanku" name="pesanku" hidden>'.$pesannya.';'.$yuk_nowa.';'.$apikey.';0</textarea>
		</form>';								
		?>
		
		
		
		
		<script language='javascript'>
		//membuat document jquery
		$(document).ready(function(){
		
		
			var datastring = $("#pesanku").serialize();
			
			$.ajax({
			    url: "<?php echo $sumberya;?>",
			    data: datastring,
			    method: "post",
			    success: function(data) 
			    	{ 
			    	$('#ikirimwa<?php echo $e_swnis;?>').html(data)
			    	}
			});
		
		
		
		
		});
		
		</script>
		
		
		
		<div id="ikirimwa<?php echo $e_swnis;?>"></div>
						
		
		
	
		<?php
		}
	}
else
	{
	echo '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h5><i class="icon fas fa-check"></i> TELAH TERKIRIM</h5>
      TAGIHAN HARI INI, SEMUA MESSAGE WA.
    </div>';
	}
?>