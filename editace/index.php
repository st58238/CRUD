<?php require_once('../php/user.class.php'); require_once('../php/database.php'); require_once('../php/html.php'); require_once('../php/control.php'); ?>
<?php if (empty(session_id())) {session_start();}; ?>
<?php

$inputs = "";
$user = $_SESSION['user'];

if (!loggedIn() || $user->getRole() <= 50) {
	header('Location: ../');
} else if (isset($_GET['id']) && $user->getRole() > 50) {
	$db = new DB("mysql", "localhost", "crud", "utf8mb4", "root", "");

	$user = $db->query("SELECT id, login, email, password, role FROM users WHERE id = ?", array(htmlspecialchars($_GET['id'])))->fetch();

	$inputs .= '<input type="text" name="login" id="login" class="form_input" placeholder="Login" value="' . $user['login'] . '">
				<input type="hidden" name="ologin" id="ologin" class="form_input" value="' . $user['login'] . '">
				<input type="text" name="email" id="email" class="form_input" placeholder="Email" value="' . $user['email'] . '">
				<input type="text" name="role" id="role" class="form_input" placeholder="Role" value="' . $user['role'] . '">
				<input type="password" name="pass" id="passA" class="form_input" placeholder="Heslo, alespoň 8 znaků">
				<input type="password" id="passB" class="form_input" placeholder="Heslo znovu">
				<input type="submit" class="form_input" value="Změnit">';
}

?>
<!DOCTYPE html>
<html>
<head>
	<base href="../">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Správa uživatelů</title>
	<link rel="stylesheet" href="css/main.css">
	<script defer="defer">
		document.addEventListener("DOMContentLoaded", function(){
			document.querySelector("form.form_full_center").addEventListener("submit", function(e){
				document.querySelector('input[name="login"]').value = document.querySelector('input[name="login"]').value.trim();
				document.querySelector('#email').value = document.querySelector('#email').value.trim();
				document.querySelector('#passA').value = document.querySelector('#passA').value.trim();

				const login = document.querySelector("#login").value;
				const email = document.querySelector("#email").value;
				const passA = document.querySelector("#passA").value;
				const passB = document.querySelector("#passB").value;

				const reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

				let ret = true;
				const lo = document.querySelector('#login'); // Login input
				const em = document.querySelector('#email'); // Email input
				const pa = document.querySelector('#passA'); // Password input A
				const pb = document.querySelector('#passB'); // Password input B

				if (passA !== passB) {
					pa.style.border = "2px solid red";
					pa.style.padding = "0 14px";
					pb.style.border = "2px solid red";
					pb.style.padding = "0 14px";
					pb.focus();
					ret &= false;
				} else if (ret === true) {
					pa.style.border = null;
					pa.style.padding = null;
					pb.style.border = null;
					pb.style.padding = null;
				}

				if (passA.length < 8 && passA.length != 0) {
					pa.style.border = "2px solid red";
					pa.style.padding = "0 14px";
					pa.focus();
					ret &= false;
				} else {
					pa.style.border = null;
					pa.style.padding = null;
				}

				if (!reg.test(email)) {
					em.style.border = "2px solid red";
					em.style.padding = "0 14px";
					em.focus();
					ret &= false;
				} else {
					em.style.border = null;
					em.style.padding = null;
				}

				if (login.length === 0) {
					lo.style.border = "2px solid red";
					lo.style.padding = "0 14px";
					lo.focus();
					ret &= false;
				} else {
					lo.style.border = null;
					lo.style.padding = null;
				}

				if (ret) {
					return true;
				} else {
					e.preventDefault();
					return false;
				}
			});

			let url = window.location;
			if (url.toString().includes("?") && !url.toString().includes("id")) {
				if (url.toString().split("?")[1].split("=")[1] == "0") {
					alert("Úspěšná změna údajů.");
				} else if (url.toString().split("?")[1].split("=")[1] == "1") {
					alert("Nepodařilo se změnit údaje.");
				}
			}
		});
	</script>
</head>
<body>
	<div class="background"></div>
	<div class="main">
		<?php echo SIDEPANEL; ?>
		<div class="user">
			<form class="form_full_center" action="php/upravit.php" method="post" style="margin: 0;">
				<div class="login_form">
					<?php echo $inputs; ?>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
