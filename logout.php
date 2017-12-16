<?php
session_start();
unset($_SESSION['badIP']);
unset($_SESSION['failattempts']);
if (isset($_SESSION['user_login'] )) {
	session_destroy();
	header('Location: login.php');
}else{
	header('Location: login.php');
}

?>