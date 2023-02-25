<?php

	$row = 0;
	$num = 0;
	$offset = 0;
	if(!isset($_POST['cari'])) { // Jika tidak melakukan pencarian kategori
		/*** Pagination ***/
		if(isset($_GET['num'])) { // Jika menggunakan pagination
			$num = (int)$_GET['num'];

			if($num > 0) {
				$offset = ($num * $_QUERY_LIMIT) - $_QUERY_LIMIT;
			}
		}

		/* Query Main */
		$sql = "SELECT transaksi.id_transaksi, anggota.nama_lengkap, buku.judul_buku, transaksi.tanggal_pinjam, admin.nama_admin, transaksi.tanggal_kembali, transaksi.id_buku
				FROM (((transaksi
				INNER JOIN anggota ON transaksi.id_anggota = anggota.id_anggota)
				INNER JOIN buku ON transaksi.id_buku = buku.id_buku)
				INNER JOIN admin ON transaksi.id_admin = admin.id_admin)
				WHERE transaksi.tanggal_kembali IS NOT NULL
				ORDER BY id_transaksi DESC LIMIT {$offset}, {$_QUERY_LIMIT};";

		$query = mysqli_query($db_conn, $sql);

		/* Query Count All */
		$sql_count = "SELECT transaksi.id_transaksi
					  FROM transaksi
					  WHERE transaksi.tanggal_kembali IS NOT NULL;";
		$query_count = mysqli_query($db_conn, $sql_count);
		$hasil = 'Jumlah Data : ';		
		$row = $query_count->num_rows;

	} else { // Jika melakukan pencarian kategori
		/*** Pencarian ***/
		$kata_kunci = $_POST['kata_kunci'];

		if(!empty($kata_kunci)) {
			/* Query Pencarian */
			if('all' == $_POST['by']){
				$sql = "SELECT transaksi.id_transaksi, anggota.nama_lengkap, buku.judul_buku, transaksi.tanggal_pinjam, admin.nama_admin, transaksi.tanggal_kembali, transaksi.id_buku
						FROM (((transaksi
						INNER JOIN anggota ON transaksi.id_anggota = anggota.id_anggota)
						INNER JOIN buku ON transaksi.id_buku = buku.id_buku)
						INNER JOIN admin ON transaksi.id_admin = admin.id_admin)
						WHERE judul_buku LIKE '%{$kata_kunci}%'
						AND transaksi.tanggal_kembali IS NOT NULL
						OR id_transaksi LIKE '%{$kata_kunci}%'
						AND transaksi.tanggal_kembali IS NOT NULL
						OR nama_lengkap LIKE '%{$kata_kunci}%'
						AND transaksi.tanggal_kembali IS NOT NULL
						OR tanggal_pinjam LIKE '%{$kata_kunci}%'
						AND transaksi.tanggal_kembali IS NOT NULL
						OR tanggal_kembali LIKE '%{$kata_kunci}%'
						AND transaksi.tanggal_kembali IS NOT NULL
						OR nama_admin LIKE '%{$kata_kunci}%'
						AND transaksi.tanggal_kembali IS NOT NULL
						ORDER BY id_transaksi DESC";
				$query = mysqli_query($db_conn, $sql);
				$hasil = 'Jumlah Hasil Pencarian : ';
				$row = $query->num_rows;
			} else if('id_transaksi' == $_POST['by']){
				$sql = "SELECT transaksi.id_transaksi, anggota.nama_lengkap, buku.judul_buku, transaksi.tanggal_pinjam, admin.nama_admin, transaksi.tanggal_kembali, transaksi.id_buku
						FROM (((transaksi
						INNER JOIN anggota ON transaksi.id_anggota = anggota.id_anggota)
						INNER JOIN buku ON transaksi.id_buku = buku.id_buku)
						INNER JOIN admin ON transaksi.id_admin = admin.id_admin)
						WHERE id_transaksi LIKE '%{$kata_kunci}%'
						AND transaksi.tanggal_kembali IS NOT NULL
						ORDER BY id_transaksi DESC";
				$query = mysqli_query($db_conn, $sql);
				$hasil = 'Jumlah Hasil Pencarian : ';
				$row = $query->num_rows;
			} else if('nama_lengkap' == $_POST['by']){
				$sql = "SELECT transaksi.id_transaksi, anggota.nama_lengkap, buku.judul_buku, transaksi.tanggal_pinjam, admin.nama_admin, transaksi.tanggal_kembali, transaksi.id_buku
						FROM (((transaksi
						INNER JOIN anggota ON transaksi.id_anggota = anggota.id_anggota)
						INNER JOIN buku ON transaksi.id_buku = buku.id_buku)
						INNER JOIN admin ON transaksi.id_admin = admin.id_admin)
						WHERE nama_lengkap LIKE '%{$kata_kunci}%'
						AND transaksi.tanggal_kembali IS NOT NULL
						ORDER BY id_transaksi DESC";
				$query = mysqli_query($db_conn, $sql);
				$hasil = 'Jumlah Hasil Pencarian : ';
				$row = $query->num_rows;
			}  else if('judul_buku' == $_POST['by']){
				$sql = "SELECT transaksi.id_transaksi, anggota.nama_lengkap, buku.judul_buku, transaksi.tanggal_pinjam, admin.nama_admin, transaksi.tanggal_kembali, transaksi.id_buku
						FROM (((transaksi
						INNER JOIN anggota ON transaksi.id_anggota = anggota.id_anggota)
						INNER JOIN buku ON transaksi.id_buku = buku.id_buku)
						INNER JOIN admin ON transaksi.id_admin = admin.id_admin)
						WHERE judul_buku LIKE '%{$kata_kunci}%'
						AND transaksi.tanggal_kembali IS NOT NULL
						ORDER BY id_transaksi DESC";
				$query = mysqli_query($db_conn, $sql);
				$hasil = 'Jumlah Hasil Pencarian : ';
				$row = $query->num_rows;
			} else if('tanggal_kembali' == $_POST['by']){
				$sql = "SELECT transaksi.id_transaksi, anggota.nama_lengkap, buku.judul_buku, transaksi.tanggal_pinjam, admin.nama_admin, transaksi.tanggal_kembali, transaksi.id_buku
						FROM (((transaksi
						INNER JOIN anggota ON transaksi.id_anggota = anggota.id_anggota)
						INNER JOIN buku ON transaksi.id_buku = buku.id_buku)
						INNER JOIN admin ON transaksi.id_admin = admin.id_admin)
						WHERE tanggal_kembali LIKE '%{$kata_kunci}%'
						AND transaksi.tanggal_kembali IS NOT NULL
						ORDER BY id_transaksi DESC";
				$query = mysqli_query($db_conn, $sql);
				$hasil = 'Jumlah Hasil Pencarian : ';
				$row = $query->num_rows;
			} else if('tanggal_pinjam' == $_POST['by']){
				$sql = "SELECT transaksi.id_transaksi, anggota.nama_lengkap, buku.judul_buku, transaksi.tanggal_pinjam, admin.nama_admin, transaksi.tanggal_kembali, transaksi.id_buku
						FROM (((transaksi
						INNER JOIN anggota ON transaksi.id_anggota = anggota.id_anggota)
						INNER JOIN buku ON transaksi.id_buku = buku.id_buku)
						INNER JOIN admin ON transaksi.id_admin = admin.id_admin)
						WHERE tanggal_pinjam LIKE '%{$kata_kunci}%'
						AND transaksi.tanggal_kembali IS NOT NULL
						ORDER BY id_transaksi DESC";
				$query = mysqli_query($db_conn, $sql);
				$hasil = 'Jumlah Hasil Pencarian : ';
				$row = $query->num_rows;
			} else if('nama_admin' == $_POST['by']){
				$sql = "SELECT transaksi.id_transaksi, anggota.nama_lengkap, buku.judul_buku, transaksi.tanggal_pinjam, admin.nama_admin, transaksi.tanggal_kembali, transaksi.id_buku
						FROM (((transaksi
						INNER JOIN anggota ON transaksi.id_anggota = anggota.id_anggota)
						INNER JOIN buku ON transaksi.id_buku = buku.id_buku)
						INNER JOIN admin ON transaksi.id_admin = admin.id_admin)
						WHERE nama_admin LIKE '%{$kata_kunci}%'
						AND transaksi.tanggal_kembali IS NOT NULL
						ORDER BY id_transaksi DESC";
				$query = mysqli_query($db_conn, $sql);
				$hasil = 'Jumlah Hasil Pencarian : ';
				$row = $query->num_rows;
			}
		} else {
			/* Query Main */
			$sql = "SELECT transaksi.id_transaksi, anggota.nama_lengkap, buku.judul_buku, transaksi.tanggal_pinjam, admin.nama_admin, transaksi.tanggal_kembali, transaksi.id_buku
					FROM (((transaksi
					INNER JOIN anggota ON transaksi.id_anggota = anggota.id_anggota)
					INNER JOIN buku ON transaksi.id_buku = buku.id_buku)
					INNER JOIN admin ON transaksi.id_admin = admin.id_admin)
					WHERE transaksi.tanggal_kembali IS NOT NULL
					ORDER BY id_transaksi DESC LIMIT {$offset}, {$_QUERY_LIMIT};";

			$query = mysqli_query($db_conn, $sql);

			/* Query Count All */
			$sql_count = "SELECT transaksi.id_transaksi
						  FROM transaksi
						  WHERE transaksi.tanggal_kembali IS NOT NULL;";
			$query_count = mysqli_query($db_conn, $sql_count);
			$hasil = 'Jumlah Data : ';		
			$row = $query_count->num_rows;
		}
	}
