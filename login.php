<?php
$host = 'localhost';
$db = 'netland';
$user = 'root';
$pass = '';
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
	PDO::ATTR_ERRMODE				=>	PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE	=>	PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES		=>	false,
];
try {
	$pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
	throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
if (isset($_POST['username']) && isset($_POST['password'])) {
	$stmt = $pdo->query('SELECT * FROM gebruikers');
	$found = false;
	while ($row = $stmt->fetch()) {
		if (strtolower($row['username']) === strtolower($_POST['username'])) {
			$found = true;
			if ($row['wachtwoord'] === $_POST['password']) {
				setcookie("loggedInUser", $row['id'], time()+3600);
				header("Location: index.php");
				die();
			} else {
?>
<div style="background: red; color: white; padding: 20px;">Password or username incorrect!</div><br /><br />
<?php
			}
		}
	}
	if (!$found) {
?>
<div style="background: red; color: white; padding: 20px;">Password or username incorrect!</div><br /><br />
<?php
	}
}
?>
<form method="POST">
<input type="text" name='username' placeholder="Username">
<input type="passwprd" name="password" placeholder="Password">
<input type="submit" value="login">
</form>