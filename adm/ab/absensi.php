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
$filenya = "absensi.php";
$judul = "[ABSENSI]. Absensi Harian";
$judulku = "[ABSENSI]. Absensi Harian";
$judulx = $judul;
$kd = nosql($_REQUEST['kd']);
$s = nosql($_REQUEST['s']);
$swkd = cegah($_REQUEST['swkd']);
$swnowa = cegah($_REQUEST['swnowa']);
$kunci = cegah($_REQUEST['kunci']);
$kunci2 = balikin($_REQUEST['kunci']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}
	
	


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
	$e_ket = cegah($_POST['e_ket']);

	
	//nilai
	$e_kode2 = balikin($_POST['e_kode']);
	
	
	//pecah lagi... nama
	$pecahku = explode("NAMA:", $e_kode2);
	$e_kodex1 = trim($pecahku[1]);
	
	$pecahku = explode("NIP/NIS:", $e_kodex1);
	$e_nama = trim($pecahku[0]);
	
	
	$pecahku = explode("NIP/NIS:", $e_kode2);
	$e_kodex1 = trim($pecahku[1]);
	

	$pecahku = explode("JABATAN:", $e_kodex1);
	$e_kode = trim($pecahku[0]);
	

	$pecahku = explode("JABATAN:", $e_kode2);
	$e_jabatan = trim($pecahku[1]);
		
		
		
		
	
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
	$xyz = md5("$tahun:$bulan:$tanggal:$e_kode");
	
	
	//hapus dahulu, sebelum entri
	mysqli_query($koneksi, "DELETE FROM user_absensi WHERE kd = '$xyz'");
	
	//jika ada
	if (!empty($yuk_kd))
		{
		//insert
		mysqli_query($koneksi, "INSERT INTO user_absensi(kd, user_kd, user_kode, ".
									"user_nama, user_jabatan, user_tapel, user_kelas, ".
									"tanggal, postdate, ket) VALUES ".
									"('$xyz', '$yuk_kd', '$e_kode', ".
									"'$yuk_nama', '$yuk_jabatan', '$yuk_tapel', '$yuk_kelas', ".
									"'$today', '$today', '$e_ket')");
		}	
	
	
	
	
					

	//total point nya
	$qyuk = mysqli_query($koneksi, "SELECT kd FROM user_absensi ".
										"WHERE user_kd = '$yuk_kd' ".
										"AND ket = '$e_ket'");
	$ryuk = mysqli_fetch_assoc($qyuk);
	$tyuk_subtotal = mysqli_num_rows($qyuk);
	
	//jika null
	if (empty($tyuk_subtotal))
		{
		$tyuk_subtotal = 0;
		}

	
	
	//jika siswa
	if ($yuk_jabatan == "SISWA")
		{
		//jika sakit
		if ($e_ket == "Sakit")
			{
			//update kan
			mysqli_query($koneksi, "UPDATE m_siswa SET jml_absen_sakit = '$tyuk_subtotal' ".
										"WHERE tapel = '$yuk_tapel' ".
										"AND kode = '$e_kode'");
			}
		
		//jika ijin
		else if ($e_ket == "Ijin")
			{
			//update kan
			mysqli_query($koneksi, "UPDATE m_siswa SET jml_absen_ijin = '$tyuk_subtotal' ".
										"WHERE tapel = '$yuk_tapel' ".
										"AND kode = '$e_kode'");
			}
			
		//jika alpha
		else if ($e_ket == "Alpha")
			{
			//update kan
			mysqli_query($koneksi, "UPDATE m_siswa SET jml_absen_alpha = '$tyuk_subtotal' ".
										"WHERE tapel = '$yuk_tapel' ".
										"AND kode = '$e_kode'");
			}
		
											
	
	
	
	
	
		//detail
		$qyuk = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
											"WHERE tapel = '$yuk_tapel' ".
											"AND kode = '$e_kode'");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$swkd = balikin($ryuk['kd']);
		$swnama = balikin($ryuk['nama']);
		$swnowa = balikin($ryuk['nowa']);
		$swjabatan = "SISWA";
		$yuk_abs_sakit = balikin($ryuk['jml_absen_sakit']);
		$yuk_abs_ijin = balikin($ryuk['jml_absen_ijin']);
		$yuk_abs_alpha = balikin($ryuk['jml_absen_alpha']);
		
		if (empty($yuk_abs_sakit))
			{
			$yuk_abs_sakit = 0;
			}
		
		if (empty($yuk_abs_ijin))
			{
			$yuk_abs_ijin = 0;
			}
			
		if (empty($yuk_abs_alpha))
			{
			$yuk_abs_alpha = 0;
			}
		
		
		$yuk_abs = $yuk_abs_sakit + $yuk_abs_ijin + $yuk_abs_alpha;
		
		
		
		
		//update kan
		mysqli_query($koneksi, "UPDATE m_siswa SET jml_absen = '$yuk_abs' ".
									"WHERE tapel = '$yuk_tapel' ".
									"AND kode = '$e_kode'");
		}


	//jika guru
	else if ($yuk_jabatan == "PEGAWAI")
		{
		//jika sakit
		if ($e_ket == "Sakit")
			{
			//update kan
			mysqli_query($koneksi, "UPDATE m_pegawai SET jml_absen_sakit = '$tyuk_subtotal' ".
										"WHERE kode = '$e_kode'");
			}
		
		//jika ijin
		else if ($e_ket == "Ijin")
			{
			//update kan
			mysqli_query($koneksi, "UPDATE m_pegawai SET jml_absen_ijin = '$tyuk_subtotal' ".
										"WHERE kode = '$e_kode'");
			}
			
		//jika alpha
		else if ($e_ket == "Alpha")
			{
			//update kan
			mysqli_query($koneksi, "UPDATE m_pegawai SET jml_absen_alpha = '$tyuk_subtotal' ".
										"WHERE kode = '$e_kode'");
			}
		
											
	
	
	
	
	
		//detail
		$qyuk = mysqli_query($koneksi, "SELECT * FROM m_pegawai ".
											"WHERE kode = '$e_kode'");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$swkd = balikin($ryuk['kd']);
		$swnama = balikin($ryuk['nama']);
		$swnowa = balikin($ryuk['nowa']);
		$swjabatan = "PEGAWAI";
		$yuk_abs_sakit = balikin($ryuk['jml_absen_sakit']);
		$yuk_abs_ijin = balikin($ryuk['jml_absen_ijin']);
		$yuk_abs_alpha = balikin($ryuk['jml_absen_alpha']);
		$yuk_abs = $yuk_abs_sakit + $yuk_abs_ijin + $yuk_abs_alpha;
		
		
		
		
		//update kan
		mysqli_query($koneksi, "UPDATE m_pegawai SET jml_absen = '$yuk_abs' ".
									"WHERE kode = '$e_kode'");
			
			
		}


	
	

	//re-direct
	$ke = "$filenya?swkd=$yuk_kd&swnowa=$swnowa";
	xloc($ke);
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
  		
	$.noConflict();
    
});
</script>
  
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
	$sqlcount = "SELECT * FROM user_absensi ".
					"ORDER BY postdate DESC";
	}
	
