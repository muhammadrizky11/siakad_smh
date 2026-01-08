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
require("../../inc/cek/adm.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/adm.html");






//nilai
$filenya = "pembinaan.php";
$judul = "Pembinaan Siswa";
$judulku = "[PEMBINAAN]. $judul";
$judulx = $judul;
$ikd = nosql($_REQUEST['ikd']);
$kdx = nosql($_REQUEST['kdx']);
$nis = nosql($_REQUEST['nis']);
$jnskd = nosql($_REQUEST['jnskd']);
$pelkd = nosql($_REQUEST['pelkd']);
$swkd = nosql($_REQUEST['swkd']);
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
//jika hapus daftar seorang siswa.
if ($s == "hapus")
	{
	//nilai
	$nis = cegah($_REQUEST['nis']);
	$swkd = cegah($_REQUEST['swkd']);
	$ikd = cegah($_REQUEST['ikd']);




	//update
	mysqli_query($koneksi, "UPDATE siswa_pelanggaran SET bina_tgl = '0000-00-00', ".
								"bina_kd = '', ".
								"bina_nama = '', ".
								"bina_ket = '' ".
								"WHERE kd = '$ikd'");



	//re-direct
	$ke = "$filenya?s=detail&swkd=$swkd&nis=$nis";
	xloc($ke);
	exit();
	}










//ke detail pelanggaran
if ($_POST['btnSMPx'])
	{
	//nilai
	$nis = nosql($_POST['nis']);


	//cek
	if (empty($nis))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//cek
		$qcc = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
											"WHERE kode = '$nis'");
		$rcc = mysqli_fetch_assoc($qcc);
		$tcc = mysqli_num_rows($qcc);
		$cc_kd = nosql($rcc['kd']);

		//nek ada
		if ($tcc != 0)
			{
			//re-direct
			$ke = "$filenya?s=detail&swkd=$cc_kd&nis=$nis";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Tidak Ada Siswa dengan NIS : $nis. Harap Diperhatikan...!!";
			pekem($pesan,$filenya);
			exit();
			}
		}
	}






