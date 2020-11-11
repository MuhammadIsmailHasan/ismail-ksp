<?php
	session_start();
	include "koneksi.php";

	$uname = mysqli_escape_string($con, $_POST['username']);
	$pass = mysqli_escape_string($con, $_POST['password']);
	$pass_enc = md5($pass);

	//pengecekan apakah user = admin
	$qry = "SELECT * FROM users WHERE username = '$uname' AND password = '$pass_enc'";
	$sql = mysqli_query($con, $qry);

	if ( mysqli_num_rows($sql) > 0 ) {
		$data = mysqli_fetch_array($sql);
		$_SESSION['auth_id'] = $data['id'];
		$_SESSION['auth_name'] = $data['nama'];
		$_SESSION['auth_type'] = $data['akses'];

		header('Location: index.php');
	} else {
		header('Location: login.php?msg=invalid');
	}
?>