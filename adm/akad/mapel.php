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
$filenya = "mapel.php";
$judul = "[AKADEMIK]. Data Mapel";
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
			$filex_namex2 = "mapel.xls";

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
				      $i_no = cegah($sheet['A']);
				      $i_tapel = cegah($sheet['B']);
				      $i_kelas = cegah($sheet['C']);
				      $i_jenis = cegah($sheet['D']);
				      $i_nourut = cegah($sheet['E']);
				      $i_mapel = cegah($sheet['F']);
				      $i_singkatan = cegah($sheet['G']);
				      $i_kkm = cegah($sheet['H']);

				      $i_xyz = md5("$i_tapel$i_kelas$i_mapel");
					  
						//insert
						mysqli_query($koneksi, "INSERT INTO m_mapel(kd, tapel, kelas, ".
													"jenis, no, nama, kode, ".
													"kkm, postdate) VALUES ".
													"('$i_xyz', '$i_tapel', '$i_kelas', ".
													"'$i_jenis', '$i_nourut', '$i_mapel', '$i_singkatan', ".
													"'$i_kkm', '$today')");

					  
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
		      $i_no = cegah2(trim($pecahya[0]));
		      $i_tapel = cegah2(trim($pecahya[1]));
		      $i_kelas = cegah2(trim($pecahya[2]));
		      $i_jenis = cegah2(trim($pecahya[3]));
		      $i_nourut = cegah2(trim($pecahya[4]));
		      $i_mapel = cegah2(trim($pecahya[5]));
		      $i_singkatan = cegah2(trim($pecahya[6]));
		      $i_kkm = cegah2(trim($pecahya[7]));

		      $i_xyz = md5("$i_tapel$i_kelas$i_mapel");
			  
			  //hapus dulu, sebelum entri
			  mysqli_query($koneksi, "DELETE FROM m_mapel WHERE kd = '$i_xyz'");
			  
			  
				//insert
				mysqli_query($koneksi, "INSERT INTO m_mapel(kd, tapel, kelas, ".
											"jenis, no, nama, kode, ".
											"kkm, postdate) VALUES ".
											"('$i_xyz', '$i_tapel', '$i_kelas', ".
											"'$i_jenis', '$i_nourut', '$i_mapel', '$i_singkatan', ".
											"'$i_kkm', '$today')");

			
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
	$i_filename = "mapel.xls";
	$i_judul = "mapel";
	
	//isi *START
	ob_start();


	$sqlcount = "SELECT * FROM m_mapel ".
					"ORDER BY tapel ASC, ".
					"kelas ASC, ".
					"jenis ASC, ".
					"nama ASC";

		
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
	<td width="50"><strong><font color="'.$warnatext.'">NO</font></strong></td>
	<td><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
	<td><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
	<td><strong><font color="'.$warnatext.'">JENIS</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NOURUT</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
	<td><strong><font color="'.$warnatext.'">SINGKATAN</font></strong></td>
	<td><strong><font color="'.$warnatext.'">KKM</font></strong></td>
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
			$i_nip = balikin($data['kode']);
			$i_tapel = balikin($data['tapel']);
			$i_kelas = balikin($data['kelas']);
			$i_jenis = balikin($data['jenis']);
			$i_mapel = balikin($data['nama']);
			$i_singkatan = balikin($data['kode']);
			$i_kkm = balikin($data['kkm']);
			$i_nourut = balikin($data['no']);
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$nomer.'</td>
			<td>'.$i_tapel.'</td>
			<td>'.$i_kelas.'</td>
			<td>'.$i_jenis.'</td>
			<td>'.$i_nourut.'</td>
			<td>'.$i_mapel.'</td>
			<td>'.$i_singkatan.'</td>
			<td>'.$i_kkm.'</td>
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












