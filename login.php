<?php
	session_start();
	include './config/konfigurasi-umum.php';
	include './config/koneksi-db.php';

	if(isset($_SESSION["username"])){
		//jika sudah login, arahkan ke index
		echo "<meta http-equiv='refresh' content='0; url=index.php?p=beranda'>";
		exit;
	}

	if(!isset($_POST['kirim'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Admin | Sistem Informasi Perpustakaan</title>
	<link rel="stylesheet" href="./assets/css/login.css">
</head>
<body>
	<body>
    <div class="container">
      <form class="box" action="" method="post">
        <div class="header">
          <h2>Login Admin</h2>
        </div>
        <input type="text" name="username" placeholder="Username" required
        oninvalid="this.setCustomValidity('Username tidak boleh kosong!')"
 				oninput="setCustomValidity('')">
        <input type="password" name="password" placeholder="Password" required
        oninvalid="this.setCustomValidity('Password tidak boleh kosong!')"
 				oninput="setCustomValidity('')">
        <input type="submit" name="kirim" value="Log in">
      </form>
    </div>
  </body>
</body>
</html>

<?php
	} else {
		// session_start();

		$username = $_POST['username'];
		$password = $_POST['password'];

		$sql = "SELECT * FROM `admin` WHERE `username` = '{$username}'";
		$query = mysqli_query($db_conn, $sql);

		if($query->num_rows > 0) {
			$data = mysqli_fetch_array($query);

			if(password_verify($password, $data['password'])){
				$_SESSION['id_admin'] = $data['id_admin'];
				$_SESSION['username'] = $data['username'];
				$_SESSION['nama_admin'] = $data['nama_admin'];
				
				echo "<script>alert('Login Berhasil!');</script>";
				echo "<meta http-equiv='refresh' content='0; url=index.php?p=beranda'>";
			} else {
				echo "<script>alert('Login Gagal!');</script>";
			  echo "<meta http-equiv='refresh' content='0; url=login.php'>";
			}

			// echo '<pre>';
			// var_dump($_SESSION);
			// echo '</pre>';
		} else {
			echo "<script>alert('Login Gagal!');</script>";
			echo "<meta http-equiv='refresh' content='0; url=login.php'>";
		}
	}
?>