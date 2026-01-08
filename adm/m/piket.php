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
$filenya = "piket.php";
$judul = "[USER AKSES]. Data Petugas Piket";
$judulku = "[USER AKSES]. Data Petugas Piket";
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
//jika import
if ($_POST['btnIM'])
	{
	//re-direct
	$ke = "$filenya?s=import";
	xloc($ke);
	exit();
	}










/*

//lama
//import sekarang
if ($_POST['btnIMX'])
	{
	$filex_namex2 = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex2))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?s=import";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .xls
		$ext_filex = substr($filex_namex2, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox";
			$path2 = "../../filebox/excel";
			chmod($path1,0777);
			chmod($path2,0777);

			//nama file import, diubah menjadi baru...
			$filex_namex2 = "piket.xls";

			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex2");

			//chmod
            $path3 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0755);
			chmod($path2,0777);
			chmod($path3,0777);

			//file-nya...
			$uploadfile = $path3;


			//require
			require('../../inc/class/PHPExcel.php');
			require('../../inc/class/PHPExcel/IOFactory.php');


			  // load excel
			  $load = PHPExcel_IOFactory::load($uploadfile);
			  $sheets = $load->getActiveSheet()->toArray(null,true,true,true);
			
			  $i = 1;
			  foreach ($sheets as $sheet) 
			  	{
			    // karena data yang di excel di mulai dari baris ke 2
			    // maka jika $i lebih dari 1 data akan di masukan ke database
			    if ($i > 1) 
			    	{
				      // nama ada di kolom A
				      // sedangkan alamat ada di kolom B
				      $i_xyz = md5("$x$i");
				      $i_no = cegah($sheet['A']);
				      $i_kode = cegah($sheet['B']);
				      $i_nama = cegah($sheet['C']);
				      $i_jabatan = cegah($sheet['D']);
					  
					  //kasi random depan...
					  $kdepan = rand(1000, 10000);
					  $i_qrcode = "$kdepan$i_kode";
					  
						//cek
						$qcc = mysqli_query($koneksi, "SELECT * FROM m_piket ".
														"WHERE kode = '$i_kode'");
						$rcc = mysqli_fetch_assoc($qcc);
						$tcc = mysqli_num_rows($qcc);
		
						//jika ada, update				
						if (!empty($tcc))
							{
							mysqli_query($koneksi, "UPDATE m_piket SET nama = '$i_nama' ".
														"WHERE kode = '$i_kode'");
							}
		
		
						else
							{
							//insert
							mysqli_query($koneksi, "INSERT INTO m_piket(kd, kode, nama, ".
														"jabatan, qrcode, postdate) VALUES ".
														"('$i_xyz', '$i_kode', '$i_nama', ".
														"'$i_jabatan', '$i_qrcode', '$today')");
							}
					  
				    }
			
			    $i++;
			  }





			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0777);
			unlink ($path1);


			//re-direct
			xloc($filenya);
			exit();
			}
		else
			{
			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
*/




//import sekarang
if ($_POST['btnIMX'])
	{
	$e_nilai = balikin($_POST['display_excel_data']);
	
	
	

	//baca per loop
	for ($k=2;$k<=10000;$k++)
		{
		//nilai
		$kk = $k - 1 ;
		
		//pecah
		$pecahku = explode("<br>", $e_nilai);
		$pecahku1 = trim($pecahku[$kk]); 
		
		
		//jika ada
		if (!empty($pecahku1))
			{
			//pecah string
			$pecahya = explode(";", $pecahku1);
		      $i_xyz = md5("$x$k");
		      $i_no = cegah2(trim($pecahya[1]));
		      $i_kode = cegah2(trim($pecahya[2]));
		      $i_nama = cegah2(trim($pecahya[3]));
		      $i_jabatan = cegah2(trim($pecahya[4]));


				//jika ada
				if (!empty($i_kode))
					{
					//insert
					mysqli_query($koneksi, "INSERT INTO m_piket(kd, kode, nama, ".
											"jabatan, postdate) VALUES ".
											"('$i_xyz', '$i_kode', '$i_nama', ".
											"'$i_jabatan', '$today')");
					}
			
			
			}
		}



	//re-direct
	xloc($filenya);
	exit();	
	}









