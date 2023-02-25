<?php
	include '../config/koneksi-db.php';
	include '../config/konfigurasi-umum.php';

	$sql = "SELECT transaksi.id_transaksi, anggota.nama_lengkap, buku.judul_buku, transaksi.tanggal_pinjam, admin.nama_admin, transaksi.tanggal_kembali, transaksi.id_buku
			FROM (((transaksi
			INNER JOIN anggota ON transaksi.id_anggota = anggota.id_anggota)
			INNER JOIN buku ON transaksi.id_buku = buku.id_buku)
			INNER JOIN admin ON transaksi.id_admin = admin.id_admin)
			ORDER BY id_transaksi ASC";
	$query = mysqli_query($db_conn, $sql);
	$row = $query->num_rows;

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Semua Transaksi</title>
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
	
		$html .='<h3 class="text-center">Semua Transaksi</h3>

		<table>
			<tr>
				<th width="30">No.</th>
				<th width="80">ID Transaksi</th>
				<th width="100">Nama Anggota</th>
				<th width="150">Judul Buku</th>
				<th width="80">Tanggal Pinjam</th>
				<th width="80">Tanggal Kembali</th>
				<th width="70">Status</th>
				<th width="70">Admin</th>
			</tr>';
		
			$i = 1;
			while($data = mysqli_fetch_array($query)) {

				$status = 'Sudah Kembali';
				if($data['tanggal_kembali'] == null){
					$status = 'Belum Kembali';
				}

			$html .= '
			<tr>
				<td class="text-center">' . $i++ . '</td>
				<td class="text-center">' . $data['id_transaksi'] . '</td>
				<td>' . $data['nama_lengkap'] . '</td>
				<td>' . $data['judul_buku'] . '</td>
				<td class="text-center">' . $data['tanggal_pinjam'] . '</td>
				<td class="text-center">' . $data['tanggal_kembali'] . '</td>
				<td class="text-center">' . $status . '</td>	
				<td>' . $data['nama_admin'] . '</td>
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
$dompdf->stream("Semua Transaksi", array("Attachment" => 0));
?>