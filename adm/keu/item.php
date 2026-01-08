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
require("../../inc/cek/adm.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/adm.html");








//nilai
$filenya = "item.php";
$judul = "[KEUANGAN SISWA] Data Item Pembayaran";
$judulku = "$judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek baru
if ($_POST['btnBR'])
	{
	//nilai
	$ke = "$filenya?s=baru&kd=$x";
	
	
	//re-direct
	xloc($ke);
	exit();
	}






//nek cari
if ($_POST['btnCARI'])
	{
	//nilai
	$kunci = cegah($_POST['e_kunci']);
	
	$ke = "$filenya?kunci=$kunci";
	
	
	//re-direct
	xloc($ke);
	exit();
	}









//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}



//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$page = nosql($_POST['page']);
	$e_kd = nosql($_POST['e_kd']);
	$e_tapel = cegah($_POST['e_tapel']);
	$e_smt = cegah($_POST['e_smt']);
	$e_kelas = cegah($_POST['e_kelas']);
	$e_tahun = cegah($_POST['e_tahun']);
	$e_bulan = cegah($_POST['e_bulan']);
	$e_nama = cegah($_POST['e_nama']);
	$e_nominal = cegah($_POST['e_nominal']);

	
	


	//nek null
	if (empty($e_nama))
		{
		//re-direct
		$pesan = "Belum Ditulis. Harap Diulangi...!!";
		$ke = "$filenya?s=$s&kd=$e_kd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika baru
		if ($s == "baru")
			{
			//cek
			$qcc = mysqli_query($koneksi, "SELECT * FROM m_keu_siswa ".
												"WHERE tapel = '$e_tapel' ".
												"AND smt = '$e_smt' ".
												"AND kelas = '$e_kelas' ".
												"AND tahun = '$e_tahun' ".
												"AND bulan = '$e_bulan' ".
												"AND nama = '$e_nama'");
			$rcc = mysqli_fetch_assoc($qcc);
			$tcc = mysqli_num_rows($qcc);
			
			//nek ada
			if ($tcc != 0)
				{
				//re-direct
				$pesan = "Sudah Ada. Silahkan Ganti Yang Lain...!!";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//insert
				mysqli_query($koneksi, "INSERT INTO m_keu_siswa(kd, tapel, smt, ".
											"kelas, thn, bln, ".
											"nama, nominal, postdate) VALUES ".
											"('$e_kd', '$e_tapel', '$e_smt', ".
											"'$e_kelas', '$e_tahun', '$e_bulan', ".
											"'$e_nama', '$e_nominal', '$today')");
	

				//re-direct
				xloc($filenya);
				exit();
				}
			}
			
			
				
				
		//jika update
		else if ($s == "edit")
			{
			mysqli_query($koneksi, "UPDATE m_keu_siswa SET nama = '$e_nama', ".
									"tapel = '$e_tapel', ".
									"smt = '$e_smt', ".
									"kelas = '$e_kelas', ".
									"thn = '$e_tahun', ".
									"bln = '$e_bulan', ".
									"nama = '$e_nama', ".
									"nominal = '$e_nominal', ".
									"postdate = '$today' ".
									"WHERE kd = '$e_kd'");
	
	
			//re-direct
			xloc($filenya);
			exit();
			}
		}
	}	
	
	
	
	
	
	

//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$ke = $filenya;

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysqli_query($koneksi, "DELETE FROM m_keu_siswa ".
						"WHERE kd = '$kd'");
		}


	//auto-kembali
	xloc($ke);
	exit();
	}
	
	
	
	
	
	
	
	
	
	
	

	
	
	
//jika import
if ($_POST['btnIM'])
	{
	//re-direct
	$ke = "$filenya?s=import";
	xloc($ke);
	exit();
	}












