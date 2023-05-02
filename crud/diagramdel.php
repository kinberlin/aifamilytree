<?php
		session_start();
		include_once '../database.php';
        try{
		$database = new Database();
		$db = $database->getConnection();
        $idd = $_POST["idd"];
        $q = 'DELETE FROM diagram WHERE id='.$idd;
        $db->exec($q);
        }
        catch(Exception $ex)
            {echo("An error Occurred <br>Error :"+$ex->getMessage());}

    ?>