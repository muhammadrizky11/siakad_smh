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
require("../../inc/cek/admbdh.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admbdh.html");








//nilai
$filenya = "tunggakan_wa.php";
$judul = "[KEUANGAN SISWA] Kirim WA Tunggakan Siswa";
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
//entri tunggakan ////////////////////////////////////////////////////
$qjuk = mysqli_query($koneksi, "SELECT * FROM m_keu_siswa ".
									"ORDER BY tapel DESC, ".
									"smt ASC, ".
									"thn DESC, ".
									"round(bln) ASC, ".
									"kelas ASC, ".
									"nama ASC");
$rjuk = mysqli_fetch_assoc($qjuk);


do
	{
	//nilai
	$e_kd = cegah($rjuk['kd']);
	$e_tapel = cegah($rjuk['tapel']);
	$e_smt = cegah($rjuk['smt']);
	$e_kelas = cegah($rjuk['kelas']);
	$e_tahun = cegah($rjuk['thn']);
	$e_bulan = cegah($rjuk['bln']);
	$e_nama = cegah($rjuk['nama']);
	$e_nominal = cegah($rjuk['nominal']);

		
	
	
	//list siswa
	$qyuk = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
										"WHERE tapel = '$e_tapel' ".
										"AND kelas = '$e_kelas' ".
										"ORDER BY kode ASC");
	$ryuk = mysqli_fetch_assoc($qyuk);
	
	do
		{
		//nilai
		$swkd = cegah($ryuk['kd']);
		$swnis = cegah($ryuk['kode']);
		$swnama = cegah($ryuk['nama']);
		$swtapel = cegah($ryuk['tapel']);
		$swkelas = cegah($ryuk['kelas']);
		
		
		$xyz = md5("$swnis$e_tapel$e_smt$e_kelas$e_tahun$e_bulan$e_nama");
	
	
	
		
		//insert
		mysqli_query($koneksi, "INSERT INTO siswa_bayar_tagihan(kd, item_tapel, item_smt, ".
									"item_kelas, item_thn, item_bln, ".
									"item_kd, item_nama, item_nominal, ".
									"nominal_bayar, nominal_kurang, ".
									"siswa_kd, siswa_kode, siswa_nama, ".
									"siswa_tapel, siswa_kelas, postdate) VALUES ".
									"('$xyz', '$e_tapel', '$e_smt', ".
									"'$e_kelas', '$e_tahun', '$e_bulan', ".
									"'$e_kd', '$e_nama', '$e_nominal', ".
									"'0', '$e_nominal', ".
									"'$swkd', '$swnis', '$swnama', ".
									"'$swtapel', '$swkelas', '$today')");
		}
	while ($ryuk = mysqli_fetch_assoc($qyuk));	
	
	}
while ($rjuk = mysqli_fetch_assoc($qjuk));
//entri tunggakan ////////////////////////////////////////////////////















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


//query
$limit = 100;
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT DISTINCT(siswa_kode) AS swnis ".
				"FROM siswa_bayar_tagihan ".
				"WHERE nominal_kurang > 0 ".
				"ORDER BY item_kelas ASC, ".
				"siswa_nama ASC";
$sqlresult = $sqlcount;

$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
$target = "$filenya?kunci=$kunci";
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysqli_fetch_array($result);




echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">


Per Tanggal : <b>'.$tanggal.' '.$arrbln[$bulan].' '.$tahun.'</b>';
?>



<script language='javascript'>
//membuat document jquery
$(document).ready(function(){

	setInterval(poll,3000);
	
	function poll()
		{
		$.ajax({
			url: "<?php echo $sumber;?>/adm/keu/i_proses_wa.php",
			type:$(this).attr("method"),
			data:$(this).serialize(),
			success:function(data){					
				$("#jawabanku").html(data);
				}
			});
		}





$.ajax({
	url: "<?php echo $sumber;?>/adm/keu/i_proses_wa.php",
	type:$(this).attr("method"),
	data:$(this).serialize(),
	success:function(data){					
		$("#jawabanku").html(data);
		}
	});


	
		
});

</script>
    
          
<?php
echo '<div id="jawabanku"></div>

<div class="table-responsive">          
	  <table class="table" border="1">
	    <thead>
			
			<tr bgcolor="'.$warnaheader.'">
			<td width="50" align="center"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
			<td width="50" align="center"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
			<td width="200" align="center"><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
			<td width="100" align="center"><strong><font color="'.$warnatext.'">NO.WA</font></strong></td>
			<td align="left"><strong><font color="'.$warnatext.'">TOTAL TAGIHAN</font></strong></td>
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
		$e_swnis = balikin($data['swnis']);
		
		
		//detail e
		$qku = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
										"WHERE kode = '$e_swnis'");
		$rku = mysqli_fetch_assoc($qku);
		$e_swnama = balikin($rku['nama']);
		$e_swnama2 = cegah($rku['nama']);
		$e_kelas = balikin($rku['kelas']);
		$e_kelas2 = cegah($rku['kelas']);
		$e_nowa = balikin($rku['nowa']);

		
		
		//data ne
		$qcob = mysqli_query($koneksi, "SELECT SUM(nominal_kurang) AS totalnya ".
										"FROM siswa_bayar_tagihan ".
										"WHERE siswa_kode = '$e_swnis'");
		$rcob = mysqli_fetch_assoc($qcob);
		$tcob = mysqli_num_rows($qcob);
		$cob_kurang = balikin($rcob['totalnya']);
		
		
		//yg ada nowa saja
		if (!empty($e_nowa))
			{
			//masukin ke database kirim wa
			$xyz = md5("$tahun$bulan$tanggal$e_swnis");
			
			mysqli_query($koneksi, "INSERT INTO wa_tagihan_siswa(kd, kelas, siswa_nis, siswa_nama, ".
									"siswa_nowa, terkirim, nominal, postdate) VALUES ".
									"('$xyz', '$e_kelas2', '$e_swnis', '$e_swnama2', ".
									"'$e_nowa', 'false', '$cob_kurang', '$today')");
			}		
		

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td align="center">'.$e_kelas.'</td>
		<td align="left">'.$e_swnis.'</td>
		<td align="left">'.$e_swnama.'</td>
		<td align="left">+62'.$e_nowa.'</td>
		<td align="left">'.xduit3($cob_kurang).'</td>
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
<br>
</td>
</tr>
</table>';



echo '</form>';

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