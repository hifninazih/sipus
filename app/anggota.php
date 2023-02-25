<?php

	$row = 0;
	$num = 0;
	$offset = 0;
	if(!isset($_POST['cari'])) { // Jika tidak melakukan pencarian anggota
		/*** Pagination ***/
		if(isset($_GET['num'])) { // Jika menggunakan pagination
			$num = (int)$_GET['num'];

			if($num > 0) {
				$offset = ($num * $_QUERY_LIMIT) - $_QUERY_LIMIT;
			}
		}

		/* Query Main */
		$sql = "SELECT * FROM anggota ORDER BY nama_lengkap ASC LIMIT {$offset}, {$_QUERY_LIMIT};";
		$query = mysqli_query($db_conn, $sql);

		/* Query Count All */
		$sql_count = "SELECT id_anggota FROM anggota;";
		$query_count = mysqli_query($db_conn, $sql_count);
		$hasil = 'Jumlah Data : ';			
		$row = $query_count->num_rows;
	} else { // Jika melakukan pencarian anggota
		/*** Pencarian ***/
		$kata_kunci = $_POST['kata_kunci'];

		if(!empty($kata_kunci)) {
			/* Query Pencarian */
			if('all' == $_POST['by']){
				$sql = "SELECT * FROM anggota 
						WHERE id_anggota LIKE '%{$kata_kunci}%'
						OR nama_lengkap LIKE '%{$kata_kunci}%'
						OR alamat LIKE '%{$kata_kunci}%'
						ORDER BY id_anggota ASC;";
				$query = mysqli_query($db_conn, $sql);
				$hasil = 'Jumlah Hasil Pencarian : ';
				$row = $query->num_rows;
			}else if('id_anggota' == $_POST['by']){
				$sql = "SELECT * FROM anggota 
						WHERE id_anggota LIKE '%{$kata_kunci}%'
						ORDER BY id_anggota ASC;";
				$query = mysqli_query($db_conn, $sql);
				$hasil = 'Jumlah Hasil Pencarian : ';
				$row = $query->num_rows;
			}else if('nama' == $_POST['by']){
				$sql = "SELECT * FROM anggota 
						WHERE nama_lengkap LIKE '%{$kata_kunci}%'";
				$query = mysqli_query($db_conn, $sql);
				$hasil = 'Jumlah Hasil Pencarian : ';
				$row = $query->num_rows;	
			}else if('alamat' == $_POST['by']){
				$sql = "SELECT * FROM anggota 
						WHERE alamat LIKE '%{$kata_kunci}%'
						ORDER BY alamat ASC;";
				$query = mysqli_query($db_conn, $sql);
				$hasil = 'Jumlah Hasil Pencarian : ';
				$row = $query->num_rows;	
			}
		} else {

			/* Query Main */
			$sql = "SELECT * FROM anggota ORDER BY nama_lengkap ASC LIMIT {$offset}, {$_QUERY_LIMIT};";
			$query = mysqli_query($db_conn, $sql);

			/* Query Count All */
			$sql_count = "SELECT id_anggota FROM anggota;";
			$query_count = mysqli_query($db_conn, $sql_count);
			$hasil = 'Jumlah Data : ';			
			$row = $query_count->num_rows;
		}
	}
?>

		<div id="container">
			<div class="page-title">
				<h3>Data Anggota</h3>	
			</div>
			<div class="page-content">
				<div class="table-upper">
					<div class="table-upper-left">
						<a href="index.php?p=anggota-tambah" class="btn-success btn-medium">Tambah</a>
						<a href="app/anggota-cetak-daftar.php" title="Cetak Daftar Anggota" target="_blank" class="btn-primary btn-medium ml-2">Cetak</a>
						<a href="index.php?p=anggota" class="btn-info btn-medium ml-2">Refresh</a>
					</div>
					<div class="table-upper-right">
						<form name="pencarian_anggota" action="" method="post" class="text-right form-inline">
							<input class="form-control" type="text" name="kata_kunci" value="<?php if(isset($_POST['kata_kunci'])){echo $_POST['kata_kunci'];} else{echo '';}?>" placeholder="Cari berdasarkan...">

							<select class="form-control ml-1" id="berdasarkan" name="by">
	      						<option value="all" <?php if(isset($_POST['by'])){if($_POST['by'] == 'all'){ echo 'selected'; }} ?> >Semua</option>
							    <option value="id_anggota" <?php if(isset($_POST['by'])){if($_POST['by'] == 'id_anggota'){ echo 'selected'; }} ?> >ID Anggota</option>
							    <option value="nama" <?php if(!isset($_POST['by'])){ echo 'selected'; }else if($_POST['by'] == 'nama'){ echo 'selected';} ?>>Nama Lengkap</option>
							    <option value="alamat" <?php if(isset($_POST['by'])){if($_POST['by'] == 'alamat'){ echo 'selected'; }} ?> >Alamat</option>
							</select>
							<button class="btn btn-success my-2 my-sm-0 ml-2" type="submit" name="cari">Cari</button>
						</form>
					</div>
				</div>

			<?php 
				if($row > 0) {
			?>
				<table class="data-table">
					<tr>
						<th>No.</th>
						<th>ID Anggota</th>
						<th>Nama Lengkap</th>
						<th>Foto</th>
						<th>Jenis Kelamin</th>
						<th>Alamat</th>
						<th>Status Aktif</th>
						<th>Aksi</th>
					</tr>
				<?php
					$i = $offset + 1;
					while($data = mysqli_fetch_array($query)) {
				?>
					<tr>
						<td class="text-center"><?php echo $i++; ?></td>
						<td><?php echo $data['id_anggota']; ?></td>
						<td><?php echo $data['nama_lengkap']; ?></td>
						<td class="text-center">
							<?php
								$data_foto = $data['foto'];
								if($data_foto == '-') {
									$data_foto = 'foto-default.jpg';
								}
							?>
							<img src="<?php echo './images/' . $data_foto; ?>" width="60">
						</td>
						<td class="text-center"><?php echo ($data['jenis_kelamin'] == 'L') ? 'Pria' : 'Wanita'; ?></td>
						<td><?php echo $data['alamat']; ?></td>
						<td class="text-center"><?php echo ($data['status_aktif'] == 'Y') ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-secondary">Tidak Aktif</span>'; ?></td>
						<td class="text-center">
							<a href="./app/anggota-cetak-kartu.php?&id=<?php echo $data['id_anggota']; ?>" class="btn-primary mg-btm-5" target="_blank">Cetak Kartu</a>
							<a href="index.php?p=anggota-ubah&id=<?php echo $data['id_anggota']; ?>" class="btn-warning mg-btm-5">Ubah</a>
							<a href="index.php?p=anggota-hapus&id=<?php echo $data['id_anggota']; ?>" class="btn-danger mg-btm-5 confirm">Hapus</a>
						</td>
					</tr>
				<?php
					}
				?>
				</table>
				<div class="table-lower">
					<div class="table-lower-left mg-top-5">
						<?= $hasil . $row; ?>
					</div>
					<div class="table-lower-right text-right">
					<?php if(!isset($_POST['cari']) || (isset($_POST['cari']) && empty($kata_kunci))) {
							//jalankan pagination
							pagination($row, $num, $_QUERY_LIMIT);
							}
					?>
					</div>
				</div>
			<?php } else { ?>
				<p class="text-center">Data tidak tersedia.</p>
			<?php } ?>		
			</div>
		</div>