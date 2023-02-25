<?php

	$row = 0;
	$num = 0;
	$offset = 0;
	if(!isset($_POST['cari'])) { // Jika tidak melakukan pencarian penulis
		/*** Pagination ***/
		if(isset($_GET['num'])) { // Jika menggunakan pagination
			$num = (int)$_GET['num'];

			if($num > 0) {
				$offset = ($num * $_QUERY_LIMIT) - $_QUERY_LIMIT;
			}
		}

		/* Query Main */
		$sql = "SELECT * FROM penulis ORDER BY id_penulis ASC LIMIT {$offset}, {$_QUERY_LIMIT};";
		$query = mysqli_query($db_conn, $sql);

		/* Query Count All */
		$sql_count = "SELECT id_penulis FROM penulis;";
		$query_count = mysqli_query($db_conn, $sql_count);
		$hasil = 'Jumlah Data : ';		
		$row = $query_count->num_rows;
	} else { // Jika melakukan pencarian penulis
		/*** Pencarian ***/
		$kata_kunci = $_POST['kata_kunci'];

		if(!empty($kata_kunci)) {
			/* Query Pencarian */
			if('all' == $_POST['by']){
				$sql = "SELECT * FROM penulis 
						WHERE id_penulis LIKE '%{$kata_kunci}%'
						OR nama_penulis LIKE '%{$kata_kunci}%'
						ORDER BY id_penulis ASC;";
				$query = mysqli_query($db_conn, $sql);
				$hasil = 'Jumlah Hasil Pencarian : ';
				$row = $query->num_rows;
			} else if('id_penulis' == $_POST['by']){
				$sql = "SELECT * FROM penulis 
						WHERE id_penulis LIKE '%{$kata_kunci}%'
						ORDER BY id_penulis ASC;";
				$query = mysqli_query($db_conn, $sql);
				$hasil = 'Jumlah Hasil Pencarian : ';
				$row = $query->num_rows;
			} else if('nama_penulis' == $_POST['by']){
				$sql = "SELECT * FROM penulis 
						WHERE nama_penulis LIKE '%{$kata_kunci}%'
						ORDER BY id_penulis ASC;";
				$query = mysqli_query($db_conn, $sql);
				$hasil = 'Jumlah Hasil Pencarian : ';
				$row = $query->num_rows;
			}
		} else {
			/* Query Main */
			$sql = "SELECT * FROM penulis ORDER BY id_penulis ASC LIMIT {$offset}, {$_QUERY_LIMIT};";
			$query = mysqli_query($db_conn, $sql);

			/* Query Count All */
			$sql_count = "SELECT id_penulis FROM penulis;";
			$query_count = mysqli_query($db_conn, $sql_count);
			$hasil = 'Jumlah Data : ';		
			$row = $query_count->num_rows;
		}
	}
?>

		<div id="container">
			<div class="page-title">
				<h3>Data Penulis</h3>	
			</div>
			<div class="page-content">
				<div class="table-upper">
					<div class="table-upper-left">
						<a href="index.php?p=penulis-tambah" class="btn-success btn-medium">Tambah</a>
						<a href="index.php?p=penulis" class="btn-info btn-medium ml-2">Refresh</a>
					</div>
					<div class="table-upper-right">
						<form name="pencarian_penulis" action="" method="post" class="text-right form-inline">
							<input class="form-control" type="text" name="kata_kunci" value="<?php if(isset($_POST['kata_kunci'])){echo $_POST['kata_kunci'];} else{echo '';}?>" placeholder="Cari berdasarkan...">

							<select class="form-control ml-1" id="berdasarkan" name="by">
	      						<option value="all" <?php if(isset($_POST['by'])){if($_POST['by'] == 'all'){ echo 'selected'; }} ?> >Semua</option>
							    <option value="id_penulis" <?php if(isset($_POST['by'])){if($_POST['by'] == 'id_penulis'){ echo 'selected'; }} ?> >ID Penulis</option>
							    <option value="nama_penulis" <?php if(!isset($_POST['by'])){ echo 'selected'; }else if($_POST['by'] == 'nama_penulis'){ echo 'selected';} ?>>Nama Penulis</option>
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
						<th>ID Penulis</th>
						<th>Nama Penulis</th>
						<th>Aksi</th>
					</tr>
				<?php
					$i = $offset + 1;
					while($data = mysqli_fetch_array($query)) {
				?>
					<tr>
						<td class="text-center"><?php echo $i++; ?></td>
						<td class="text-center"><?php echo $data['id_penulis']; ?></td>
						<td><?php echo $data['nama_penulis']; ?></td>
						<td class="text-center">
							<a href="index.php?p=penulis-ubah&id=<?php echo $data['id_penulis']; ?>" class="btn-warning mg-btm-5">Ubah</a>
							<a href="index.php?p=penulis-hapus&id=<?php echo $data['id_penulis']; ?>" class="btn-danger mg-btm-5 confirm">Hapus</a>
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