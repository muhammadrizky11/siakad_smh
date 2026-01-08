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
require("../../inc/class/paging.php");
require("../../inc/cek/admbk.php");
$tpl = LoadTpl("../../template/admbk.html");






//nilai
$filenya = "belum.php";
$judul = "Perlu Verifikasi Pelanggaran";
$judulku = "[PELANGGARAN]. $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
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
	
	
	
	
	
//jika hapus
if ($s == "hapusya")
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
	xloc($filenya);
	exit();
	}




	
//jika beri sah
if ($s == "sahya")
	{
	//nilai
	$nis = cegah($_REQUEST['nis']);
	$swkd = cegah($_REQUEST['swkd']);
	$pkd = cegah($_REQUEST['pkd']);

	
	//update
	mysqli_query($koneksi, "UPDATE siswa_pelanggaran SET sahya = 'true', ".
								"sahya_tgl = '$today' ".
								"WHERE siswa_kd = '$swkd' ".
								"AND siswa_nis = '$nis' ".
								"AND kd = '$pkd'");


	//re-direct
	xloc($filenya);
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


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$p = new Pager();
$limit = 1000;
$start = $p->findStart($limit);

//jika null
if (empty($kunci))
	{
	$sqlcount = "SELECT * FROM siswa_pelanggaran ".
					"WHERE sahya = 'false' ".
					"ORDER BY tgl DESC";
	}
	
else
	{
	$sqlcount = "SELECT * FROM siswa_pelanggaran ".
					"WHERE sahya = 'false' ".
					"AND (kelas_nama LIKE '%$kunci%' ".
					"OR siswa_nis LIKE '%$kunci%' ".
					"OR siswa_nama LIKE '%$kunci%' ".
					"OR jenis_nama LIKE '%$kunci%' ".
					"OR point_nama LIKE '%$kunci%' ".
					"OR point_nilai LIKE '%$kunci%' ".
					"OR point_sanksi LIKE '%$kunci%' ".
					"OR piket_kode LIKE '%$kunci%' ".
					"OR piket_nama LIKE '%$kunci%' ".
					"OR piket_jabatan LIKE '%$kunci%') ".
					"ORDER BY tgl DESC";
	}
	
	
$sqlresult = $sqlcount;

$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysqli_fetch_array($result);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
</p>
</form>


<div class="table-responsive">          
<table class="table" border="1">
<thead>

<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="50"><strong><font color="'.$warnatext.'">TANGGAL</font></strong></td>
<td width="140"><strong><font color="'.$warnatext.'">PETUGAS PIKET</font></strong></td>
<td><strong><font color="'.$warnatext.'">SISWA</font></strong></td>
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
		$i_swkd = balikin($data['siswa_kd']);
		$i_swnis = balikin($data['siswa_nis']);
		$i_swnama = balikin($data['siswa_nama']);
		$i_kelas = balikin($data['kelas_nama']);
		$i_tgl = balikin($data['tgl']);
		$i_jenis = balikin($data['jenis_nama']);
		$i_nama = balikin($data['point_nama']);
		$i_nilai = balikin($data['point_nilai']);
		$i_sanksi = balikin($data['point_sanksi']);
		$i_pikd = balikin($data['piket_kd']);
		$i_pikode = balikin($data['piket_kode']);
		$i_pinama = balikin($data['piket_nama']);
		$i_pijabatan = balikin($data['piket_jabatan']);

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_tgl.'</td>
		<td>
		'.$i_pinama.'
		<br>
		NIP.'.$i_pikode.'
		<br>
		Jabatan:'.$i_pijabatan.'
		
		</td>
		<td>
		'.$i_swnama.'
		<br>
		NIS:'.$i_swnis.'
		<br>
		Kelas:'.$i_kelas.'
		</td>
		<td>'.$i_jenis.'</td>
		<td>
		'.$i_nama.'
		
		<br>
		<br>
		<a href="'.$filenya.'?s=hapusya&pkd='.$i_kd.'&swkd='.$i_swkd.'&nis='.$i_swnis.'" class="btn btn-danger">HAPUS >></a>

		<a href="'.$filenya.'?s=sahya&pkd='.$i_kd.'&swkd='.$i_swkd.'&nis='.$i_swnis.'" class="btn btn-success">BERI VERIFIKASI >></a>
		</td>
		<td align="right">'.$i_nilai.'</td>
		<td>'.$i_sanksi.'</td>
        </tr>';
		}
	while ($data = mysqli_fetch_assoc($result));
	}


echo '</tbody>
  </table>
  </div>
<font color="red">'.$count.'</font> Data. '.$pagelist.'
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