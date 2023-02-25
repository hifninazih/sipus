<?php

	/* Kondisi jika tidak melakukan simpan/ submit, maka tampilkan formulir */
	if(!isset($_POST['simpan'])) {
		/* Mempersiapkan ID Penerbit Baru */
		//01. Menggunakan referensi id terbesar 
		$sql_hitung = "SELECT id_penerbit FROM penerbit ORDER BY id_penerbit DESC LIMIT 1;";
		$query_hitung = mysqli_query($db_conn, $sql_hitung);
		$query_row = $query_hitung->num_rows;

		if($query_row === 0){
			$row = 0;
		} else {
			$fetch_hitung = mysqli_fetch_assoc($query_hitung);
			$last_id_penerbit = $fetch_hitung['id_penerbit'];
			//Match regex
			preg_match('/^PN(.+[^0(\d)]?$)/i', $last_id_penerbit, $matches);
			$match = $matches[1];
			$row = (int)$match;
		}

		//02. Menggunakan jumlah data sebagai referensi (tidak disarankan, karena akan bentrok jika data sudah ada yang dihapus)
		// $sql = "SELECT id_penerbit FROM penerbit;";
		// $query = mysqli_query($db_conn, $sql);
		// $row = $query->num_rows;

		$id_penerbit_tmp = $row + 1; // Menambahkan +1 untuk ID Anggota Baru
		$id_penerbit_tmp = str_pad($id_penerbit_tmp, 3, "0", STR_PAD_LEFT); // Menambahkan "0" sampai panjang 3 digit termasuk ID Anggota Baru
		$id_penerbit_tmp = 'PN' . $id_penerbit_tmp; // Menambahkan prefix 'PN' untuk ID Anggota Baru
?>

		<div id="container">
			<div class="page-title">
				<h3>Tambah Data Penerbit</h3>	
			</div>
			<div class="page-content">
				<form action="" method="post" enctype="multipart/form-data">
					<table class="form-table">
						<tr>
							<td>
								<label for="id_penerbit">ID Penerbit</label>
							</td>
							<td>					
								<input class="form-control mb-2" type="text" name="id_penerbit" id="id_penerbit" value="<?php echo $id_penerbit_tmp; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label for="nama_penerbit">Nama Penerbit</label>
							</td>
							<td>								
								<input class="form-control mb-3" type="text" name="nama_penerbit" id="nama_penerbit" placeholder="Isi nama penerbit..." required
								oninvalid="this.setCustomValidity('Isi Nama Penerbit!')"
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

		$id_penerbit 	= $_POST['id_penerbit'];
		$nama_penerbit 	= $_POST['nama_penerbit'];

		// Query
		$sql = "INSERT INTO penerbit 
				VALUES('{$id_penerbit}', '{$nama_penerbit}')";
		$query = mysqli_query($db_conn, $sql);



		// mengalihkan halaman
		echo "<meta http-equiv='refresh' content='0; url=index.php?p=penerbit'>";
	}
?>