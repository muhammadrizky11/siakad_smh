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
require("../../inc/cek/adminv.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/adminv.html");



//nilai
$filenya = "lap_rekap.php";
$judul = "Per REKAPITULASI BUKU INVENTARIS";
$judul = "[DATA]. Per REKAPITULASI BUKU INVENTARIS";
$judulku = "$judul";
$judulx = $judul;














//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika export
if ($_POST['btnEX'])
	{
	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');


	//nama file e...
	$i_filename = "per_rekap_buku_inventaris.xls";
	$i_judul = "per_rekap";
	



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
	$worksheet1->write_string(0,1,"KODE_GOLONGAN");
	$worksheet1->write_string(0,2,"KODE_BIDANG");
	$worksheet1->write_string(0,3,"NAMA_BIDANG_DAN_BARANG");
	$worksheet1->write_string(0,4,"JUMLAH_BARANG");
	$worksheet1->write_string(0,5,"JUMLAH_HARGA");
	$worksheet1->write_string(0,6,"KETERANGAN");

	//data
	$qdt = mysqli_query($koneksi, "SELECT * FROM m_kib_jenis ".
									"ORDER BY round(nourut) ASC");
	$rdt = mysqli_fetch_assoc($qdt);

	do
		{
		//nilai
		$dt_nox = $dt_nox + 1;
		$i_nourut = balikin($rdt['nourut']);
		$i_nama = balikin($rdt['nama']);

		
		//list bidang
		$qyuk = mysqli_query($koneksi, "SELECT DISTINCT(bidang) AS bidku ".
											"FROM m_kib_kode ".
											"WHERE golongan = '$i_nourut' ".
											"AND bidang <> '*' ".
											"ORDER BY round(bidang) ASC");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$tyuk = mysqli_num_rows($qyuk);
		
		
		
		do
			{
			//nilai
			$j_no = $j_no + 1;
			$j_bidang = balikin($ryuk['bidku']);
			$dt_nox2 = $j_no;


			//namanya
			$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_kib_kode ".
											"WHERE bidang = '$j_bidang'");
			$ryuk2 = mysqli_fetch_assoc($qyuk2);
			$j_nama = balikin($ryuk2['nama']);
			
			
				
			//hitung jumlahnya
			//jika kib-a
			if ($i_nourut == "01")
				{
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT kd, ket FROM inv_kib_a ".
													"WHERE sekolah_kd = '$sekkd83_session'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$tyuk21 = mysqli_num_rows($qyuk21);
				$j_ket = balikin($ryuk21['ket']);
				$j_jumlah = $tyuk21;
				
				
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
													"FROM inv_kib_a ".
													"WHERE sekolah_kd = '$sekkd83_session'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_harga = balikin($ryuk21['harganya']);
				}
	
			
			//jika kib-b
			else if ($i_nourut == "02")
				{
				//nilai
				$kodeku = "$i_nourut.$j_bidang";
				
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlahnya ".
													"FROM inv_kib_b ".
													"WHERE sekolah_kd = '$sekkd83_session' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_jumlah = balikin($ryuk21['jumlahnya']);
				
				
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
													"FROM inv_kib_b ".
													"WHERE sekolah_kd = '$sekkd83_session' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_harga = balikin($ryuk21['harganya']);
				
				//ket 
				$qyuk21 = mysqli_query($koneksi, "SELECT ket FROM inv_kib_b ".
													"WHERE sekolah_kd = '$sekkd83_session' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_ket = balikin($ryuk21['ket']);
				}
	
				
				
			//jika kib-c
			else if ($i_nourut == "03")
				{
				//nilai
				$kodeku = "$i_nourut.$j_bidang";
				
				
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT kd, ket FROM inv_kib_c ".
													"WHERE sekolah_kd = '$sekkd83_session' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$tyuk21 = mysqli_num_rows($qyuk21);
				$j_ket = balikin($ryuk21['ket']);
				$j_jumlah = $tyuk21;
				
				
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
													"FROM inv_kib_c ".
													"WHERE sekolah_kd = '$sekkd83_session' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_harga = balikin($ryuk21['harganya']);
				}
	
				
	
	
			//jika kib-d
			else if ($i_nourut == "04")
				{
				//nilai
				$kodeku = "$i_nourut.$j_bidang";
				
				
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT kd, ket FROM inv_kib_d ".
													"WHERE sekolah_kd = '$sekkd83_session' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$tyuk21 = mysqli_num_rows($qyuk21);
				$j_ket = balikin($ryuk21['ket']);
				$j_jumlah = $tyuk21;
				
				
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
													"FROM inv_kib_d ".
													"WHERE sekolah_kd = '$sekkd83_session' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_harga = balikin($ryuk21['harganya']);
				}
	
	
	
	
	
	
	
			//jika kib-e
			else if ($i_nourut == "05")
				{
				//nilai
				$kodeku = "$i_nourut.$j_bidang";
				
				
				//jika buku
				if ($j_bidang == "17")
					{
					//jumlah 
					$qyuk21 = mysqli_query($koneksi, "SELECT kd, ket FROM inv_kib_e ".
														"WHERE sekolah_kd = '$sekkd83_session' ".
														"AND buku_judul <> '' ".
														"AND barang_kode LIKE '$kodeku%'");
					$ryuk21 = mysqli_fetch_assoc($qyuk21);
					$j_ket = balikin($ryuk21['ket']);
					
					
					//jumlah 
					$qyuk21 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlahnya ".
														"FROM inv_kib_e ".
														"WHERE sekolah_kd = '$sekkd83_session' ".
														"AND buku_judul <> '' ".
														"AND barang_kode LIKE '$kodeku%'");
					$ryuk21 = mysqli_fetch_assoc($qyuk21);
					$j_jumlah = balikin($ryuk21['jumlahnya']);
					
					
					//jumlah 
					$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
														"FROM inv_kib_e ".
														"WHERE sekolah_kd = '$sekkd83_session' ".
														"AND buku_judul <> '' ".
														"AND barang_kode LIKE '$kodeku%'");
					$ryuk21 = mysqli_fetch_assoc($qyuk21);
					$j_harga = balikin($ryuk21['harganya']);
					}
					
					
					
				//jika corak
				else if ($j_bidang == "18")
					{
					//jumlah 
					$qyuk21 = mysqli_query($koneksi, "SELECT kd, ket FROM inv_kib_e ".
														"WHERE sekolah_kd = '$sekkd83_session' ".
														"AND corak_asal <> '' ".
														"AND barang_kode LIKE '$kodeku%'");
					$ryuk21 = mysqli_fetch_assoc($qyuk21);
					$j_ket = balikin($ryuk21['ket']);
					
					
					//jumlah 
					$qyuk21 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlahnya ".
														"FROM inv_kib_e ".
														"WHERE sekolah_kd = '$sekkd83_session' ".
														"AND corak_asal <> '' ".
														"AND barang_kode LIKE '$kodeku%'");
					$ryuk21 = mysqli_fetch_assoc($qyuk21);
					$j_jumlah = balikin($ryuk21['jumlahnya']);
					
					
					//jumlah 
					$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
														"FROM inv_kib_e ".
														"WHERE sekolah_kd = '$sekkd83_session' ".
														"AND corak_asal <> '' ".
														"AND barang_kode LIKE '$kodeku%'");
					$ryuk21 = mysqli_fetch_assoc($qyuk21);
					$j_harga = balikin($ryuk21['harganya']);
	
					}
					
					
				//jika hewan
				else if ($j_bidang == "19")
					{
					//jumlah 
					$qyuk21 = mysqli_query($koneksi, "SELECT kd, ket FROM inv_kib_e ".
														"WHERE sekolah_kd = '$sekkd83_session' ".
														"AND hewan_jenis <> '' ".
														"AND barang_kode LIKE '$kodeku%'");
					$ryuk21 = mysqli_fetch_assoc($qyuk21);
					$j_ket = balikin($ryuk21['ket']);
					
					
					//jumlah 
					$qyuk21 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlahnya ".
														"FROM inv_kib_e ".
														"WHERE sekolah_kd = '$sekkd83_session' ".
														"AND hewan_jenis <> '' ".
														"AND barang_kode LIKE '$kodeku%'");
					$ryuk21 = mysqli_fetch_assoc($qyuk21);
					$j_jumlah = balikin($ryuk21['jumlahnya']);
					
					
					//jumlah 
					$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
														"FROM inv_kib_e ".
														"WHERE sekolah_kd = '$sekkd83_session' ".
														"AND hewan_jenis <> '' ".
														"AND barang_kode LIKE '$kodeku%'");
					$ryuk21 = mysqli_fetch_assoc($qyuk21);
					$j_harga = balikin($ryuk21['harganya']);
					}
				}
	
	
	
			//jika kib-f
			else if ($i_nourut == "06")
				{
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT kd, ket FROM inv_kib_f ".
													"WHERE sekolah_kd = '$sekkd83_session'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$tyuk21 = mysqli_num_rows($qyuk21);
				$j_ket = balikin($ryuk21['ket']);
				$j_jumlah = $tyuk21;
				
				
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
													"FROM inv_kib_f ".
													"WHERE sekolah_kd = '$sekkd83_session'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_harga = balikin($ryuk21['harganya']);
				}
	
	
				
			else
				{
				$j_jumlah = "0";
				$j_harga = "0";
				$j_ket = "-";
				}
	


			//ciptakan
			$worksheet1->write_string($dt_nox2,0,$dt_nox2);
			$worksheet1->write_string($dt_nox2,1,$i_nourut);
			$worksheet1->write_string($dt_nox2,2,$j_bidang);
			$worksheet1->write_string($dt_nox2,3,"$i_nama. $j_nama");
			$worksheet1->write_string($dt_nox2,4,$j_jumlah);
			$worksheet1->write_string($dt_nox2,5,$j_harga);
			$worksheet1->write_string($dt_nox2,6,$j_ket);

			}
		while ($ryuk = mysqli_fetch_assoc($qyuk));
		
		
		}
	while ($rdt = mysqli_fetch_assoc($qdt));





	//close
	$workbook->close();

	
	
	//re-direct
	xloc($filenya);
	exit();
	}













