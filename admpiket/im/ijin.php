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
require("../../inc/class/paging.php");
require("../../inc/cek/admpiket.php");
$tpl = LoadTpl("../../template/admpiket.html");





//nilai
$filenya = "ijin.php";
$judul = "[IJIN MASUK PULANG]. Entri Ijin";
$judulku = "[IJIN MASUK PULANG]. Entri Ijin";
$judulx = $judul;
$ikd = nosql($_REQUEST['ikd']);
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
//jika hapus daftar seorang siswa.
if ($s == "hapus")
	{
	//hapus
	mysqli_query($koneksi, "DELETE FROM user_ijin ".
								"WHERE kd = '$ikd'");


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






//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$e_kode = cegah($_POST['e_kode']);
	$e_status = cegah($_POST['e_status']);
	$e_ket = cegah($_POST['e_ket']);

	
	
	//detail e
	$qyuk = mysqli_query($koneksi, "SELECT * FROM m_user ".
										"WHERE kode = '$e_kode' ".
										"ORDER BY tapel DESC");
	$ryuk = mysqli_fetch_assoc($qyuk);
	$yuk_kd = cegah($ryuk['kd']);
	$yuk_nama = cegah($ryuk['nama']);
	$yuk_jabatan = cegah($ryuk['jabatan']);
	$yuk_kelas = cegah($ryuk['kelas']);
	$yuk_tapel = cegah($ryuk['tapel']);
	
	
	
	

	
							
	//kd
	$xyz = md5("$tahun:$bulan:$tanggal:$e_kode:$e_status");
	
	
	//jika ada
	if (!empty($yuk_kd))
		{
		//insert
		mysqli_query($koneksi, "INSERT INTO user_ijin(kd, user_kd, user_kode, ".
									"user_nama, user_jabatan, user_tapel, user_kelas, ".
									"tanggal, postdate, status, ket) VALUES ".
									"('$xyz', '$yuk_kd', '$e_kode', ".
									"'$yuk_nama', '$yuk_jabatan', '$yuk_tapel', '$yuk_kelas', ".
									"'$today', '$today', '$e_status', '$e_ket')");
		}	
	
	
	
	

	//total point nya
	$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
										"WHERE user_kd = '$yuk_kd' ".
										"AND status = '$e_status'");
	$ryuk = mysqli_fetch_assoc($qyuk);
	$tyuk_subtotal = mysqli_num_rows($qyuk);

	
	
	//jika siswa
	if ($yuk_jabatan == "SISWA")
		{
		//jika masuk
		if ($e_status == "IJIN MASUK")
			{
			//update kan
			mysqli_query($koneksi, "UPDATE m_siswa SET jml_ijin_masuk = '$tyuk_subtotal' ".
										"WHERE tapel = '$yuk_tapel' ".
										"AND kode = '$e_kode'");
			}
		
		//jika pulang
		else if ($e_status == "IJIN PULANG")
			{
			//update kan
			mysqli_query($koneksi, "UPDATE m_siswa SET jml_ijin_pulang = '$tyuk_subtotal' ".
										"WHERE tapel = '$yuk_tapel' ".
										"AND kode = '$e_kode'");
			}
			
	
	
	
		//total point nya
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
											"WHERE user_kd = '$yuk_kd'");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$tyuk_subtotal = mysqli_num_rows($qyuk);
	
	
		
		//update kan
		mysqli_query($koneksi, "UPDATE m_siswa SET jml_ijin = '$tyuk_subtotal' ".
									"WHERE tapel = '$yuk_tapel' ".
									"AND kode = '$e_kode'");
		}
	
	//jika guru
	else if ($yuk_jabatan == "GURU")
		{
		//jika masuk
		if ($e_status == "IJIN MASUK")
			{
			//update kan
			mysqli_query($koneksi, "UPDATE m_guru SET jml_ijin_masuk = '$tyuk_subtotal' ".
										"WHERE kode = '$e_kode'");
			}
		
		//jika pulang
		else if ($e_status == "IJIN PULANG")
			{
			//update kan
			mysqli_query($koneksi, "UPDATE m_guru SET jml_ijin_pulang = '$tyuk_subtotal' ".
										"WHERE kode = '$e_kode'");
			}
			
	
	
	
		//total point nya
		$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_ijin ".
											"WHERE user_kd = '$yuk_kd'");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$tyuk_subtotal = mysqli_num_rows($qyuk);
	
	
		
		//update kan
		mysqli_query($koneksi, "UPDATE m_guru SET jml_ijin = '$tyuk_subtotal' ".
									"WHERE kode = '$e_kode'");
		}
		
		
			
		
		
			
	
	

	//re-direct
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
//jika null
if (empty($kunci))
	{
	$sqlcount = "SELECT * FROM user_ijin ".
					"ORDER BY postdate DESC";
	}
	
else
	{
	$sqlcount = "SELECT * FROM user_ijin ".
					"WHERE user_kode LIKE '%$kunci%' ".
					"OR user_nama LIKE '%$kunci%' ".
					"OR user_jabatan LIKE '%$kunci%' ".
					"OR user_kelas LIKE '%$kunci%' ".
					"OR user_tapel LIKE '%$kunci%' ".
					"OR tanggal LIKE '%$kunci%' ".
					"OR status LIKE '%$kunci%' ".
					"OR ket LIKE '%$kunci%' ".
					"ORDER BY postdate DESC";
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
KODE/NIS/NIP : <input name="e_kode" type="text" value="'.$e_kode.'" size="10" class="btn btn-warning" required>, 

IJIN :
<select name="e_status" class="btn btn-warning" required>
<option value="" selected></option>
<option value="IJIN MASUK">MASUK</option>
<option value="IJIN PULANG">PULANG</option>
</select>, 

Keterangan :
<input name="e_ket" type="text" value="'.$e_ket.'" size="20" class="btn btn-warning" required>


<input name="btnSMP" type="submit" value="SIMPAN >>" class="btn btn-danger">
</p>
<hr>

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
<td width="50"><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">JABATAN</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">KODE</font></strong></td>
<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
<td width="250"><strong><font color="'.$warnatext.'">IJIN</font></strong></td>
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
		$i_postdate = balikin($data['postdate']);
		$i_jabatan = balikin($data['user_jabatan']);
		$i_kode = balikin($data['user_kode']);
		$i_nama = balikin($data['user_nama']);
		$i_kelas = balikin($data['user_kelas']);
		$i_tapel = balikin($data['user_tapel']);
		$i_status = balikin($data['status']);
		$i_ket = balikin($data['ket']);

		
		//jika SISWA
		if ($i_jabatan == "SISWA")
			{
			$i_namax = "$i_nama <br> $i_kelas";
			}
			
		else
			{
			$i_namax = "$i_nama";
			}	
		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		'.$i_postdate.'
		<br>
		<a href="'.$filenya.'?s=hapus&ikd='.$i_kd.'" class="btn btn-block btn-danger">HAPUS >></a>
		<br>
		
		<a href="ijin_qrcode.php?ikd='.$i_kd.'" class="btn btn-block btn-success" target="_blank">CETAK PDF >></a>
		</td>
		<td>'.$i_jabatan.'</td>
		<td>'.$i_kode.'</td>
		<td>'.$i_namax.'</td>
		<td>
		'.$i_status.'
		<br>
		<i>'.$i_ket.'</i>
		</td>
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
</td>
</tr>
</table>
</form>';








//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>