//lama
//import sekarang
if ($_POST['btnIMX'])
	{
	$filex_namex2 = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex2))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?s=import";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .xls
		$ext_filex = substr($filex_namex2, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox";
			$path2 = "../../filebox/excel";
			chmod($path1,0777);
			chmod($path2,0777);

			//nama file import, diubah menjadi baru...
			$filex_namex2 = "daftar_item_keuangan_siswa.xls";

			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex2");

			//chmod
            $path3 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0755);
			chmod($path2,0777);
			chmod($path3,0777);

			//file-nya...
			$uploadfile = $path3;





			//require
			require('../../inc/class/PHPExcel.php');
			require('../../inc/class/PHPExcel/IOFactory.php');


			  // load excel
			  $load = PHPExcel_IOFactory::load($uploadfile);
			  $sheets = $load->getActiveSheet()->toArray(null,true,true,true);
			
			  $i = 1;
			  foreach ($sheets as $sheet) 
			  	{
			    // karena data yang di excel di mulai dari baris ke 3
			    // maka jika $i lebih dari 1 data akan di masukan ke database
			    if ($i > 3) 
			    	{
				      // nama ada di kolom A
				      // sedangkan alamat ada di kolom B
				      $i_tapel = cegah($sheet['A']);
				      $i_smt = cegah($sheet['B']);
				      $i_kelas = cegah($sheet['C']);
				      $i_tahun = cegah($sheet['D']);
				      $i_bulan = cegah($sheet['E']);
				      $i_nama = cegah($sheet['F']);
				      $i_nominal = cegah($sheet['G']);


				      $i_xyz = md5("$i_tapel$i_smt$i_kelas$i_tahun$i_bulan$i_nama");
					  



						//hapus dulu, sebelum entri
						mysqli_query($koneksi, "DELETE FROM m_keu_siswa ".
												"WHERE tapel = '$i_tapel' ".
												"AND smt = '$i_smt' ".
												"AND kelas = '$i_kelas' ".
												"AND tahun = '$i_tahun' ".
												"AND bulan = '$i_bulan' ".
												"AND nama = '$i_nama'");

						

						
					//insert
					mysqli_query($koneksi, "INSERT INTO m_keu_siswa(kd, tapel, smt, ".
												"kelas, thn, bln, ".
												"nama, nominal, postdate) VALUES ".
												"('$i_xyz', '$i_tapel', '$i_smt', ".
												"'$i_kelas', '$i_tahun', '$i_bulan', ".
												"'$i_nama', '$i_nominal', '$today')");


					  
				    }
			
			    $i++;
			  }





			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0777);
			unlink ($path1);



			//re-direct
			xloc($filenya);
			exit();
			}
		else
			{
			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}



	
	
	
	
	

//jika export
//export
if ($_POST['btnEX'])
	{
	//query
	$limit = 10000;
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM m_keu_siswa ".
					"ORDER BY tapel DESC, ".
					"smt ASC, ".
					"kelas ASC, ".
					"thn DESC, ".
					"bln ASC, ".
					"nama ASC";
	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);


	$fileku = "item_keuangan_siswa.xls";





	
	//isi *START
	ob_start();
	

	

	echo '<div class="table-responsive">
	<h3>DAFTAR ITEM KEUANGAN SISWA</h3>
	
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>

		<tr bgcolor="'.$warnaheader.'">
		<td width="50" align="center"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
		<td width="50" align="center"><strong><font color="'.$warnatext.'">SMT</font></strong></td>
		<td width="100" align="center"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
		<td width="50" align="center"><strong><font color="'.$warnatext.'">TAHUN</font></strong></td>
		<td width="50" align="center"><strong><font color="'.$warnatext.'">BULAN</font></strong></td>
		<td align="center"><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
		<td width="150" align="center"><strong><font color="'.$warnatext.'">NOMINAL</font></strong></td>
		</tr>

	</thead>
	<tbody>';
	
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
			$e_tapel = balikin($data['tapel']);
			$e_smt = balikin($data['smt']);
			$e_kelas = balikin($data['kelas']);
			$e_tahun = balikin($data['thn']);
			$e_bulan = balikin($data['bln']);
			$e_nama = balikin($data['nama']);
			$e_nominal = balikin($data['nominal']);
			$e_postdate = balikin($data['postdate']);

	
	
	
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td align="center">'.$e_tapel.'</td>
			<td align="center">'.$e_smt.'</td>
			<td align="center">'.$e_kelas.'</td>
			<td align="center">'.$e_tahun.'</td>
			<td align="center">'.$e_bulan.'</td>
			<td>'.$e_nama.'</td>
			<td align="center">'.$e_nominal.'</td>
	        </tr>';

			}
		while ($data = mysqli_fetch_assoc($result));



	echo '</tbody>
	  </table>
	  </div>';



	
	//isi
	$isiku = ob_get_contents();
	ob_end_clean();


	
	
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$fileku");
	echo $isiku;
	
	

	exit();
	}	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();


?>


  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  
  
  