else
	{
	$sqlcount = "SELECT * FROM user_absensi ".
					"WHERE user_kode LIKE '%$kunci%' ".
					"OR user_nama LIKE '%$kunci%' ".
					"OR user_jabatan LIKE '%$kunci%' ".
					"OR user_kelas LIKE '%$kunci%' ".
					"OR user_tapel LIKE '%$kunci%' ".
					"OR tanggal LIKE '%$kunci%' ".
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
KODE/NIP/NIS/NAMA : <input name="e_kode" id="e_kode" type="text" value="'.$e_kode.'" size="30" class="btn btn-warning" required>, 

Keterangan : 
<select name="e_ket" class="btn btn-warning" required>
<option value="" selected></option>
<option value="Sakit">Sakit</option>
<option value="ijin">Ijin</option>
<option value="Alpha">Alpha</option>
</select>

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
<td width="100"><strong><font color="'.$warnatext.'">KET.</font></strong></td>
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
		echo '<td>'.$i_postdate.'</td>
		<td>'.$i_jabatan.'</td>
		<td>'.$i_kode.'</td>
		<td>'.$i_namax.'</td>
		<td>'.$i_ket.'</td>
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





//jika ada
if (!empty($swkd))
	{
	//detail e
	$qyuk = mysqli_query($koneksi, "SELECT * FROM m_user ".
										"WHERE kd = '$swkd' ".
										"ORDER BY tapel DESC");
	$ryuk = mysqli_fetch_assoc($qyuk);
	$yuk_kd = cegah($ryuk['kd']);
	$yuk_nama = cegah($ryuk['nama']);
	$yuk_kode = cegah($ryuk['kode']);
	$yuk_jabatan = cegah($ryuk['jabatan']);
	$yuk_kelas = cegah($ryuk['kelas']);
	$yuk_tapel = cegah($ryuk['tapel']);
	

	$qku = mysqli_query($koneksi, "SELECT * FROM user_absensi ".
									"WHERE user_kd = '$swkd' ".
									"ORDER BY postdate DESC");
	$rku = mysqli_fetch_assoc($qku);
	$ku_ket = balikin($rku['ket']);
	
								
	//jika siswa
	if ($yuk_jabatan == "SISWA")
		{
		//detail
		$qyuk = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
											"WHERE kode = '$yuk_kode' ".
											"ORDER BY tapel DESC");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$swkd = balikin($ryuk['kd']);
		$swkode = balikin($ryuk['kode']);
		$swkelas = balikin($ryuk['kelas']);
		$swnama = balikin($ryuk['nama']);
		$swnowa = balikin($ryuk['nowa']);
		$swjabatan = "SISWA:$swkode. $swkelas";
		}


	//jika guru
	else if ($yuk_jabatan == "PEGAWAI")
		{
		//detail
		$qyuk = mysqli_query($koneksi, "SELECT * FROM m_pegawai ".
											"WHERE kode = '$yuk_kode'");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$swkd = balikin($ryuk['kd']);
		$swkode = balikin($ryuk['kode']);
		$swnama = balikin($ryuk['nama']);
		$swnowa = balikin($ryuk['nowa']);
		$swjabatan = "PEGAWAI:$swkode";
		}



	//kirim wa
	$yuk_nowa = balikin($swnowa);
	$pesannya = "$today
$swnama
$swjabatan
			 
TIDAK HADIR, DIKARENAKAN : 
$ku_ket.
	
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
	
	<?php
	}

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>