//simpan pembinaan
if ($_POST['btnSMPx2'])
	{
	//nilai
	$pb_tgl = balikin($_POST['pb_tgl']);
	$pbkd = cegah($_POST['pbkd']);
	$pbket = cegah($_POST['pbket']);

	
	
	//pecah tanggal
	$tgl1_pecah = balikin($pb_tgl);
	$tgl1_pecahku = explode("-", $tgl1_pecah);
	$tgl1_tgl = trim($tgl1_pecahku[2]);
	$tgl1_bln = trim($tgl1_pecahku[1]);
	$tgl1_thn = trim($tgl1_pecahku[0]);
	$tgl_entry = "$tgl1_thn-$tgl1_bln-$tgl1_tgl";
	
	$nis = nosql($_POST['nis']);
	$s = nosql($_POST['s']);
	$pelkd = nosql($_POST['pelkd']);
	$swkd = nosql($_POST['swkd']);


	//query
	$qccx = mysqli_query($koneksi, "SELECT * FROM m_pembinaan ".
										"WHERE kd = '$pbkd'");
	$rccx = mysqli_fetch_assoc($qccx);
	$e_nama = cegah($rccx['nama']);





	//update
	mysqli_query($koneksi, "UPDATE siswa_pelanggaran SET bina_tgl = '$tgl_entry', ".
								"bina_kd = '$pbkd', ".
								"bina_nama = '$e_nama', ".
								"bina_ket = '$pbket' ".
								"WHERE kd = '$pelkd'");




	//re-direct
	$ke = "$filenya?s=detail&pelkd=$pelkd&swkd=$swkd&nis=$nis";
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


//jika null
$e_tgl = "$tahun-$bulan-$tanggal";


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
NIS : 
<input type="text" name="nis" id="nis" value="'.$nis.'" size="10" class="btn btn-warning" required>
<input type="submit" name="btnSMPx" class="btn btn-danger" value="DETAIL >>"> 
</td>
</tr>
</table>

</form>
<br>';

//jika entry
if ($s == "detail")
	{
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
										"FROM siswa_pelanggaran ".
										"WHERE siswa_kd = '$swkd'");
	$rccx = mysqli_fetch_assoc($qccx);
	$e_total = nosql($rccx['totalnya']);
	
	
	
	//update kan
	mysqli_query($koneksi, "UPDATE m_siswa SET jml_pelanggaran = '$e_total' ".
							"WHERE kd = '$swkd'");
	?>
	
	
		<div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fa fa-user"></i></span>

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
              <span class="info-box-icon bg-info"><i class="far fa-flag"></i></span>

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
              <span class="info-box-icon bg-info"><i class="fa fa-building-o"></i></span>

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
              <span class="info-box-icon bg-info"><i class="fa fa-briefcase"></i></span>

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
        
        
	
	
	
		<div class="card card-primary card-tabs">
          <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">BELUM DIBINA</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">SUDAH DIBINA</a>
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
					
					$sqlcount = "SELECT * FROM siswa_pelanggaran ".
									"WHERE siswa_kd = '$swkd' ".
									"AND bina_kd = '' ".
									"ORDER BY tgl DESC";
					$sqlresult = $sqlcount;
					
					$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
					$pages = $p->findPages($count, $limit);
					$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
					$target = "$filenya?s=detail&swkd=$swkd&nis=$nis";
					$pagelist = $p->pageList($_GET['page'], $pages, $target);
					$data = mysqli_fetch_array($result);
					
					
					//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					echo '<div class="table-responsive">          
							<table class="table" border="1">
							<thead>
							
							<tr valign="top" bgcolor="'.$warnaheader.'">
							<td width="50"><strong><font color="'.$warnatext.'">TANGGAL</font></strong></td>
							<td width="150"><strong><font color="'.$warnatext.'">JENIS PELANGGARAN</font></strong></td>
							<td><strong><font color="'.$warnatext.'">NAMA PELANGGARAN</font></strong></td>
							<td width="50"><strong><font color="'.$warnatext.'">NILAI POINT</font></strong></td>
							<td width="200"><strong><font color="'.$warnatext.'">SANKSI</font></strong></td>
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
									$i_sanksi = balikin($data['point_sanksi']);
							
									echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
									echo '<td>
									'.$i_tgl.'
									</td>
									<td>'.$i_jenis.'</td>
									<td>
									'.$i_nama.'
									
									<br>
									<a href="'.$filenya.'?s=binaya&pelkd='.$i_kd.'&swkd='.$swkd.'&nis='.$nis.'" class="btn btn-danger">BINA SEKARANG >></a>
									</td>
									<td align="right">'.$i_nilai.'</td>
									<td>'.$i_sanksi.'</td>
							        </tr>';
									}
								while ($data = mysqli_fetch_assoc($result));
								}
							
							
							echo '</tbody>
							  </table>
							  </div>';
							  ?>
 
                  </div>
              <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">


					<?php
					//query
					$p = new Pager();
					$limit = 1000;
					$start = $p->findStart($limit);
					
					$sqlcount = "SELECT * FROM siswa_pelanggaran ".
									"WHERE siswa_kd = '$swkd' ".
									"AND bina_kd <> '' ".
									"ORDER BY tgl DESC";
					$sqlresult = $sqlcount;
					
					$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
					$pages = $p->findPages($count, $limit);
					$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
					$target = "$filenya?s=detail&swkd=$swkd&nis=$nis";
					$pagelist = $p->pageList($_GET['page'], $pages, $target);
					$data = mysqli_fetch_array($result);
					
					
					//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					echo '<div class="table-responsive">          
							<table class="table" border="1">
							<thead>
							
							<tr valign="top" bgcolor="'.$warnaheader.'">
							<td width="50"><strong><font color="'.$warnatext.'">TANGGAL PEMBINAAN</font></strong></td>
							<td><strong><font color="'.$warnatext.'">DETAIL PEMBINAAN</font></strong></td>
							<td><strong><font color="'.$warnatext.'">PELANGGARAN</font></strong></td>
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
									$i_sanksi = balikin($data['point_sanksi']);
									
									
									$i_btgl = balikin($data['bina_tgl']);
									$i_bket = balikin($data['bina_ket']);
									$i_bnama = balikin($data['bina_nama']);
							
									echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
									echo '<td>
									'.$i_btgl.'
									
									<br>
									<a href="'.$filenya.'?s=hapus&swkd='.$swkd.'&nis='.$nis.'&ikd='.$i_kd.'" class="btn btn-block btn-danger">HAPUS >></a>
									<br>
									
									<a href="pembinaan_pdf.php?swkd='.$swkd.'&nis='.$nis.'&ikd='.$i_kd.'" class="btn btn-block btn-success" target="_blank">CETAK PDF >></a>
									</td>
									<td>
									'.$i_bnama.'.
									<br>
									'.$i_bket.'
									</td>
									<td>
									Tanggal Melanggar : '.$i_tgl.'
									<br>
									'.$i_jenis.'. '.$i_nama.'
									<br>
									Point:'.$i_nilai.'
									<br>
									Sanksi:'.$i_sanksi.'
									
									</td>
							        </tr>';
									}
								while ($data = mysqli_fetch_assoc($result));
								}
							
							
							echo '</tbody>
							  </table>
							  </div>';





					
						//cek
						$qcc = mysqli_query($koneksi, "SELECT * FROM siswa_pelanggaran ".
															"WHERE siswa_kd = '$swkd' ".
															"AND bina_kd <> '' ".
															"ORDER BY bina_tgl DESC");
						$rcc = mysqli_fetch_assoc($qcc);
						$tcc = mysqli_num_rows($qcc);
						$i_btgl = balikin($rcc['bina_tgl']);
						$i_bket = balikin($rcc['bina_ket']);
						$i_bnama = balikin($rcc['bina_nama']);
							
						
					
					
					
						//cek
						$qcc = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
														"WHERE kd = '$swkd' ".
														"ORDER BY tapel DESC");
						$rcc = mysqli_fetch_assoc($qcc);
						$tcc = mysqli_num_rows($qcc);
						$cc_kd = nosql($rcc['kd']);
						$cc_nama = cegah($rcc['nama']);
						$cc_nama2 = balikin($rcc['nama']);
						$cc_tapel = cegah($rcc['tapel']);
						$cc_kelas = cegah($rcc['kelas']);
						$cc_kelas2 = balikin($rcc['kelas']);
						$cc_nowa = cegah($rcc['nowa']);
						


						//kirim wa
						$yuk_nowa = balikin($cc_nowa);
						$pesannya = "$i_btgl
