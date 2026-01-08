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
$filenya = "ekstra_siswa.php";
$judul = "Ekstra Siswa";
$judulku = "[EKSTRA]. $judul";
$judulx = $judul;
$kdx = nosql($_REQUEST['kdx']);
$nis = nosql($_REQUEST['nis']);
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
	mysqli_query($koneksi, "DELETE FROM siswa_ekstra ".
								"WHERE siswa_kd = '$swkd' ".
								"AND siswa_nis = '$nis' ".
								"AND kd = '$pkd'");


	//re-direct
	$ke = "$filenya?s=detail&swkd=$swkd&nis=$nis";
	xloc($ke);
	exit();
	}










//ke detail prestasi
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






//simpan 
if ($_POST['btnSMPx2'])
	{
	//nilai
	$p_smt = balikin($_POST['p_smt']);
	$p_predikat = cegah($_POST['p_predikat']);
	$p_ket = cegah($_POST['p_ket']);

	
		

	
	$nis = nosql($_POST['nis']);
	$s = nosql($_POST['s']);
	$pelkd = nosql($_POST['pelkd']);
	$kdx = nosql($_POST['kdx']);
	$swkd = nosql($_POST['swkd']);


	
	//cek
	$qcc = mysqli_query($koneksi, "SELECT * FROM m_ekstra ".
									"WHERE kd = '$pelkd'");
	$rcc = mysqli_fetch_assoc($qcc);
	$tcc = mysqli_num_rows($qcc);
	$cc_pelnama = cegah($rcc['nama']);

	
	



	//cek
	$qcc = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
									"WHERE kd = '$swkd' ".
									"ORDER BY tapel DESC");
	$rcc = mysqli_fetch_assoc($qcc);
	$tcc = mysqli_num_rows($qcc);
	$cc_kd = nosql($rcc['kd']);
	$cc_nama = cegah($rcc['nama']);
	$cc_tapel = cegah($rcc['tapel']);
	$cc_kelas = cegah($rcc['kelas']);




	//cek
	if ((empty($p_ket)) OR (empty($pelkd)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?s=$s&swkd=$swkd&nis=$nis";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//insert
		mysqli_query($koneksi, "INSERT INTO siswa_ekstra (kd, tapel, kelas, ".
									"siswa_kd, siswa_nis, siswa_nama, ".
									"smt, ekstra_kd, ekstra_nama, ".
									"predikat, ket, postdate) VALUES ".
									"('$x', '$cc_tapel', '$cc_kelas', ".
									"'$swkd', '$nis', '$cc_nama', ".
									"'$p_smt', '$pelkd', '$cc_pelnama', ".
									"'$p_predikat', '$p_ket', '$today')");


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
	$qccx = mysqli_query($koneksi, "SELECT * FROM siswa_ekstra ".
										"WHERE siswa_kd = '$swkd'");
	$rccx = mysqli_fetch_assoc($qccx);
	$e_total = mysqli_num_rows($qccx);
	
	//jika null
	if (empty($e_total))
		{
		$e_total = "0";
		}
	
	
	//update kan
	mysqli_query($koneksi, "UPDATE m_siswa SET jml_ekstra = '$e_total' ".
								"WHERE kd = '$swkd'");
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
                <span class="info-box-text">Jumlah Ekstra</span>
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
                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">ENTRI BARU</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">HISTORY EKSTRA</a>
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
				Semester : 
				<br>
				<select name="p_smt" class="btn btn-warning" required>
				<option value="'.$e_smt.'" selected>'.$e_smt.'</option>
				<option value="1">1</option>
				<option value="2">2</option>
				</select>
				</p>
				
				<p>
				Nama Ekstra :
				<br>
				
				<select name="pelkd" class="btn btn-warning" required>';
		
				//terpilih
				$qtpx = mysqli_query($koneksi, "SELECT * FROM m_ekstra ".
													"WHERE kd = '$pelkd'");
				$rowtpx = mysqli_fetch_assoc($qtpx);
				$tpx_kd = nosql($rowtpx['kd']);
				$tpx_nama = balikin2($rowtpx['nama']);
		
		
				echo '<option value="'.$tpx_kd.'" selected>'.$tpx_nama.'</option>';
		
				$qtpi = mysqli_query($koneksi, "SELECT * FROM m_ekstra ".
												"ORDER BY nama ASC");
				$rowtpi = mysqli_fetch_assoc($qtpi);
		
				do
					{
					$i_kd = nosql($rowtpi['kd']);
					$i_nama = balikin2($rowtpi['nama']);
		
					echo '<option value="'.$i_kd.'">'.$i_nama.'</option>';
					}
				while ($rowtpi = mysqli_fetch_assoc($qtpi));
		
				echo '</select>
				</p>

				<p>
				Predikat : 
				<br>
				<select name="p_predikat" class="btn btn-warning" required>
				<option value="'.$e_predikat.'" selected>'.$e_predikat.'</option>
				<option value="Sangat Baik">Sangat Baik</option>
				<option value="Baik">Baik</option>
				<option value="Cukup">Cukup</option>
				<option value="Kurang">Kurang</option>
				</select>
				</p>

				<p>
				Keterangan : 
				<br>
				<input type="text" name="p_ket" id="p_ket" value="'.$e_ket.'" size="30" class="btn btn-warning" required>
				</p>
		


		
				<p>
		
				<input type="submit" name="btnSMPx2" value="SIMPAN >>" class="btn btn-danger">
				<input type="hidden" name="s" value="'.$s.'">
				<input type="hidden" name="kdx" value="'.$kdx.'">
				<input type="hidden" name="nis" value="'.$nis.'">
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
					
					$sqlcount = "SELECT * FROM siswa_ekstra ".
									"WHERE siswa_kd = '$swkd' ".
									"ORDER BY tapel DESC, ".
									"smt ASC";
					$sqlresult = $sqlcount;
					
					$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
					$pages = $p->findPages($count, $limit);
					$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
					$target = "$filenya?s=detail&swkd=$swkd&nis=$nis";
					$pagelist = $p->pageList($_GET['page'], $pages, $target);
					$data = mysqli_fetch_array($result);
					
					
					
	
					//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					echo '<div class="row">
					
						<div class="col-md-12">
							<div class="box">
							
								<div class="box-body">
									<div class="table-responsive">          
									<table class="table" border="1">
									<thead>
									
									<tr valign="top" bgcolor="'.$warnaheader.'">
									<td width="50"><strong><font color="'.$warnatext.'">SEMESTER</font></strong></td>
									<td><strong><font color="'.$warnatext.'">NAMA EKSTRA</font></strong></td>
									<td width="150" align="center"><strong><font color="'.$warnatext.'">PREDIKAT</font></strong></td>
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
											$i_smt = balikin($data['smt']);
											$i_nama = balikin($data['ekstra_nama']);
											$i_nilai = balikin($data['predikat']);
											$i_ket = balikin($data['ket']);
									
											echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
											echo '<td align="center">
											'.$i_smt.'
											</td>
											<td>
											'.$i_nama.'
											<br>
											<a href="'.$filenya.'?s=hapus&pkd='.$i_kd.'&swkd='.$swkd.'&nis='.$nis.'" class="btn btn-danger">HAPUS >></a>
											</td>
											<td align="center">'.$i_nilai.'</td>
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