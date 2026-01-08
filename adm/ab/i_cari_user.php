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

//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");



//nilai
$filenya = "$sumber/adm/ps/i_cari_user.php";
$filenyax = "$sumber/adm/ps/i_cari_user.php";
$judul = "cari nama";
$juduli = $judul;




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nilai
$searchTerm = cegah($_GET['query']);


$query = "SELECT * FROM m_user ".
			"WHERE kode LIKE '%".$searchTerm."%' ".
			"OR nama LIKE '%".$searchTerm."%' ".
			"ORDER BY nama ASC";
$result = mysqli_query($koneksi, $query);

$data = array();


if (mysqli_num_rows($result) > 0)
    {
    while ($row = mysqli_fetch_assoc($result))
	    {
	    $i_nip = balikin($row["kode"]);
	    $i_nama = balikin($row["nama"]);
	    $i_jabatan = balikin($row["jabatan"]);
	    $data[] = "NAMA:$i_nama NIP/NIS:$i_nip JABATAN:$i_jabatan";
	    }

    echo json_encode($data);

	}



exit();
?>