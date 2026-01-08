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
require("../../inc/cek/admgr.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admgr.html");





//nilai
$filenya = "rs.php";
$judul = "RPP Silabus";
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











//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
	
	
	

	
	

//jika hapus data
if($_POST['btnHPS'])
	{
	//set ke 777
	$path1 = "../../filebox/arsip/$kd1_session";
	chmod($path1,0777);
	
		
	
	
	//ambil semua
	for ($i=1; $i<=$limit;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

	
	
		
		//baca dulu
		$qyuk = mysqli_query($koneksi, "SELECT * FROM user_filebox ".
											"WHERE kd = '$kd'");
		$ryuk = mysqli_fetch_assoc($qyuk);
		$yuk_filex = balikin($ryuk['filex']);
		
					
						
		//hapus file 
		$filex_namex2 = "$kd.pdf";
		$path1 = "../../filebox/arsip/$kd1_session/$kd/$yuk_filex";
		chmod($path1,0777);
		unlink ($path1);
		
		
		
		//del
		mysqli_query($koneksi, "DELETE FROM user_filebox ".
									"WHERE kd = '$kd'");
		}
		


	//set ke 755
	$path1 = "../../filebox/arsip/$kd1_session";
	chmod($path1,0755);
	

	//re-direct
	xloc($filenya);
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
//jika entri baru
if ($s == "baru")
	{
	//bikin folder, jika belum ada
	$path1 = "../../filebox/arsip/$kd1_session";
	
	//cek, sudah ada belum
	if (!file_exists($path1))
		{
		//bikin folder kd_user
		mkdir($path1, 0777);
		}
	
	chmod($path1,0777);
	


	//bikin folder, jika belum ada
	$path2 = "../../filebox/arsip/$kd1_session/$kd";
	
	//cek, sudah ada belum
	if (!file_exists($path2))
		{
		//bikin folder kd_user
		mkdir($path2, 0777);
		}
	
	chmod($path2,0777);
	
	
	?>
		
	<form id="upload-form" class="upload-form" method="post">
	     <div class="row align-items-center">
	      <div class="form-group col-md-8">
	      	
	          	
	          	<p>
	            <label for="inputEmail4">File Dokumen .pdf (Maksimal 10MB)</label>
	            <input type="file" class="btn btn-warning form-control" id="upl-file" name="upl_file" accept=".pdf" required>  
	            <span id="chk-error"></span>
	            
	            </p>
	
				<p>
	            <label for="inputEmail5">Judul : </label>
					
					<input name="e_judul" id="e_judul" type="text" size="30" class="btn btn-warning form-control" value="<?php echo $e_judul;?>" required>
				</p>
	
				<p>
	            <label for="inputEmail7">Kategori : </label>
					
					<select name="e_kat" id="e_kat" class="btn btn-warning form-control" required>
						<option value="<?php echo $e_kat;?>" selected><?php echo $e_kat;?></option>
						<option value="RPP">RPP</option>
						<option value="Silabus">Silabus</option>
					</select>
				</p>
				
				<p>
	            <label for="inputEmail6">Keterangan : </label>
					
					<input name="e_ket" id="e_ket" type="text" size="30" class="btn btn-warning form-control" value="<?php echo $e_ket;?>" required>
				</p>
				
				
				<p>
					<input name="pegkd" id="pegkd" type="hidden" value="<?php echo $kd1_session;?>">
					<input name="kd" id="kd" type="hidden" value="<?php echo $kd;?>">
	                <button type="submit" class="btn btn-danger mt-3 float-left" id="upload-file"><i class="fa fa-upload" aria-hidden="true"></i> UNGGAH DOKUMEN >></button>
	                
	           </p>
	        </div>
	    </div>
	</form>
	
	
	    <div class="row align-items-center">
	  <div class="col-md-8">
	    <div class="progress">
	      <div id="file-progress-bar" class="progress-bar"></div>
	   </div>
	 </div>
	</div>    
	
	
	
	  <div class="row align-items-center">  
	    <div class="col-md-8">
	        <div id="uploaded_file"></div>
	    </div>
	</div>   
	
	
	
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous" charset="utf-8"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/tokenfield-typeahead.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" charset="utf-8"></script>
	
	
	
		
	
	
	
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
	
	<script>
		    jQuery(document).on('submit', '#upload-form', function(e){
	        jQuery("#chk-error").html('');
	        e.preventDefault();
	        $.ajax({
	            xhr: function() {
	                var xhr = new window.XMLHttpRequest();         
	                xhr.upload.addEventListener("progress", function(element) {
	                    if (element.lengthComputable) {
	                        var percentComplete = ((element.loaded / element.total) * 100);
	                        $("#file-progress-bar").width(percentComplete + '%');
	                        $("#file-progress-bar").html(percentComplete+'%');
	                    }
	                }, false);
	                return xhr;
	            },
	            type: 'POST',
	            url: 'i_rs_upload.php',
	            data: new FormData(this),
	            contentType: false,
	            cache: false,
	            processData:false,
	            dataType:'json',
	
	            beforeSend: function(){
	                $("#file-progress-bar").width('0%');
	            },
	
	            success: function(json){
	                if(json == 'BERHASIL'){
	                    $('#upload-form')[0].reset();
	                    $('#uploaded_file').html('<p style="color:#28A74B;">Unggah Berhasil..!!</p>');
						window.location.href = "<?php echo $filenya;?>";
	                    
	                }else if(json == 'Gagal'){
	                    $('#uploaded_file').html('<p style="color:#EA4335;">Tentukan File Unggah yang Benar..!!</p>');
	                }
	            },
	            error: function (xhr, ajaxOptions, thrownError) {
	              console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	            }
	        });
	    });
	  
	
	
	</script>

	<?php
	}
	
	
	
else
	{
	//jika null
	if (empty($kunci))
		{
		$sqlcount = "SELECT * FROM user_filebox ".
						"WHERE user_kd = '$kd1_session' ".
						"ORDER BY judul ASC";
		}
		
	else
		{
		$sqlcount = "SELECT * FROM user_filebox ".
						"WHERE user_kd = '$kd1_session' ".
						"AND (judul LIKE '%$kunci%' ".
						"OR ket LIKE '%$kunci%') ".
						"ORDER BY judul ASC";
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
	
	<a href="'.$filenya.'?s=baru&kd='.$x.'" class="btn btn-danger">UNGGAH BARU >></a>
	
	<hr>
	<p>
	<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
	<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
	<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
	</p>
		
	
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
	
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="50"><strong><font color="'.$warnatext.'">KATEGORI</font></strong></td>
	<td><strong><font color="'.$warnatext.'">JUDUL + KETERANGAN</font></strong></td>
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
			$i_kat = balikin($data['kategori']);
			$i_judul = balikin($data['judul']);
			$i_ket = balikin($data['ket']);
			$i_postdate = balikin($data['postdate']);
			$i_filex = balikin($data['filex']);
			
		
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$i_kd.'">
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
			</td>
			<td>'.$i_kat.'</td>
			<td>
			<b>'.$i_judul.'</b>
			<br>
			<i>'.$i_ket.'</i>
			<br>
			<a href="../../filebox/arsip/'.$kd1_session.'/'.$i_kd.'/'.$i_filex.'" class="btn btn-danger" title="'.$i_judul.'" target="_blank">UNDUH</a>
			</td>
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
	<td width="300">
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')" class="btn btn-success">
	<input name="btnBTL" type="reset" value="BATAL" class="btn btn-info">
	<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-danger">
	</td>
	<td align="right"><strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</td>
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