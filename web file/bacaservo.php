<?php
	//include koneksi
	include "koneksi.php";

	$sql = mysqli_query($konek, "SELECT * FROM tb_kontrol");
	$data = mysqli_fetch_array($sql);
	$servo = $data['servo'];
	//reponse balik ke nodemcu
	echo $servo;    // 1 / 0
?>