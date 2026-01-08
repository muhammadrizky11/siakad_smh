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
$filenya = "catatan.php";
$judul = "[PIKET HARIAN]. Catatan Kejadian";
$judulku = "[PIKET HARIAN]. Catatan Kejadian";
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
//jika simpan
if ($_POST['btnSMP'])
	{
	$e_isi = cegah($_POST['e_isi']);
	$tglnya = "$tahun-$bulan-$tanggal";


	//query
	mysqli_query($koneksi, "UPDATE user_piket SET catatan = '$e_isi', ".
								"catatan_postdate = '$today' ".
								"WHERE tanggal = '$tglnya' ".
								"AND user_kd = '$kd71_session'");


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
					"OR catatan LIKE '%$kunci%' ".
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



echo '<form action="'.$filenya.'" method="post" name="formx2">
<div class="row">

	<div class="col-md-5">

		<div class="card card-warning">
			<div class="card-header">
				<h3 class="card-title">Catatan Kejadian Hari ini :</h3>
		
		        <div class="card-tools">
		          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
		          </button>
		        </div>
		    </div>
		        
		    <div class="card-body">
		
		    	<p>		
				<textarea cols="52" id="e_isi" name="e_isi" rows="5" wrap="yes" class="btn-warning" required></textarea>
				</p>
				
				
				<p>
				<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-block btn-danger">
				</p>
			</div>
		</div>
	</div>
</div>

</form>

<hr>
		
		
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
<td width="50"><strong><font color="'.$warnatext.'">TANGGAL</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">NIP</font></strong></td>
<td width="200"><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
<td width="150"><strong><font color="'.$warnatext.'">JABATAN</font></strong></td>
<td><strong><font color="'.$warnatext.'">CATATAN KEJADIAN</font></strong></td>
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
		$i_ket = balikin($data['catatan']);
		$i_ket_postdate = balikin($data['catatan_postdate']);
		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_tanggal.'</td>
		<td>'.$i_kode.'</td>
		<td>'.$i_nama.'</td>
		<td>'.$i_jabatan.'</td>
		<td>
		'.$i_ket.'
		<hr>
		<i>Postdate Update : '.$i_ket_postdate.'</i>
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