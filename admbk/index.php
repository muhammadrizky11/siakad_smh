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
require("../inc/class/paging.php");
require("../inc/cek/admbk.php");
$tpl = LoadTpl("../template/admbk.html");






//nilai
$filenya = "index.php";
$judul = "Selamat Datang, BK";
$judulku = "$judul  [$nm11_session]";





//isi *START
ob_start();







//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM m_siswa");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_siswa = mysqli_num_rows($qtyk);


//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM m_gurubk");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_gurubk = mysqli_num_rows($qtyk);





//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM m_pegawai");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_guru = mysqli_num_rows($qtyk);




//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM m_piket");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_piket = mysqli_num_rows($qtyk);



//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM siswa_pelanggaran");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_pelanggaran = mysqli_num_rows($qtyk);




//query
$qtyk = mysqli_query($koneksi, "SELECT bina_kd FROM siswa_pelanggaran ".
									"WHERE bina_kd IS NULL");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_bina_belum = mysqli_num_rows($qtyk);




//query
$qtyk = mysqli_query($koneksi, "SELECT bina_kd FROM siswa_pelanggaran ".
									"WHERE bina_kd IS NOT NULL");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_bina_sudah = mysqli_num_rows($qtyk);







//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM siswa_prestasi");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_prestasi = mysqli_num_rows($qtyk);






//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM user_presensi");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_presensi = mysqli_num_rows($qtyk);






//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM user_ijin ".
									"WHERE status = 'IJIN MASUK'");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_ijin_masuk = mysqli_num_rows($qtyk);



//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM user_ijin ".
									"WHERE status = 'IJIN PULANG'");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_ijin_pulang = mysqli_num_rows($qtyk);





//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM user_absensi ".
									"WHERE ket = 'Sakit'");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_abs_sakit = mysqli_num_rows($qtyk);



//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM user_absensi ".
									"WHERE ket = 'Ijin'");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_abs_ijin = mysqli_num_rows($qtyk);




//query
$qtyk = mysqli_query($koneksi, "SELECT * FROM user_absensi ".
									"WHERE ket = 'Alpha'");
$rtyk = mysqli_fetch_assoc($qtyk);
$jml_abs_alpha = mysqli_num_rows($qtyk);


?>

      <!-- Info boxes -->
      <div class="row">



        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">SISWA</span>
              <span class="info-box-number"><?php echo $jml_siswa;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        






        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">PEGAWAI/STAFF/GURU</span>
              <span class="info-box-number"><?php echo $jml_guru;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->



        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">BK</span>
              <span class="info-box-number"><?php echo $jml_gurubk;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->





        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">PETUGAS PIKET</span>
              <span class="info-box-number"><?php echo $jml_piket;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->







        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-orange"><i class="fa fa-tachometer"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">PRESENSI</span>
              <span class="info-box-number"><?php echo $jml_presensi;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->







        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-balance-scale"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">PELANGGARAN</span>
              <span class="info-box-number"><?php echo $jml_pelanggaran;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->






        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-gears"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">BELUM DIBINA</span>
              <span class="info-box-number"><?php echo $jml_bina_belum;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        





        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fa fa-gears"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">SUDAH DIBINA</span>
              <span class="info-box-number"><?php echo $jml_bina_sudah;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        




        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fa fa-trophy"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">PRESTASI</span>
              <span class="info-box-number"><?php echo $jml_prestasi;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->



        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-tasks"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">ABSEN : SAKIT</span>
              <span class="info-box-number"><?php echo $jml_abs_sakit;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>




        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-tasks"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">ABSEN : IJIN</span>
              <span class="info-box-number"><?php echo $jml_abs_ijin;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>





        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-tasks"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">ABSEN : ALPHA</span>
              <span class="info-box-number"><?php echo $jml_abs_alpha;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>







                
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-tasks"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">IJIN MASUK</span>
              <span class="info-box-number"><?php echo $jml_ijin_masuk;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-tasks"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">IJIN PULANG</span>
              <span class="info-box-number"><?php echo $jml_ijin_pulang;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>




        <!-- /.col -->
      </div>
      <!-- /.row -->


