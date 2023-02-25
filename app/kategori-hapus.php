<?php

	if(isset($_GET['id'])) { // memperoleh kategori_id
		$id_kategori = $_GET['id'];

		if(!empty($id_kategori)) {
			// Query
			$sql = "DELETE FROM kategori WHERE id_kategori = '{$id_kategori}';";
			$query = mysqli_query($db_conn, $sql);

			if(!$query) {
				echo "<script>alert('Data gagal dihapus!');</script>";
			}
		} else {
			echo "<script>alert('ID Kategori kosong!');</script>";
		}
	} else {
		echo "<script>alert('ID Kategori tidak didefinisikan!');</script>";		
	}

	// mengalihkan halaman
	echo "<meta http-equiv='refresh' content='0; url=index.php?p=kategori'>";
?>