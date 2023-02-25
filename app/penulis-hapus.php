<?php

	if(isset($_GET['id'])) { // memperoleh penulis_id
		$id_penulis = $_GET['id'];

		if(!empty($id_penulis)) {
			// Query
			$sql = "DELETE FROM penulis WHERE id_penulis = '{$id_penulis}';";
			$query = mysqli_query($db_conn, $sql);

			if(!$query) {
				echo "<script>alert('Data gagal dihapus!');</script>";
			}
		} else {
			echo "<script>alert('ID Penulis kosong!');</script>";
		}
	} else {
		echo "<script>alert('ID Penulis tidak didefinisikan!');</script>";		
	}

	// mengalihkan halaman
	echo "<meta http-equiv='refresh' content='0; url=index.php?p=penulis'>";
?>