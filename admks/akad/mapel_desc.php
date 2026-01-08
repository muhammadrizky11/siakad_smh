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
require("../../inc/cek/admks.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admks.html");





//nilai
$filenya = "mapel_desc.php";
$judul = "[AKADEMIK]. Deskripsi Mapel";
$judulku = $judul;
$judulx = $judul;

$s = nosql($_REQUEST['s']);
$m = nosql($_REQUEST['m']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
$ke = $filenya;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//PROSES ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$kunci = cegah($_POST['kunci']);


	//cek
	if (empty($kunci))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?kunci=$kunci";
		xloc($ke);
		exit();
		}
	}



//batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();




//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/js/swap.js");




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
	$sqlcount = "SELECT * FROM m_mapel_deskripsi ".
					"ORDER BY tapel ASC, ".
					"kelas ASC, ".
					"jenis ASC, ".
					"round(no) ASC";
	}
	
else
	{
	$sqlcount = "SELECT * FROM m_mapel_deskripsi ".
					"WHERE tapel LIKE '%$kunci%' ".
					"OR kelas LIKE '%$kunci%' ".
					"OR jenis LIKE '%$kunci%' ".
					"OR nama LIKE '%$kunci%' ".
					"OR kode LIKE '%$kunci%' ".
					"OR smt1_p_isi LIKE '%$kunci%' ".
					"OR smt1_k_isi LIKE '%$kunci%' ".
					"OR smt2_p_isi LIKE '%$kunci%' ".
					"OR smt2_k_isi LIKE '%$kunci%' ".
					"ORDER BY tapel ASC, ".
					"kelas ASC, ".
					"jenis ASC, ".
					"round(no) ASC";
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



echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
</p>
	

<div class="table-responsive">          
<table class="table" border="1">
<thead>

<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="50"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">JENIS</font></strong></td>
<td width="5"><strong><font color="'.$warnatext.'">NOURUT</font></strong></td>
<td><strong><font color="'.$warnatext.'">NAMA MAPEL</font></strong></td>
<td><strong><font color="'.$warnatext.'">SMT.1 PENGETAHUAN</font></strong></td>
<td><strong><font color="'.$warnatext.'">SMT.1 KETERAMPILAN</font></strong></td>
<td><strong><font color="'.$warnatext.'">SMT.2 PENGETAHUAN</font></strong></td>
<td><strong><font color="'.$warnatext.'">SMT.2 KETERAMPILAN</font></strong></td>	
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
		$i_tapel = balikin($data['tapel']);
		$i_smt = balikin($data['smt']);
		$i_kelas = balikin($data['kelas']);
		$i_jenis = balikin($data['jenis']);
		$i_mapel = balikin($data['nama']);
		$i_singkatan = balikin($data['kode']);
		$i_nourut = balikin($data['no']);
		$i_postdate = balikin($data['postdate']);
		
		$i_smt1_p_isi = balikin($data['smt1_p_isi']);
		$i_smt1_k_isi = balikin($data['smt1_k_isi']);
		
		$i_smt2_p_isi = balikin($data['smt2_p_isi']);
		$i_smt2_k_isi = balikin($data['smt2_k_isi']);
		
					
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_tapel.'</td>
		<td>'.$i_kelas.'</td>
		<td>'.$i_jenis.'</td>
		<td>'.$i_nourut.'</td>
		<td>
		'.$i_mapel.'
		<br>
		Kode:'.$i_singkatan.'
		</td>
		<td>'.$i_smt1_p_isi.'</td>
		<td>'.$i_smt1_k_isi.'</td>
		<td>'.$i_smt2_p_isi.'</td>
		<td>'.$i_smt2_k_isi.'</td>
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


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>