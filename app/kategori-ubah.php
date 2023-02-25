<?php

	if(!isset($_POST['simpan'])) {
		if(isset($_GET['id'])) { // memperoleh kategori_id
			$id_kategori = $_GET['id'];

			if(!empty($id_kategori)) {
				// Query
				$sql = "SELECT * FROM kategori WHERE id_kategori = '{$id_kategori}';";
				$query = mysqli_query($db_conn, $sql);
				$row = $query->num_rows;

				if($row > 0) {
					$data = mysqli_fetch_array($query); // memperoleh data kategori

					// echo '<pre>';
					// var_dump($data);
					// echo '</pre>';
				} else {
					echo "<script>alert('ID Kategori tidak ditemukan!');</script>";

					// mengalihkan halaman
					echo "<meta http-equiv='refresh' content='0; url=index.php?p=kategori'>";
					exit;
				}
			} else {
				echo "<script>alert('ID Kategori kosong!');</script>";

				// mengalihkan halaman
				echo "<meta http-equiv='refresh' content='0; url=index.php?p=kategori'>";
				exit;
			}
		} else {
			echo "<script>alert('ID Kategori tidak didefinisikan!');</script>";

			// mengalihkan halaman
			echo "<meta http-equiv='refresh' content='0; url=index.php?p=kategori'>";
			exit;
		}
?>

		<div id="container">
			<div class="page-title">
				<h3>Ubah Data Kategori</h3>	
			</div>
			<div class="page-content">
				<form action="" method="post" enctype="multipart/form-data">
					<table class="form-table">
						<tr>
							<td>
								<label for="id_kategori">ID Kategori</label>
							</td>
							<td>					
								<input class="form-control mb-2" type="text" name="id_kategori" id="id_kategori" value="<?php echo $data['id_kategori']; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label for="nama_kategori">Nama Kategori</label>
							</td>
							<td>								
								<input class="form-control mb-3" type="text" name="nama_kategori" id="nama_kategori" value="<?php echo $data['nama_kategori']; ?>" required
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
		$sql = "UPDATE kategori 
					SET nama_kategori 	= '{$nama_kategori}'
					WHERE id_kategori	='{$id_kategori}'";
		$query = mysqli_query($db_conn, $sql);
		
		if(!$query) {
			echo "<script>alert('Data gagal diubah!');</script>";
		}

		// mengalihkan halaman
		echo "<meta http-equiv='refresh' content='0; url=index.php?p=kategori'>";
	}
?>