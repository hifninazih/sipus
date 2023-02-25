<?php
	include './config/koneksi-db.php';
	
	if(isset($_GET['id'])) { // memperoleh buku_id
		$id_buku = $_GET['id'];

		if(!empty($id_buku)) {
			// Query
			$sql = "DELETE FROM buku WHERE id_buku = '{$id_buku}';";
			$query = mysqli_query($db_conn, $sql);

			if(!$query) {
				echo "<script>alert('Data gagal dihapus!');</script>";
			}
		} else {
			echo "<script>alert('ID Buku kosong!');</script>";
		}
	} else {
		echo "<script>alert('ID Buku tidak didefinisikan!');</script>";		
	}

	// mengalihkan halaman
	echo "<meta http-equiv='refresh' content='0; url=index.php?p=buku'>";
?>