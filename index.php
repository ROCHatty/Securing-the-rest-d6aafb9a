<?php
if (!isset($_COOKIE['loggedInUser'])) {
	header("Location: login.php");
	die();
}
?>