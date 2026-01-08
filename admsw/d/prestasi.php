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


//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admsw.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admsw.html");






//nilai
$filenya = "prestasi.php";
$judul = "Prestasi Siswa";
$judulku = "$judul";
$judulx = $judul;
$kdx = nosql($_REQUEST['kdx']);
$nis = $nis2_session;
$pelkd = nosql($_REQUEST['pelkd']);
$swkd = $kd2_session;
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya";




//focus...
if (empty($nis))
	{
	$diload = "document.formx.nis.focus();";
	}








//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");


//jika null
$e_tgl = "$tahun-$bulan-$tanggal";


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qccx = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
									"WHERE kode = '$nis' ".
									"AND kd = '$swkd' ".
									"ORDER BY tapel DESC");
$rccx = mysqli_fetch_assoc($qccx);
$tccx = mysqli_num_rows($qccx);
$e_swkd = nosql($rccx['kd']);
$e_nama = balikin($rccx['nama']);
$e_kelas = balikin($rccx['kelas']);
$e_tapel = balikin($rccx['tapel']);



//ketahui totalnya
//query
$qccx = mysqli_query($koneksi, "SELECT SUM(point_nilai) AS totalnya ".
									"FROM siswa_prestasi ".
									"WHERE siswa_kd = '$swkd'");
$rccx = mysqli_fetch_assoc($qccx);
$e_total = nosql($rccx['totalnya']);
?>


	<div class="row">
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fa fa-user"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">NIS, NAMA SISWA</span>
            <span class="info-box-number"><?php echo "$nis. <br>$e_nama";?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Tahun Pelajaran</span>
            <span class="info-box-number"><?php echo $e_tapel;?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fa fa-building-o"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Kelas</span>
            <span class="info-box-number"><?php echo $e_kelas;?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fa fa-briefcase"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Total Point</span>
            <span class="info-box-number"><?php echo $e_total;?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
    
    



	<div class="card card-success card-tabs">
      <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">HISTORY PRESTASI</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
          <div class="tab-pane show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

			<?php
				//query
				$p = new Pager();
				$limit = 1000;
				$start = $p->findStart($limit);
				
				$sqlcount = "SELECT * FROM siswa_prestasi ".
								"WHERE siswa_kd = '$swkd' ".
								"ORDER BY tgl DESC";
				$sqlresult = $sqlcount;
				
				$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
				$pages = $p->findPages($count, $limit);
				$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
				$target = "$filenya?s=detail&swkd=$swkd&nis=$nis";
				$pagelist = $p->pageList($_GET['page'], $pages, $target);
				$data = mysqli_fetch_array($result);
				
				
				
				

				//total point nya
				$qyuk = mysqli_query($koneksi, "SELECT SUM(point_nilai) AS totalnya ".
													"FROM siswa_prestasi ".
													"WHERE siswa_kd = '$swkd'");
				$ryuk = mysqli_fetch_assoc($qyuk);
				$yuk_subtotal = balikin($ryuk['totalnya']);



				//total pelanggaran
				$qyuk = mysqli_query($koneksi, "SELECT SUM(point_nilai) AS totalnya ".
													"FROM siswa_pelanggaran ".
													"WHERE siswa_kd = '$swkd'");
				$ryuk = mysqli_fetch_assoc($qyuk);
				$yuk_pelanggaran = balikin($ryuk['totalnya']);


				//subtotal akhir
				$yuk_akhir = $yuk_pelanggaran - $yuk_subtotal;


				//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				echo '<div class="row">
				
					<div class="col-md-12">
						<div class="box">
						
							<div class="box-body">
							
							
								<p>
								[Jumlah Prestasi : <b>'.$count.'</b>]. 
								
								[Total Point : <b>'.$yuk_subtotal.'</b>].
								</p>
			
		
								<div class="table-responsive">          
								<table class="table" border="1">
								<thead>
								
								<tr valign="top" bgcolor="'.$warnaheader.'">
								<td width="50"><strong><font color="'.$warnatext.'">TANGGAL</font></strong></td>
								<td><strong><font color="'.$warnatext.'">NAMA PRESTASI</font></strong></td>
								<td width="50"><strong><font color="'.$warnatext.'">NILAI POINT</font></strong></td>
								<td><strong><font color="'.$warnatext.'">KETERANGAN</font></strong></td>
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
										$i_tgl = balikin($data['tgl']);
										$i_jenis = balikin($data['jenis_nama']);
										$i_nama = balikin($data['point_nama']);
										$i_nilai = balikin($data['point_nilai']);
										$i_ket = balikin($data['point_ket']);
								
										echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
										echo '<td>'.$i_tgl.'</td>
										<td>'.$i_nama.'</td>
										<td align="right">'.$i_nilai.'</td>
										<td>'.$i_ket.'</td>
								        </tr>';
										}
									while ($data = mysqli_fetch_assoc($result));
									}
								
								
								echo '</tbody>
								  </table>
								  </div>
		
							</div>
						</div>
					</div>';
					?>



 
                  </div>

        </div>
      </div>
      <!-- /.card -->
    </div>
	<?php
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