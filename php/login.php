<?php if (empty(session_id())) {session_start();}; ?>
<?php

require_once('user.class.php');
require_once('database.php');

if (isset($_POST['login']) && isset($_POST['pass'])) {
	$db = new DB("mysql", "localhost", "crud", "utf8mb4", "root", "");

	$login = htmlspecialchars($_POST['login']);
	$pass = htmlspecialchars($_POST['pass']);

	$stmt = $db->query("SELECT login, password, email, role FROM users WHERE login = ?", array($login));
	$user = $stmt->fetch();

	var_dump($pass, $user['password'], password_verify($pass, $user['password']));

	if ($user == false || !password_verify($pass, $user['password'])) {
		header('Location: ../?failed=1');
	} else {
	$user = new User($user['login'], $user['email'], $user['role']);
		$_SESSION['user'] = $user;

		header('Location: ../info');
	}
}

?>