<!DOCTYPE html>
<html lang="fr">
    <?php
    include_once '../database.php';
    $database = new Database();
    $db = $database->getConnection();
    if (isset($_POST['block'])) {
        $q='UPDATE user SET acces="Disable" where id='.$_POST["block"];
        $db->exec($q); 
    }
    if (isset($_POST['validate'])) {
        $q='UPDATE user SET acces="Enable" where id='.$_POST["validate"];
        $db->exec($q); 
    }
    if (isset($_POST['delete'])) {
        $q='DELETE FROM user where id='.$_POST["delete"];
        $db->exec($q); 
        //echo('<script>alert("L\'etudiant #'.$_POST["delete"].' a ete supprimer avec succes.")</script>');
    }
    ?>
    <head>
    <style>
                body {
                    color: #566787;
                    background: #f5f5f5;
                    font-family: 'Varela Round', sans-serif;
                    font-size: 13px;}
                .table-responsive {
                    margin: 30px 0;}
                .table-wrapper {
                        min-width: 1000px;
                        background: #fff;
                        padding: 20px 25px;
                    border-radius: 3px;
                        box-shadow: 0 1px 1px rgba(0,0,0,.05);
                    }
                .table-title {
                    padding-bottom: 15px;
                    background: #299be4;
                    color: #fff;
                    padding: 16px 30px;
                    margin: -20px -25px 10px;
                    border-radius: 3px 3px 0 0;
                    }
                    .table-title h2 {
                    margin: 5px 0 0;
                    font-size: 24px;
                }
                .table-title .btn {
                    color: #566787;
                    float: right;
                    font-size: 13px;
                    background: #fff;
                    border: none;
                    min-width: 50px;
                    border-radius: 2px;
                    border: none;
                    outline: none !important;
                    margin-left: 10px;
                }
                .table-title .btn:hover, .table-title .btn:focus {
                        color: #566787;
                    background: #f2f2f2;
                }
                .table-title .btn i {
                    float: left;
                    font-size: 21px;
                    margin-right: 5px;
                }
                .table-title .btn span {
                    float: left;
                    margin-top: 2px;
                }
                    table.table-bordered th
                    {border:0px;}
                    table.table-bordered td
                    {border:0px;}
                    table.table tr th, table.table tr td {
                        border-color: #e9e9e9;
                    
                    vertical-align: middle;
                    }
                table.table tr th:first-child {
                    width: 60px;
                }
                table.table tr th:last-child {
                    width: 100px;
                }
                    table.table-striped tbody tr:nth-of-type(odd) {
                    background-color: #fcfcfc;
                }
                table.table-striped.table-hover tbody tr:hover {
                    background: #f5f5f5;
                }
                    table.table th i {
                        font-size: 13px;
                        margin: 0 5px;
                        cursor: pointer;
                    }	
                    table.table td:last-child i {
                    opacity: 0.9;
                    font-size: 22px;
                        margin: 0 5px;
                    }
                table.table td a {
                    font-weight: bold;
                    color: #566787;
                    display: inline-block;
                    text-decoration: none;
                }
                table.table td a:hover {
                    color: #2196F3;
                }
                table.table td a.settings {
                        color: #2196F3;
                    }
                    table.table td a.delete {
                        color: #F44336;
                    }
                    table.table td i {
                        font-size: 19px;
                    }
                table.table .avatar {
                    border-radius: 50%;
                    vertical-align: middle;
                    margin-right: 10px;
                        height: 60px;
                        width: 60px;
                }
                .status {
                    font-size: 30px;
                    margin: 2px 2px 0 0;
                    display: inline-block;
                    vertical-align: middle;
                    line-height: 10px;
                }
                    .text-success {
                        color: #10c469;
                    }
                    .text-info {
                        color: #62c9e8;
                    }
                    .text-warning {
                        color: #FFC107;
                    }
                    .text-danger {
                        color: #ff5b5b;
                    }
                    .pagination {
                        float: right;
                        margin: 0 0 5px;
                    }
                    .pagination li a {
                        border: none;
                        font-size: 13px;
                        min-width: 30px;
                        min-height: 30px;
                        color: #999;
                        margin: 0 2px;
                        line-height: 30px;
                        border-radius: 2px !important;
                        text-align: center;
                        
                    }
                    .pagination li a:hover {
                        color: #666;
                    }	
                    .pagination li.active a, .pagination li.active a.page-link {
                        background: #03A9F4;
                    }
                    .pagination li.active a:hover {        
                        background: #0397d6;
                    }
                .pagination li.disabled i {
                        color: #ccc;
                    }
                    .pagination li i {
                        font-size: 16px;
                        padding-top: 6px
                    }
                    .hint-text {
                        float: left;
                        margin-top: 10px;
                        font-size: 13px;
                    }
        </style>
    </head>
    <body>
        <form method="post">
    <div class="container-fluid px-4">
                        <h1 class="mt-4">Users</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php?page=users">Users</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>    
                        <div class="row px-3 mb-4"></div>                    
                        <div class="card mb-4">                            
                            <div class="card-body">
                                <div class="table-wrapper">
                                    <div class="adv-table">
                                        <table id="datatablesSimple" class="display table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>						
                                                    <th>Number of Diagrams</th>
                                                    <th>Recovery Email</th>
                                                    <th>Acces to Website</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                <th>#</th>
                                                    <th>Name</th>						
                                                    <th>Number of Diagrams</th>
                                                    <th>Recovery Email</th>
                                                    <th>Acces to Website</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                    include_once '../database.php';
                                                    $database = new Database();
                                                    $db = $database->getConnection();
                                                    $rec = $db->query("SELECT * FROM user")->fetchAll(PDO::FETCH_OBJ);
                                                    $totals = sizeof($rec);
                                                    for ($x = 0; $x < $totals; $x++) {
                                                    echo('<tr class="gradeX">');
                                                    $ch ='';
                                                    $dgc = $db->query("SELECT count(id) \"no\" FROM diagram where user =".$rec[$x]->id)->fetchAll(PDO::FETCH_OBJ);
                                                        echo('<td>'.$x.' </td>');
                                                        echo('<td> <strong>'.$rec[$x]->nom .' </strong>'.$rec[$x]->prenom.' </td>');
                                                        echo('<td><strong> '.$dgc[0]->no.'</strong> </td>');
                                                        echo('<td class="center hidden-phone"> '.$rec[$x]->em_recup.'</td>');
                                                        echo('<td class="center hidden-phone"><strong> '.$rec[$x]->acces.'</strong></td>');
                                                        echo("<td>");
                                                        if($rec[0]->acces == "Enable")
                                                            {echo('<button type="submit" value="'.$rec[$x]->id.'" class="btn btn-primary btn-xs" name="block"><i class="fa fa-ban"></i></button>');}
                                                        else{echo('<button type="submit" value="'.$rec[$x]->id.'" class="btn btn-primary btn-xs" name="validate"><i class="fa fa-check"></i></button>');}
                                                        echo('<button type="submit" value="'.$rec[$x]->id.'" class="btn btn-primary btn-xs" name="delete"><i class="fa fa-trash"></i></button>');
                                                        echo("</td>");
                                                        echo('</tr>');
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </form>
                </body>
</html>