<?php	

	if(!isset($_POST['simpan'])) {
		if(isset($_GET['id'])) { // memperoleh buku_id
			$id_buku = $_GET['id'];

			if(!empty($id_buku)) {
				// Query
				$sql = "SELECT * FROM buku WHERE id_buku = '{$id_buku}';";
				$query = mysqli_query($db_conn, $sql);
				$row = $query->num_rows;

				// Query Kategori
				$sql_kategori = "SELECT * FROM kategori ORDER BY nama_kategori;";
				$query_kategori = mysqli_query($db_conn, $sql_kategori);
				$row_kategori = $query_kategori->num_rows;
				// Query Penulis
				$sql_penulis = "SELECT * FROM penulis ORDER BY nama_penulis;";
				$query_penulis = mysqli_query($db_conn, $sql_penulis);
				$row_penulis = $query_penulis->num_rows;
				// Query Penerbit
				$sql_penerbit = "SELECT * FROM penerbit ORDER BY nama_penerbit;";
				$query_penerbit = mysqli_query($db_conn, $sql_penerbit);
				$row_penerbit = $query_penerbit->num_rows;

				if($row > 0) {
					$data = mysqli_fetch_array($query); // memperoleh data buku

					// echo '<pre>';
					// var_dump($data);
					// echo '</pre>';
				} else {
					echo "<script>alert('ID Buku tidak ditemukan!');</script>";

					// mengalihkan halaman
					echo "<meta http-equiv='refresh' content='0; url=index.php?p=buku'>";
					exit;
				}
			} else {
				echo "<script>alert('ID Buku kosong!');</script>";

				// mengalihkan halaman
				echo "<meta http-equiv='refresh' content='0; url=index.php?p=buku'>";
				exit;
			}
		} else {
			echo "<script>alert('ID Buku tidak didefinisikan!');</script>";

			// mengalihkan halaman
			echo "<meta http-equiv='refresh' content='0; url=index.php?p=buku'>";
			exit;
		}
?>

		<div id="container">
			<div class="page-title">
				<h3>Ubah Data Buku</h3>	
			</div>
			<div class="page-content">
				<form action="" method="post" enctype="multipart/form-data">
					<table class="form-table">
						<tr>
							<td>
								<label for="id_buku">ID Buku</label>
							</td>
							<td>					
								<input class="form-control mb-2" type="text" name="id_buku" id="id_buku" value="<?php echo $data['id_buku']; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label for="judul_buku">Judul Buku</label>
							</td>
							<td>								
								<input class="form-control mb-2" type="text" name="judul_buku" id="judul_buku" value="<?php echo $data['judul_buku']; ?>" required
								oninvalid="this.setCustomValidity('Isi Judul Buku!')"
 								oninput="setCustomValidity('')">
							</td>
						</tr>
						<tr>
							<td>
								<label for="id_kategori">Kategori</label>
							</td>
							<td>
								<select class="form-control mb-2" name="id_kategori" id="id_kategori" required>
									<?php 
										while($data_kategori = mysqli_fetch_array($query_kategori)){ 
									 ?>
								    	<option value="<?= $data_kategori['id_kategori']; ?>" <?php echo ($data['id_kategori'] == $data_kategori['id_kategori']) ? 'selected' : ''; ?>><?= $data_kategori['nama_kategori']; ?></option>
								    <?php 
										}
								    ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<label for="id_penulis">Nama Penulis</label>
							</td>
							<td>								
								<select class="form-control mb-2" name="id_penulis" id="id_penulis" required>
									<?php 
										while($data_penulis = mysqli_fetch_array($query_penulis)){ 
									 ?>
								    	<option value="<?= $data_penulis['id_penulis']; ?>" <?php echo ($data['id_penulis'] == $data_penulis['id_penulis']) ? 'selected' : ''; ?>><?= $data_penulis['nama_penulis']; ?></option>
								    <?php 
										}
								    ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<label for="id_penerbit">Nama Penerbit</label>
							</td>
							<td>								
								<select class="form-control mb-2" name="id_penerbit" id="id_penerbit" required>
									<?php 
										while($data_penerbit = mysqli_fetch_array($query_penerbit)){ 
									 ?>
								    	<option value="<?= $data_penerbit['id_penerbit']; ?>" <?php echo ($data['id_penerbit'] == $data_penerbit['id_penerbit']) ? 'selected' : ''; ?>><?= $data_penerbit['nama_penerbit']; ?></option>
								    <?php 
										}
								    ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<label>Status</label>
							</td>
							<td>								
								<input type="radio" name="status" value="Tersedia" id="tersedia" <?php echo ($data['status'] == 'Tersedia') ? 'checked' : ''; ?> required>
								<label for="tersedia"><span class="badge badge-success">Tersedia</span></label>

								<input type="radio" class="ml-1" name="status" value="Dipinjam" id="dipinjam" <?php echo ($data['status'] == 'Dipinjam') ? 'checked' : ''; ?> required>
								<label for="dipinjam"><span class="badge badge-secondary">Dipinjam</span></label>
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

		$id_buku 	= $_POST['id_buku'];
		$judul_buku	= $_POST['judul_buku'];
		$id_kategori = $_POST['id_kategori'];
		$id_penulis = $_POST['id_penulis'];
		$id_penerbit = $_POST['id_penerbit'];
		$status = $_POST['status'];

		// Query
		$sql = "UPDATE buku 
					SET judul_buku 	= '{$judul_buku}',
					 	id_kategori	= '{$id_kategori}',
					 	id_penulis	= '{$id_penulis}',
					 	id_penerbit	= '{$id_penerbit}',
					 	status		= '{$status}'
					WHERE id_buku	='{$id_buku}'";
		$query = mysqli_query($db_conn, $sql);

		
		if(!$query) {
			echo "<script>alert('Data gagal diubah!');</script>";
		}

		// mengalihkan halaman
		echo "<meta http-equiv='refresh' content='0; url=index.php?p=buku'>";
	}
?>