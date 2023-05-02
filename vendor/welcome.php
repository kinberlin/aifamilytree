<!DOCTYPE html>
<html lang="en">
<head>
	<title>Philou | Authentification</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/login_util.css">
	<link rel="stylesheet" type="text/css" href="css/login_main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Account Login
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5" method="post">

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="useremail" id="useremail" placeholder="User Email">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="pass" id="pass" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
						<p1 id="msg"> <center>
						<?php
							session_start();
							include_once './database.php';
							$_SESSION["active"] = false;
							$database = new Database();
							$db = $database->getConnection();

							if (isset($_POST['btnLogin'])) {
								require_once('./functions.php');  // PHP functions file
								$page_id = 2;
								$visitor_ip = $_SERVER['REMOTE_ADDR']; // stores IP address of visitor in variable
								add_view($page_id,$db);
								
								$login = $_POST['useremail'];
								$password = $_POST['pass'];
								$rec = $db->query('SELECT * from user where login = "'.$login.'" and password = "'.$password.'"')->fetchAll(PDO::FETCH_OBJ);
								$size1 = sizeof($rec);
								if($size1 > 0)
								{
									if($rec[0]-> acces == "Enable"){
									$_SESSION["active"] = true;
									$_SESSION["email"] = $rec[0]->login;
									$_SESSION["userId"] = $rec[0]->id;
									$_SESSION["userName"] = $rec[0]->nom .' '. $rec[0]->prenom ;
									$_SESSION["type"] = "User";
									header("Location: index.php?l=0");
									exit();
									}
									else{
										echo("Access could not be granted");
									}
								}
								else{
									echo("Incorrect Credentials");
								}
							}
							

						?>
						</center>
					</p1>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<a class="login100-form-btn" href="./register.php">
							Register
						</a>
						<button class="login100-form-btn" name="btnLogin" id="btnLogin">
							Login
						</button>
					</div>
					
				</form>
				<a href="asignin.php" ><center class="adm">Are you an Administrator ?</center></a>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="js/jquery_min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->

<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/login_main.js"></script>


</body>
</html>