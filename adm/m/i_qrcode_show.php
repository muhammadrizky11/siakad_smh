<?php
//error reporting //////////////////////////////////////////////////////////////////////////////
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL & ~E_NOTICE);
//error reporting //////////////////////////////////////////////////////////////////////////////




//ambil nilai
require("../../inc/fungsi.php");
require("../../inc/config.php");
require("../../inc/koneksi.php");


//ambil nilai
$pesanku1 = trim(cegah2($_POST['pesanku']));
$pesanku2 = balikin2($pesanku1);

 
//pecah
$pecahku = $pesanku2;
$nilku2 = $pecahku;


$qrimage = "../../filebox/qrcode/$nilku2.png";
echo '<img src="'.$qrimage.'" width="200" height="200">';

exit;
?>