//jika export
//export
if ($_POST['btnEX'])
	{
	//nama file e...
	$i_filename = "data_piket.xls";
	$i_judul = "DATA PIKET";
	
	//isi *START
	ob_start();


	$sqlcount = "SELECT * FROM m_piket ".
					"ORDER BY nama ASC";

		
	//query
	$p = new Pager();
	$limit = 10000000;
	$start = $p->findStart($limit);
	
	$sqlresult = $sqlcount;
	
	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);
	

	echo '<div class="table-responsive">
	
	<table class="table" border="1">
	<thead>
	
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="5"><strong><font color="'.$warnatext.'">NO</font></strong></td>
	<td><strong><font color="'.$warnatext.'">KODE</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
	<td><strong><font color="'.$warnatext.'">JABATAN</font></strong></td>
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
			$dt_nip = balikin($data['kode']);
			$dt_nama = balikin($data['nama']);
			$dt_jabatan = balikin($data['jabatan']);
	

			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$nomer.'</td>
			<td>'.$dt_nip.'</td>
			<td>'.$dt_nama.'</td>
			<td>'.$dt_jabatan.'</td>
	        </tr>';
			}
		while ($data = mysqli_fetch_assoc($result));
		}
	
	
	echo '</tbody>
	  </table>

	  </div>';

	
	//isi
	$isiku = ob_get_contents();
	ob_end_clean();

	
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$i_filename");
	echo $isiku;


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




//nek entri baru
if ($_POST['btnBARU'])
	{
	//re-direct
	$ke = "$filenya?s=baru&kd=$x";
	xloc($ke);
	exit();
	}







//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$page = nosql($_POST['page']);
	$e_nip = cegah($_POST['e_nip']);
	$e_nama = cegah($_POST['e_nama']);
	$e_jabatan = cegah($_POST['e_jabatan']);



	//nek null
	if ((empty($e_nip)) OR (empty($e_nama)))
		{
		//re-direct
		$pesan = "Belum Ditulis. Harap Diulangi...!!";
		$ke = "$filenya?s=$s&kd=$kd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//set qrcode 
		$kdepan = rand(1000, 10000);
		$e_qrcode = "$kdepan$e_nip";
		
		
		//jika update
		if ($s == "edit")
			{
			mysqli_query($koneksi, "UPDATE m_piket SET kode = '$e_nip', ".
										"nama = '$e_nama', ".
										"jabatan = '$e_jabatan' ".
										"WHERE kd = '$kd'");

			//re-direct
			xloc($filenya);
			exit();
			}



		//jika baru
		if ($s == "baru")
			{
			//cek
			$qcc = mysqli_query($koneksi, "SELECT * FROM m_piket ".
												"WHERE kode = '$e_nip'");
			$rcc = mysqli_fetch_assoc($qcc);
			$tcc = mysqli_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//re-direct
				$pesan = "Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?s=baru&kd=$kd";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				mysqli_query($koneksi, "INSERT INTO m_piket(kd, kode, nama, ".
										"jabatan, qrcode, postdate) VALUES ".
										"('$kd', '$e_nip', '$e_nama', ".
										"'$e_jabatan', '$e_qrcode', '$today')");


				//re-direct
				xloc($filenya);
				exit();
				}
			}
		}
	}




//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$page = nosql($_POST['page']);
	$ke = "$filenya?page=$page";

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysqli_query($koneksi, "DELETE FROM m_piket ".
						"WHERE kd = '$kd'");
		}

	//auto-kembali
	xloc($filenya);
	exit();
	}
	
	
	
	