?>

		<div id="container">
			<div class="page-title">
				<h3>Transaksi Pengembalian</h3>	
			</div>
			<div class="page-content">
				<div class="table-upper">
					<div class="table-upper-left">
						<a href="app/pengembalian-cetak-daftar.php" title="Cetak Daftar Pengembalian" target="_blank" class="btn-primary btn-medium">Cetak</a>
						<a href="index.php?p=pengembalian" class="btn-info btn-medium ml-2">Refresh</a>
					</div>
					<div class="table-upper-right">
						<form name="pencarian_kategori" action="" method="post" class="text-right form-inline">
							<input class="form-control" type="text" name="kata_kunci" value="<?php if(isset($_POST['kata_kunci'])){echo $_POST['kata_kunci'];} else{echo '';}?>" placeholder="Cari berdasarkan...">

							<select class="form-control ml-1" id="berdasarkan" name="by">
	      						<option value="all" <?php if(isset($_POST['by'])){if($_POST['by'] == 'all'){ echo 'selected'; }} ?> >Semua</option>
							    <option value="id_transaksi" <?php if(isset($_POST['by'])){if($_POST['by'] == 'id_transaksi'){ echo 'selected'; }} ?> >ID Transaksi</option>
							    <option value="nama_lengkap" <?php if(!isset($_POST['by'])){ echo 'selected'; }else if($_POST['by'] == 'nama_lengkap'){ echo 'selected';} ?>>Nama Anggota</option>
							    <option value="judul_buku" <?php if(isset($_POST['by'])){if($_POST['by'] == 'judul_buku'){ echo 'selected'; }} ?> >Judul Buku</option>
							    <option value="tanggal_pinjam" <?php if(isset($_POST['by'])){if($_POST['by'] == 'tanggal_pinjam'){ echo 'selected'; }} ?> >Tanggal Pinjam</option>
							    <option value="tanggal_kembali" <?php if(isset($_POST['by'])){if($_POST['by'] == 'tanggal_kembali'){ echo 'selected'; }} ?> >Tanggal Kembali</option>
							    <option value="nama_admin" <?php if(isset($_POST['by'])){if($_POST['by'] == 'nama_admin'){ echo 'selected'; }} ?> >Admin</option>
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
						<th>ID Transaksi</th>
						<th>Nama Anggota</th>
						<th>Judul Buku</th>
						<th>Tanggal Pinjam</th>
						<th>Tanggal Kembali</th>
						<th>Admin</th>
						<th>Aksi</th>
					</tr>
				<?php
					$i = $offset + 1;
					while($data = mysqli_fetch_array($query)) {
				?>
					<tr>
						<td class="text-center"><?php echo $i++; ?></td>
						<td class="text-center"><?php echo $data['id_transaksi']; ?></td>
						<td><?php echo $data['nama_lengkap']; ?></td>
						<td><?php echo $data['judul_buku']; ?></td>
						<td class="text-center"><?php echo $data['tanggal_pinjam']; ?></td>
						<td class="text-center"><?php echo $data['tanggal_kembali']; ?></td>
						<td class="text-center"><?php echo $data['nama_admin']; ?></td>
						<td class="text-center">
							<a href="index.php?p=pengembalian-hapus&id=<?php echo $data['id_transaksi']; ?>&bk=<?php echo $data['id_buku']; ?>" class="btn-danger mg-btm-5 confirm-batal">Batalkan</a>
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