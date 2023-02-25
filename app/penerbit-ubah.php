<?php

	if(!isset($_POST['simpan'])) {
		if(isset($_GET['id'])) { // memperoleh penerbit_id
			$id_penerbit = $_GET['id'];

			if(!empty($id_penerbit)) {
				// Query
				$sql = "SELECT * FROM penerbit WHERE id_penerbit = '{$id_penerbit}';";
				$query = mysqli_query($db_conn, $sql);
				$row = $query->num_rows;

				if($row > 0) {
					$data = mysqli_fetch_array($query); // memperoleh data penerbit

					// echo '<pre>';
					// var_dump($data);
					// echo '</pre>';
				} else {
					echo "<script>alert('ID Penerbit tidak ditemukan!');</script>";

					// mengalihkan halaman
					echo "<meta http-equiv='refresh' content='0; url=index.php?p=penerbit'>";
					exit;
				}
			} else {
				echo "<script>alert('ID Penerbit kosong!');</script>";

				// mengalihkan halaman
				echo "<meta http-equiv='refresh' content='0; url=index.php?p=penerbit'>";
				exit;
			}
		} else {
			echo "<script>alert('ID Penerbit tidak didefinisikan!');</script>";

			// mengalihkan halaman
			echo "<meta http-equiv='refresh' content='0; url=index.php?p=penerbit'>";
			exit;
		}
?>

		<div id="container">
			<div class="page-title">
				<h3>Ubah Data Penerbit</h3>	
			</div>
			<div class="page-content">
				<form action="" method="post" enctype="multipart/form-data">
					<table class="form-table">
						<tr>
							<td>
								<label for="id_penerbit">ID Penerbit</label>
							</td>
							<td>					
								<input class="form-control mb-2" type="text" name="id_penerbit" id="id_penerbit" value="<?php echo $data['id_penerbit']; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label for="nama_penerbit">Nama Lengkap</label>
							</td>
							<td>								
								<input class="form-control mb-3" type="text" name="nama_penerbit" id="nama_penerbit" value="<?php echo $data['nama_penerbit']; ?>" required
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
		$sql = "UPDATE penerbit 
					SET nama_penerbit 	= '{$nama_penerbit}'
					WHERE id_penerbit	='{$id_penerbit}'";
		$query = mysqli_query($db_conn, $sql);
		
		if(!$query) {
			echo "<script>alert('Data gagal diubah!');</script>";
		}

		// mengalihkan halaman
		echo "<meta http-equiv='refresh' content='0; url=index.php?p=penerbit'>";
	}
?>