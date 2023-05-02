    <?php
		session_start();
		include_once '../database.php';
        try{
		$database = new Database();
		$db = $database->getConnection();
        $name = $_POST["name"];
        $noq = 'SELECT count(id) "no" from diagram where user ='.$_SESSION["userId"];
        $rec = $db->query($noq)->fetchAll(PDO::FETCH_OBJ);
            if($rec[0]-> no < 5)
            {
                $q = 'INSERT INTO  diagram ( user , name ) 
                VALUES ('.$_SESSION["userId"].',"'.$name.'")';
                $db->exec($q);
                $lastd = 'SELECT id from diagram where user ='.$_SESSION["userId"]. '  and id NOT IN (SELECT DISTINCT diagramme from familly)';
                $rec1 = $db->query($lastd)->fetchAll(PDO::FETCH_OBJ);
                $ftad ='INSERT INTO  familly ( name ,  title ,  comments , keyss ,  pic ,  diagramme, mother, spouse ) 
                VALUES ("New Person","Person Title","Describe me",1,"nopic.webp",'.$rec1[0]->id.', "", "")';
                $db->exec($ftad);
                echo("Diagram created succesfully");
            }
            else
            {
                echo("You reached the maximum number of Diagrams allocated per user. <br> Please Delete some from your dashboard");
            }
        }
        catch(Exception $ex)
            {echo("An error Occurred <br>Error :"+$ex->getMessage());}

    ?>