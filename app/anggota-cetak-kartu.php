<?php

	include '../config/koneksi-db.php';

	if(isset($_GET['id'])) { // memperoleh anggota_id
		$id_anggota = $_GET['id'];

		if(!empty($id_anggota)) {
			// Query
			$sql = "SELECT * FROM anggota WHERE id_anggota = '{$id_anggota}';";
			$query = mysqli_query($db_conn, $sql);
			$row = $query->num_rows;
			
			if($row > 0) {
				$data = mysqli_fetch_array($query); // memperoleh data anggota
				$data_foto = $data['foto'];
				if($data_foto == '-') {
					$data_foto = 'foto-default.jpg';
				}

				$id_anggota = $data['id_anggota'];
				$nama = $data['nama_lengkap'];
				$alamat = $data['alamat'];

				$jenis_kelamin = "Wanita";
				if($data['jenis_kelamin'] == "L"){
					$jenis_kelamin = 'Pria';
				}

			}
		}

$html = '
 <!DOCTYPE html>
  <html lang="en">
  <head>
  	<title> Kartu Anggota '. $id_anggota .'</title>
  	<link rel="stylesheet" href="../assets/vendor/bootstrap-4.3/css/bootstrap.css">
  	<style type="text/css">
  		* {
  			box-sizing: border-box;
  		}
 		.box {
 			margin: 5px auto;
 			width: 500px;
 			height: 296px;
 		}
 		#card {
 			margin: 10px 10px;
 			padding: 5px;
 			float: left;
 			width: 100%;
 		}
 		table {
 			width: 75%;
 			float: left;
 		}
 		table, tr, td {
 			vertical-align: top;
 		}
 		tr td p {
 			line-height: 16px;
 		}
 		tr td {
 			text-align: left;
 			vertical-align: top;
 		}
 		#member-photo {
 			float: right;
 			margin-top: 10px;
 		}
 	</style>
 </head>
 <body>
 	<div class="box">
		<h1 class="text-center">Kartu Anggota Perpustakaan</h1>
		<div id="card">
	 		<table>
	 			<tr>
	 				<td><p>ID Anggota</p></td>
	 				<td><p>: ' . $id_anggota . '</p></td>
	 			</tr>
	 			<tr>
	 				<td><p>Nama</p></td>
	 				<td><p>: ' . $nama . '</p></td>
	 			</tr>
	 			<tr>
	 				<td><p>Jenis Kelamin</p></td>
	 				<td><p>: ' . $jenis_kelamin . '</p></td>
	 			</tr>
	 			<tr>
	 				<td><p>Alamat</p></td>
	 				<td><p>: ' . $alamat . '</p></td>
	 			</tr>
	 		</table>
 		<div>
 		<div id="member-photo">
			<img src="../images/' . $data_foto . '" width="100">
		</div>
 	</div>
 </body>
 </html>';

 } else {
			echo "<script>alert('ID Anggota kosong!');</script>";
			// mengalihkan halaman
			echo "<meta http-equiv='refresh' content='0; url=../index.php?p=anggota'>";
			exit;
		}


require '../assets/vendor/autoload.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();

define("DOMPDF_UNICODE", true);

$dompdf->set_option('isRemoteEnabled', true);

$dompdf->loadHtml($html);
$dompdf->setPaper('A5', 'landscape');
$dompdf->render();
$dompdf->stream("Kartu Anggota", array("Attachment" => 0));
?>