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
$filenya = "pegawai.php";
$judul = "[MASTER] Data Pegawai";
$judulku = "$judul";
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


	




	
	


$limit = 5;


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika import
if ($_POST['btnIM'])
	{
	//re-direct
	$ke = "$filenya?s=import";
	xloc($ke);
	exit();
	}













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
		      $i_nip = cegah2(trim($pecahya[1]));
		      $i_username = cegah2(trim($pecahya[2]));
		      $i_nama = cegah2(trim($pecahya[3]));
		      $i_jabatan = cegah2(trim($pecahya[4]));
		      $i_nowa = cegah2(trim($pecahya[5]));


					  
				//user pass
				$i_user = $i_username;
				$i_pass = md5($i_nip);


				//jika ada
				if (!empty($i_user))
					{
					//insert
					mysqli_query($koneksi, "INSERT INTO m_pegawai(kd, kode, nama, ".
											"jabatan, usernamex, ".
											"passwordx, nowa, postdate) VALUES ".
											"('$i_xyz', '$i_nip', '$i_nama', ".
											"'$i_jabatan', '$i_user', ".
											"'$i_pass', '$i_nowa', '$today')");
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
	$i_filename = "data_pegawai.xls";
	$i_judul = "DATA PEGAWAI";
	
	//isi *START
	ob_start();


	$sqlcount = "SELECT * FROM m_pegawai ".
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
	<td width="50"><strong><font color="'.$warnatext.'">NIP</font></strong></td>
	<td><strong><font color="'.$warnatext.'">USERNAME</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
	<td><strong><font color="'.$warnatext.'">JABATAN</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NOWA</font></strong></td>
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
			$i_nama = balikin($data['nama']);
			$i_namax = cegah($data['nama']);
			$i_username = balikin($data['usernamex']);
			$i_usernamex = cegah($data['usernamex']);
			$i_jabatan = balikin($data['jabatan']);
			$i_postdate = balikin($data['postdate']);
			$i_qrcode = balikin($data['kode']);
			$i_nowa = balikin($data['nowa']);
			$i_akses = $i_nip;
			$kodex = md5($i_nip);
			

			$i_filex1 = "$i_kd-1.jpg";
			$nil_foto1 = "$sumber/filebox/pegawai/$i_kd/$i_filex1";	



			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i_nip.'</td>
			<td>'.$i_username.'</td>
			<td>'.$i_nama.'</td>
			<td>'.$i_jabatan.'</td>
			<td>+62'.$i_nowa.'</td>
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
	$e_user = cegah($_POST['e_user']);
	$e_nama = cegah($_POST['e_nama']);
	$e_jabatan = cegah($_POST['e_jabatan']);
	$e_nowa = cegah($_POST['e_nowa']);


	$kd2 = md5($e_nip);
	
	//user pass
	$e_user = $e_user;
	$e_pass = md5($e_nip);
	
	


	//nek null
	if ((empty($e_nama)) OR (empty($e_nip)))
		{
		//re-direct
		$pesan = "Belum Ditulis. Harap Diulangi...!!";
		$ke = "$filenya?s=$s&kd=$kd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika update
		if ($s == "edit")
			{
			mysqli_query($koneksi, "UPDATE m_pegawai SET kode = '$e_nip', ".
										"usernamex = '$e_user', ".
										"nama = '$e_nama', ".
										"nowa = '$e_nowa', ".
										"jabatan = '$e_jabatan' ".
										"WHERE kd = '$kd'");


			//update
			mysqli_query($koneksi, "UPDATE m_user SET usernamex = '$e_user', ".
										"passwordx = '$e_pass', ".
										"kode = '$e_nip', ".
										"nama = '$e_nama', ".
										"nowa = '$e_nowa', ".
										"qrcode = '$e_nip' ".
										"WHERE kd = '$kd'");



			//re-direct
			xloc($filenya);
			exit();
			}



		//jika baru
		if ($s == "baru")
			{
			//cek
			$qcc = mysqli_query($koneksi, "SELECT * FROM m_pegawai ".
												"WHERE kode = '$e_nip'");
			$rcc = mysqli_fetch_assoc($qcc);
			$tcc = mysqli_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//re-direct
				$pesan = "Kode Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?s=baru&kd=$kd";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//insert
				mysqli_query($koneksi, "INSERT INTO m_pegawai(kd, kode, nama, ".
										"jabatan, nowa, usernamex, ".
										"passwordx, postdate) VALUES ".
										"('$kd2', '$e_nip', '$e_nama', ".
										"'$e_jabatan', '$e_nowa', '$e_user', ".
										"'$e_pass', '$today')");


				//insert
				mysqli_query($koneksi, "INSERT INTO m_user(kd, usernamex, passwordx, ".
											"kode, nama, jabatan, nowa, ".
											"tapel, kelas, qrcode, postdate) VALUES ".
											"('$kd2', '$e_user', '$e_pass', ".
											"'$e_nip', '$e_nama', 'PEGAWAI', '$e_nowa', ".
											"'-', '-', '$e_nip', '$today')");


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
		mysqli_query($koneksi, "DELETE FROM m_pegawai ".
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
	mysqli_query($koneksi, "UPDATE m_pegawai SET passwordx = '$passbarux' ".
								"WHERE kd = '$kd'"); 
	
	
	//update
	mysqli_query($koneksi, "UPDATE m_user SET passwordx = '$passbarux' ".
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
//jika edit / baru
if (($s == "baru") OR ($s == "edit"))
	{
	$kdx = nosql($_REQUEST['kd']);

	$qx = mysqli_query($koneksi, "SELECT * FROM m_pegawai ".
									"WHERE kd = '$kdx'");
	$rowx = mysqli_fetch_assoc($qx);
	$e_nip = balikin($rowx['kode']);
	$e_user = balikin($rowx['usernamex']);
	$e_nama = balikin($rowx['nama']);
	$e_jabatan = balikin($rowx['jabatan']);
	$e_nowa = balikin($rowx['nowa']);




	$i_filex1 = "$kdx-1.jpg";
	$nil_foto1 = "$sumber/filebox/pegawai/$kdx/$i_filex1";				


	?>
	
	
	
	<div class="row">

	<div class="col-md-6">
		
	<?php
	echo '<form action="'.$filenya.'" method="post" name="formx2">
	

	<p>
	KODE/NIP : 
	<br>
	<input name="e_nip" type="text" value="'.$e_nip.'" size="30" class="btn-warning" required>
	</p>
	


	<p>
	Username : 
	<br>
	<input name="e_user" type="text" value="'.$e_user.'" size="30" class="btn-warning" required>
	</p>

	<p>
	NAMA : 
	<br>
	<input name="e_nama" type="text" value="'.$e_nama.'" size="30" class="btn-warning" required>
	</p>


	<p>
	JABATAN : 
	<br>
	<input name="e_jabatan" type="text" value="'.$e_jabatan.'" size="30" class="btn-warning" required>
	</p>

	<p>
	NO.WA : 
	<br>
	+62<input name="e_nowa" type="text" value="'.$e_nowa.'" size="20" class="btn-warning" required>
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
	



	
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  


	<style type="text/css">
	.thumb-image{
	 float:left;
	 width:150px;
	 height:150px;
	 position:relative;
	 padding:5px;
	}
	</style>
	
	
	
	
		<table border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="100">
			<div id="image-holder"></div>
		</td>
		

		</tr>
		</table>
	
	<script>
	$(document).ready(function() {
		
		
	        $("#image_upload").on('change', function() {
	          //Get count of selected files
	          var countFiles = $(this)[0].files.length;
	          var imgPath = $(this)[0].value;
	          var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
	          var image_holder = $("#image-holder");
	          image_holder.empty();
	          if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
	            if (typeof(FileReader) != "undefined") {
	              //loop for each file selected for uploaded.
	              for (var i = 0; i < countFiles; i++) 
	              {
	                var reader = new FileReader();
	                reader.onload = function(e) {
	                  $("<img />", {
	                    "src": e.target.result,
	                    "class": "thumb-image"
	                  }).appendTo(image_holder);
	                }
	                image_holder.show();
	                reader.readAsDataURL($(this)[0].files[i]);
	              }
	              
	
		    
	            } else {
	              alert("This browser does not support FileReader.");
	            }
	          } else {
	            alert("Pls select only images");
	          }
	        });
	        
	        


	        
	        
	        
	      });
	</script>

	<?php
	echo '<div id="loading" style="display:none">
	<img src="'.$sumber.'/template/img/progress-bar.gif" width="100" height="16">
	</div>
	
	
   <form method="post" id="upload_image" enctype="multipart/form-data">
	<input type="file" name="image_upload" id="image_upload" class="btn btn-warning" />

   </form>
   
   <hr>';
	
	?>
	
	
	<script>  
	$(document).ready(function(){
		
		
		
	       $('#image-holder').load("<?php echo $sumber;?>/adm/m/i_pegawai.php?aksi=lihat1&kd=<?php echo $kd;?>");

	
	
	        
	    $('#upload_image').on('change', function(event){
	     event.preventDefault();
	     
			$('#loading').show();
	
	
		
		     $.ajax({
		      url:"i_pegawai_upload.php?kd=<?php echo $kd;?>",
		      method:"POST",
		      data:new FormData(this),
		      contentType:false,
		      cache:false,
		      processData:false,
		      success:function(data){
				$('#loading').hide();
		       $('#preview').load("<?php echo $sumber;?>/adm/m/i_pegawai.php?aksi=lihat&kd=<?php echo $kd;?>");
		       	
		      }
		     })
		    });
		    
		    
	});  
	</script>





			
			


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
            htmlData+=''+row["NO."]+';'+row["NIP"]+';'+row["USERNAME"]+';'+row["NAMA"]+';'+row["JABATAN"]+';'+row["NOWA"]+';<br>';
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
		$sqlcount = "SELECT * FROM m_pegawai ".
						"ORDER BY nama ASC";
		}
		
	else
		{
		$sqlcount = "SELECT * FROM m_pegawai ".
						"WHERE kode LIKE '%$kunci%' ".
						"OR usernamex LIKE '%$kunci%' ".
						"OR nama LIKE '%$kunci%' ".
						"OR jabatan LIKE '%$kunci%' ".
						"OR nowa LIKE '%$kunci%' ".
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
	<td width="50"><strong><font color="'.$warnatext.'">FOTO</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
	<td><strong><font color="'.$warnatext.'">JABATAN</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NOWA</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
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
			$i_nama = balikin($data['nama']);
			$i_namax = cegah($data['nama']);
			$i_username = balikin($data['usernamex']);
			$i_usernamex = cegah($data['usernamex']);
			$i_jabatan = balikin($data['jabatan']);
			$i_postdate = balikin($data['postdate']);
			$i_qrcode = balikin($data['kode']);
			$i_nowa = balikin($data['nowa']);
			$i_akses = $i_nip;
			$kodex = md5($i_nip);
			

			$i_filex1 = "$i_kd-1.jpg";
			$nil_foto1 = "$sumber/filebox/pegawai/$i_kd/$i_filex1";	


			//hapus dulu, sebelum insert
			mysqli_query($koneksi, "DELETE FROM m_user ".
										"WHERE kd = '$kodex'");

			//insert
			mysqli_query($koneksi, "INSERT INTO m_user(kd, usernamex, passwordx, ".
										"kode, nama, jabatan, nowa, ".
										"tapel, kelas, qrcode, postdate) VALUES ".
										"('$kodex', '$i_usernamex', '$kodex', ".
										"'$i_nip', '$i_namax', 'PEGAWAI', '$nowa', ".
										"'-', '-', '$i_qrcode', '$today')");

			
			
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
	        </td>
			<td>
			<a href="'.$filenya.'?s=edit&page='.$page.'&kd='.$i_kd.'"><img src="'.$sumber.'/template/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			
			<img src="'.$nil_foto1.'" width="150">
			
			</td>
			<td>
			'.$i_nama.'
			<br>
			NIP:'.$i_nip.'
			<br>
			USERNAME:'.$i_username.'
			
			
			
			<hr>
			<a href="pegawai_pdf.php?kd='.$i_kd.'&kode='.$i_nip.'" target="_blank" class="btn btn-danger">PRINT KARTU PEGAWAI >></a>			
			<hr>
			<a href="'.$filenya.'?s=reset&kd='.$i_kd.'" class="btn btn-primary">RESET PASSWORD >></a>
			
			</td>
			<td>'.$i_jabatan.'</td>
			<td>+62'.$i_nowa.'</td>
			<td>'.$i_postdate.'</td>
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