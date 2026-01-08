<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMK_v6.78_(Code:Tekniknih)                     ///////
/////// (Sistem Informasi Sekolah untuk SMK)                    ///////
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
require("../../inc/cek/admsw.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admsw.html");





//nilai
$filenya = "hariini.php";
$judul = "Kelas Hari Ini";
$judulku = "$judul";
$judulx = $judul;
$s = cegah($_REQUEST['s']);






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
?>


  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  
<?php
$tglnya = "$tahun-$bulan-$tanggal";

//pecah
$pecahnya = explode("-", $tglnya);
$p_thn = trim($pecahnya[0]);
$p_bln = trim($pecahnya[1]);
$p_bln2 = $arrbln1[$p_bln];
$p_tgl = trim($pecahnya[2]);

$tanggalnya = "$p_thn-$p_bln-$p_tgl";
$tanggalnya2 = "$p_tgl $p_bln2 $p_thn";


$dayya = date('D', strtotime($tanggalnya));
$dayList = array(
    'Sun' => 'Minggu',
    'Mon' => 'Senin',
    'Tue' => 'Selasa',
    'Wed' => 'Rabu',
    'Thu' => 'Kamis',
    'Fri' => 'Jumat',
    'Sat' => 'Sabtu'
);

$dinone = $dayList[$dayya];



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formxx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Hari, Tanggal : <b>'.$dinone.', '.$tanggalnya2.'</b>  
</td>
</tr>
</table>

</form>
<br>';

echo '<form name="formx" method="post" action="'.$filenya.'">';

//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT * FROM m_waktu_jadwal ".
				"WHERE hari_nama = '$dinone' ".
				"ORDER BY round(hari_no) ASC, ".
				"round(nourut) ASC, ".
				"waktu ASC";
$sqlresult = $sqlcount;

$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysqli_fetch_array($result);




