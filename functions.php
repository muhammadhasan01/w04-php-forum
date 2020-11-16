<?php

session_start();

require 'connect.php';

function register($data) {

	global $db;

	$username = stripslashes($data["username"]);
	$password = mysqli_real_escape_string($db, $data["password"]);
	$k_password = mysqli_real_escape_string($db, $data["konfirmasi-password"]);

	if ($password !== $k_password) {
		echo "<script>alert('konfirmasi password tidak sesuai')</script>";
		return false;
	}

	$check_query = "SELECT username FROM user WHERE username='$username'";

	$result = mysqli_query($db, $check_query);
	if (mysqli_fetch_assoc($result)) {
		echo "<script>alert('username sudah terdaftar')</script>";
		return false;
	}

	$password = password_hash($password, PASSWORD_DEFAULT);

	$insert_query = "INSERT INTO user VALUES ('', '$username', '$password')";

	mysqli_query($db, $insert_query);

	return mysqli_affected_rows($db);
}

function add_message($data) {

	global $db;

	$username = $_SESSION["username"];
	$message = $data["message"];
	$current_date = date("Y-m-d", time());
	$id_parent = "NULL";
	if (isset($data["id_parent"])) {
		$id_parent = $data["id_parent"];
	}

	$query = "INSERT INTO message VALUES ('', '$current_date', '$username', '$message', $id_parent)";

	mysqli_query($db, $query);

	return mysqli_affected_rows($db);
}

function show_message($messages, $key, $value, $is_reply) {
	if ($is_reply && !is_null($value["id_parent"])) return;
	echo "<li>";
	echo 'username: ' . $value["username"] . '<br/>';
	echo 'message: ' . $value["message"] . '<br/>';
	echo 'ditambahkan pada: '. $value["date"] . '</br>';
	if ($is_reply) {
		echo "<h3>Tambahkan Reply Baru</h3>
			<form action='index.php' method='post'>
				<ul>
					<input type='hidden' name='id_parent' value='$key'>
					<li><label for='Reply Message'>Reply Message<br/>
						<input type='textarea' name='message'>
					</li>
					<li>
						<button type='submit'>Tambah Reply</button>
					</li>
				</ul>
			</form>";	
		echo "<h4>List Reply Message</h4>";
		echo "<ul>";
		$exist_reply = false;
		foreach ($messages as $r_key => $r_value) {
			if (is_null($r_value["id_parent"])) continue;
			if ($r_value["id_parent"] != $key) continue;
			$exist_reply = true;
			show_message($messages, $r_key, $r_value, false);
		}
		echo "</ul>";
		if (!$exist_reply) {
			echo "belum ada reply apa-apa untuk message ini...</br>";
		}
	}
	echo "</li>";
}

?>