$cc_nama2
NIS:$nis 
KELAS:$cc_kelas2
		 
TELAH DILAKUKAN PEMBINAAN : 
$i_bnama

$i_bket. 



";
				
				
						echo '<form name="formxku" id="formxku">
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
							    	$('#ikirimwa').html(data)
							    	}
							});
						
						
						
						
						});
						
						</script>
						
						
						
						<div id="ikirimwa"></div>
				




 
                  </div>

            </div>
          </div>
          <!-- /.card -->
        </div>
		<?php
	}



//jika bina
else if ($s == "binaya")
	{
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
										"FROM siswa_pelanggaran ".
										"WHERE siswa_kd = '$swkd'");
	$rccx = mysqli_fetch_assoc($qccx);
	$e_total = nosql($rccx['totalnya']);



	//query
	$qccx2 = mysqli_query($koneksi, "SELECT * FROM siswa_pelanggaran ".
										"WHERE siswa_kd = '$swkd' ".
										"AND kd = '$pelkd'");
	$rccx2 = mysqli_fetch_assoc($qccx2);
	$e_pnama = balikin($rccx2['point_nama']);
	$e_pnilai = balikin($rccx2['point_nilai']);
	$e_psanksi = balikin($rccx2['point_sanksi']);
	$e_ptgl = balikin($rccx2['tgl']);

	?>
	
	
		<div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fa fa-user"></i></span>

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
              <span class="info-box-icon bg-info"><i class="far fa-flag"></i></span>

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
              <span class="info-box-icon bg-info"><i class="fa fa-building-o"></i></span>

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
              <span class="info-box-icon bg-info"><i class="fa fa-briefcase"></i></span>

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
        
        <?php
        echo '<hr>
        <div class="row">
        <div class="col-md-6">
	          
	          <div class="callout callout-danger">
	          <h5><b>'.$e_pnama.' [Point:'.$e_pnilai.']</b></h5>
	          
	          <p>
	          Tanggal Melanggar : 
	          <br>
	          <b>'.$e_ptgl.'</b>
	          </p>
	
	          <p>
	          Sanksi :
	          <br>
	          <b>'.$e_psanksi.'</b>
	          </p>
	        </div>
	    </div>
	    
		<div class="col-md-6">
	          
	          <div class="callout callout-success">
	          <h5><b>PEMBINAAN</b></h5>
	          
			  <form name="formx2" method="post" action="'.$filenya.'">
	          <p>
	          Tanggal Pembinaan : 
	          <br>
				<input type="date" name="pb_tgl" id="pb_tgl" value="'.$e_pbtgl.'" size="10" class="btn btn-warning" required>
	          </p>
	
	          <p>
	          Pembinaan dan Oleh :
	          <br>
				<select name="pbkd" class="btn btn-warning" required>
				<option value="" selected></option>';
		
				$qtpi = mysqli_query($koneksi, "SELECT * FROM m_pembinaan ".
												"ORDER BY nama ASC");
				$rowtpi = mysqli_fetch_assoc($qtpi);
		
				do
					{
					$i_kd = nosql($rowtpi['kd']);
					$i_nama = balikin2($rowtpi['nama']);
					$i_pkode = balikin2($rowtpi['pembina_kode']);
					$i_pnama = balikin2($rowtpi['pembina_nama']);
		
					echo '<option value="'.$i_kd.'">'.$i_nama.' [Pembina:'.$i_pkode.'. '.$i_pnama.']</option>';
					}
				while ($rowtpi = mysqli_fetch_assoc($qtpi));
		
				echo '</select>
				</p>


				<p>
				Keterangan : 
				<br>
				<textarea cols="50" id="pbket" name="pbket" rows="5" wrap="yes" class="btn-block btn-warning" required>'.$e_ket.'</textarea>
				</p>
				
				<p>
				<input type="hidden" name="s" value="'.$s.'">
				<input type="hidden" name="swkd" value="'.$swkd.'">
				<input type="hidden" name="pelkd" value="'.$pelkd.'">
				<input type="hidden" name="nis" value="'.$nis.'">
				<input type="submit" name="btnSMPx2" class="btn btn-block btn-danger" value="SIMPAN >>">
				<a href="'.$filenya.'?swkd='.$swkd.'&nis='.$nis.'&s=detail" class="btn btn-block btn-info"><< BATAL</a>
				</p>
				
				</form>

	        </div>
	    </div>
	 
	</div>';
	}





echo '</form>
<br>
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