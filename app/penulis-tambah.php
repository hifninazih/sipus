<?php

	/* Kondisi jika tidak melakukan simpan/ submit, maka tampilkan formulir */
	if(!isset($_POST['simpan'])) {
		/* Mempersiapkan ID Anggota Baru */
		//01. Menggunakan referensi id terbesar 
		$sql_hitung = "SELECT id_penulis FROM penulis ORDER BY id_penulis DESC LIMIT 1;";
		$query_hitung = mysqli_query($db_conn, $sql_hitung);
		$query_row = $query_hitung->num_rows;

		if($query_row === 0){
			$row = 0;
		} else {
			$fetch_hitung = mysqli_fetch_assoc($query_hitung);
			$last_id_penulis = $fetch_hitung['id_penulis'];
			//Match regex
			preg_match('/^PL(.+[^0(\d)]?$)/i', $last_id_penulis, $matches);
			$match = $matches[1];
			$row = (int)$match;
		}

		//02. Menggunakan jumlah data sebagai referensi (tidak disarankan, karena akan bentrok jika data sudah ada yang dihapus)
		$sql = "SELECT id_penulis FROM penulis;";
		$query = mysqli_query($db_conn, $sql);
		$row = $query->num_rows;

		$id_penulis_tmp = $row + 1; // Menambahkan +1 untuk ID Anggota Baru
		$id_penulis_tmp = str_pad($id_penulis_tmp, 3, "0", STR_PAD_LEFT); // Menambahkan "0" sampai panjang 3 digit termasuk ID Anggota Baru
		$id_penulis_tmp = 'PL' . $id_penulis_tmp; // Menambahkan prefix 'PL' untuk ID Anggota Baru
?>

		<div id="container">
			<div class="page-title">
				<h3>Tambah Data Penulis</h3>	
			</div>
			<div class="page-content">
				<form action="" method="post" enctype="multipart/form-data">
					<table class="form-table">
						<tr>
							<td>
								<label for="id_penulis">ID Penulis</label>
							</td>
							<td>					
								<input class="form-control mb-2" type="text" name="id_penulis" id="id_penulis" value="<?php echo $id_penulis_tmp; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label for="nama_penulis">Nama Penulis</label>
							</td>
							<td>								
								<input class="form-control mb-3" type="text" name="nama_penulis" id="nama_penulis" placeholder="Isi nama penulis..." required
								oninvalid="this.setCustomValidity('Isi Nama Penulis!')"
 								oninput="setCustomValidity('')">
							</td>
						</tr>
						<tr>
							<td>
								&nbsp;
							</td>
							<td>								
								<input class="btn btn-primary" type="submit" name="simpan" value="Simpan">
							</td>
						</tr>						
					</table>
				</form>
			</div>
		</div>

<?php 
	} else { 
		/* Proses Penyimpanan Data dari Form */

		$id_penulis 	= $_POST['id_penulis'];
		$nama_penulis 	= $_POST['nama_penulis'];

		// Query
		$sql = "INSERT INTO penulis 
				VALUES('{$id_penulis}', '{$nama_penulis}')";
		$query = mysqli_query($db_conn, $sql);



		// mengalihkan halaman
		echo "<meta http-equiv='refresh' content='0; url=index.php?p=penulis'>";
	}
?>