<?php

	/* Kondisi jika tidak melakukan simpan/ submit, maka tampilkan formulir */
	if(!isset($_POST['simpan'])) {
		/* Mempersiapkan ID Kategori Baru */
		//01. Menggunakan referensi id terbesar 
		$sql_hitung = "SELECT id_kategori FROM kategori ORDER BY id_kategori DESC LIMIT 1;";
		$query_hitung = mysqli_query($db_conn, $sql_hitung);
		$query_row = $query_hitung->num_rows;

		if($query_row === 0){
			$row = 0;
		} else {
			$fetch_hitung = mysqli_fetch_assoc($query_hitung);
			$last_id_kategori = $fetch_hitung['id_kategori'];
			//Match regex
			preg_match('/^KT(.+[^0(\d)]?$)/i', $last_id_kategori, $matches);
			$match = $matches[1];
			$row = (int)$match;
		}

		//02. Menggunakan jumlah data sebagai referensi (tidak disarankan, karena akan bentrok jika data sudah ada yang dihapus)
		// $sql = "SELECT id_kategori FROM kategori;";
		// $query = mysqli_query($db_conn, $sql);
		// $row = $query->num_rows;

		$id_kategori_tmp = $row + 1; // Menambahkan +1 untuk ID Anggota Baru
		$id_kategori_tmp = str_pad($id_kategori_tmp, 3, "0", STR_PAD_LEFT); // Menambahkan "0" sampai panjang 3 digit termasuk ID Anggota Baru
		$id_kategori_tmp = 'KT' . $id_kategori_tmp; // Menambahkan prefix 'KT' untuk ID Anggota Baru
?>

		<div id="container">
			<div class="page-title">
				<h3>Tambah Data Kategori</h3>	
			</div>
			<div class="page-content">
				<form action="" method="post" enctype="multipart/form-data">
					<table class="form-table">
						<tr>
							<td>
								<label for="id_kategori">ID Kategori</label>
							</td>
							<td>					
								<input class="form-control mb-2" type="text" name="id_kategori" id="id_kategori" value="<?php echo $id_kategori_tmp; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label for="nama_kategori">Nama Kategori</label>
							</td>
							<td>								
								<input class="form-control mb-3" type="text" name="nama_kategori" id="nama_kategori" placeholder="Isi kategori..." required
								oninvalid="this.setCustomValidity('Isi Nama Kategori!')"
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

		$id_kategori 	= $_POST['id_kategori'];
		$nama_kategori 	= $_POST['nama_kategori'];

		// Query
		$sql = "INSERT INTO kategori 
				VALUES('{$id_kategori}', '{$nama_kategori}')";
		$query = mysqli_query($db_conn, $sql);



		// mengalihkan halaman
		echo "<meta http-equiv='refresh' content='0; url=index.php?p=kategori'>";
	}
?>