<?php
//require
require("../../template/js/jumpmenu.js");
require("../../template/js/checkall.js");
require("../../template/js/swap.js");
require("../../inc/js/number.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<div class="row">

<div class="col-md-12">
<div class="box">

<div class="box-body">
<div class="row">


<div class="col-md-12">';

//jika import
if ($s == "import")
	{
	?>
	<div class="row">

	<div class="col-md-12">
		
	<?php
	echo '<form action="'.$filenya.'" method="post" enctype="multipart/form-data" name="formxx2">
	<p>
		<input name="filex_xls" type="file" size="30" class="btn btn-warning" required>
	</p>

	<p>
	
		<input name="btnBTL" type="submit" value="BATAL" class="btn btn-info">
		<input name="btnIMX" type="submit" value="IMPORT >>" class="btn btn-danger">
	</p>
	
	
	</form>';	
	?>
		


	</div>
	
	</div>


	<?php
	}
else
	{
	if (($s == "baru") OR ($s == "edit"))
		{
		?>
		
		
		<script language='javascript'>
		//membuat document jquery
		$(document).ready(function(){
		
		
			  $('#e_kode').bind('keyup paste', function(){
		        this.value = this.value.replace(/[^0-9]/g, '');
		  		});
	
					
		});
		
		</script>
	
	
	
		<?php
		//edit
		$qx = mysqli_query($koneksi, "SELECT * FROM m_keu_siswa ".
										"WHERE kd = '$kd'");
		$rowx = mysqli_fetch_assoc($qx);
		$e_kd = nosql($rowx['kd']);
		$e_tapel = balikin($rowx['tapel']);
		$e_smt = balikin($rowx['smt']);
		$e_kelas = balikin($rowx['kelas']);
		$e_tahun = balikin($rowx['thn']);
		$e_bulan = balikin($rowx['bln']);
		$e_nominal = balikin($rowx['nominal']);
		$e_nama = balikin($rowx['nama']);
	
	
	
		
		echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
		
		<div class="row">
	
		<div class="col-md-4">
		
		
			<p>
			TAHUN PELAJARAN : 
			<br>';
			
			echo '<select name="e_tapel" class="btn btn-warning" required>
			<option value="'.$e_tapel.'" selected>'.$e_tapel.'</option>';
			
			//daftar 
			$qku = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
											"ORDER BY nama DESC");
			$rku = mysqli_fetch_assoc($qku);
			
			do
				{
				//nilai
				$ku_nama = balikin($rku['nama']);
				
				echo '<option value="'.$ku_nama.'">'.$ku_nama.'</option>';
				}
			while ($rku = mysqli_fetch_assoc($qku));
			
			
			echo '</select>
			</p>
		
		
			<p>
			SEMESTER : 
			<br>';
			
			echo '<select name="e_smt" class="btn btn-warning" required>
			<option value="'.$e_smt.'" selected>'.$e_smt.'</option>
			<option value="1">1</option>
			<option value="2">2</option>
			</select>	
			</p>
		
		
		
			<p>
			KELAS : 
			<br>';
			
			echo '<select name="e_kelas" class="btn btn-warning" required>
			<option value="'.$e_kelas.'" selected>'.$e_kelas.'</option>';
			
			//daftar 
			$qku = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
											"ORDER BY nama ASC");
			$rku = mysqli_fetch_assoc($qku);
			
			do
				{
				//nilai
				$ku_nama = balikin($rku['nama']);
				
				echo '<option value="'.$ku_nama.'">'.$ku_nama.'</option>';
				}
			while ($rku = mysqli_fetch_assoc($qku));
			
			
			echo '</select>
			</p>
			
		</div>
		
		<div class="col-md-4">
			
			<p>
			TAHUN : 
			<br>
			<input name="e_tahun" id="e_tahun" type="text" size="4" value="'.$e_tahun.'" onKeyPress="return numbersonly(this, event)" class="btn btn-warning" required>
			</p>
			
			
			
			<p>
			BULAN : 
			<br>
			<input name="e_bulan" id="e_bulan" type="text" size="2" value="'.$e_bulan.'" onKeyPress="return numbersonly(this, event)" class="btn btn-warning" required>
			</p>
			
			
			<p>
			NAMA : 
			<br>
			<input name="e_nama" type="text" size="30" value="'.$e_nama.'" class="btn btn-warning" required>
			</p>
			
			
			
			
			<p>
			NOMINAL : 
			<br>
			Rp. <input name="e_nominal" id="e_nominal" type="text" size="10" value="'.$e_nominal.'" onKeyPress="return numbersonly(this, event)" class="btn btn-warning" required>,-
			</p>
			
		</div>
	
		</div>
		
		
		
		
		
		<div class="row">
	
		<div class="col-md-8">
	
			<input name="s" type="hidden" value="'.$s.'">
			<input name="e_kd" type="hidden" value="'.$kd.'">
			<input name="page" type="hidden" value="'.$page.'">
		
			<p>
			<hr>	
			<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
			
			<a href="'.$filenya.'" class="btn btn-info">BATAL</a>
			<hr>
			</p>
			
		</div>
		
		</div>
		
		
		
		</form>';
		}
		
		
		
		
	
	
		
	else
		{
		//jika kunci cari
		if (!empty($kunci))
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);
			
			$sqlcount = "SELECT * FROM m_keu_siswa ".
							"WHERE tapel LIKE '%$kunci%' ".
							"OR smt LIKE '%$kunci%' ".
							"OR kelas LIKE '%$kunci%' ".
							"OR thn LIKE '%$kunci%' ".
							"OR bln LIKE '%$kunci%' ".
							"OR nama LIKE '%$kunci%' ".
							"OR nominal LIKE '%$kunci%' ".
							"ORDER BY nama ASC";
			$sqlresult = $sqlcount;

			$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			}
	
	
		else
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);
			
			$sqlcount = "SELECT * FROM m_keu_siswa ".
							"ORDER BY tapel DESC, ".
							"smt ASC, ".
							"thn DESC, ".
							"round(bln) ASC, ".
							"kelas ASC, ".
							"nama ASC";
			$sqlresult = $sqlcount;
			
			$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			}
		
		
		
		
		//detail
		$e_kunci = balikin($kunci);
		
		echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
		
		<p>
		<input name="btnBR" type="submit" value="ENTRI BARU >>" class="btn btn-danger">
		
		
		<input name="btnIM" type="submit" value="IMPORT" class="btn btn-primary">
		<input name="btnEX" type="submit" value="EXPORT" class="btn btn-success">
		<hr>
		</p>
	
		<div class="table-responsive">          
			  <table class="table">
			    <thead>
					
				<tr valign="top">
				<td>
			
				<p>
				<input name="e_kunci" type="text" size="30" value="'.$e_kunci.'" class="btn btn-warning">
				
				<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
				
				<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
				</p>
			
			
			
				</td>
	
				</tr>
				</tbody>
			  </table>
			  </div>
			  
			  
		
		<div class="table-responsive">          
			  <table class="table" border="1">
			    <thead>
					
					<tr bgcolor="'.$warnaheader.'">
					<td width="1">&nbsp;</td>
					<td width="1">&nbsp;</td>
					<td width="50" align="center"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
					<td width="50" align="center"><strong><font color="'.$warnatext.'">SMT</font></strong></td>
					<td width="100" align="center"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
					<td width="50" align="center"><strong><font color="'.$warnatext.'">TAHUN</font></strong></td>
					<td width="50" align="center"><strong><font color="'.$warnatext.'">BULAN</font></strong></td>
					<td align="center"><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
					<td width="150" align="center"><strong><font color="'.$warnatext.'">NOMINAL</font></strong></td>
					<td width="50" align="center"><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
					</tr>
		
			    </thead>
			    <tbody>';
		
		if ($count != 0)
			{
			do {
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
				$e_tapel = balikin($data['tapel']);
				$e_smt = balikin($data['smt']);
				$e_kelas = balikin($data['kelas']);
				$e_tahun = balikin($data['thn']);
				$e_bulan = balikin($data['bln']);
				$e_nama = balikin($data['nama']);
				$e_nominal = balikin($data['nominal']);
				$e_postdate = balikin($data['postdate']);
	
		
		
		
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input type="checkbox" name="item'.$nomer.'" value="'.$e_kd.'">
		        </td>
				<td>
				<a href="'.$filenya.'?s=edit&kd='.$e_kd.'"><img src="'.$sumber.'/template/img/edit.gif" width="16" height="16" border="0"></a>
				</td>
				<td align="center">'.$e_tapel.'</td>
				<td align="center">'.$e_smt.'</td>
				<td align="center">'.$e_kelas.'</td>
				<td align="center">'.$e_tahun.'</td>
				<td align="center">'.$e_bulan.'</td>
				<td>'.$e_nama.'</td>
				<td align="center">'.xduit3($e_nominal).'</td>
				<td>'.$e_postdate.'</td>
		        </tr>';
				}
			while ($data = mysqli_fetch_assoc($result));
			}
		
		
		echo '</tbody>
			  </table>
			  </div>
			  
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
		<input name="jml" type="hidden" value="'.$count.'">
		<br>
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')" class="btn btn-primary">
		<input name="btnBTL" type="reset" value="BATAL" class="btn btn-warning">
		<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-danger">
		</td>
		</tr>
		</table>';
		}
		
	
	echo '</form>';
	}



echo '</div>
</div>
</div>
</div>
</div>
</div>';

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//null-kan
xclose($koneksi);
exit();
?>