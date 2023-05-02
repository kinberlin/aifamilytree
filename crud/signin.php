<?php
		session_start();
		include_once '../database.php';
		$_SESSION["active"] = false;
		$database = new Database();
		$db = $database->getConnection();

		if (isset($_POST['btnLogin'])) {
			echo('<script>alert("Tested")</script>');
			$login = $_POST['useremail'];
			$password = $_POST['pass'];
			$rec = $db->query('SELECT * from user where login = "'.$login.'" and password = "'.$password.'"')->fetchAll(PDO::FETCH_OBJ);
			$size1 = sizeof($rec);
			if($size1 > 0)
			{
				$_SESSION["active"] = true;
				$_SESSION["email"] = $rec[0]->login;
				$_SESSION["userId"] = $rec[0]->id;
				$_SESSION["type"] = "User";
				header("Location: index.php?l=0");
				exit();
			}
            else{
                echo("Incorrect Credentials");
            }
		}
        

	?>