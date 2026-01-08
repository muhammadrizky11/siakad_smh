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


//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
require("../inc/cek/admgr.php");
require("../inc/class/paging.php");
$tpl = LoadTpl("../template/admgr.html");





//nilai
$filenya = "index.php";
$judul = "Selamat Datang, $guru_session : $nip1_session.$nm1_session";
$judulku = $judul;
$juduli = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);










//isi *START
ob_start();

//tanggal sekarang
$m = date("m");
$de = date("d");
$y = date("Y");

//ambil 14hari terakhir
for($i=0; $i<=14; $i++)
	{
	$nilku = date('Ymd',mktime(0,0,0,$m,($de-$i),$y)); 

	echo "$nilku, ";
	}


//isi
$isi_data1 = ob_get_contents();
ob_end_clean();










//isi *START
ob_start();

//tanggal sekarang
$m = date("m");
$de = date("d");
$y = date("Y");

//ambil 14hari terakhir
for($i=0; $i<=14; $i++)
	{
	$nilku = date('Y-m-d',mktime(0,0,0,$m,($de-$i),$y)); 


	//pecah
	$ipecah = explode("-", $nilku);
	$itahun = trim($ipecah[0]);  
	$ibln = trim($ipecah[1]);
	$itgl = trim($ipecah[2]);    


	//ketahui ordernya...
	$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_login ".
							"WHERE user_kd = '$kd1_session' ".
							"AND user_posisi = 'GURU MAPEL' ".
							"AND round(DATE_FORMAT(postdate, '%d')) = '$itgl' ".
							"AND round(DATE_FORMAT(postdate, '%m')) = '$ibln' ".
							"AND round(DATE_FORMAT(postdate, '%Y')) = '$itahun'");
	$tyuk = mysqli_num_rows($qyuk);
									
									
	if (empty($tyuk))
		{
		$tyuk = "0";
		}
		
	echo "$tyuk, ";
	}


//isi
$isi_data2 = ob_get_contents();
ob_end_clean();









//isi *START
ob_start();

//tanggal sekarang
$m = date("m");
$de = date("d");
$y = date("Y");

//ambil 14hari terakhir
for($i=0; $i<=14; $i++)
	{
	$nilku = date('Y-m-d',mktime(0,0,0,$m,($de-$i),$y)); 


	//pecah
	$ipecah = explode("-", $nilku);
	$itahun = trim($ipecah[0]);  
	$ibln = trim($ipecah[1]);
	$itgl = trim($ipecah[2]);    


	//ketahui
	$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_entri ".
							"WHERE user_kd = '$kd1_session' ".
							"AND user_posisi = 'GURU MAPEL' ".
							"AND round(DATE_FORMAT(postdate, '%d')) = '$itgl' ".
							"AND round(DATE_FORMAT(postdate, '%m')) = '$ibln' ".
							"AND round(DATE_FORMAT(postdate, '%Y')) = '$itahun'");
	$tyuk = mysqli_num_rows($qyuk);
	
	if (empty($tyuk))
		{
		$tyuk = "0";
		}
		
	echo "$tyuk, ";
	}


//isi
$isi_data3 = ob_get_contents();
ob_end_clean();
















//isi *START
ob_start();

//js
require("../inc/js/swap.js");
require("../inc/js/jumpmenu.js");




//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//postdate entri
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_entri ".
									"WHERE user_kd = '$kd1_session' ".
									"AND user_posisi = 'GURU MAPEL' ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$yuk_entri_terakhir = balikin($ryuk['postdate']);






//postdate login
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_login ".
									"WHERE user_kd = '$kd1_session' ".
									"AND user_posisi = 'GURU MAPEL' ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$yuk_login_terakhir = balikin($ryuk['postdate']);











//jumlah siswa
$qx = mysqli_query($koneksi, "SELECT DISTINCT(kode) AS totalnya ".
								"FROM m_siswa");
$rowx = mysqli_fetch_assoc($qx);
$e_total_siswa = mysqli_num_rows($qx);









