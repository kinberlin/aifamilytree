<?php
    include_once '../database.php';
    $database = new Database();
    $db = $database->getConnection();
    //Datalist is familly members JSON List
        $datalist = $_POST["datalist"];
        $familly = json_decode($datalist);
        $total = sizeof($familly);
        //Inserting familly members in family tree diagram
        for($x =0; $x < $total; $x++)
        {
            if($familly[$x]->parent == '')
            {
                $q="INSERT INTO  familly ( name ,  title ,  comments , keyss ,  pic ,  diagramme ) 
                VALUES ('".$familly[$x]->name."','".$familly[$x]->title."','".$familly[$x]->comments."',".$familly[$x]->key.",'".$familly[$x]->pic."',1)";      
            }
            else
            {
            $q="INSERT INTO  familly ( name ,  title ,  comments ,  parent ,  keyss ,  pic ,  diagramme ) 
            VALUES ('".$familly[$x]->name."','".$familly[$x]->title."','".$familly[$x]->comments."',".$familly[$x]->parent.",".$familly[$x]->key.",'".$familly[$x]->pic."',1)";
            }
            $db->exec($q);
        //echo($q);
        }
       //echo('Reussie');
    ?>