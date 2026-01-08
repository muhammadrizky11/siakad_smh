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
$filenya = "guru.php";
$judul = "[USER AKSES]. Data Guru Mapel";
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


//jika edit
if ($s == "edit")
	{
	//nilai
	$kdx = nosql($_REQUEST['kd']);

	//query
	$qx = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
									"WHERE kd = '$kdx'");
	$rowx = mysqli_fetch_assoc($qx);
	$e_tapel = balikin($rowx['tapel']);
	$e_kelas = balikin($rowx['kelas']);
	$e_jenis = balikin($rowx['jenis']);
	$e_no = balikin($rowx['no']);
	$e_kode = balikin($rowx['kode']);
	$e_nama = balikin($rowx['nama']);
	$e_kkm = balikin($rowx['kkm']);
	
	$e_peg_kd = balikin($rowx['pegawai_kd']);
	$e_peg_kode = balikin($rowx['pegawai_kode']);
	$e_peg_nama = balikin($rowx['pegawai_nama']);
	
	
	//jika ada
	if (!empty($e_peg_kd))
		{
		$e_peg_ket = "$e_peg_nama [NIP.$e_peg_kode]";	
		}
	}






//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$e_no = cegah($_POST['e_no']);
	$e_tapel = cegah($_POST['e_tapel']);
	$e_kelas = cegah($_POST['e_kelas']);
	$e_jenis = cegah($_POST['e_jenis']);
	$e_nama = cegah($_POST['e_nama']);
	$e_kode = cegah($_POST['e_kode']);
	$e_kkm = cegah($_POST['e_kkm']);
	$e_pegawai = cegah($_POST['e_pegawai']);


	//query
	$qx = mysqli_query($koneksi, "SELECT * FROM m_pegawai ".
									"WHERE kd = '$e_pegawai'");
	$rowx = mysqli_fetch_assoc($qx);
	$e_peg_kode = cegah($rowx['kode']);
	$e_peg_nama = cegah($rowx['nama']);



	//query
	mysqli_query($koneksi, "UPDATE m_mapel SET pegawai_kd = '$e_pegawai', ".
								"pegawai_kode = '$e_peg_kode', ".
								"pegawai_nama = '$e_peg_nama' ".
								"WHERE kd = '$kd'");

	//diskonek
	xfree($qbw);
	xclose($koneksi);

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
//jika baru/edit
if (($s == "baru") OR ($s == "edit"))
	{
	echo '<form action="'.$filenya.'" method="post" name="formx">
	
	<div class="row">

    	<div class="col-md-2">
	
			<p>
			TaPel :
			<br>
			<b>'.$e_tapel.'</b>
			</p>
			
			
			<p>
			Kelas :
			<br>
			<b>'.$e_kelas.'</b>
			</p>
		</div>
		
		<div class="col-md-3">
			<p>
			Jenis Mapel :
			<br>
			<b>'.$e_jenis.'</b>
			</p>
				
				
			<p>
			Nama Mapel :
			<br>
			<b>'.$e_nama.' ['.$e_kode.']</b>
			</p>
			
		</div>
		
		<div class="col-md-3">
				
			<p>
			Pegawai
			<br>
			<select name="e_pegawai" class="btn btn-warning" required>
			<option value="'.$e_peg_kd.'" selected>'.$e_peg_ket.'</option>';
		
			//data pegawai
			$qpeg = mysqli_query($koneksi, "SELECT * FROM m_pegawai ".
												"ORDER BY nama ASC");
			$rpeg = mysqli_fetch_assoc($qpeg);
		
			do
				{
				$peg_kd = nosql($rpeg['kd']);
				$peg_nip = nosql($rpeg['kode']);
				$peg_nm = balikin($rpeg['nama']);
		
				echo '<option value="'.$peg_kd.'">'.$peg_nm.' [NIP:'.$peg_nip.']</option>';
				}
			while ($rpeg = mysqli_fetch_assoc($qpeg));
		
			echo '</select>
			</p>
				
				
		</div>
			
	</div>
	
	

	<div class="row">
    	<div class="col-md-7">
			<input name="btnSMP" type="submit" value="SIMPAN >>" class="btn btn-block btn-danger">
			
			<a href="'.$filenya.'" class="btn btn-block btn-primary"><< BATAL</a>
			<input name="s" type="hidden" value="'.$s.'">
			<input name="kd" type="hidden" value="'.$kd.'">
		</div>
	</div>';
	}
	
	




else
	{
	//jika null
	if (empty($kunci))
		{
		$sqlcount = "SELECT * FROM m_mapel ".
						"ORDER BY tapel ASC, ".
						"nama ASC";
		}
		
	else
		{
		$sqlcount = "SELECT * FROM m_mapel ".
						"WHERE tapel LIKE '%$kunci%' ".
						"OR kelas LIKE '%$kunci%' ".
						"OR nama LIKE '%$kunci%' ".
						"OR kode LIKE '%$kunci%' ".
						"ORDER BY tapel ASC, ".
						"nama ASC";
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
	<td width="100"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NAMA MAPEL</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
	<td width="300"><strong><font color="'.$warnatext.'">GURU</font></strong></td>
	
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
			$i_kelas = balikin($data['kelas']);
			$i_jenis = balikin($data['jenis']);
			$i_mapel = balikin($data['nama']);
			$i_kkm = balikin($data['kkm']);
			$i_singkatan = balikin($data['kode']);
			$i_nourut = balikin($data['no']);
			$i_postdate = balikin($data['postdate']);
			
			
			$i_peg_kd = balikin($data['pegawai_kd']);
			$i_peg_kode = balikin($data['pegawai_kode']);
			$i_peg_nama = balikin($data['pegawai_nama']);
			
			
						
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i_tapel.'</td>
			<td>'.$i_mapel.' ['.$i_singkatan.']</td>
			<td>'.$i_kelas.'</td>
			<td>
			'.$i_peg_nama.'
			<br>
			NIP.'.$i_peg_kode.'
			<br>
			<a href="'.$filenya.'?s=edit&kd='.$i_kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
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
	}




//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>