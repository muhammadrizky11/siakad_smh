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









//jumlah mapel
$qx = mysqli_query($koneksi, "SELECT DISTINCT(kode) AS totalnya ".
								"FROM m_mapel ".
								"WHERE pegawai_kd = '$kd1_session'");
$rowx = mysqli_fetch_assoc($qx);
$e_total_mapel = mysqli_num_rows($qx);









//jumlah kelas
$qx = mysqli_query($koneksi, "SELECT DISTINCT(kelas) AS totalnya ".
								"FROM m_mapel ".
								"WHERE pegawai_kd = '$kd1_session'");
$rowx = mysqli_fetch_assoc($qx);
$e_total_kelas = mysqli_num_rows($qx);











//jumlah siswa
$qx = mysqli_query($koneksi, "SELECT DISTINCT(kode) AS totalnya ".
								"FROM m_siswa");
$rowx = mysqli_fetch_assoc($qx);
$e_total_siswa = mysqli_num_rows($qx);










//jumlah jam mengajar
$qx = mysqli_query($koneksi, "SELECT * FROM m_pegawai ".
								"WHERE kd = '$kd1_session'");
$rowx = mysqli_fetch_assoc($qx);
$e_total_jam = mysqli_num_rows($qx);




?>

		<!-- Info boxes -->
      <div class="row">

        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fa fa-book"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">JUMLAH MAPEL</span>
              <span class="info-box-number"><?php echo $e_total_mapel;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->



        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fa fa-building-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">JUMLAH KELAS</span>
              <span class="info-box-number"><?php echo $e_total_kelas;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        

        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fa fa-clock-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">JUMLAH JAM MENGAJAR</span>
              <span class="info-box-number"><?php echo $e_total_jam;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->



        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">JUMLAH SISWA</span>
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
	
	

	            <div class="card">
	              <div class="card-header border-transparent">
	                <h3 class="card-title">Grafik : Login, Entri</h3>
	
	                <div class="card-tools">
	                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
	                    <i class="fas fa-minus"></i>
	                  </button>
	                </div>
	              </div>
	              <div class="card-body">
	
	
	
	                <div class="position-relative mb-4">
	                  <canvas id="visitors-chart" height="200"></canvas>
	                </div>
	
	                <div class="d-flex flex-row justify-content-end">
	                  <span class="mr-2">
	                    <i class="fas fa-square text-blue"></i> Login
	                  </span>
	                  &nbsp;
	
	                  <span>
	                    <i class="fas fa-square text-orange"></i> Entri
	                  </span>
	                  
	                  
	                </div>
	
	
	                
	                
	              </div>
	            </div>
	
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