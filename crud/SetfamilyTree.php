<?php
    include_once '../database.php';
    $database = new Database();
    $db = $database->getConnection();
    //Datalist is familly members JSON List
        $datalist = $_POST["datalist"];
        $familly = json_decode($datalist);
        $total = sizeof($familly);
        //Delete family in tree Diagram
        $dg = $_POST["id"];
        $delQ="DELETE FROM familly WHERE diagramme =".$dg;
        $db->exec($delQ);
        //Inserting Updated Family members in Tree Diagram
        for($x =0; $x < $total; $x++)
        {
            if($familly[$x]->parent == '')
            {
                $q="INSERT INTO  familly ( name ,  title ,  comments , keyss ,  pic ,  diagramme, mother, spouse ) 
                VALUES ('".$familly[$x]->name."','".$familly[$x]->title."','".$familly[$x]->comments."',".$familly[$x]->key.",'".$familly[$x]->pic."',$dg,'".$familly[$x]->mother."','".$familly[$x]->spouse."' )";      
            }
            else
            {
            $q="INSERT INTO  familly ( name ,  title ,  comments ,  parent ,  keyss ,  pic ,  diagramme, mother, spouse ) 
            VALUES ('".$familly[$x]->name."','".$familly[$x]->title."','".$familly[$x]->comments."',".$familly[$x]->parent.",".$familly[$x]->key.",'".$familly[$x]->pic."',$dg,'".$familly[$x]->mother."','".$familly[$x]->spouse."')";
            }
            $db->exec($q);
        //echo($q);
        }
       echo('Updates Successfully made');
    ?>