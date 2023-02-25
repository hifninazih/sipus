<?php

	if(isset($_GET['id']) && isset($_GET['bk'])) { // memperoleh kategori_id dan buku
		$id_transaksi = $_GET['id'];
		$id_buku = $_GET['bk'];
		if(!empty($id_transaksi) && !empty($id_buku)) {
			// Query Cek Buku
			$sql_cekbuku = "SELECT * FROM buku
					 		WHERE status = 'Tersedia'
					 		AND	id_buku = '{$id_buku}'
					 		ORDER BY judul_buku;";
			$query_cekbuku = mysqli_query($db_conn, $sql_cekbuku);
			$row_cekbuku = $query_cekbuku->num_rows;
			if($row_cekbuku === 1){
			
				// Query Transaksi
				$sql_transaksi = "UPDATE transaksi 
							 	  SET tanggal_kembali	= NULL
								  WHERE id_transaksi	='{$id_transaksi}'";
				$query_transaksi = mysqli_query($db_conn, $sql_transaksi);
				// Query Buku
				$sql_buku = "UPDATE buku 
								  SET status	= 'Dipinjam'
								  WHERE id_buku	='{$id_buku}'";
				$query_buku = mysqli_query($db_conn, $sql_buku);
			} else {
				echo "<script>alert('Gagal! : Buku sedang dipinjam');</script>";
			}
		} else {
			echo "<script>alert('ID Transaksi atau ID Buku kosong!');</script>";
		}
	} else {
		echo "<script>alert('ID Transaksi atau ID Buku tidak didefinisikan!');</script>";		
	}

	// mengalihkan halaman
	echo "<meta http-equiv='refresh' content='0; url=index.php?p=pengembalian'>";
?>