<?php
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
							"WHERE round(DATE_FORMAT(postdate, '%d')) = '$itgl' ".
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
							"WHERE round(DATE_FORMAT(postdate, '%d')) = '$itgl' ".
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
	$qyuk = mysqli_query($koneksi, "SELECT * FROM siswa_pelanggaran ".
							"WHERE round(DATE_FORMAT(tgl, '%d')) = '$itgl' ".
							"AND round(DATE_FORMAT(tgl, '%m')) = '$ibln' ".
							"AND round(DATE_FORMAT(tgl, '%Y')) = '$itahun'");
	$tyuk = mysqli_num_rows($qyuk);
	
	if (empty($tyuk))
		{
		$tyuk = "0";
		}
		
	echo "$tyuk, ";
	}


//isi
$isi_data4 = ob_get_contents();
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
	$qyuk = mysqli_query($koneksi, "SELECT bina_kd FROM siswa_pelanggaran ".
							"WHERE bina_kd IS NOT NULL ".
							"AND round(DATE_FORMAT(bina_tgl, '%d')) = '$itgl' ".
							"AND round(DATE_FORMAT(bina_tgl, '%m')) = '$ibln' ".
							"AND round(DATE_FORMAT(bina_tgl, '%Y')) = '$itahun'");
	$tyuk = mysqli_num_rows($qyuk);
	
	if (empty($tyuk))
		{
		$tyuk = "0";
		}
		
	echo "$tyuk, ";
	}


//isi
$isi_data5 = ob_get_contents();
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
	$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
							"WHERE round(DATE_FORMAT(postdate, '%d')) = '$itgl' ".
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
$isi_data6 = ob_get_contents();
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
	$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%d')) = '$itgl' ".
										"AND round(DATE_FORMAT(postdate, '%m')) = '$ibln' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$itahun' ".
										"AND status = 'IJIN MASUK'");
	$tyuk = mysqli_num_rows($qyuk);
	
	if (empty($tyuk))
		{
		$tyuk = "0";
		}
		
	echo "$tyuk, ";
	}


//isi
$isi_data7 = ob_get_contents();
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
	$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE round(DATE_FORMAT(postdate, '%d')) = '$itgl' ".
										"AND round(DATE_FORMAT(postdate, '%m')) = '$ibln' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$itahun' ".
										"AND status = 'IJIN PULANG'");
	$tyuk = mysqli_num_rows($qyuk);
	
	if (empty($tyuk))
		{
		$tyuk = "0";
		}
		
	echo "$tyuk, ";
	}


//isi
$isi_data8 = ob_get_contents();
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
	$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_absensi ".
										"WHERE round(DATE_FORMAT(tanggal, '%d')) = '$itgl' ".
										"AND round(DATE_FORMAT(tanggal, '%m')) = '$ibln' ".
										"AND round(DATE_FORMAT(tanggal, '%Y')) = '$itahun'");
	$tyuk = mysqli_num_rows($qyuk);
	
	if (empty($tyuk))
		{
		$tyuk = "0";
		}
		
	echo "$tyuk, ";
	}


//isi
$isi_data9 = ob_get_contents();
ob_end_clean();

