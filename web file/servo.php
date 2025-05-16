<?php
//include koneksi
include "koneksi.php";

if(isset($_GET['stat'])) {
  $status = $_GET['stat'];

  //update status servo di database
  mysqli_query($konek, "UPDATE tb_kontrol SET servo='$status'");

  echo $status;
}
?>
