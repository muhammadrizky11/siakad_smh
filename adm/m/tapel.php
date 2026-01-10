<?php

session_start();


require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/adm.html");


//nilai
$filenya = "tapel.php";
$diload = "document.formx.tahun1.focus();";
$judul = "[MASTER]. Tahun Pelajaran";
$judulku = "[MASTER]. Tahun Pelajaran";
$judulx = $judul;
$s = nosql($_REQUEST['s']);



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL']) {
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
}



//jika edit
if ($s == "edit") {
	//nilai
	$kdx = nosql($_REQUEST['kd']);

	//query
	$qx = mysqli_query($koneksi, "SELECT * FROM m_tapel " .
		"WHERE kd = '$kdx'");
	$rowx = mysqli_fetch_assoc($qx);
	$tahun1 = balikin($rowx['nama']);
	$e_status = balikin($rowx['aktif']);

	//jika true
	if ($e_status == "true") {
		$e_status_ket = "Aktif";
	} else if ($e_status == "false") {
		$e_status_ket = "Tidak Aktif";
	}
}



//jika simpan
if ($_POST['btnSMP']) {
	//nilai
	$kd = nosql($_POST['kd']);
	$tahun1 = cegah($_POST['tahun1']);
	$e_status = cegah($_POST['e_status']);


	//netralkan semua dulu
	mysqli_query($koneksi, "UPDATE m_tapel SET aktif = 'false'");




	//nek null
	if (empty($tahun1)) {
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan, $filenya);
		exit();
	} else {
		//jika baru
		if (empty($s)) {
			//cek
			$qcc = mysqli_query($koneksi, "SELECT * FROM m_tapel " .
				"WHERE nama = '$tahun1'");
			$rcc = mysqli_fetch_assoc($qcc);
			$tcc = mysqli_num_rows($qcc);

			//nek ada
			if ($tcc != 0) {
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Sudah Ada. Silahkan Ganti Yang Lain...!!";
				pekem($pesan, $filenya);
				exit();
			} else {
				//query
				mysqli_query($koneksi, "INSERT INTO m_tapel(kd, nama, aktif, postdate) VALUES " .
					"('$x', '$tahun1', '$e_status', '$today')");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				xloc($filenya);
				exit();
			}
		}

		//jika update
		else if ($s == "edit") {
			//query
			mysqli_query($koneksi, "UPDATE m_tapel SET nama = '$tahun1', " .
				"aktif = '$e_status', " .
				"postdate = '$today' " .
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


//jika hapus
if ($_POST['btnHPS']) {
	//ambil nilai
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i = 1; $i <= $jml; $i++) {
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysqli_query($koneksi, "DELETE FROM m_tapel " .
			"WHERE kd = '$kd'");
	}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//isi *START
ob_start();

//query
$q = mysqli_query($koneksi, "SELECT * FROM m_tapel " .
	"ORDER BY nama ASC");
$row = mysqli_fetch_assoc($q);
$total = mysqli_num_rows($q);
?>



<script>
	$(document).ready(function() {
		$('#table-responsive').dataTable({
			"scrollX": true
		});
	});
</script>

<?php
//js
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
require("../../inc/js/number.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo
'<form action="' . $filenya . '" method="post" name="formx">
	<p>
	Tahun Pelajaran : 
	<br>
	<input name="tahun1" type="text" value="' . $tahun1 . '" size="20" class="btn btn-warning">
	</p>

	<p>
	Status :
	<br>
	<select name="e_status" class="btn btn-warning">
	<option value="' . $e_status . '" selected>' . $e_status_ket . '</option>
	<option value="true">Aktif</option>
	<option value="false">Tidak Aktif</option>
	</select>
	</p>

	<p>
	<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
	<input name="btnBTL" type="submit" value="BATAL" class="btn btn-primary">
	</p>';

if ($total != 0) {
	echo '<div class="table-responsive">          
		<table class="table" border="1">
		<thead>

		<tr valign="top" bgcolor="' . $warnaheader . '">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><strong><font color="' . $warnatext . '">Tahun Pelajaran</font></strong></td>
		<td><strong><font color="' . $warnatext . '">Status</font></strong></td>
		</tr>
		</thead>
		<tbody>';

	do {
		if ($warna_set == 0) {
			$warna = $warna01;
			$warna_set = 1;
		} else {
			$warna = $warna02;
			$warna_set = 0;
		}

		$nomer = $nomer + 1;
		$kd = nosql($row['kd']);
		$tahun1 = balikin($row['nama']);
		$e_status = balikin($row['aktif']);

		//jika true
		if ($e_status == "true") {
			$e_status_ket = "Aktif";
		} else if ($e_status == "false") {
			$e_status_ket = "Tidak Aktif";
		}


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td width="1">
		<input type="checkbox" name="item' . $nomer . '" value="' . $kd . '">
        </td>
		<td width="5">
		<a href="' . $filenya . '?s=edit&kd=' . $kd . '">
		<img src="' . $sumber . '/img/edit.gif" width="16" height="16" border="0">
		</a>
		</td>
		<td>' . $tahun1 . '</td>
		<td>' . $e_status_ket . '</td>
        </tr>';
	} while ($row = mysqli_fetch_assoc($q));

	echo '</tbody>
	</table>
	</div>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	<input name="jml" type="hidden" value="' . $total . '">
	<input name="s" type="hidden" value="' . $s . '">
	<input name="kd" type="hidden" value="' . $kdx . '">
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll(' . $total . ')" class="btn btn-success">
	<input name="btnBTL" type="reset" value="BATAL" class="btn btn-primary">
	<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-danger">
	</td>
	</tr>
	</table>';
} else {
	echo '<p>
	<font color="red">
	<strong>TIDAK ADA DATA. Silahkan Entry Dahulu...!!</strong>
	</font>
	</p>';
}

echo '</form>';
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