//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$page = nosql($_REQUEST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}


	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM m_mapel ".
					"ORDER BY tapel ASC, ".
					"kelas ASC, ".
					"jenis ASC, ".
					"nama ASC";
	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);


	//ambil semua
	do
		{
		//ambil nilai
		$i = $i + 1;
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysqli_query($koneksi, "DELETE FROM m_mapel ".
						"WHERE kd = '$kd'");
		}
	while ($data = mysqli_fetch_assoc($result));


	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?page=$page";
	xloc($ke);
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



	//nek null
	if ((empty($e_tapel)) OR (empty($e_nama)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?s=s$kd=$kd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika baru
		if ($s == "baru")
			{
			//cek
			$qcc = mysqli_query($koneksi, "SELECT * FROM m_mapel ".
												"WHERE tapel = '$e_tapel' ".
												"AND kelas = '$e_kelas' ".
												"AND nama = '$e_nama'");
			$rcc = mysqli_fetch_assoc($qcc);
			$tcc = mysqli_num_rows($qcc);
	
			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);
	
				//re-direct
				$pesan = "Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?s=s$kd=$kd";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//insert
				mysqli_query($koneksi, "INSERT INTO m_mapel(kd, tapel, kelas, ".
											"jenis, no, nama, kode, ".
											"kkm, postdate) VALUES ".
											"('$x', '$e_tapel', '$e_kelas', ".
											"'$e_jenis', '$e_no', '$e_nama', '$e_kode', ".
											"'$e_kkm', '$today')");

													
													
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				xloc($filenya);
				exit();
				}
			}
			
			
		//jika update
		else if ($s == "edit")
			{
			//query
			mysqli_query($koneksi, "UPDATE m_mapel SET tapel = '$e_tapel', ".
									"kelas = '$e_kelas', ".
									"jenis = '$e_jenis', ".
									"no = '$e_no', ".
									"nama = '$e_nama', ".
									"kode = '$e_kode', ".
									"kkm = '$e_kkm', ".
									"postdate = '$today' ".
									"WHERE kd = '$kd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			xloc($filenya);
			exit();
			}
		}
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
//jika baru/edit
if (($s == "baru") OR ($s == "edit"))
	{
	echo '<form action="'.$filenya.'" method="post" name="formx">
	
	<div class="row">

    	<div class="col-md-2">
	
			<p>
			TaPel :
			<br>
			<select name="e_tapel" class="btn btn-block btn-warning" required>
			<option value="'.$e_tapel.'" selected>'.$e_tapel.'</option>"';
			
			//list
			$qrua = mysqli_query($koneksi, "SELECT * FROM m_tapel ".
												"ORDER BY nama DESC");
			$rrua = mysqli_fetch_assoc($qrua);
		
			do
				{
				$rua = balikin($rrua['nama']);
				$rua2 = cegah($rrua['nama']);
		
				echo '<option value="'.$rua2.'">'.$rua.'</option>';
				}
			while ($rrua = mysqli_fetch_assoc($qrua));
			
			echo '</select>
			</p>
			
			
			<p>
			Kelas :
			<br>
			<select name="e_kelas" class="btn btn-block btn-warning" required>
			<option value="'.$e_kelas.'" selected>'.$e_kelas.'</option>"';
			
			//list
			$qrua = mysqli_query($koneksi, "SELECT * FROM m_kelas ".
												"ORDER BY nama ASC");
			$rrua = mysqli_fetch_assoc($qrua);
		
			do
				{
				$rua = balikin($rrua['nama']);
				$rua2 = cegah($rrua['nama']);
		
				echo '<option value="'.$rua2.'">'.$rua.'</option>';
				}
			while ($rrua = mysqli_fetch_assoc($qrua));
			
			echo '</select>
			</p>
		</div>
		
		<div class="col-md-3">
			<p>
			Jenis Mapel :
			<br>
			<select name="e_jenis" class="btn btn-block btn-warning" required>
			<option value="'.$e_jenis.'" selected>'.$e_jenis.'</option>"';
			
			//list
			$qrua = mysqli_query($koneksi, "SELECT * FROM m_mapel_jns ".
												"ORDER BY round(no) ASC");
			$rrua = mysqli_fetch_assoc($qrua);
		
			do
				{
				$rua3 = balikin($rrua['no']);
				$rua = balikin($rrua['jenis']);
				$rua2 = cegah($rrua['jenis']);
		
				echo '<option value="'.$rua2.'">'.$rua3.'. '.$rua.'</option>';
				}
			while ($rrua = mysqli_fetch_assoc($qrua));
			
			echo '</select>
			</p>
				
				
			<p>
			No.Urut :
			<br>
			<input name="e_no" type="text" value="'.$e_no.'" size="5" class="btn btn-warning" required>
			</p>
			
			<p>
			Nama Mapel :
			<br>
			<input name="e_nama" type="text" value="'.$e_nama.'" size="30" class="btn btn-warning" required>
			</p>
			
		</div>
		
		<div class="col-md-3">
				
			<p>
			Singkatan :
			<br>
			<input name="e_kode" type="text" value="'.$e_kode.'" size="10" class="btn btn-warning" required>
			</p>
				
			<p>
			KKM :
			<br>
			<input name="e_kkm" type="text" value="'.$e_kkm.'" size="5" class="btn btn-warning" required>
			</p>
		</div>
			
	</div>
	
	

	<div class="row">
    	<div class="col-md-7">
			<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-block btn-danger">
			<input name="btnBTL" type="submit" value="BATAL" class="btn btn-block btn-primary">
			<input name="s" type="hidden" value="'.$s.'">
			<input name="kd" type="hidden" value="'.$kd.'">
		</div>
	</div>';
	}
	
	
