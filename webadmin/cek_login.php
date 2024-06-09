<?php
include '../config/koneksi.php';

$username=$mysqli->real_escape_string(stripslashes(strip_tags(htmlspecialchars($_POST['auser'],ENT_QUOTES))));
$password=$mysqli->real_escape_string(stripslashes(strip_tags(htmlspecialchars($_POST['apass'],ENT_QUOTES))));

$login = $mysqli->query("SELECT * FROM admin WHERE auser='$username'") or die ($mysqli->error);
$data = $login->fetch_assoc();
$user_name = $data['auser'];
$user_pass = $data['apass'];

if (password_verify($password, $user_pass)) {
	session_start();
	$_SESSION['admin'] = 1;
	$_SESSION['aid'] = $data['aid'];
	$_SESSION['auser'] = $data['auser'];
	header('location:beranda.php');
} else {
	header('location:index.php?failed=1');
}