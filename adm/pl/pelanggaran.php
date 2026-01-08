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
$filenya = "pelanggaran.php";
$judul = "Pelanggaran Siswa";
$judulku = "[PELANGGARAN]. $judul";
$judulx = $judul;
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
	$pkd = cegah($_REQUEST['pkd']);

	
	//hapus
	mysqli_query($koneksi, "DELETE FROM siswa_pelanggaran ".
								"WHERE siswa_kd = '$swkd' ".
								"AND siswa_nis = '$nis' ".
								"AND kd = '$pkd'");


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






//simpan pelanggaran
if ($_POST['btnSMPx2'])
	{
	//nilai
	$p_tgl = balikin($_POST['p_tgl']);
	
	
	
	//pecah tanggal
	$tgl1_pecah = balikin($p_tgl);
	$tgl1_pecahku = explode("-", $tgl1_pecah);
	$tgl1_tgl = trim($tgl1_pecahku[2]);
	$tgl1_bln = trim($tgl1_pecahku[1]);
	$tgl1_thn = trim($tgl1_pecahku[0]);
	$tgl_entry = "$tgl1_thn-$tgl1_bln-$tgl1_tgl";
	
	$nis = nosql($_POST['nis']);
	$s = nosql($_POST['s']);
	$jnskd = nosql($_POST['jnskd']);
	$pelkd = nosql($_POST['pelkd']);
	$kdx = nosql($_POST['kdx']);
	$swkd = nosql($_POST['swkd']);




	//cek
	$qcc = mysqli_query($koneksi, "SELECT * FROM m_bk_point_jenis ".
									"WHERE kd = '$jnskd'");
	$rcc = mysqli_fetch_assoc($qcc);
	$tcc = mysqli_num_rows($qcc);
	$cc_jeniskode = cegah($rcc['no']);
	$cc_jenisnama = cegah($rcc['jenis']);

	
	//cek
	$qcc = mysqli_query($koneksi, "SELECT * FROM m_bk_point ".
									"WHERE kd = '$pelkd'");
	$rcc = mysqli_fetch_assoc($qcc);
	$tcc = mysqli_num_rows($qcc);
	$cc_pelkode = cegah($rcc['no']);
	$cc_pelnama = cegah($rcc['nama']);
	$cc_pelnama2 = balikin($rcc['nama']);
	$cc_pelpoint = cegah($rcc['point']);
	$cc_pelsanksi = cegah($rcc['sanksi']);
	
	
	
	



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




	//cek
	if ((empty($jnskd)) OR (empty($pelkd)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?s=$s&swkd=$swkd&nis=$nis&jnskd=$jnskd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//insert
		mysqli_query($koneksi, "INSERT INTO siswa_pelanggaran (kd, tapel_nama, kelas_nama, ".
									"siswa_kd, siswa_nis, siswa_nama, ".
									"tgl, jenis_kd, jenis_kode, jenis_nama, ".
									"point_kd, point_kode, point_nama, ".
									"point_nilai, point_sanksi, postdate, ".
									"sahya, sahya_tgl) VALUES ".
									"('$x', '$cc_tapel', '$cc_kelas', ".
									"'$swkd', '$nis', '$cc_nama', ".
									"'$tgl_entry', '$jnskd', '$cc_jeniskode', '$cc_jenisnama', ".
									"'$pelkd', '$cc_pelkode', '$cc_pelnama', ".
									"'$cc_pelpoint', '$cc_pelsanksi', '$today', ".
									"'true', '$today')");


		//re-direct
		$ke = "$filenya?s=$s&swkd=$swkd&nis=$nis";
		xloc($ke);
		exit();
		}
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
                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">ENTRI BARU</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">HISTORY PELANGGARAN</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
              <div class="tab-pane show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

	
				<?php
				//entry
				echo '<form name="formx2" method="post" action="'.$filenya.'">
				<p>
				Tanggal Pelanggaran : <input type="date" name="p_tgl" id="p_tgl" value="'.$e_tgl.'" size="10" class="btn btn-warning" readonly>
				</p>


		
				<p>
				Jenis Pelanggaran :
				<br>';
				echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\" required>";
		
				//terpilih
				$qtpx = mysqli_query($koneksi, "SELECT * FROM m_bk_point_jenis ".
												"WHERE kd = '$jnskd'");
				$rowtpx = mysqli_fetch_assoc($qtpx);
				$tpx_kd = nosql($rowtpx['kd']);
				$tpx_no = balikin($rowtpx['no']);
				$tpx_jenis = balikin($rowtpx['jenis']);
		
		
				echo '<option value="'.$tpx_kd.'" selected>'.$tpx_no.'. '.$tpx_jenis.'</option>';
		
				$qtp = mysqli_query($koneksi, "SELECT * FROM m_bk_point_jenis ".
												"WHERE kd <> '$jnskd' ".
												"ORDER BY round(no) ASC");
				$rowtp = mysqli_fetch_assoc($qtp);
		
				do
					{
					$tpkd = nosql($rowtp['kd']);
					$tpno = nosql($rowtp['no']);
					$tpjenis = balikin($rowtp['jenis']);
		
					echo '<option value="'.$filenya.'?s='.$s.'&swkd='.$swkd.'&nis='.$nis.'&jnskd='.$tpkd.'">'.$tpno.'. '.$tpjenis.'</option>';
					}
				while ($rowtp = mysqli_fetch_assoc($qtp));
		
				echo '</select>
				</p>
		
				<p>
				Nama Pelanggaran :
				<br>';
				echo "<select name=\"pelkd\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\" required>";
		
				//terpilih
				$qtpx = mysqli_query($koneksi, "SELECT * FROM m_bk_point ".
													"WHERE jenis_kd = '$jnskd' ".
													"AND kd = '$pelkd'");
				$rowtpx = mysqli_fetch_assoc($qtpx);
				$tpx_kd = nosql($rowtpx['kd']);
				$tpx_no = balikin2($rowtpx['no']);
				$tpx_nama = balikin2($rowtpx['nama']);
				$tpx_point = balikin2($rowtpx['point']);
		
		
				echo '<option value="'.$tpx_kd.'">'.$tpx_no.'. '.$tpx_nama.' [Point:'.$tpx_point.']</option>';
		
				$qtpi = mysqli_query($koneksi, "SELECT * FROM m_bk_point ".
												"WHERE jenis_kd = '$jnskd' ".
												"AND kd <> '$pelkd' ".
												"ORDER BY round(no) ASC");
				$rowtpi = mysqli_fetch_assoc($qtpi);
		
				do
					{
					$i_kd = nosql($rowtpi['kd']);
					$i_no = balikin2($rowtpi['no']);
					$i_nama = balikin2($rowtpi['nama']);
					$i_point = balikin2($rowtpi['point']);
					$i_sanksi = balikin2($rowtpi['sanksi']);
		
					echo '<option value="'.$filenya.'?s='.$s.'&swkd='.$swkd.'&nis='.$nis.'&jnskd='.$jnskd.'&pelkd='.$i_kd.'">'.$i_no.'. '.$i_nama.' [Point:'.$i_point.']</option>';
					}
				while ($rowtpi = mysqli_fetch_assoc($qtpi));
		
				echo '</select>
				</p>
		
				<p>
		
				<input type="submit" name="btnSMPx2" value="SIMPAN >>" class="btn btn-danger">
				<input type="hidden" name="s" value="'.$s.'">
				<input type="hidden" name="jnskd" value="'.$jnskd.'">
				<input type="hidden" name="kdx" value="'.$kdx.'">
				<input type="hidden" name="nis" value="'.$nis.'">
				<input type="hidden" name="pelkd" value="'.$pelkd.'">
				<input type="hidden" name="swkd" value="'.$swkd.'">
				</p>
				
				</form>';
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
														"FROM siswa_pelanggaran ".
														"WHERE siswa_kd = '$swkd'");
					$ryuk = mysqli_fetch_assoc($qyuk);
					$yuk_subtotal = balikin($ryuk['totalnya']);
					
					
					//update kan
					mysqli_query($koneksi, "UPDATE m_siswa SET jml_pelanggaran = '$count', ".
												"subtotal_pelanggaran = '$yuk_subtotal' ".
												"WHERE kd = '$swkd'");	
					
					//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					echo '<div class="row">
					
						<div class="col-md-12">
							<div class="box">
							
								<div class="box-body">
								
								<p>
								[Jumlah Pelanggaran : <b>'.$count.'</b>]. 
								
								[Total Point : <b>'.$yuk_subtotal.'</b>].
								</p>
			
									<div class="table-responsive">          
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
											<br>
											<a href="'.$filenya.'?s=hapus&pkd='.$i_kd.'&swkd='.$swkd.'&nis='.$nis.'" class="btn btn-block btn-danger">HAPUS >></a>
											<br>
											<br>
											
											<a href="pelanggaran_pdf.php?pkd='.$i_kd.'&swkd='.$swkd.'&nis='.$nis.'" class="btn btn-block btn-success" target="_blank">CETAK PDF >></a>
											</td>
											<td>'.$i_jenis.'</td>
											<td>'.$i_nama.'</td>
											<td align="right">'.$i_nilai.'</td>
											<td>'.$i_sanksi.'</td>
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



					
						//cek
						$qcc = mysqli_query($koneksi, "SELECT * FROM siswa_pelanggaran ".
															"WHERE siswa_kd = '$swkd' ".
															"ORDER BY tgl DESC");
						$rcc = mysqli_fetch_assoc($qcc);
						$tcc = mysqli_num_rows($qcc);
						$i_tgl = balikin($rcc['tgl']);
						$i_jenis = balikin($rcc['jenis_nama']);
						$i_nama = balikin($rcc['point_nama']);
						$i_nilai = balikin($rcc['point_nilai']);
						$i_sanksi = balikin($rcc['point_sanksi']);

						
						
					
					
					
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
						$pesannya = "$i_tgl
$cc_nama2
NIS:$nis 
KELAS:$cc_kelas2
		 
TELAH MELAKUKAN PELANGGARAN : 
$i_nama. 

SANKSI :
$i_sanksi


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