//nek pegawai : reset
if ($s == "reset")
	{ 
	//nilai
	$nilku = rand(111,999);
	
	//pass baru
	$passbarux = md5($nilku);
	
	
	//update
	mysqli_query($koneksi, "UPDATE m_piket SET passwordx = '$passbarux' ".
								"WHERE kd = '$kd'"); 
	
	//re-direct
	$pesan = "Password Baru : $nilku";
	pekem($pesan,$filenya);
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.min.js">

  
  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  
<?php
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika import
if ($s == "import")
	{
	?>
	<div class="row">

	<div class="col-md-12">
		
	<?php
	echo '<form action="'.$filenya.'" method="post" enctype="multipart/form-data" name="formxx2">
	<input type="file" name="file_upload" id="file_upload" class="btn btn-warning" onchange="upload()">
	<br>
	
	
    <textarea name="display_excel_data" id="display_excel_data" hidden></textarea>



	<p>
		<input name="btnBTL" type="submit" value="BATAL" class="btn btn-info">
		<input name="btnIMX" type="submit" value="IMPORT >>" class="btn btn-danger">
	</p>
	
	
	</form>';	
	?>
		
		
	

    <script>// Method to upload a valid excel file
      function upload() {
        var files = document.getElementById('file_upload').files;
        if(files.length==0){
          alert("Please choose any file...");
          return;
        }
        var filename = files[0].name;
        var extension = filename.substring(filename.lastIndexOf(".")).toUpperCase();
        if (extension == '.XLS' || extension == '.XLSX') {
          //Here calling another method to read excel file into json
          excelFileToJSON(files[0]);
        }
        else{
          alert("Please select a valid excel file.");
        }
      }
      //Method to read excel file and convert it into JSON 
      function excelFileToJSON(file){
        try {
          var reader = new FileReader();
          reader.readAsBinaryString(file);
          reader.onload = function(e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, {
              type : 'binary'
            }
                                    );
            var result = {
            };
            var firstSheetName = workbook.SheetNames[0];
            //reading only first sheet data
            var jsonData = XLSX.utils.sheet_to_json(workbook.Sheets[firstSheetName]);
            //displaying the json result into HTML table
            displayJsonToHtmlTable(jsonData);

			//alert(displayJsonToHtmlTable(jsonData));
			
			
          }
        }
        catch(e){
          console.error(e);
        }
      }
      //Method to display the data in HTML Table
      function displayJsonToHtmlTable(jsonData){
        var table=document.getElementById("display_excel_data");
        if(jsonData.length>0){
          var htmlData='NO;KODE;NAMA;JABATAN;<br>';
          for(var i=0;i<jsonData.length;i++){
            var row=jsonData[i];
            htmlData+=''+row["NO"]+';'+row["KODE"]+';'+row["NAMA"]+';'+row["JABATAN"]+';<br>';
          }
          table.innerHTML=htmlData;
        }
        else{
          table.innerHTML='There is no data in Excel';
        }
      }
    </script> 





	</div>
	
	</div>


	<?php
	}








//jika edit / baru
else if (($s == "baru") OR ($s == "edit"))
	{
	$kdx = nosql($_REQUEST['kd']);

	$qx = mysqli_query($koneksi, "SELECT * FROM m_piket ".
									"WHERE kd = '$kdx'");
	$rowx = mysqli_fetch_assoc($qx);
	$e_nip = balikin($rowx['kode']);
	$e_nama = balikin($rowx['nama']);
	$e_jabatan = balikin($rowx['jabatan']);
	?>
	
	
	
	<div class="row">

		<div class="col-md-4">
			
		<?php
		echo '<form action="'.$filenya.'" method="post" name="formx2">
		
		
		<p>
		NIP/USERNAME : 
		<br>
		<input name="e_nip" type="text" value="'.$e_nip.'" size="10" class="btn btn-warning" required>
		</p>
		
		
		
		<p>
		Nama : 
		<br>
		<input name="e_nama" type="text" value="'.$e_nama.'" size="30" class="btn btn-warning" required>
		</p>
		
		
		<p>
		Jabatan : 
		<br>
		<input name="e_jabatan" type="text" value="'.$e_jabatan.'" size="30" class="btn btn-warning" required>
		</p>
		
		
		<p>
		<input name="jml" type="hidden" value="'.$count.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="page" type="hidden" value="'.$page.'">
		
		<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
		<input name="btnBTL" type="submit" value="BATAL" class="btn btn-info">
		</p>
		
		
		</form>';
		?>
	
	</div>
	
	
	
	<div class="col-md-6">		
		
			


		<?php
	  	//bikin qrcode ///////////////////////////////////////////////////////////////////////////////////
		$idatanya = "$e_nip";

		echo '<form name="formxku" id="formxku">
		<textarea id="pesanku" name="pesanku" hidden>'.$idatanya.'</textarea>
		</form>';
		?>
			  	
		

		<script language='javascript'>
		//membuat document jquery
		$(document).ready(function(){
		
		$.noConflict();
	
		});
		
		</script>



			

		<script language='javascript'>
		//membuat document jquery
		$(document).ready(function(){
			
		
			var datastring = $("#pesanku").serialize();
			
			
			$.ajax({
			    url: "<?php echo $sumber;?>/adm/m/i_qrcode.php",
			    data: datastring,
			    method: "post",
			    success: function(data) 
			    	{
			    	$('#ikirim').html(data);
			    	}
			});
		
		
		
		

			$.ajax({
			    url: "<?php echo $sumber;?>/adm/m/i_qrcode_show.php",
			    data: datastring,
			    method: "post",
			    success: function(data) 
			    	{ 
			    	$('#ikirim2').html(data);
			    	$('#ikirim2').show();
			    	}
			});
	

		
		
		});
		
		</script>

		
		
		<div id="ikirim"></div>
		<div id="ikirim2"></div>
		




		
		</div>
		
		
	</div>


	<?php
	}
	














