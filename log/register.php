<?php 

session_start();

if (isset($_SESSION["login"])) {
	header("Location: ../array.php");
}

require '../functions.php';

if (isset($_POST["register"])) {
   if (registrasi($_POST) > 0) {
       echo "<script>
                alert('register berhasil!');
             </script";
   } else {
       echo mysqli_error($conn);
   }
}


if (isset($_POST["login"])) {
	$username = $_POST["username"];
	$password = $_POST["password"];

	$result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

	if (mysqli_num_rows($result) === 1) {
		$row = mysqli_fetch_assoc($result);
		if(password_verify($password, $row["password"])){
			$_SESSION["login"] = true;
			header("Location: ../array.php");
			exit;
		}
	}
	$error = true;
}



?>

<!DOCTYPE html>
<html>
<head>
	<title>REGISTER</title>
	<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form action="" method="post">
				<?php
				if (isset($error)) : ?>
					<p style="color:red; font-style:italic; text-align:center;">Username / Password Salah!</p>
				<?php endif; ?>
					<label for="chk" aria-hidden="true">Sign up</label>
					<input type="text" name="username" placeholder="Username" required="">
					<input type="password" name="password" placeholder="Password" required="">
					<input type="password" name="password2" placeholder="Password" required="">
					<button type="submit" name="register">Sign up</button>
				</form>
			</div>

			<div class="login">
				<form action="" method="post">
					<label for="chk" aria-hidden="true">Login</label>
					<input type="text" name="username" placeholder="username" required="">
					<input type="password" name="password" placeholder="Password" required="">
					<button type="submit" name="login">Login</button>
				</form>
			</div>
	</div>
</body>
</html>