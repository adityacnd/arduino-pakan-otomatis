<?php
//include koneksi
include "koneksi.php";

$sql = mysqli_query($konek, "SELECT * FROM tb_kontrol");
$data = mysqli_fetch_array($sql);
//ambil status servo
$servo = $data['servo'];

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

  <title>IOT Kontrol Servo</title>

  <script type="text/javascript">
    function ubahstatus(value) {
      var status = value ? "ON" : "OFF";
      document.getElementById('status').innerHTML = status;

      //ajax untuk merubah nilai status servo
      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          //ambil respon dari web setelah berhasil merubah nilai
          document.getElementById('status').innerHTML = xmlhttp.responseText;
        }
      }
      //execute file PHP untuk merubah nilai di database
      xmlhttp.open("GET", "servo.php?stat=" + status, true);
      //kirim data
      xmlhttp.send();
    }
  </script>

</head>

<body>

  <!-- Judul -->
  <div class="container" style="text-align: center; padding-top: 20px">
    <h2>UAS Piranti Cerdas <br> SISTEM SMART HOME PEMBERIAN PAKAN KUCING OTOMATIS  <br> BERBASIS WEBSITE</h2>
  </div>

  <!-- tampilan kartu -->
  <div class="container" style="display: flex; justify-content: center; padding-top: 20px">
    <!-- kartu servo -->
    <div class="card text-black mb-3" style="width: 25rem; margin-right: 20px">
      <div class="card-header" style="font-size: 30px; text-align: center; background-color: green; color: white">Servo</div>
      <div class="card-body">

        <!-- switch -->
        <div class="form-check form-switch" style="font-size: 40px">
          <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" onchange="ubahstatus(this.checked)" <?php if ($servo == "ON") echo "checked"; ?>>
          <label class="form-check-label" for="flexSwitchCheckDefault"> <span id="status"><?php echo $servo; ?></span> </label>
        </div>
        <!-- akhir switch -->

      </div>
    </div>
    <!-- akhir kartu servo -->
  </div>
  <!-- akhir tampilan kartu -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>

</html>