//isi *START
ob_start();


//require
require("../../template/js/jumpmenu.js");
require("../../template/js/checkall.js");
require("../../template/js/swap.js");





$warnatext = "white";

echo '<form action="'.$filenya.'" method="post" name="formx">

<input name="btnEX" type="submit" value="EXPORT EXCEL" class="btn btn-success">

<div class="table-responsive">          
<table class="table" border="1">
<thead>

<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="50" align="center"><strong><font color="'.$warnatext.'">NO</font></strong></td>
<td width="50" align="center"><strong><font color="'.$warnatext.'">KODE GOLONGAN</font></strong></td>
<td width="50" align="center"><strong><font color="'.$warnatext.'">KODE BIDANG</font></strong></td>
<td align="center"><strong><font color="'.$warnatext.'">NAMA_BIDANG DAN BARANG</font></strong></td>
<td align="center"><strong><font color="'.$warnatext.'">JUMLAH BARANG</font></strong></td>
<td align="center"><strong><font color="'.$warnatext.'">JUMLAH HARGA(RP)</font></strong></td>
<td align="center"><strong><font color="'.$warnatext.'">KETERANGAN</font></strong></td>
</tr>
</thead>
<tbody>';

//list
$qku2 = mysqli_query($koneksi, "SELECT * FROM m_kib_jenis ".
									"ORDER BY round(nourut) ASC");
