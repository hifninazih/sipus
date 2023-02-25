<?php

	if(!isset($_POST['simpan'])) {
		if(isset($_GET['id'])) { // memperoleh penulis_id
			$id_penulis = $_GET['id'];

			if(!empty($id_penulis)) {
				// Query
				$sql = "SELECT * FROM penulis WHERE id_penulis = '{$id_penulis}';";
				$query = mysqli_query($db_conn, $sql);
				$row = $query->num_rows;

				if($row > 0) {
					$data = mysqli_fetch_array($query); // memperoleh data penulis

					// echo '<pre>';
					// var_dump($data);
					// echo '</pre>';
				} else {
					echo "<script>alert('ID Penulis tidak ditemukan!');</script>";

					// mengalihkan halaman
					echo "<meta http-equiv='refresh' content='0; url=index.php?p=penulis'>";
					exit;
				}
			} else {
				echo "<script>alert('ID Penulis kosong!');</script>";

				// mengalihkan halaman
				echo "<meta http-equiv='refresh' content='0; url=index.php?p=penulis'>";
				exit;
			}
		} else {
			echo "<script>alert('ID Penulis tidak didefinisikan!');</script>";

			// mengalihkan halaman
			echo "<meta http-equiv='refresh' content='0; url=index.php?p=penulis'>";
			exit;
		}
?>

		<div id="container">
			<div class="page-title">
				<h3>Ubah Data Penulis</h3>	
			</div>
			<div class="page-content">
				<form action="" method="post" enctype="multipart/form-data">
					<table class="form-table">
						<tr>
							<td>
								<label for="id_penulis">ID Penulis</label>
							</td>
							<td>					
								<input class="form-control mb-2" type="text" name="id_penulis" id="id_penulis" value="<?php echo $data['id_penulis']; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label for="nama_penulis">Nama Lengkap</label>
							</td>
							<td>								
								<input class="form-control mb-3" type="text" name="nama_penulis" id="nama_penulis" value="<?php echo $data['nama_penulis']; ?>" required
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
		$sql = "UPDATE penulis 
					SET nama_penulis 	= '{$nama_penulis}'
					WHERE id_penulis	='{$id_penulis}'";
		$query = mysqli_query($db_conn, $sql);
		
		if(!$query) {
			echo "<script>alert('Data gagal diubah!');</script>";
		}

		// mengalihkan halaman
		echo "<meta http-equiv='refresh' content='0; url=index.php?p=penulis'>";
	}
?>