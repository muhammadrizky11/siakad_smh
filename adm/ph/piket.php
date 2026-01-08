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
$filenya = "piket.php";
$judul = "[PIKET HARIAN]. Petugas Piket";
$judulku = "[PIKET HARIAN]. Petugas Piket";
$judulx = $judul;
$kd = nosql($_REQUEST['kd']);
$s = nosql($_REQUEST['s']);
$kunci = cegah($_REQUEST['kunci']);
$kunci2 = balikin($_REQUEST['kunci']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}
	
	


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika export
//export
if ($_POST['btnEX'])
	{
	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');


	//nama file e...
	$i_filename = "piket_harian.xls";
	$i_judul = "piket_harian";
	



	//header file
	function HeaderingExcel($i_filename)
		{
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=$i_filename");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public");
		}

	
	
	
	//bikin...
	HeaderingExcel($i_filename);
	$workbook = new Workbook("-");
	$worksheet1 =& $workbook->add_worksheet($i_judul);
	$worksheet1->write_string(0,0,"NO.");
	$worksheet1->write_string(0,1,"TANGGAL");
	$worksheet1->write_string(0,2,"NIP");
	$worksheet1->write_string(0,3,"NAMA");
	$worksheet1->write_string(0,4,"JABATAN");



	//data
	$qdt = mysqli_query($koneksi, "SELECT * FROM user_piket ".
										"ORDER BY tanggal DESC");
	$rdt = mysqli_fetch_assoc($qdt);

	do
		{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_tgl = balikin($rdt['tanggal']);
		$dt_nip = balikin($rdt['user_kode']);
		$dt_nama = balikin($rdt['user_nama']);
		$dt_jabatan = balikin($rdt['user_jabatan']);



		//ciptakan
		$worksheet1->write_string($dt_nox,0,$dt_nox);
		$worksheet1->write_string($dt_nox,1,$dt_tgl);
		$worksheet1->write_string($dt_nox,2,$dt_nip);
		$worksheet1->write_string($dt_nox,3,$dt_nama);
		$worksheet1->write_string($dt_nox,4,$dt_jabatan);
		}
	while ($rdt = mysqli_fetch_assoc($qdt));


	//close
	$workbook->close();

	
	
	//re-direct
	xloc($filenya);
	exit();
	}












//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//jika cari
if ($_POST['btnCARI'])
	{
	//nilai
	$kunci = cegah($_POST['kunci']);


	//re-direct
	$ke = "$filenya?kunci=$kunci";
	xloc($ke);
	exit();
	}




//nek entri baru
if ($_POST['btnBARU'])
	{
	//re-direct
	$ke = "$filenya?s=baru";
	xloc($ke);
	exit();
	}







//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$page = nosql($_POST['page']);
	$e_tgl = cegah($_POST['e_tgl']);
	$e_petugas = cegah($_POST['e_petugas']);


	
	//pecah tanggal
	$tgl1_pecah = balikin($e_tgl);
	$tgl1_pecahku = explode("-", $tgl1_pecah);
	$tgl1_tgl = trim($tgl1_pecahku[2]);
	$tgl1_bln = trim($tgl1_pecahku[1]);
	$tgl1_thn = trim($tgl1_pecahku[0]);
	$tgl_entry = "$tgl1_thn-$tgl1_bln-$tgl1_tgl";



	//detail e
	$qccx = mysqli_query($koneksi, "SELECT * FROM m_piket ".
										"WHERE kd = '$e_petugas'");
	$rccx = mysqli_fetch_assoc($qccx);
	$e_kode = cegah($rccx['kode']);
	$e_nama = cegah($rccx['nama']);
	$e_jabatan = cegah($rccx['jabatan']);
	

	//nek null
	if ((empty($e_petugas)) OR (empty($e_tgl)))
		{
		//re-direct
		$pesan = "Belum Ditulis. Harap Diulangi...!!";
		$ke = "$filenya?s=$s&kd=$kd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika update
		if ($s == "edit")
			{
			mysqli_query($koneksi, "UPDATE user_piket SET user_kd = '$e_petugas', ".
										"user_kode = '$e_kode', ".
										"user_nama = '$e_nama', ".
										"jabatan = '$e_jabatan', ".
										"tanggal = '$e_tgl' ".
										"WHERE kd = '$kd'");

			//re-direct
			xloc($filenya);
			exit();
			}



		//jika baru
		if ($s == "baru")
			{
			$xyz = md5("$tgl_entry$e_kode");
			
			

			//insert
			mysqli_query($koneksi, "INSERT INTO user_piket(kd, tanggal, user_kd, ".
									"user_kode, user_nama, user_jabatan, postdate) VALUES ".
									"('$xyz', '$tgl_entry', '$e_petugas', ".
									"'$e_kode', '$e_nama', '$e_jabatan', '$today')");

			

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
	$page = nosql($_POST['page']);
	$ke = "$filenya?page=$page";

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysqli_query($koneksi, "DELETE FROM user_piket ".
									"WHERE kd = '$kd'");
		}

	//auto-kembali
	xloc($filenya);
	exit();
	}
	
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();