$rku2 = mysqli_fetch_assoc($qku2);
		
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
	$i_kd = nosql($rku2['kd']);
	$i_nourut = nosql($rku2['nourut']);
	$i_nama = balikin($rku2['nama']);

	
	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td align="center">'.$nomer.'.</td>
	<td align="center">'.$i_nourut.'</td>
	<td>&nbsp;</td>
	<td>'.$i_nama.'</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
    </tr>';
	
	
	//list bidang
	$qyuk = mysqli_query($koneksi, "SELECT DISTINCT(bidang) AS bidku ".
										"FROM m_kib_kode ".
										"WHERE golongan = '$i_nourut' ".
										"AND bidang <> '*' ".
										"ORDER BY round(bidang) ASC");
	$ryuk = mysqli_fetch_assoc($qyuk);
	
	do
		{
		//nilai
		$j_bidang = balikin($ryuk['bidku']);
		
		//namanya
		$qyuk2 = mysqli_query($koneksi, "SELECT * FROM m_kib_kode ".
										"WHERE bidang = '$j_bidang'");
		$ryuk2 = mysqli_fetch_assoc($qyuk2);
		$j_nama = balikin($ryuk2['nama']);
		
		
		
		//hitung jumlahnya
		//jika kib-a
		if ($i_nourut == "01")
			{
			//jumlah 
			$qyuk21 = mysqli_query($koneksi, "SELECT kd, ket FROM inv_kib_a");
			$ryuk21 = mysqli_fetch_assoc($qyuk21);
			$tyuk21 = mysqli_num_rows($qyuk21);
			$j_ket = balikin($ryuk21['ket']);
			$j_jumlah = $tyuk21;
			
			
			//jumlah 
			$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
												"FROM inv_kib_a");
			$ryuk21 = mysqli_fetch_assoc($qyuk21);
			$j_harga = balikin($ryuk21['harganya']);
			}

		
		//jika kib-b
		else if ($i_nourut == "02")
			{
			//nilai
			$kodeku = "$i_nourut.$j_bidang";
			
			//jumlah 
			$qyuk21 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlahnya ".
												"FROM inv_kib_b ".
												"WHERE barang_kode LIKE '$kodeku%'");
			$ryuk21 = mysqli_fetch_assoc($qyuk21);
			$j_jumlah = balikin($ryuk21['jumlahnya']);
			
			
			//jumlah 
			$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
												"FROM inv_kib_b ".
												"WHERE barang_kode LIKE '$kodeku%'");
			$ryuk21 = mysqli_fetch_assoc($qyuk21);
			$j_harga = balikin($ryuk21['harganya']);
			
			//ket 
			$qyuk21 = mysqli_query($koneksi, "SELECT ket FROM inv_kib_b ".
												"WHERE barang_kode LIKE '$kodeku%'");
			$ryuk21 = mysqli_fetch_assoc($qyuk21);
			$j_ket = balikin($ryuk21['ket']);
			}

			
			
		//jika kib-c
		else if ($i_nourut == "03")
			{
			//nilai
			$kodeku = "$i_nourut.$j_bidang";
			
			
			//jumlah 
			$qyuk21 = mysqli_query($koneksi, "SELECT kd, ket FROM inv_kib_c ".
												"WHERE barang_kode LIKE '$kodeku%'");
			$ryuk21 = mysqli_fetch_assoc($qyuk21);
			$tyuk21 = mysqli_num_rows($qyuk21);
			$j_ket = balikin($ryuk21['ket']);
			$j_jumlah = $tyuk21;
			
			
			//jumlah 
			$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
												"FROM inv_kib_c ".
												"WHERE barang_kode LIKE '$kodeku%'");
			$ryuk21 = mysqli_fetch_assoc($qyuk21);
			$j_harga = balikin($ryuk21['harganya']);
			}

			


		//jika kib-d
		else if ($i_nourut == "04")
			{
			//nilai
			$kodeku = "$i_nourut.$j_bidang";
			
			
			//jumlah 
			$qyuk21 = mysqli_query($koneksi, "SELECT kd, ket FROM inv_kib_d ".
												"WHERE barang_kode LIKE '$kodeku%'");
			$ryuk21 = mysqli_fetch_assoc($qyuk21);
			$tyuk21 = mysqli_num_rows($qyuk21);
			$j_ket = balikin($ryuk21['ket']);
			$j_jumlah = $tyuk21;
			
			
			//jumlah 
			$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
												"FROM inv_kib_d ".
												"WHERE barang_kode LIKE '$kodeku%'");
			$ryuk21 = mysqli_fetch_assoc($qyuk21);
			$j_harga = balikin($ryuk21['harganya']);
			}







		//jika kib-e
		else if ($i_nourut == "05")
			{
			//nilai
			$kodeku = "$i_nourut.$j_bidang";
			
			
			//jika buku
			if ($j_bidang == "17")
				{
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT kd, ket FROM inv_kib_e ".
													"WHERE buku_judul <> '' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_ket = balikin($ryuk21['ket']);
				
				
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlahnya ".
													"FROM inv_kib_e ".
													"WHERE buku_judul <> '' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_jumlah = balikin($ryuk21['jumlahnya']);
				
				
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
													"FROM inv_kib_e ".
													"WHERE buku_judul <> '' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_harga = balikin($ryuk21['harganya']);
				}
				
				
				
			//jika corak
			else if ($j_bidang == "18")
				{
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT kd, ket FROM inv_kib_e ".
													"WHERE corak_asal <> '' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_ket = balikin($ryuk21['ket']);
				
				
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlahnya ".
													"FROM inv_kib_e ".
													"WHERE corak_asal <> '' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_jumlah = balikin($ryuk21['jumlahnya']);
				
				
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
													"FROM inv_kib_e ".
													"WHERE corak_asal <> '' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_harga = balikin($ryuk21['harganya']);

				}
				
				
			//jika hewan
			else if ($j_bidang == "19")
				{
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT kd, ket FROM inv_kib_e ".
													"WHERE hewan_jenis <> '' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_ket = balikin($ryuk21['ket']);
				
				
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jumlahnya ".
													"FROM inv_kib_e ".
													"WHERE hewan_jenis <> '' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_jumlah = balikin($ryuk21['jumlahnya']);
				
				
				//jumlah 
				$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
													"FROM inv_kib_e ".
													"WHERE hewan_jenis <> '' ".
													"AND barang_kode LIKE '$kodeku%'");
				$ryuk21 = mysqli_fetch_assoc($qyuk21);
				$j_harga = balikin($ryuk21['harganya']);
				}
				
				
			}



		//jika kib-f
		else if ($i_nourut == "06")
			{
			//jumlah 
			$qyuk21 = mysqli_query($koneksi, "SELECT kd, ket FROM inv_kib_f");
			$ryuk21 = mysqli_fetch_assoc($qyuk21);
			$tyuk21 = mysqli_num_rows($qyuk21);
			$j_ket = balikin($ryuk21['ket']);
			$j_jumlah = $tyuk21;
			
			
			//jumlah 
			$qyuk21 = mysqli_query($koneksi, "SELECT SUM(harga) AS harganya ".
												"FROM inv_kib_f");
			$ryuk21 = mysqli_fetch_assoc($qyuk21);
			$j_harga = balikin($ryuk21['harganya']);
			}


			
		else
			{
			$j_jumlah = "0";
			$j_harga = "0";
			$j_ket = "-";
			}
		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center">'.$j_bidang.'</td>
		<td>'.$j_nama.'</td>
		<td>'.$j_jumlah.'</td>
		<td align="right">'.$j_harga.'</td>
		<td>'.$j_ket.'</td>
        </tr>';
		}
	while ($ryuk = mysqli_fetch_assoc($qyuk));
	
	}
while ($rku2 = mysqli_fetch_assoc($qku2));


echo '</tbody>
  </table>
  </div>
  
  
</form>';



//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>