<?php

	/* Kondisi jika tidak melakukan simpan/ submit, maka tampilkan formulir */
	if(!isset($_POST['simpan'])) {
		/* Mempersiapkan ID Buku Baru */
		//01. Menggunakan referensi id terbesar 
		$sql_hitung = "SELECT id_buku FROM buku ORDER BY id_buku DESC LIMIT 1;";
		$query_hitung = mysqli_query($db_conn, $sql_hitung);
		$query_row = $query_hitung->num_rows;

		if($query_row === 0){
			$row = 0;
		} else {
			$fetch_hitung = mysqli_fetch_assoc($query_hitung);
			$last_id_buku = $fetch_hitung['id_buku'];
			//Match regex
			preg_match('/^BK(.+[^0(\d)]?$)/i', $last_id_buku, $matches);
			$match = $matches[1];
			$row = (int)$match;
		}
		

		//02. Menggunakan jumlah data sebagai referensi (tidak disarankan, karena akan bentrok jika data sudah ada yang dihapus)
		// $sql = "SELECT id_buku FROM buku;";
		// $query = mysqli_query($db_conn, $sql);
		// $row = $query->num_rows;

		$id_buku_tmp = $row + 1; // Menambahkan +1 untuk ID Anggota Baru
		$id_buku_tmp = str_pad($id_buku_tmp, 3, "0", STR_PAD_LEFT); // Menambahkan "0" sampai panjang 3 digit termasuk ID Anggota Baru
		$id_buku_tmp = 'BK' . $id_buku_tmp; // Menambahkan prefix 'BK' untuk ID Anggota Baru

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
?>

		<div id="container">
			<div class="page-title">
				<h3>Tambah Data Buku</h3>	
			</div>
			<div class="page-content">
				<form action="" method="post" enctype="multipart/form-data">
					<table class="form-table">
						<tr>
							<td>
								<label for="id_buku">ID Buku</label>
							</td>
							<td>					
								<input class="form-control mb-2" type="text" name="id_buku" id="id_buku" value="<?php echo $id_buku_tmp; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label for="judul_buku">Judul Buku</label>
							</td>
							<td>								
								<input class="form-control mb-2" type="text" name="judul_buku" id="judul_buku" placeholder="Isi judul buku..." required
								oninvalid="this.setCustomValidity('Isi Judul Buku!')"
 								oninput="setCustomValidity('')">
							</td>
						</tr>
						<tr>
							<td>
								<label for="id_kategori">Kategori</label>
							</td>
							<td>
								<select class="form-control mb-2" name="id_kategori" id="id_kategori" required
								oninvalid="this.setCustomValidity('Isi Kategori')"
 								oninput="setCustomValidity('')">
									<option value="">Pilih Kategori...</option>
									<?php
										while($data_kategori = mysqli_fetch_array($query_kategori)){ 
									 ?>
								    	<option value="<?= $data_kategori['id_kategori']; ?>"><?= $data_kategori['nama_kategori']; ?></option>
								    <?php 
										}
								    ?>
								</select>
									<?php
										if($row_kategori == 0){
									?>		
										<small class="form-text mb-2" style="color: red;">Kategori kosong, silakan input Data Kategori!</small>
									<?php 
										}
									 ?>
							</td>
						</tr>
						<tr>
							<td>
								<label for="id_penulis">Penulis</label>
							</td>
							<td>
								<select class="form-control mb-2" name="id_penulis" id="id_penulis" required
								oninvalid="this.setCustomValidity('Isi Nama Penulis!')"
 								oninput="setCustomValidity('')">
									<option value="">Pilih Nama Penulis...</option>
									<?php 
										while($data_penulis = mysqli_fetch_array($query_penulis)){ 
									 ?>
								    	<option value="<?= $data_penulis['id_penulis']; ?>"><?= $data_penulis['nama_penulis']; ?></option>
								    <?php 
										}
								    ?>
								</select>
									<?php
										if($row_penulis == 0){
									?>		
										<small class="form-text mb-2" style="color: red;">Nama penulis kosong, silakan input Data Penulis!</small>
									<?php 
										}
									 ?>
							</td>
						</tr>
						<tr>
							<td>
								<label for="id_penerbit">Penerbit</label>
							</td>
							<td>
								<select class="form-control mb-3" name="id_penerbit" id="id_penerbit" required
								oninvalid="this.setCustomValidity('Isi Nama Penerbit!')"
 								oninput="setCustomValidity('')">
									<option value="">Pilih Nama Penerbit...</option>
									<?php 
										while($data_penerbit = mysqli_fetch_array($query_penerbit)){ 
									 ?>
								    	<option value="<?= $data_penerbit['id_penerbit']; ?>"><?= $data_penerbit['nama_penerbit']; ?></option>
								    <?php 
										}
								    ?>
								</select>
									<?php
										if($row_penerbit == 0){
									?>		
										<small class="form-text mb-2" style="color: red;">Nama penerbit kosong, silakan input Data Penerbit!</small>
									<?php 
										}
									 ?>
							</td>
						</tr>

										
						<input type="hidden" name="status" value="Tersedia" id="tersedia" required checked>
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
		$judul_buku = $_POST['judul_buku'];
		$id_kategori = $_POST['id_kategori'];
		$id_penulis = $_POST['id_penulis'];
		$id_penerbit = $_POST['id_penerbit'];
		$status = $_POST['status'];

		// Query
		$sql = "INSERT INTO buku 
				VALUES('{$id_buku}', '{$judul_buku}', '{$id_kategori}', '{$id_penulis}', '{$id_penerbit}', '{$status}')";
		$query = mysqli_query($db_conn, $sql);



		// mengalihkan halaman
		echo "<meta http-equiv='refresh' content='0; url=index.php?p=buku'>";
	}
?>