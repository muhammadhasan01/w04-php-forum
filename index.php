<?php
require 'functions.php';

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

if (isset($_POST['message'])) {
	if (add_message($_POST) > 0) {
		echo "<script>alert('Message Berhasil Ditambahkan!')</script>";
	} else {
		echo mysqli_error($db);
	}
}

$query = "SELECT * FROM message";

if ($result = mysqli_query($db, $query)) {

	$messages = array();
	while ($row = $result->fetch_assoc()) {
		$messages[$row["id"]] = array(
			"username" => $row["username"],
			"message" => $row["message"],
			"date" => $row["timestamp"],
			"id_parent" => $row["id_parent"]
		);
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Forum Diskusi</title>
</head>
<body>
	<a href="logout.php">logout</a>
	<h1>Forum Diskusi</h1>
	<h2>Tambahkan Message Baru</h2>
	<form action="index.php" method="post">
		<ul>
			<li><label for="message">Message<br/>
				<input type="textarea" name="message">
			</li>
			<li>
				<button type="submit">Tambah Message</button>
			</li>
		</ul>
	</form>
	<h2>Daftar Messages</h2>
	<?php

		if (!isset($messages)) {
			echo "Belum ada message yang ditambahkan...";
			exit;
		}

		echo "<ul>";
		foreach ($messages as $key => $value) {
			show_message($messages, $key, $value, true);
		}
		echo "</ul>";
	?>
</body>
</html>