//nek ada
if ($count != 0)
	{
	echo '<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
		<tr valign="top" bgcolor="'.$warnaheader.'">
			<td width="10" align="center"><b>JAM</b></td>
			<td width="120" align="center"><b>WAKTU</b></td>';
			
			//loop kelasnya
			$qjuk = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
												"WHERE kd = '$kd2_session' ".
												"AND tapel LIKE '%$tahun%' ".
												"ORDER BY kelas ASC");
			$rjuk = mysqli_fetch_assoc($qjuk);
			
			do
				{
				//nilai
				$juk_nama = balikin($rjuk['kelas']);
				
				
				echo '<td align="center"><b>'.$juk_nama.'</b>';
				}
			while ($rjuk = mysqli_fetch_assoc($qjuk));
			
			
			
			
		echo '</tr>

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

			$i_kd = nosql($data['kd']);
			$i_hari_no = balikin($data['hari_no']);
			$i_hari_nama = balikin($data['hari_nama']);
			$i_hari = balikin($data['hari_nama']);
			$i_jam = balikin($data['jam_ke']);
			$i_waktu = balikin($data['waktu']);
			$i_ket = balikin($data['ket']);


			//jika istirahat
			if ($i_ket == "ISTIRAHAT")
				{
				$warna = "yellow";
				
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td align="center">'.$i_jam.'.</td>
				<td align="right">'.$i_waktu.'</td>';
				
				//kelas
				$qjuk = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
												"WHERE kd = '$kd2_session' ".
												"AND tapel LIKE '%$tahun%' ".
												"ORDER BY kelas ASC");
				$rjuk = mysqli_fetch_assoc($qjuk);
				$tjuk = mysqli_num_rows($qjuk);

				echo '<td align="center" colspan="'.$tjuk.'"><font color="red"><b>'.$i_ket.'</b></font></td>';
				echo '</tr>';
				
				}
				
			else
				{
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td align="center">'.$i_jam.'.</td>
				<td align="right">'.$i_waktu.'</td>';
				
				//loop kelas
				$qjuk = mysqli_query($koneksi, "SELECT * FROM m_siswa ".
												"WHERE kd = '$kd2_session' ".
												"AND tapel LIKE '%$tahun%' ".
												"ORDER BY kelas ASC");
				$rjuk = mysqli_fetch_assoc($qjuk);
				
				do
					{
					//nilai
					$juk_kd = cegah($rjuk['kd']);
					$juk_nama = cegah($rjuk['kelas']);
					$juk_namax = md5($juk_nama);
					
					
					//nilainya
					$qok = mysqli_query($koneksi, "SELECT * FROM jadwal ".
													"WHERE hari = '$dinone' ".
													"AND jam_ke = '$i_jam' ".
													"AND mapel_kode <> '' ".
													"AND kelas = '$juk_nama' ".
													"ORDER BY tapel DESC, ".
													"smt DESC");
					$rok = mysqli_fetch_assoc($qok);
					$ok_kd = balikin($rok['kd']);
					$ok_mapel_kode = balikin($rok['mapel_kode']);
					$ok_mapel_kode2 = cegah($rok['mapel_kode']);
					$ok_mapel_nama = balikin($rok['mapel_nama']);
					$ok_tapel = cegah($rok['tapel']);
					$ok_kelas = cegah($rok['kelas']);
					$ok_smt = cegah($rok['smt']);
					
					
					
					//ketahui gurunya...
					$qok2 = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
													"WHERE tapel LIKE '%$tahun%' ".
													"AND kelas = '$juk_nama' ".
													"AND kode = '$ok_mapel_kode' ".
													"ORDER BY tapel DESC");
					$rok2 = mysqli_fetch_assoc($qok2);
					$ok_peg_kd = balikin($rok2['pegawai_kd']);
					$ok_peg_kode = balikin($rok2['pegawai_kode']);
					$ok_peg_kode2 = cegah($rok2['pegawai_kode']);
					$ok_peg_nama = balikin($rok2['pegawai_nama']);
					$ok_peg_nama2 = cegah($rok2['pegawai_nama']);
					
					
					
					$qku = mysqli_query($koneksi, "SELECT * FROM rev_guru_agenda ".
													"WHERE pegawai_kd = '$ok_peg_kd' ".
													"AND tapel = '$ok_tapel' ".
													"AND kelas = '$ok_kelas' ".
													"AND smt = '$ok_smt' ".
													"AND mapel_kode = '$ok_mapel_kode2' ".
													"AND tglnya = '$tglnya'");
					$rku = mysqli_fetch_assoc($qku);
					$tku = mysqli_num_rows($qku);
					
					//jika null, entri baru dulu...
					if (empty($tku))
						{
						//pecah tanggal
						$p_tgl = "$tahun-$bulan-$tanggal";
						$tgl1_pecah = balikin($p_tgl);
						$tgl1_pecahku = explode("-", $tgl1_pecah);
						$tgl1_tgl = trim($tgl1_pecahku[2]);
						$tgl1_bln = trim($tgl1_pecahku[1]);
						$tgl1_thn = trim($tgl1_pecahku[0]);
						$tgl_entry = "$tgl1_thn-$tgl1_bln-$tgl1_tgl";
						
					

					
						//ketahui jadwalnya
						$qyuk3 = mysqli_query($koneksi, "SELECT * FROM jadwal ".
															"WHERE kd = '$ok_kd'");
						$ryuk3 = mysqli_fetch_assoc($qyuk3);
						$yuk3_kd = balikin($ryuk3['kd']);
						$yuk3_tapel = cegah($ryuk3['tapel']);
						$yuk3_smt = cegah($ryuk3['smt']);
						$yuk3_kelas = cegah($ryuk3['kelas']);
						$yuk3_jam = cegah($ryuk3['jam_ke']);	
						$yuk3_waktu = balikin($ryuk3['waktu']);
						//$yuk3_jamnya = cegah("$yuk3_jam ($yuk3_waktu)");
						$yuk3_hari = cegah($ryuk3['hari']);
						$yuk3_mapel = cegah($ryuk3['mapel_nama']);
						$yuk3_mapel_kode = cegah($ryuk3['mapel_kode']);
					
					

						//insert
						mysqli_query($koneksi, "INSERT INTO rev_guru_agenda (kd, pegawai_kd, pegawai_kode, pegawai_nama, ".
													"tapel, kelas, smt, ".
													"mapel_kode, mapel_nama, kurikulum, tglnya, ".
													"jamnya, postdate) VALUES ".
													"('$x', '$ok_peg_kd', '$ok_peg_kode2', '$ok_peg_nama2', ".
													"'$yuk3_tapel', '$yuk3_kelas', '$yuk3_smt', ".
													"'$yuk3_mapel_kode', '$yuk3_mapel', 'KUR13', '$tgl_entry', ".
													"'$yuk3_jam', '$today')");
						}


					
					$i_pguru = balikin($rku['wk_presensi']);
					$i_pguru_catatan = balikin($rku['wk_catatan']);
					$i_pguru_postdate = balikin($rku['wk_postdate']);
						

					//jika H
					if ($i_pguru == "H")
						{
						$i_pguru_ket = "<font color=green>Hadir</font>";
						}
					else if ($i_pguru == "I")
						{
						$i_pguru_ket = "<font color=red>Ijin</font>";
						}
					else if ($i_pguru == "S")
						{
						$i_pguru_ket = "<font color=red>Sakit</font>";
						}		
					else if ($i_pguru == "A")
						{
						$i_pguru_ket = "<font color=red>Alpha</font>";
						}	
							



					
					echo '<td align="center">';
					
					//jika ada
					if (!empty($ok_mapel_kode))
						{
						echo '<b>'.$ok_mapel_kode.'</b> ['.$ok_mapel_kode.']
						<br>
						<b>'.$ok_peg_nama.'</b> [NIP.'.$ok_peg_kode.']
						<br>
						[<b>'.$i_pguru_ket.'</b>]
						<br>
						<i>'.$i_pguru_catatan.'</i>
						
						<hr>
						
						<a href="cek.php?jkd='.$ok_kd.'" class="btn btn-danger">CEK RUANG KELAS >></a>';
						}
					
					echo '</td>';
					}
				while ($rjuk = mysqli_fetch_assoc($qjuk));
				
				echo '</tr>';
				}


			}
		while ($data = mysqli_fetch_assoc($result));
		
		
		echo '</tbody>
	</table>
	</div>

	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	<input name="jml" type="hidden" value="'.$count.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kdx.'">
	<input name="page" type="hidden" value="'.$page.'">
	</td>
	</tr>
	</table>
	</form>';
	}

else
	{
	echo '<p>
	<font color="red"><strong>TIDAK ADA DATA.</strong></font>
	</p>';
	}



echo '</form>
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