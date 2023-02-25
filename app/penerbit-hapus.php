<?php

	if(isset($_GET['id'])) { // memperoleh penerbit_id
		$id_penerbit = $_GET['id'];

		if(!empty($id_penerbit)) {
			// Query
			$sql = "DELETE FROM penerbit WHERE id_penerbit = '{$id_penerbit}';";
			$query = mysqli_query($db_conn, $sql);

			if(!$query) {
				echo "<script>alert('Data gagal dihapus!');</script>";
			}
		} else {
			echo "<script>alert('ID Penerbit kosong!');</script>";
		}
	} else {
		echo "<script>alert('ID Penerbit tidak didefinisikan!');</script>";		
	}

	// mengalihkan halaman
	echo "<meta http-equiv='refresh' content='0; url=index.php?p=penerbit'>";
?>