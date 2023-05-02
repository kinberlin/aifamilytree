<!DOCTYPE html>
<html lang="fr">
    <?php
    include_once '../database.php';
    $database = new Database();
    $db = $database->getConnection();
    if (isset($_POST['block'])) {
        $q='UPDATE administrateur SET acces="Disable" where id='.$_POST["block"];
        $db->exec($q); 
    }
    if (isset($_POST['validate'])) {
        $q='UPDATE administrateur SET acces="Enable" where id='.$_POST["validate"];
        $db->exec($q); 
    }
    ?>
    <body >
        <div class="container-fluid px-4">
            <h1 class="mt-4">Administrators</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php?page=adminlist">Dashboard</a></li>
                <li class="breadcrumb-item active">Administrators</li>
            </ol>    
            <div>
                <a href="index.php?page=newadmin" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Add an Administrator</a>
            </div>
            
            <div class="row px-3 mb-4"></div>                    
            <div class="card mb-4">                            
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Acces to Website</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Acces to Website</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        <?php
                            include_once '../database.php';
                            $database = new Database();
                            $db = $database->getConnection();
                            $rec = $db->query("SELECT * FROM administrateur where id!=1")->fetchAll(PDO::FETCH_OBJ);
                            $totals = sizeof($rec);
                            for ($x = 0; $x < $totals; $x++) {
                                echo('<tr class="gradeX">');
                                echo('<td> <strong>'.$rec[$x]->name.' '.$rec[$x]->surname.'</strong></td>');
                                echo('<td>'.$rec[$x]->login.'</td>');
                                echo('<td> '.$rec[$x]->telephone .'</td>');
                                echo('<td> '.$rec[$x]->acces.'</td>');
                                echo("<td>");
                                    echo('<button type="submit" value="'.$rec[$x]->id.'" class="btn btn-primary btn-xs" name="block"><i class="fa fa-ban"></i></button>');
                                    echo('<button type="submit" value="'.$rec[$x]->id.'" class="btn btn-primary btn-xs" name="validate"><i class="fa fa-check"></i></button>');
                                    echo('<button type="submit" formaction="index.php?page=setadmin&ind='.$rec[$x]->id.'" class="btn btn-primary btn-xs"><i class="fa fa-info"></i></button>');
                                echo("</td>");
                                echo('</tr>');
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