//jika import
else if ($s == "import")
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
          var htmlData='NO.;NIP;USERNAME;NAMA;JABATAN;NOWA;<br>';
          for(var i=0;i<jsonData.length;i++){
            var row=jsonData[i];
            htmlData+=''+row["NO"]+';'+row["TAPEL"]+';'+row["KELAS"]+';'+row["JENIS"]+';'+row["NOURUT"]+';'+row["NAMA"]+';'+row["SINGKATAN"]+';'+row["KKM"]+';<br>';
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









else
	{
	//jika null
	if (empty($kunci))
		{
		$sqlcount = "SELECT * FROM m_mapel ".
						"ORDER BY tapel ASC, ".
						"kelas ASC, ".
						"jenis ASC, ".
						"round(no) ASC";
		}
		
	else
		{
		$sqlcount = "SELECT * FROM m_mapel ".
						"WHERE tapel LIKE '%$kunci%' ".
						"OR kelas LIKE '%$kunci%' ".
						"OR jenis LIKE '%$kunci%' ".
						"OR nama LIKE '%$kunci%' ".
						"OR kode LIKE '%$kunci%' ".
						"OR kkm LIKE '%$kunci%' ".
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
	
	
	
	echo '<form action="'.$filenya.'" method="post" name="formxx">
	<p>
	<a href="'.$filenya.'?s=baru" class="btn btn-danger">ENTRI BARU</a>
	<input name="btnIM" type="submit" value="IMPORT" class="btn btn-primary">
	<input name="btnEX" type="submit" value="EXPORT" class="btn btn-success">
	</p>
	
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
	<td width="20">&nbsp;</td>
	<td width="20">&nbsp;</td>
	<td width="100"><strong><font color="'.$warnatext.'">TAPEL</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">KELAS</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">JENIS</font></strong></td>
	<td width="5"><strong><font color="'.$warnatext.'">NOURUT</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NAMA MAPEL</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">SINGKATAN</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">KKM</font></strong></td>
	
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
			
			
						
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
	        </td>
			<td>
			<a href="'.$filenya.'?s=edit&kd='.$i_kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$i_tapel.'</td>
			<td>'.$i_kelas.'</td>
			<td>'.$i_jenis.'</td>
			<td>'.$i_nourut.'</td>
			<td>'.$i_mapel.'</td>
			<td>'.$i_singkatan.'</td>
			<td>'.$i_kkm.'</td>
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


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>