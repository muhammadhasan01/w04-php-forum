<?php

require 'functions.php';

if (isset($_POST['register'])) {
	if (register($_POST) > 0) {
		echo "<script>alert('Registrasi Berhasil')</script>";
	} else {
		echo mysqli_error($db);
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Halaman Register</title>
</head>
<body>
	<h1>Halaman Register</h1>
	<p>Isilah data berikut untuk melakukan registrasi:</p>
	<form action="" method="post">
		<ul>
			<li>
				<label for="username">username</label>
				<input type="text" name="username" id="username">
			</li>
			<li>
				<label for="password">password</label>
				<input type="password" name="password" id="password">
			</li>
			<li>
				<label for="konfirmasi password">konfirmasi password</label>
				<input type="password" name="konfirmasi-password" id="password">
			</li>
			<li>
				<button type="submit" name="register">register</button>
			</li>
		</ul>
	</form>
	<p>kembali ke halaman <a href="login.php">login</a>.</p>
</body>
</html>