<?php

	include '../config/koneksi-db.php';
	
	//Query Anggota
	$sql = "SELECT * FROM anggota ORDER BY id_anggota ASC;";
	$query = mysqli_query($db_conn, $sql);
	$row = $query->num_rows;

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Daftar Anggota</title>
	<style>
		* { margin: 0; font-family: Arial, Helvetica, sans-serif; }
		h3 { text-align: center; margin: 15px; text-decoration: underline; }
		section { margin: 0 auto; width: 960px; }
		table { border-collapse: collapse; }
		table, table th, table td { padding: 5px; border: 1px solid #CCC; }
		.text-center { text-align: center; }
	</style>
</head>
<body>
	<section>';
	
		if($row > 0) {
	
		$html .='<h3 class="text-center">Daftar Anggota Perpustakaan</h3>

		<table>
			<tr>
				<th width="30">No.</th>
				<th width="70">ID Anggota</th>
				<th width="120">Nama Lengkap</th>
				<th width="70">Foto</th>
				<th width="100">Jenis Kelamin</th>
				<th width="170">Alamat</th>
				<th width="100">Status Aktif</th>
			</tr>';
		
			$i = 1;
			while($data = mysqli_fetch_array($query)) {
			$html .= '
			<tr class="text-center">
				<td class="text-center">' . $i++ . '</td>
				<td class="text-center">' . $data['id_anggota'] . '</td>
				<td>' . $data['nama_lengkap'] . '</td>
				<td>';
					$data_foto = $data['foto'];
					if($data_foto == '-') {
						$data_foto = 'foto-default.jpg';
					}
			$html .=
				'<img src="../images/' . $data_foto . '" width="60">
				</td>
				<td>';
					$jenis_kelamin = 'Wanita';
					if($data['jenis_kelamin'] == 'L') {
						$jenis_kelamin = 'Pria';
					}
			$html .=
				$jenis_kelamin . '
				</td>
				<td>' . $data['alamat'] . '</td>
				<td>';
					$status_aktif = 'Tidak Aktif';
					if($data['status_aktif'] == 'Y') {
						$status_aktif = 'Aktif';
					}
			$html .=
				$status_aktif . '
				</td>
			</tr>';
			}
		$html .= '
		</table>
	</section>';
	
		}
$html .= '
</body>
</html>';


require '../assets/vendor/autoload.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();

define("DOMPDF_UNICODE", true);

$dompdf->set_option('isRemoteEnabled', true);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Daftar Anggota", array("Attachment" => 0));
?>