//require
require("../../template/js/jumpmenu.js");
require("../../template/js/checkall.js");
require("../../template/js/swap.js");
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
//jika edit / baru
if (($s == "baru") OR ($s == "edit"))
	{
	$kdx = nosql($_REQUEST['kd']);

	$qx = mysqli_query($koneksi, "SELECT * FROM user_piket ".
									"WHERE kd = '$kdx'");
	$rowx = mysqli_fetch_assoc($qx);
	$e_kd = balikin($rowx['user_kd']);
	$e_nip = balikin($rowx['user_kode']);
	$e_nama = balikin($rowx['user_nama']);
	$e_jabatan = balikin($rowx['user_jabatan']);
	$e_tgl = balikin($rowx['tanggal']);
	
	
	
	//jika null
	$e_tgl = "$tahun-$bulan-$tanggal";
		
	?>
	
	
	
	<div class="row">

		<div class="col-md-6">
			
		<?php
		echo '<form action="'.$filenya.'" method="post" name="formx2">
		
		<p>
		Tanggal Piket :
		<br>
		<input type="date" name="e_tgl" id="e_tgl" value="'.$e_tgl.'" size="10" class="btn btn-warning" required>
		</p>

		<p>
	    Petugas Piket :
	    <br>
	    <select name="e_petugas" class="btn btn-warning" required>
	    <option value="'.$e_kd.'" selected>'.$e_nama.' [NIP.'.$e_nip.']. ['.$e_jabatan.'].</option>';
		
		$qtpi = mysqli_query($koneksi, "SELECT * FROM m_piket ".
										"ORDER BY nama ASC");
		$rowtpi = mysqli_fetch_assoc($qtpi);

		do
			{
			$i_kd = nosql($rowtpi['kd']);
			$i_kode = balikin2($rowtpi['kode']);
			$i_nama = balikin2($rowtpi['nama']);
			$i_jabatan = balikin2($rowtpi['jabatan']);
			
			
			echo '<option value="'.$i_kd.'">'.$i_nama.' [NIP.'.$i_kode.']. ['.$i_jabatan.']</option>';
			}
		while ($rowtpi = mysqli_fetch_assoc($qtpi));

		echo '</select>
		</p>

		
		<p>
		<input name="s" type="hidden" value="'.$s.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="page" type="hidden" value="'.$page.'">
		
		
		<a href="'.$filenya.'" class="btn btn-info"><< BATAL</a>
		<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
		</p>
		
		
		</form>';
	
	
	
		?>
			
		
		
		</div>
		
		
	</div>


	<?php
	}
	














else
	{
	//jika null
	if (empty($kunci))
		{
		$sqlcount = "SELECT * FROM user_piket ".
						"ORDER BY tanggal DESC";
		}
		
	else
		{
		$sqlcount = "SELECT * FROM user_piket ".
						"WHERE user_kode LIKE '%$kunci%' ".
						"OR user_nama LIKE '%$kunci%' ".
						"OR user_jabatan LIKE '%$kunci%' ".
						"OR tanggal LIKE '%$kunci%' ".
						"ORDER BY tanggal DESC";
		}
		
		
	
	//query
	$p = new Pager();
	$start = $p->findStart($limit);
	
	$sqlresult = $sqlcount;
	
	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);
	
	
	
	echo '<form action="'.$filenya.'" method="post" name="formxx">
	<p>
	<input name="btnBARU" type="submit" value="ENTRI BARU" class="btn btn-danger">
	<input name="btnEX" type="submit" value="EXPORT" class="btn btn-success">
	</p>
	<br>
	
	</form>



	<form action="'.$filenya.'" method="post" name="formx">
	<p>
	<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
	<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
	<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
	</p>
		
	
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
	
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="20">&nbsp;</td>
	<td width="20">&nbsp;</td>
	<td width="50"><strong><font color="'.$warnatext.'">TANGGAL</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">NIP</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
	<td><strong><font color="'.$warnatext.'">JABATAN</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">LOGIN TERAKHIR</font></strong></td>
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
			$i_kode = balikin($data['user_kode']);
			$i_nama = balikin($data['user_nama']);
			$i_jabatan = balikin($data['user_jabatan']);
			$i_tanggal = balikin($data['tanggal']);
			$i_login = balikin($data['postdate_last_login']);
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
	        </td>
			<td>
			<a href="'.$filenya.'?s=edit&page='.$page.'&kd='.$i_kd.'"><img src="'.$sumber.'/template/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>'.$i_tanggal.'</td>
			<td>'.$i_kode.'</td>
			<td>'.$i_nama.'</td>
			<td>'.$i_jabatan.'</td>
			<td>'.$i_login.'</td>
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
	<br>

	<input name="jml" type="hidden" value="'.$count.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kdx.'">
	<input name="page" type="hidden" value="'.$page.'">
	
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')" class="btn btn-primary">
	<input name="btnBTL" type="reset" value="BATAL" class="btn btn-warning">
	<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-danger">
	</td>
	</tr>
	</table>
	</form>';
	}








//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>