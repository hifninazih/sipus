<?php

	/* Kondisi jika tidak melakukan simpan/ submit, maka tampilkan formulir */
	if(!isset($_POST['simpan'])) {
		/* Mempersiapkan ID Buku Baru */
		//01. Menggunakan referensi id terbesar 
		$sql_hitung = "SELECT id_transaksi FROM transaksi ORDER BY id_transaksi DESC LIMIT 1;";
		$query_hitung = mysqli_query($db_conn, $sql_hitung);
		$query_row = $query_hitung->num_rows;
		
		if($query_row === 0){
			$row = 0;
		} else {
			$fetch_hitung = mysqli_fetch_assoc($query_hitung);
			$last_id_transaksi = $fetch_hitung['id_transaksi'];
			//Match regex
			preg_match('/^TR(.+[^0(\d)]?$)/i', $last_id_transaksi, $matches);
			$match = $matches[1];
			$row = (int)$match;
		}
		

		//02. Menggunakan jumlah data sebagai referensi (tidak disarankan, karena akan bentrok jika data sudah ada yang dihapus)
		// $sql = "SELECT id_buku FROM buku;";
		// $query = mysqli_query($db_conn, $sql);
		// $row = $query->num_rows;

		$id_transaksi_tmp = $row + 1; // Menambahkan +1 untuk ID Anggota Baru
		$id_transaksi_tmp = str_pad($id_transaksi_tmp, 3, "0", STR_PAD_LEFT); // Menambahkan "0" sampai panjang 3 digit termasuk ID Anggota Baru
		$id_transaksi_tmp = 'TR' . $id_transaksi_tmp; // Menambahkan prefix 'BK' untuk ID Anggota Baru

		// Query Buku
		$sql_buku = "SELECT * FROM buku 
					 WHERE status = 'Tersedia'
					 ORDER BY judul_buku;";
		$query_buku = mysqli_query($db_conn, $sql_buku);
		$row_buku = $query_buku->num_rows;
		// Query Anggota
		$sql_anggota = "SELECT * FROM anggota
						WHERE status_aktif = 'Y'
						ORDER BY nama_lengkap;";
		$query_anggota = mysqli_query($db_conn, $sql_anggota);
		$row_anggota = $query_anggota->num_rows;
?>

		<div id="container">
			<div class="page-title">
				<h3>Tambah Transaksi</h3>	
			</div>
			<div class="page-content">
				<form action="" method="post" enctype="multipart/form-data">
					<table class="form-table">
						<tr>
							<td>
								<label for="id_transaksi">ID Transaksi</label>
							</td>
							<td>					
								<input class="form-control mb-2" type="text" name="id_transaksi" id="id_transaksi" value="<?php echo $id_transaksi_tmp; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label for="id_anggota">Nama Anggota</label>
							</td>
							<td>
								<select class="form-control mb-2" name="id_anggota" id="id_anggota" required
								oninvalid="this.setCustomValidity('Pilih Anggota!')"
 								oninput="setCustomValidity('')">
									<option value="">Pilih Anggota...</option>
									<?php
										while($data_anggota = mysqli_fetch_array($query_anggota)){ 
									 ?>
								    	<option value="<?= $data_anggota['id_anggota']; ?>"><?= $data_anggota['nama_lengkap']; ?></option>
								    <?php 
										}
								    ?>
								</select>
									<?php
										if($row_anggota == 0){
									?>		
										<small class="form-text mb-2" style="color: red;">Tidak ada anggota yang aktif!</small>
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
								<select class="form-control mb-2" name="id_buku" id="id_buku" required
								oninvalid="this.setCustomValidity('Pilih Buku!')"
 								oninput="setCustomValidity('')">
									<option value="">Pilih Buku...</option>
									<?php
										while($data_buku = mysqli_fetch_array($query_buku)){ 
									 ?>
								    	<option value="<?= $data_buku['id_buku']; ?>"><?= $data_buku['judul_buku']; ?></option>
								    <?php 
										}
								    ?>
								</select>
									<?php
										if($row_buku == 0){
									?>		
										<small class="form-text mb-2" style="color: red;">Buku tidak tersedia!</small>
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
		/* Proses Penyimpanan Data dari Form */

		$id_transaksi 	= $_POST['id_transaksi'];
		$id_anggota = $_POST['id_anggota'];
		$id_buku = $_POST['id_buku'];
		$id_admin = $_SESSION['id_admin'];


		// Query
		$sql = "INSERT INTO transaksi 
				VALUES('{$id_transaksi}', '{$id_anggota}', '{$id_buku}', NOW() , NULL, '{$id_admin}')";
		$query = mysqli_query($db_conn, $sql);
		// Query Update Buku
		$sql_update = "UPDATE buku 
					SET status 	= 'Dipinjam'
					WHERE id_buku	='{$id_buku}'";
		$query_update = mysqli_query($db_conn, $sql_update);


		// mengalihkan halaman
		echo "<meta http-equiv='refresh' content='0; url=index.php?p=peminjaman'>";
	}
?>