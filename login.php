<?php

session_start();

require 'connect.php';

if (isset($_POST["login"])) {

	$username = $_POST["username"];
	$password = $_POST["password"];

	$query = "SELECT * FROM user WHERE username='$username'";

	$result = mysqli_query($db, $query);

	if (mysqli_num_rows($result) === 1) {
		
		$row = mysqli_fetch_assoc($result);

		if (password_verify($password, $row["password"])) {

			$_SESSION["login"] = true;
			$_SESSION["username"] = $row["username"];

			header("Location: index.php");
			exit;
		}

	}

	$error = true;

}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Halaman Login</title>
	</head>
<body>


	<h1>Halaman Login</h1>

	<?php 
		if (isset($error)) {
			echo "<p style='color: red; font-style: italic;'>username / password salah</p>";
		}
	?>

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
				<button type="submit" name="login">login</button>
			</li>
		</ul>
	</form>

	<p>belum punya akun? silahkan <a href="register.php">register</a> dulu.</p>

</body>
</html>