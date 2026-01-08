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
require("../inc/cek/admbdh.php");
$tpl = LoadTpl("../template/admbdh.html");






//nilai
$filenya = "index.php";
$judul = "Selamat Datang....";
$judulku = "$judul  [$bdh_session]";








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
	$qyuk = mysqli_query($koneksi, "SELECT SUM(nominal_bayar) AS totalnya ".
										"FROM siswa_bayar ".
										"WHERE round(DATE_FORMAT(tgl_bayar, '%d')) = '$itgl' ".
										"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ibln' ".
										"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$itahun'");
	$ryuk = mysqli_fetch_assoc($qyuk);
	$tyuk = mysqli_num_rows($qyuk);
	
	$yuk_total = balikin($ryuk['totalnya']);
	
	
	//jika null
	if (empty($yuk_total))
		{
		$yuk_total = 0;
		}
	else
		{
		$yuk_total = round(balikin($ryuk['totalnya']));
		}
		
	echo "$yuk_total, ";
	}


//isi
$isi_data2 = ob_get_contents();
ob_end_clean();
















//isi *START
ob_start();


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//postdate entri
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_entri ".
									"WHERE user_kd = '$kd42_session' ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$yuk_entri_terakhir = balikin($ryuk['postdate']);






//postdate login
$qyuk = mysqli_query($koneksi, "SELECT * FROM user_log_login ".
									"WHERE user_kd = '$kd42_session' ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$yuk_login_terakhir = balikin($ryuk['postdate']);







//jumlah siswa
$qx = mysqli_query($koneksi, "SELECT DISTINCT(kode) AS totalnya ".
								"FROM m_siswa");
$rowx = mysqli_fetch_assoc($qx);
$e_total_siswa = mysqli_num_rows($qx);









//total bayar
$qx = mysqli_query($koneksi, "SELECT SUM(nominal_bayar) AS totalnya ".
								"FROM siswa_bayar_rincian");
$rowx = mysqli_fetch_assoc($qx);
$e_total_bayar = balikin($rowx['totalnya']);




//total tunggakan
$qx = mysqli_query($koneksi, "SELECT SUM(nominal_kurang) AS totalnya ".
								"FROM siswa_bayar_tagihan");
$rowx = mysqli_fetch_assoc($qx);
$e_total_tunggakan = balikin($rowx['totalnya']);






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



        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL PEMBAYARAN</span>
              <span class="info-box-number"><?php echo xduit3($e_total_bayar);?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->





        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL TUNGGAKAN</span>
              <span class="info-box-number"><?php echo xduit3($e_total_tunggakan);?></span>
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
	                <h3 class="card-title">Grafik : Pembayaran</h3>
	
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
	                    <i class="fas fa-square text-blue"></i> Pembayaran
	                  </span>
                  
	                  
	                </div>
	
	
	                
	                
	              </div>
	            </div>
	
			</div>
			
		</div>
			            
	          

	





	
            
		<!-- Info boxes -->
      <div class="row">
	
        <!-- /.col -->
        <div class="col-md-6">
            
			<?php
			$limit = 30;
			$sqlcount = "SELECT * FROM siswa_bayar ".
							"WHERE nominal_bayar > 0 ".
							"ORDER BY tgl_bayar DESC";

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
			
			
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">HISTORY PEMBAYARAN</h3>

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
                      <th>TGL.BAYAR</th>
                      <th>SISWA</th>
                      <th>NOMINAL</th>
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
							$i_tgl_bayar = balikin($data['tgl_bayar']);
							$i_nominal = balikin($data['nominal_bayar']);
							$i_swkode = balikin($data['siswa_kode']);
							$i_swnama = balikin($data['siswa_nama']);
							$i_swkelas = balikin($data['siswa_kelas']);
							


							echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
							echo '<td>'.$i_tgl_bayar.'</td>
							<td>
							'.$i_swnama.'
							 
							<br>
							NIS:'.$i_swkode.'
							
							<br>
							Kelas:'.$i_swkelas.'
							</td>
							<td>'.xduit3($i_nominal).'</td>
					        </tr>';
							}
						while ($data = mysqli_fetch_assoc($result));
						?>
						
						
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>



              <div class="card-footer">

				<a href="keu/history.php" class="btn btn-block btn-danger">SELENGKAPNYA >></a>
              </div>



              <!-- /.card-footer -->
            </div>
            <!-- /.card -->



		</div>
		
		
		
		
		<!-- /.col -->
        <div class="col-md-6">
            
			<?php
			$limit = 30;
			$sqlcount = "SELECT * FROM siswa_bayar_tagihan ".
							"WHERE nominal_kurang > 0 ".
							"ORDER BY item_tapel DESC, ".
							"item_smt ASC, ".
							"item_thn DESC, ".
							"round(item_bln) ASC, ".
							"item_kelas ASC, ".
							"item_nama ASC";

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
			
			
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">HISTORY TUNGGAKAN</h3>

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
                    	<td width="50" align="center"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
						<td width="100" align="center"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
						<td width="50" align="center"><strong><font color="'.$warnatext.'">SMT</font></strong></td>
						<td width="50" align="center"><strong><font color="'.$warnatext.'">TAHUN</font></strong></td>
						<td width="50" align="center"><strong><font color="'.$warnatext.'">BULAN</font></strong></td>
						<td width="200" align="center"><strong><font color="'.$warnatext.'">SISWA</font></strong></td>
						<td align="center"><strong><font color="'.$warnatext.'">NAMA TAGIHAN</font></strong></td>
						<td width="150" align="center"><strong><font color="'.$warnatext.'">NOMINAL</font></strong></td>
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
							$e_kd = nosql($data['kd']);
							$e_swkd = balikin($data['siswa_kd']);
							$e_swnis = balikin($data['siswa_kode']);
							$e_swnama = balikin($data['siswa_nama']);
							$e_tapel = balikin($data['item_tapel']);
							$e_smt = balikin($data['item_smt']);
							$e_kelas = balikin($data['item_kelas']);
							$e_tahun = balikin($data['item_thn']);
							$e_bulan = balikin($data['item_bln']);
							$e_nama = balikin($data['item_nama']);
							$e_nominal = balikin($data['nominal_kurang']);
							$e_postdate = balikin($data['postdate']);
					
					
							$e_siswa = "$e_swnama <br>NIS:$e_swnis";
					
					
							echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
							echo '<td align="center">'.$e_tapel.'</td>
							<td align="center">'.$e_kelas.'</td>
							<td align="center">'.$e_smt.'</td>
							<td align="center">'.$e_tahun.'</td>
							<td align="center">'.$e_bulan.'</td>
							<td align="left">'.$e_siswa.'</td>
							<td>'.$e_nama.'</td>
							<td align="center">'.xduit3($e_nominal).'</td>
					        </tr>';

							}
						while ($data = mysqli_fetch_assoc($result));
						?>
						
						
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>



              <div class="card-footer">

				<a href="keu/tunggakan.php" class="btn btn-block btn-danger">SELENGKAPNYA >></a>
              </div>



              <!-- /.card-footer -->
            </div>
            <!-- /.card -->



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