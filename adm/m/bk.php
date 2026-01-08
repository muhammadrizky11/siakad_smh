<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMP_v6.78_(Code:Tekniknih)                     ///////
/////// (Sistem Informasi Sekolah untuk SMP)                    ///////
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
$tpl = LoadTpl("../../template/adm.html");






//nilai
$filenya = "bk.php";
$judul = "Guru BK";
$judulku = "[USER AKSES]. $judul";
$judulx = $judul;
$ke = $filenya;






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}


//jika hapus
if ($_POST['btnHPS'])
	{
	$jml = nosql($_POST['jml']);



	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kdix = nosql($_POST["$yuhu"]);

		//del
		mysqli_query($koneksi, "DELETE FROM m_gurubk ".
				"WHERE kd = '$kdix'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($ke);
	exit();
	}


//jika simpan
if ($_POST['btnTBH'])
	{
	//nilai
	$pegawai = nosql($_POST['pegawai']);

		
		
	//terpilih
	$qtpx = mysqli_query($koneksi, "SELECT * FROM m_pegawai ".
										"WHERE kd = '$pegawai'");
	$rowtpx = mysqli_fetch_assoc($qtpx);
	$peg_nip = cegah($rowtpx['kode']);
	$peg_nama = cegah($rowtpx['nama']);
		
		
		
		
		

	//nek nul
	if (empty($pegawai))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//query
		mysqli_query($koneksi, "INSERT INTO m_gurubk(kd, peg_kd, ".
									"peg_kode, peg_nama, postdate) VALUES ".
									"('$x', '$pegawai', ".
									"'$peg_nip', '$peg_nama', '$today')");

		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
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
require("../../inc/js/number.js");
require("../../inc/js/checkall.js");
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
echo '<form name="formx" method="post" action="'.$filenya.'">';

//query
$q = mysqli_query($koneksi, "SELECT * FROM m_gurubk");
$row = mysqli_fetch_assoc($q);
$total = mysqli_num_rows($q);


//penambahan
echo '<select name="pegawai" class="btn btn-warning">
<option value="" selected>-Pegawai-</option>';

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

<input name="btnTBH" type="submit" value="SIMPAN >>" class="btn btn-danger">';

//detail
echo '<div class="table-responsive">          
<table class="table" border="1">
<thead>

<tr bgcolor="'.$warnaheader.'">
<td width="1">&nbsp;</td>
<td width="100"><strong><font color="'.$warnatext.'">NIP</font></strong></td>
<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
</tr>
</thead>
<tbody>';

//nek ada
if ($total != 0)
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


		//nilai
		$i_nomer = $i_nomer + 1;
		$i_kd = nosql($row['kd']);
		$i_nip = nosql($row['peg_kode']);
		$i_nama = balikin($row['peg_nama']);


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td><input name="kd'.$i_nomer.'" type="hidden" value="'.$i_kd.'">
		<input type="checkbox" name="item'.$i_nomer.'" value="'.$i_kd.'">
        </td>
		<td>'.$i_nip.'</td>
		<td>'.$i_nama.'</td>
		</tr>';
		}
	while ($row = mysqli_fetch_assoc($q));
	}

echo '</tbody>
</table>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
<strong><font color="#FF0000">'.$total.'</font></strong> Data. '.$pagelist.'
<br>
<br>

<input name="jml" type="hidden" value="'.$limit.'">
<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')" class="btn btn-success">
<input name="btnBTL" type="reset" value="BATAL" class="btn btn-primary">
<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-danger">
</td>
</tr>
</table>


</form>
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