?>







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
					        },
					        {
					          type                : 'line',
					          data                : [<?php echo $isi_data4;?>],
					          backgroundColor     : 'tansparent',
					          borderColor         : 'green',
					          pointBorderColor    : 'green',
					          pointBackgroundColor: 'green',
					          fill                : false
					          // pointHoverBackgroundColor: '#ced4da',
					          // pointHoverBorderColor    : '#ced4da'
					        },
					        {
					          type                : 'line',
					          data                : [<?php echo $isi_data5;?>],
					          backgroundColor     : 'tansparent',
					          borderColor         : 'yellow',
					          pointBorderColor    : 'yellow',
					          pointBackgroundColor: 'yellow',
					          fill                : false
					          // pointHoverBackgroundColor: '#ced4da',
					          // pointHoverBorderColor    : '#ced4da'
					        },
					        {
					          type                : 'line',
					          data                : [<?php echo $isi_data6;?>],
					          backgroundColor     : 'tansparent',
					          borderColor         : 'red',
					          pointBorderColor    : 'red',
					          pointBackgroundColor: 'red',
					          fill                : false
					          // pointHoverBackgroundColor: '#ced4da',
					          // pointHoverBorderColor    : '#ced4da'
					        },
					        {
					          type                : 'line',
					          data                : [<?php echo $isi_data7;?>],
					          backgroundColor     : 'tansparent',
					          borderColor         : 'brown',
					          pointBorderColor    : 'brown',
					          pointBackgroundColor: 'brown',
					          fill                : false
					          // pointHoverBackgroundColor: '#ced4da',
					          // pointHoverBorderColor    : '#ced4da'
					        },
					        {
					          type                : 'line',
					          data                : [<?php echo $isi_data8;?>],
					          backgroundColor     : 'tansparent',
					          borderColor         : 'cyan',
					          pointBorderColor    : 'cyan',
					          pointBackgroundColor: 'cyan',
					          fill                : false
					          // pointHoverBackgroundColor: '#ced4da',
					          // pointHoverBorderColor    : '#ced4da'
					        },
					        {
					          type                : 'line',
					          data                : [<?php echo $isi_data9;?>],
					          backgroundColor     : 'tansparent',
					          borderColor         : 'magenta',
					          pointBorderColor    : 'magenta',
					          pointBackgroundColor: 'magenta',
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
	                <h3 class="card-title">Grafik : Login, Entri, Pelanggaran, Pembinaan, Presensi, Ijin Masuk, Ijin Pulang</h3>
	
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
	                  &nbsp;
	                  &nbsp;
	
	                  <span>
	                    <i class="fas fa-square text-green"></i> Pelanggaran
	                  </span>
	                  &nbsp;
	                  &nbsp;
	
	                  <span>
	                    <i class="fas fa-square text-yellow"></i> Pembinaan
	                  </span>
	                  &nbsp;
	                  &nbsp;
	
	                  <span>
	                    <i class="fas fa-square text-red"></i> Presensi
	                  </span>
	                  &nbsp;
	                  &nbsp;
	
	                  <span>
	                    <i class="fas fa-square text-brown"></i> Ijin Masuk
	                  </span>
	                  &nbsp;
	                  &nbsp;
	
	                  <span>
	                    <i class="fas fa-square text-cyan"></i> Ijin Pulang
	                  </span>
	                  &nbsp;
	                  &nbsp;
	
	                  <span>
	                    <i class="fas fa-square text-magenta" style="color: magenta;"></i> Absensi
	                  </span>
	                  

	                </div>
	
	
	                
	                
	              </div>
	            </div>
	
			</div>
			
		</div>
			            
	          






      <div class="row">
        <div class="col-md-8">

		<?php
			$limit = 10;
			$sqlcount = "SELECT * FROM user_presensi ".
							"ORDER BY postdate DESC";

			//query
			$p = new Pager();
			$start = $p->findStart($limit);
			
			$sqlresult = $sqlcount;
			
			$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			?>
			
			
            <div class="card card-primary">
              <div class="card-header border-transparent">
                <h3 class="card-title">PRESENSI KEHADIRAN : SISWA DAN GURU</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>TANGGAL</th>
                      <th>NAMA</th>
                      <th>TERLAMBAT</th>
                    </tr>
                    </thead>
                    <tbody>
                    	
                    <?php
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
							$i_tglnya = balikin($data['postdate']);
							$i_jabatan = balikin($data['user_jabatan']);
							$i_kode = balikin($data['user_kode']);
							$i_nama = balikin($data['user_nama']);
							$i_kelas = balikin($data['user_kelas']);
							$i_telat = balikin($data['telat_ket']);



							//jika siswa
							if ($i_jabatan == "SISWA")
								{
								$i_namax = "$i_nama <br>NIS:$i_kode <br> Kelas:$i_kelas";
								}
							else
								{
								$i_namax = "$i_nama <br>NIP:$i_kode";
								}

						
							echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
							echo '<td>'.$i_tglnya.'</td>
							<td>'.$i_namax.'</td>
							<td>'.$i_telat.'</td>
					        </tr>';
							}
						while ($data = mysqli_fetch_assoc($result));
						?>
						
						
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>

              <div class="card-footer border-transparent">
					<a href="pl/lap_tgl.php" class="btn btn-block btn-danger">SELENGKAPNYA >></a>
              </div>
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->










		<?php
			$limit = 10;
			$sqlcount = "SELECT * FROM user_absensi ".
							"ORDER BY postdate DESC";

			//query
			$p = new Pager();
			$start = $p->findStart($limit);
			
			$sqlresult = $sqlcount;
			
			$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			?>
			
			
            <div class="card card-primary">
              <div class="card-header border-transparent">
                <h3 class="card-title">ABSENSI : SISWA DAN GURU</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>TANGGAL</th>
                      <th>NAMA</th>
                      <th>KETERANGAN</th>
                    </tr>
                    </thead>
                    <tbody>
                    	
                    <?php
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
							$i_tglnya = balikin($data['postdate']);
							$i_jabatan = balikin($data['user_jabatan']);
							$i_kode = balikin($data['user_kode']);
							$i_nama = balikin($data['user_nama']);
							$i_kelas = balikin($data['user_kelas']);
							$i_ket = balikin($data['ket']);



							//jika siswa
							if ($i_jabatan == "SISWA")
								{
								$i_namax = "$i_nama <br>NIS:$i_kode <br> Kelas:$i_kelas";
								}
							else
								{
								$i_namax = "$i_nama <br>NIP:$i_kode";
								}

						
							echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
							echo '<td>'.$i_tglnya.'</td>
							<td>'.$i_namax.'</td>
							<td>'.$i_ket.'</td>
					        </tr>';
							}
						while ($data = mysqli_fetch_assoc($result));
						?>
						
						
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>

              <div class="card-footer border-transparent">
					<a href="ab/absensi.php" class="btn btn-block btn-danger">SELENGKAPNYA >></a>
              </div>
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->












		<?php
			$limit = 10;
			$sqlcount = "SELECT * FROM user_ijin ".
							"ORDER BY postdate DESC";

			//query
			$p = new Pager();
			$start = $p->findStart($limit);
			
			$sqlresult = $sqlcount;
			
			$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			?>
			
			
            <div class="card card-primary">
              <div class="card-header border-transparent">
                <h3 class="card-title">IJIN MASUK PULANG : SISWA DAN GURU</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>TANGGAL</th>
                      <th>NAMA</th>
                      <th>KETERANGAN</th>
                    </tr>
                    </thead>
                    <tbody>
                    	
                    <?php
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
							$i_tglnya = balikin($data['postdate']);
							$i_jabatan = balikin($data['user_jabatan']);
							$i_kode = balikin($data['user_kode']);
							$i_nama = balikin($data['user_nama']);
							$i_kelas = balikin($data['user_kelas']);
							$i_status = balikin($data['status']);
							$i_ket = balikin($data['ket']);



							//jika siswa
							if ($i_jabatan == "SISWA")
								{
								$i_namax = "$i_nama <br>NIS:$i_kode <br> Kelas:$i_kelas";
								}
							else
								{
								$i_namax = "$i_nama <br>NIP:$i_kode";
								}

						
							echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
							echo '<td>'.$i_tglnya.'</td>
							<td>'.$i_namax.'</td>
							<td>
							'.$i_status.'
							<br>
							<i>'.$i_ket.'</i>
							</td>
					        </tr>';
							}
						while ($data = mysqli_fetch_assoc($result));
						?>
						
						
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>

              <div class="card-footer border-transparent">
					<a href="im/ijin.php" class="btn btn-block btn-danger">SELENGKAPNYA >></a>
              </div>
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->








		<?php
			$limit = 10;
			$sqlcount = "SELECT * FROM siswa_pelanggaran ".
							"ORDER BY tgl DESC";

			//query
			$p = new Pager();
			$start = $p->findStart($limit);
			
			$sqlresult = $sqlcount;
			
			$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			?>
			
			
            <div class="card card-danger">
              <div class="card-header border-transparent">
                <h3 class="card-title">PELANGGARAN SISWA</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>TANGGAL</th>
                      <th>SISWA</th>
                      <th>PELANGGARAN</th>
                    </tr>
                    </thead>
                    <tbody>
                    	
                    <?php
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
							$i_tglnya = balikin($data['tgl']);
							$i_pelnama = balikin($data['point_nama']);
							$i_pelnilai = balikin($data['point_nilai']);
							$i_swnis = balikin($data['siswa_nis']);
							$i_swnama = balikin($data['siswa_nama']);
							$i_kelas = balikin($data['kelas_nama']);


						
							echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
							echo '<td>'.$i_tglnya.'</td>
							<td>
							'.$i_swnama.'
							<br>
							NIS:'.$i_swnis.'
							<br>
							Kelas:'.$i_kelas.'
							</td>
							<td>
							'.$i_pelnama.'
							<br>
							Point:'.$i_pelnilai.'
							</td>
					        </tr>';
							}
						while ($data = mysqli_fetch_assoc($result));
						?>
						
						
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>

              <div class="card-footer border-transparent">
					<a href="pl/lap_tgl.php" class="btn btn-block btn-danger">SELENGKAPNYA >></a>
              </div>
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->









		<?php
			$limit = 10;
			$sqlcount = "SELECT * FROM siswa_pelanggaran ".
							"WHERE bina_kd IS NOT NULL ".
							"ORDER BY tgl DESC";

			//query
			$p = new Pager();
			$start = $p->findStart($limit);
			
			$sqlresult = $sqlcount;
			
			$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			?>
			
			
            <div class="card card-warning">
              <div class="card-header border-transparent">
                <h3 class="card-title">PEMBINAAN SISWA</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>TANGGAL</th>
                      <th>SISWA</th>
                      <th>PELANGGARAN</th>
                      <th>PEMBINAAN</th>
                    </tr>
                    </thead>
                    <tbody>
                    	
                    <?php
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
							$i_tgl = balikin($data['tgl']);
							$i_swnis = balikin($data['siswa_nis']);
							$i_swnama = balikin($data['siswa_nama']);
							$i_kelas = balikin($data['kelas_nama']);
							$i_bnama = balikin($data['bina_nama']);
							$i_bket = balikin($data['bina_ket']);
							$i_pnama = balikin($data['point_nama']);

						
							echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
							echo '<td>'.$i_tgl.'</td>
							<td>
							'.$i_swnama.'
							<br>
							NIS:'.$i_swnis.'
							<br>
							Kelas:'.$i_kelas.'
							</td>
							<td>'.$i_pnama.'</td>
							<td>
							'.$i_bnama.'
							<br>
							'.$i_bket.'
							</td>
					        </tr>';
							}
						while ($data = mysqli_fetch_assoc($result));
						?>
						
						
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>

              <div class="card-footer border-transparent">
					<a href="pb/lap_tgl.php" class="btn btn-block btn-danger">SELENGKAPNYA >></a>
              </div>
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->









		<?php
			$limit = 10;
			$sqlcount = "SELECT * FROM siswa_prestasi ".
							"ORDER BY tgl DESC";

			//query
			$p = new Pager();
			$start = $p->findStart($limit);
			
			$sqlresult = $sqlcount;
			
			$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			?>
			
			
            <div class="card card-success">
              <div class="card-header border-transparent">
                <h3 class="card-title">PRESTASI SISWA</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>TANGGAL</th>
                      <th>SISWA</th>
                      <th>PRESTASI</th>
                    </tr>
                    </thead>
                    <tbody>
                    	
                    <?php
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
							$i_tglnya = balikin($data['tgl']);
							$i_pelnama = balikin($data['point_nama']);
							$i_pelnilai = balikin($data['point_nilai']);
							$i_swnis = balikin($data['siswa_nis']);
							$i_swnama = balikin($data['siswa_nama']);
							$i_kelas = balikin($data['kelas_nama']);


						
							echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
							echo '<td>'.$i_tglnya.'</td>
							<td>
							'.$i_swnama.'
							<br>
							NIS:'.$i_swnis.'
							<br>
							Kelas:'.$i_kelas.'
							</td>
							<td>
							'.$i_pelnama.'
							<br>
							Point:'.$i_pelnilai.'
							</td>
					        </tr>';
							}
						while ($data = mysqli_fetch_assoc($result));
						?>
						
						
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>

              <div class="card-footer border-transparent">
					<a href="pt/lap_tgl.php" class="btn btn-block btn-danger">SELENGKAPNYA >></a>
              </div>
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->







    

        </div>
        
        <!-- /.col -->
        <div class="col-md-4">


		<?php
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
											"WHERE user_jabatan = 'SISWA' ".
											"AND round(DATE_FORMAT(postdate, '%d')) = '$tanggal' ".
											"AND round(DATE_FORMAT(postdate, '%m')) = '$bulan' ".
											"AND round(DATE_FORMAT(postdate, '%Y')) = '$tahun'");
		$tyuk = mysqli_num_rows($qyuk);
				
		$nilku_presensi = round(($tyuk / $jml_siswa) * 100);
		
		
		
		
		
		//absensi:sakit
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_absensi ".
											"WHERE user_jabatan = 'SISWA' ".
											"AND ket = 'Sakit'");
		$tyuk = mysqli_num_rows($qyuk);
		$tyuk_abs_sakit = round(($tyuk / $jml_siswa) * 100);
		

				
		
		//absensi:ijin
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_absensi ".
											"WHERE user_jabatan = 'SISWA' ".
											"AND ket = 'Ijin'");
		$tyuk = mysqli_num_rows($qyuk);
		$tyuk_abs_ijin = round(($tyuk / $jml_siswa) * 100);
				

		
		//absensi:ijin
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_absensi ".
											"WHERE user_jabatan = 'SISWA' ".
											"AND ket = 'Alpha'");
		$tyuk = mysqli_num_rows($qyuk);
		$tyuk_abs_alpha = round(($tyuk / $jml_siswa) * 100);
		
		
		
		//ijin masuk
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
											"WHERE user_jabatan = 'SISWA' ".
											"AND status = 'IJIN MASUK'");
		$tyuk = mysqli_num_rows($qyuk);
		$tyuk_ijin_masuk = round(($tyuk / $jml_siswa) * 100);

		
		//ijin pulang
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
											"WHERE user_jabatan = 'SISWA' ".
											"AND status = 'IJIN PULANG'");
		$tyuk = mysqli_num_rows($qyuk);
		$tyuk_ijin_pulang = round(($tyuk / $jml_siswa) * 100);
				
		?>        	
        	
        	<div class="card card-success">
	              <div class="card-header">
	                <h3 class="card-title">KONDISI SISWA</h3>
	
	                <div class="card-tools">
	                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
	                  </button>
	                </div>

	              </div>

	              <div class="card-body">

		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">PRESENSI HARI INI [<?php echo $nilku_presensi;?>%]</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar" style="background-color: primary; width: <?php echo $nilku_presensi;?>%"></div>
		                    </div>
		                  </div>
		                  
		                  <br>


		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">ABSENSI : Sakit [<?php echo $tyuk_abs_sakit;?>%]</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo $tyuk_abs_sakit;?>%"></div>
		                    </div>
		                  </div>
		                  
		                  <br>




		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">ABSENSI : Ijin [<?php echo $tyuk_abs_ijin;?>%]</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo $tyuk_abs_ijin;?>%"></div>
		                    </div>
		                  </div>
		                  
		                  <br>




		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">ABSENSI : Alpha [<?php echo $tyuk_abs_alpha;?>%]</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo $tyuk_abs_alpha;?>%"></div>
		                    </div>
		                  </div>
		                  
		                  <br>




		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">IJIN MASUK [<?php echo $tyuk_ijin_masuk;?>%]</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo $tyuk_ijin_masuk;?>%"></div>
		                    </div>
		                  </div>
		                  
		                  <br>




		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">IJIN PULANG [<?php echo $tyuk_ijin_pulang;?>%]</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo $tyuk_ijin_pulang;?>%"></div>
		                    </div>
		                  </div>
		                  
		                  <br>


						<?php
						$qyuk = mysqli_query($koneksi, "SELECT kd FROM siswa_pelanggaran");
						$tyuk = mysqli_num_rows($qyuk);
						$nilku_pelanggaran = round(($tyuk / $jml_siswa) * 100);
						?>        	

		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">PELANGGARAN [<?php echo $nilku_pelanggaran;?>%]</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar" style="background-color: red; width: <?php echo $nilku_pelanggaran;?>%"></div>
		                    </div>
		                  </div>
		                  
		                  <br>



						<?php
						$qyuk = mysqli_query($koneksi, "SELECT DISTINCT(siswa_kd) AS totalnya ".
															"FROM siswa_pelanggaran ".
															"WHERE bina_kd IS NOT NULL");
						$tyuk = mysqli_num_rows($qyuk);
						$nilku_bina = round(($tyuk / $jml_siswa) * 100);
						?>        	

		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">PEMBINAAN [<?php echo $nilku_bina;?>%]</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar" style="background-color: orange; width: <?php echo $nilku_bina;?>%"></div>
		                    </div>
		                  </div>
		                  
		                  <br>



						<?php
						$qyuk = mysqli_query($koneksi, "SELECT DISTINCT(siswa_kd) AS totalnya ".
															"FROM siswa_prestasi");
						$tyuk = mysqli_num_rows($qyuk);
						$nilku_prestasi = round(($tyuk / $jml_siswa) * 100);
						?>        	



		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">PRESTASI [<?php echo $nilku_prestasi;?>%]</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar" style="background-color: green; width: <?php echo $nilku_prestasi;?>%"></div>
		                    </div>
		                  </div>





	              </div>
	            </div>







		<?php
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_presensi ".
											"WHERE user_jabatan = 'GURU' ".
											"AND round(DATE_FORMAT(postdate, '%d')) = '$tanggal' ".
											"AND round(DATE_FORMAT(postdate, '%m')) = '$bulan' ".
											"AND round(DATE_FORMAT(postdate, '%Y')) = '$tahun'");
		$tyuk = mysqli_num_rows($qyuk);
				
		$nilku_presensi = round(($tyuk / $jml_siswa) * 100);
		
		
		
		
		
		//absensi:sakit
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_absensi ".
											"WHERE user_jabatan = 'GURU' ".
											"AND ket = 'Sakit'");
		$tyuk = mysqli_num_rows($qyuk);
		$tyuk_abs_sakit = round(($tyuk / $jml_siswa) * 100);
		

				
		
		//absensi:ijin
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_absensi ".
											"WHERE user_jabatan = 'GURU' ".
											"AND ket = 'Ijin'");
		$tyuk = mysqli_num_rows($qyuk);
		$tyuk_abs_ijin = round(($tyuk / $jml_siswa) * 100);
				

		
		//absensi:ijin
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_absensi ".
											"WHERE user_jabatan = 'GURU' ".
											"AND ket = 'Alpha'");
		$tyuk = mysqli_num_rows($qyuk);
		$tyuk_abs_alpha = round(($tyuk / $jml_siswa) * 100);
		
		
		
		//ijin masuk
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
											"WHERE user_jabatan = 'GURU' ".
											"AND status = 'IJIN MASUK'");
		$tyuk = mysqli_num_rows($qyuk);
		$tyuk_ijin_masuk = round(($tyuk / $jml_siswa) * 100);

		
		//ijin pulang
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
											"WHERE user_jabatan = 'GURU' ".
											"AND status = 'IJIN PULANG'");
		$tyuk = mysqli_num_rows($qyuk);
		$tyuk_ijin_pulang = round(($tyuk / $jml_siswa) * 100);
				
		?>        	
        	
        	<div class="card card-warning">
	              <div class="card-header">
	                <h3 class="card-title">KONDISI GURU/PEGAWAI/STAFF</h3>
	
	                <div class="card-tools">
	                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
	                  </button>
	                </div>

	              </div>

	              <div class="card-body">

		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">PRESENSI HARI INI [<?php echo $nilku_presensi;?>%]</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar" style="background-color: primary; width: <?php echo $nilku_presensi;?>%"></div>
		                    </div>
		                  </div>
		                  
		                  <br>


		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">ABSENSI : Sakit [<?php echo $tyuk_abs_sakit;?>%]</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo $tyuk_abs_sakit;?>%"></div>
		                    </div>
		                  </div>
		                  
		                  <br>




		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">ABSENSI : Ijin [<?php echo $tyuk_abs_ijin;?>%]</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo $tyuk_abs_ijin;?>%"></div>
		                    </div>
		                  </div>
		                  
		                  <br>




		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">ABSENSI : Alpha [<?php echo $tyuk_abs_alpha;?>%]</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo $tyuk_abs_alpha;?>%"></div>
		                    </div>
		                  </div>
		                  
		                  <br>




		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">IJIN MASUK [<?php echo $tyuk_ijin_masuk;?>%]</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo $tyuk_ijin_masuk;?>%"></div>
		                    </div>
		                  </div>
		                  
		                  <br>




		                  <!-- /.progress-group -->
		                  <div class="progress-group">
		                    <span class="progress-text">IJIN PULANG [<?php echo $tyuk_ijin_pulang;?>%]</span>
		
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo $tyuk_ijin_pulang;?>%"></div>
		                    </div>
		                  </div>
		                  
		                  <br>




	              </div>
	            </div>





		<?php
			$limit = 10;
			$sqlcount = "SELECT * FROM user_piket ".
							"ORDER BY tanggal DESC";

			//query
			$p = new Pager();
			$start = $p->findStart($limit);
			
			$sqlresult = $sqlcount;
			
			$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			?>
			
			
            <div class="card card-success">
              <div class="card-header border-transparent">
                <h3 class="card-title">CATATAN KEJADIAN</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>TANGGAL, URAIAN</th>
                    </tr>
                    </thead>
                    <tbody>
                    	
                    <?php
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
							$i_tglnya = balikin($data['tanggal']);
							$i_kode = balikin($data['user_kode']);
							$i_nama = balikin($data['user_nama']);
							$i_jabatan = balikin($data['user_jabatan']);
							$i_catatan = balikin($data['catatan']);
							$i_catatan_postdate = balikin($data['catatan_postdate']);


						
							echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
							echo '<td>
							<b>'.$i_tglnya.'</b>
							<br>
							'.$i_catatan.'
							<br>
							<i>'.$i_catatan_postdate.'</i>
							<br>
							<br>
							<b>PETUGAS PIKET :</b>
							<br>
							'.$i_nama.'
							<br>
							NIP.'.$i_kode.'
							<br>
							Jabatan:'.$i_jabatan.' 
							</td>
					        </tr>';
							}
						while ($data = mysqli_fetch_assoc($result));
						?>
						
						
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>

              <div class="card-footer border-transparent">
					<a href="ph/catatan.php" class="btn btn-block btn-danger">SELENGKAPNYA >></a>
              </div>
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->









          <!-- /.progress-group -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->







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