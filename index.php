<?php

session_start();
	require './config/konfigurasi-umum.php';
	require './config/koneksi-db.php';
	require './helpers/helper_umum.php';

// Harus login dulu
if(!isset($_SESSION["username"])){
	//jika belum login, arahkan ke login.php
	header("Location: login.php");
	exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard | Sistem Informasi Perpustakaan</title>
	<link rel="stylesheet" href="./assets/vendor/bootstrap-4.3/css/bootstrap.css">
	<link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
	<div id="wrapper">
		<?php 
		include 'app/layout/header.php';
		include 'app/layout/sidebar-menu.php';
		include 'app/layout/container.php';
		include 'app/layout/footer.php';
		?>
	</div>
	<script>

			var page = "";
			const isset = "<?= isset($_GET['p']); ?>";

			if(isset == 1){
				page = "<?= $_GET['p']; ?>";
			} else {
				page = 'beranda';
			}
	</script>
	<script src="./assets/js/app.js"></script>
</body>
</html>
