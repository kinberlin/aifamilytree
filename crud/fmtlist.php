<?php
    session_start();
    include_once '../database.php';
    $database = new Database();
    $db = $database->getConnection();
    $noq = 'SELECT * FROM diagram where user='.$_SESSION["userId"];
    $rec = $db->query($noq)->fetchAll(PDO::FETCH_OBJ);
    echo(json_encode($rec));
?>