?>

		<!-- Info boxes -->
      <div class="row">

        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">SISWA</span>
              <span class="info-box-number"><?php echo $e_total_siswa;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->






        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fa fa-calendar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">LOGIN TERAKHIR</span>
              <span class="info-box-number"><?php echo $yuk_login_terakhir;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        





        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fa fa-calendar-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">ENTRI TERAKHIR</span>
              <span class="info-box-number"><?php echo $yuk_entri_terakhir;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        
                
      </div>
      <!-- /.row -->







				<script>
					$(function () {
					  'use strict'
					
					  var ticksStyle = {
					    fontColor: '#495057',
					    fontStyle: 'bold'
					  }
					
					  var mode      = 'index'
					  var intersect = true
					
					
					  var $visitorsChart = $('#visitors-chart')
					  var visitorsChart  = new Chart($visitorsChart, {
					    data   : {
					      labels  : [<?php echo $isi_data1;?>],
					      datasets: [{
					        type                : 'line',
					        data                : [<?php echo $isi_data2;?>],
					        backgroundColor     : 'transparent',
					        borderColor         : 'blue',
					        pointBorderColor    : 'blue',
					        pointBackgroundColor: 'blue',
					        fill                : false
					        // pointHoverBackgroundColor: '#007bff',
					        // pointHoverBorderColor    : '#007bff'
					      },
					        {
					          type                : 'line',
					          data                : [<?php echo $isi_data3;?>],
					          backgroundColor     : 'tansparent',
					          borderColor         : 'orange',
					          pointBorderColor    : 'orange',
					          pointBackgroundColor: 'orange',
					          fill                : false
					          // pointHoverBackgroundColor: '#ced4da',
					          // pointHoverBorderColor    : '#ced4da'
					        }]
					    },
					    options: {
					      maintainAspectRatio: false,
					      tooltips           : {
					        mode     : mode,
					        intersect: intersect
					      },
					      hover              : {
					        mode     : mode,
					        intersect: intersect
					      },
					      legend             : {
					        display: false
					      },
					      scales             : {
					        yAxes: [{
					          // display: false,
					          gridLines: {
					            display      : true,
					            lineWidth    : '4px',
					            color        : 'rgba(0, 0, 0, .2)',
					            zeroLineColor: 'transparent'
					          },
					          ticks    : $.extend({
					            beginAtZero : true,
					            suggestedMax: 200
					          }, ticksStyle)
					        }],
					        xAxes: [{
					          display  : true,
					          gridLines: {
					            display: false
					          },
					          ticks    : ticksStyle
					        }]
					      }
					    }
					  })
					})
	
				</script>
	
	
	
	
	
	

		<!-- Info boxes -->
      <div class="row">
	
        <!-- /.col -->
        <div class="col-md-12">
	
	

			<?php
			//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			echo '<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td>
			Tahun Pelajaran : ';
			echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
			
			//terpilih
			$qtpx = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
												"WHERE nama = '$tapelkd'");
			$rowtpx = mysqli_fetch_assoc($qtpx);
			$tpth1 = cegah($rowtpx['nama']);
			$tpth2 = balikin($rowtpx['nama']);
			
			echo '<option value="'.$tpth1.'">'.$tpth2.'</option>';
			
			$qtp = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
											"ORDER BY nama DESC");
			$rowtp = mysqli_fetch_assoc($qtp);
			
			do
				{
				$tpkd = nosql($rowtp['kd']);
				$tpth1 = cegah($rowtp['nama']);
				$tpth2 = balikin($rowtp['nama']);
			
				echo '<option value="'.$filenya.'?tapelkd='.$tpth1.'">'.$tpth2.'</option>';
				}
			while ($rowtp = mysqli_fetch_assoc($qtp));
			
			echo '</select>
			</td>
			</tr>
			</table>';
			
			
			//nek null
			if (empty($tapelkd))
				{
				echo '<p>
				<font color="red">
				<strong>TAHUN PELAJARAN Belum Ditentukan...!!</strong>
				</font>
				</p>';
				}
			
			else
				{
				//data ne
				$qdty = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
													"WHERE tapel = '$tapelkd' ".
													"ORDER BY kelas ASC, ".
													"nama ASC");
				$rdty = mysqli_fetch_assoc($qdty);
				$tdty = mysqli_num_rows($qdty);
			
			
			
				echo '<p>
				<table width="100%" border="1" cellspacing="0" cellpadding="3">
				<tr bgcolor="'.$warnaheader.'">
				<td width="100"><strong>Kelas</strong></td>
				<td><strong>Mata Pelajaran</strong></td>
				<td width="50"><strong>Silabus</strong></td>
				<td width="50"><strong>RPP</strong></td>
				<td width="50"><strong>Setting Deskripsi Pengetahuan</strong></td>
				<td width="50"><strong>Nilai Absensi</strong></td>
				<td width="50"><strong>Nilai Pengetahuan</strong></td>
				<td width="50"><strong>Deskripsi Nilai Pengetahuan</strong></td>
				<td width="50"><strong>Nilai Ketrampilan</strong></td>
				<td width="50"><strong>Deskripsi Nilai Ketrampilan</strong></td>
				
				<td width="50"><strong>Nilai Sikap</strong></td>
				</tr>';
			
				//nek gak null
				if ($tdty != 0)
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
			
			
						//nilai
						$dty_kelas = balikin($rdty['kelas']);
						$dty_nama = balikin($rdty['nama']);

			
						echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
						echo '<td>'.$dty_kelas.'</td>
						<td>'.$dty_nama.'</td>
						<td>
						<a href="bahan/silabus.php?mmkd='.$dty_gurkd.'&tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&progkd='.$dty_pelkd.'"
						title="Kelas = '.$ykel_kelas.', Pelajaran = '.$dty_pel.'">
						<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
						<br>';
						$qx = mysqli_query($koneksi, "SELECT postdate FROM guru_silabus ".
												"WHERE kd_guru_prog_pddkn = '$dty_gurkd' ".
												"ORDER BY postdate DESC");
						$rowx = mysqli_fetch_assoc($qx);
						$e_postdate = $rowx['postdate'];
						
						echo ''.$e_postdate.'</td>
						<td>
						<a href="bahan/rpp.php?mmkd='.$dty_gurkd.'&tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&progkd='.$dty_pelkd.'"
						title="Kelas = '.$ykel_kelas.', Pelajaran = '.$dty_pel.'">
						<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
						<br>';
						$qx = mysqli_query($koneksi, "SELECT postdate FROM guru_rpp ".
												"WHERE kd_guru_prog_pddkn = '$dty_gurkd' ".
												"ORDER BY postdate DESC");
						$rowx = mysqli_fetch_assoc($qx);
						$e_postdate = $rowx['postdate'];
						
						echo ''.$e_postdate.'</td>
						
						</td>
						<td>
						<a href="ajar2/desk_nilai.php?mmkd='.$dty_gurkd.'&tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&progkd='.$dty_pelkd.'"
						title="Kelas = '.$ykel_kelas.', Pelajaran = '.$dty_pel.'">
						<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
						
						<br>';
						$qx = mysqli_query($koneksi, "SELECT postdate FROM m_prog_pddkn_deskripsi ".
												"WHERE kd_tapel = '$dty_tapelkd' ".
												"AND kd_kelas = '$dty_kelkd' ".
												"AND kd_prog_pddkn = '$dty_pelkd'");
						$rowx = mysqli_fetch_assoc($qx);
						$e_postdate = $rowx['postdate'];
						
						echo ''.$e_postdate.'</td>
						
						<td>
						<a href="ajar2/nil_absensi.php?mmkd='.$dty_gurkd.'&tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&progkd='.$dty_pelkd.'"
						title="Kelas = '.$ykel_kelas.', Pelajaran = '.$dty_pel.'">
						<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
						
						<br>';
						
						$qx = mysqli_query($koneksi, "SELECT tanggal FROM siswa_nilai_absensi ".
											"WHERE kd_prog_pddkn = '$dty_pelkd' ".
											"ORDER BY tanggal DESC");
						$rowx = mysqli_fetch_assoc($qx);
						$e_postdate = $rowx['tanggal'];
						
						echo ''.$e_postdate.'</td>
						<td>
						<a href="ajar2/nil_pengetahuan.php?mmkd='.$dty_gurkd.'&tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&progkd='.$dty_pelkd.'&mpkd='.$pelx_mpkd.'&kompkd='.$dty_kompkd.'"
						title="Kelas = '.$ykel_kelas.', Pelajaran = '.$dty_pel.'">
						<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
						<br>';
						
						$qx = mysqli_query($koneksi, "SELECT postdate FROM siswa_nilai_raport ".
												"WHERE kd_prog_pddkn = '$dty_pelkd' ".
												"AND nil_raport_pengetahuan <> '' ".
												"ORDER BY postdate DESC");
						$rowx = mysqli_fetch_assoc($qx);
						$e_postdate = $rowx['postdate'];
						
						echo ''.$e_postdate.'</td>
						<td>
						<a href="ajar2/desk_nil_pengetahuan.php?mmkd='.$dty_gurkd.'&tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&progkd='.$dty_pelkd.'&mpkd='.$pelx_mpkd.'&kompkd='.$dty_kompkd.'"
						title="Kelas = '.$ykel_kelas.', Pelajaran = '.$dty_pel.'">
						<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
						<br>';
						
						$qx = mysqli_query($koneksi, "SELECT postdate FROM siswa_nilai_raport ".
												"WHERE kd_prog_pddkn = '$dty_pelkd' ".
												"AND nil_raport_pengetahuan <> '' ".
												"ORDER BY postdate DESC");
						$rowx = mysqli_fetch_assoc($qx);
						$e_postdate = $rowx['postdate'];
						
						echo ''.$e_postdate.'</td>
						<td>
						<a href="ajar2/nil_ketrampilan.php?mmkd='.$dty_gurkd.'&tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&progkd='.$dty_pelkd.'&mpkd='.$pelx_mpkd.'&kompkd='.$dty_kompkd.'"
						title="Kelas = '.$ykel_kelas.', Pelajaran = '.$dty_pel.'">
						<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
						
						<br>';
						
						$qx = mysqli_query($koneksi, "SELECT postdate FROM siswa_nilai_raport ".
												"WHERE kd_prog_pddkn = '$dty_pelkd' ".
												"AND nil_raport_ketrampilan <> '' ".
												"ORDER BY postdate DESC");
						$rowx = mysqli_fetch_assoc($qx);
						$e_postdate = $rowx['postdate'];
						
						echo ''.$e_postdate.'</td>
						<td>
						<a href="ajar2/desk_nil_ketrampilan.php?mmkd='.$dty_gurkd.'&tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&progkd='.$dty_pelkd.'&mpkd='.$pelx_mpkd.'&kompkd='.$dty_kompkd.'"
						title="Kelas = '.$ykel_kelas.', Pelajaran = '.$dty_pel.'">
						<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
						<br>';
						
						$qx = mysqli_query($koneksi, "SELECT postdate FROM siswa_nilai_raport ".
												"WHERE kd_prog_pddkn = '$dty_pelkd' ".
												"AND nil_raport_ketrampilan <> '' ".
												"ORDER BY postdate DESC");
						$rowx = mysqli_fetch_assoc($qx);
						$e_postdate = $rowx['postdate'];
						
						echo ''.$e_postdate.'</td>
						
						<td>
						<a href="ajar2/nil_sikap.php?mmkd='.$dty_gurkd.'&tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&progkd='.$dty_pelkd.'&mpkd='.$pelx_mpkd.'&kompkd='.$dty_kompkd.'"
						title="Kelas = '.$ykel_kelas.', Pelajaran = '.$dty_pel.'">
						<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
						
						<br>';
						
						$qx = mysqli_query($koneksi, "SELECT postdate FROM siswa_nilai_raport ".
												"WHERE kd_prog_pddkn = '$dty_pelkd' ".
												"AND rata_sikap <> '' ".
												"ORDER BY postdate DESC");
						$rowx = mysqli_fetch_assoc($qx);
						$e_postdate = $rowx['postdate'];
						
						echo ''.$e_postdate.'</td>
						</tr>';
						}
					while ($rdty = mysqli_fetch_assoc($qdty));
					}
			
				echo '</table>
				</p>';
				}
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			?>





		

		</div>
	</div>



            


		<!-- OPTIONAL SCRIPTS -->
		<script src="../template/adminlte3/plugins/chart.js/Chart.min.js"></script>
		




	
	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){
	
	$.noConflict();

	});
	
	</script>
	




<?php
//isi
$isi = ob_get_contents();
ob_end_clean();

require("../inc/niltpl.php");



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>