else
	{
	//jika null
	if (empty($kunci))
		{
		$sqlcount = "SELECT * FROM m_piket ".
						"ORDER BY nama ASC";
		}
		
	else
		{
		$sqlcount = "SELECT * FROM m_piket ".
						"WHERE kode LIKE '%$kunci%' ".
						"OR nama LIKE '%$kunci%' ".
						"OR jabatan LIKE '%$kunci%' ".
						"ORDER BY nama ASC";
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
	<input name="btnBARU" type="submit" value="ENTRI BARU" class="btn btn-danger">
	<input name="btnIM" type="submit" value="IMPORT" class="btn btn-primary">
	<input name="btnEX" type="submit" value="EXPORT" class="btn btn-success">
	</p>
	<br>
	
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
	<td width="20">&nbsp;</td>
	<td width="20">&nbsp;</td>
	<td width="50"><strong><font color="'.$warnatext.'">NIP/USERNAME</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
	<td><strong><font color="'.$warnatext.'">JABATAN</font></strong></td>	
	<td width="50"><strong><font color="'.$warnatext.'">LOGIN TERAKHIR</font></strong></td>
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
			$i_user = balikin($data['usernamex']);
			$i_kode = balikin($data['kode']);
			$i_nama = balikin($data['nama']);
			$i_jabatan = balikin($data['jabatan']);
			$i_qrcode = balikin($data['qrcode']);
			$i_akses = $i_kode;
	

			//jika null, kasi kode
			if (empty($i_kode))
				{
				$kdepan = rand(100, 999);
				$kodenya = "$kdepan$menit$detik";
				
				//update...
				mysqli_query($koneksi, "UPDATE m_piket SET kode = '$kodenya', ".
										"qrcode = '$kodenya' ".
										"WHERE kd = '$i_kd'");
				}
				
				
				
			//jika null, kasi kode
			if (empty($i_user))
				{
				$kodex = md5($i_kode);
				
				//update...
				mysqli_query($koneksi, "UPDATE m_piket SET usernamex = '$i_kode', ".
										"passwordx = '$kodex' ".
										"WHERE kd = '$i_kd'");
				}
				
				
				
				
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
	        </td>
			<td>
			<a href="'.$filenya.'?s=edit&page='.$page.'&kd='.$i_kd.'"><img src="'.$sumber.'/template/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>'.$i_kode.'</td>
			<td>
			'.$i_nama.'
			
			<hr>
			<a href="piket_pdf.php?kd='.$i_kd.'" target="_blank" class="btn btn-danger">PRINT KARTU PIKET >></a>
			
			<hr>
			<a href="'.$filenya.'?s=reset&kd='.$i_kd.'" class="btn btn-primary">RESET PASSWORD >></a>
			</td>
			<td>'.$i_jabatan.'</td>
			<td>'.$i_login.'</td>
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
	
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')" class="btn btn-primary">
	<input name="btnBTL" type="reset" value="BATAL" class="btn btn-warning">
	<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-danger">
	</td>
	</tr>
	</table>
	</form>';
	}








//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>