<?php	

	if(!isset($_POST['simpan'])) {
		if(isset($_GET['id'])) { // memperoleh buku_id
			$id_transaksi = $_GET['id'];

			if(!empty($id_transaksi)) {
				// Query Umum
				$sql = "SELECT * FROM transaksi WHERE id_transaksi = '{$id_transaksi}';";
				$query = mysqli_query($db_conn, $sql);
				$row = $query->num_rows;

				// Query Buku All
				$sql_buku_all = "SELECT * FROM buku 
						 	 ORDER BY judul_buku;";
				$query_buku_all = mysqli_query($db_conn, $sql_buku_all);
				$row_buku_all = $query_buku_all->num_rows;

				// Query Anggota All
				$sql_anggota_all = "SELECT * FROM anggota
									ORDER BY nama_lengkap;";
				$query_anggota_all = mysqli_query($db_conn, $sql_anggota_all);
				$row_anggota_all = $query_anggota_all->num_rows;

				// Query Buku Tersedia
				$sql_buku = "SELECT * FROM buku 
					 		 WHERE status = 'Tersedia'
						 	 ORDER BY judul_buku;";
				$query_buku = mysqli_query($db_conn, $sql_buku);
				$row_buku = $query_buku->num_rows;

				// Query Anggota Aktif
				$sql_anggota = "SELECT * FROM anggota
								WHERE status_aktif = 'Y'
								ORDER BY nama_lengkap;";
				$query_anggota = mysqli_query($db_conn, $sql_anggota);
				$row_anggota = $query_anggota->num_rows;

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
				<h3>Ubah Transaksi Peminjaman</h3>	
			</div>
			<div class="page-content">
				<form action="" method="post" enctype="multipart/form-data">
					<table class="form-table">
						<tr>
							<td>
								<label for="id_buku">ID Transaksi</label>
							</td>
							<td>					
								<input class="form-control mb-2" type="text" name="id_transaksi" id="id_transaksi" value="<?php echo $data['id_transaksi']; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label for="id_anggota">Nama Anggota</label>
							</td>
							<td>
								<select class="form-control mb-2" name="id_anggota" id="id_anggota" required>
									<?php
										global $anggota_now;
										$anggota_now = '';
										while($data_anggota_all = mysqli_fetch_array($query_anggota_all)){
											if($data_anggota_all['id_anggota'] == $data['id_anggota']){
												$anggota_now = $data_anggota_all['id_anggota'];
									 ?>
								    			<option value="<?= $data_anggota_all['id_anggota']; ?>" selected><?= $data_anggota_all['nama_lengkap']; ?></option>
								    <?php 
								    		}
										}
								    ?>
								    			

									<?php
									
										while($data_anggota = mysqli_fetch_array($query_anggota)){

											if($anggota_now != $data_anggota['id_anggota']){
									 ?>
								    			<option value="<?= $data_anggota['id_anggota']; ?>"><?= $data_anggota['nama_lengkap']; ?></option>
								    <?php 
								    		}
										}
								    ?>
								</select>
									<?php
										if($row_anggota == 0){
									?>		
										<small class="form-text mb-2" style="color: red;">Tidak ada anggota lain yang aktif</small>
									<?php 
										}
									 ?>
							</td>
						</tr>

						<tr>
							<td>
								<label for="id_buku">Judul Buku</label>
							</td>
							<td>
								<select class="form-control mb-2" name="id_buku" id="id_buku" required <?php if($row_buku == 0){ echo 'disabled'; } ?> >
									<?php
										$id_buku_now = '';
										while($data_buku_all = mysqli_fetch_array($query_buku_all)){
											if($data_buku_all['id_buku'] == $data['id_buku']){
												$id_buku_now = $data_buku_all['id_buku'];
									 ?>
								    			<option value="<?= $data_buku_all['id_buku']; ?>" selected><?= $data_buku_all['judul_buku']; ?></option>
								    <?php 
								    		}
										}
								    ?>


									<?php
										while($data_buku = mysqli_fetch_array($query_buku)){
									 ?>
								    	<option value="<?= $data_buku['id_buku']; ?>"><?= $data_buku['judul_buku']; ?></option>
								    <?php 
										}
								    ?>
								</select>
								<input type="hidden" name="id_buku" value="<?= $id_buku_now; ?>">
									<?php
										if($row_buku == 0){
									?>		
										<small class="form-text mb-2" style="color: red;">Tidak tersedia buku yang lain</small>
									<?php 
										}
									 ?>
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

		

		// Query
			$sql = "SELECT * FROM transaksi WHERE id_transaksi = '{$_GET['id']}';";
			$query = mysqli_query($db_conn, $sql);
			$row = $query->num_rows;
			$data = mysqli_fetch_array($query);

			if($data['id_buku'] != $_POST['id_buku']){
				$id_buku_before = $data['id_buku'];
				$id_buku_after = $_POST['id_buku'];

				// Query Update Buku
				$sql_update_before = "UPDATE buku 
							   		  SET status 	= 'Tersedia'
							   	      WHERE id_buku	='{$id_buku_before}'";
				$query_update_before = mysqli_query($db_conn, $sql_update_before);

				// Query Update Buku
				$sql_update_after = "UPDATE buku 
							   		  SET status 	= 'Dipinjam'
							   	      WHERE id_buku	='{$id_buku_after}'";
				$query_update_after = mysqli_query($db_conn, $sql_update_after);
			}


		/* Proses Penyimpanan Data dari Form */
		$id_transaksi 	= $_POST['id_transaksi'];
		$id_anggota 	= $_POST['id_anggota'];
		$id_buku 		= $_POST['id_buku'];

		// Query
		$sql = "UPDATE transaksi
					SET id_anggota = '{$id_anggota}',
						id_buku	   = '{$id_buku}'
					WHERE id_transaksi	='{$id_transaksi}'";
		$query = mysqli_query($db_conn, $sql);

		if(!$query) {
			echo "<script>alert('Data gagal diubah!');</script>";
		}

		// mengalihkan halaman
		echo "<meta http-equiv='refresh' content='0; url=index.php?p=peminjaman'>";
	}
?>