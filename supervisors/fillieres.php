<!DOCTYPE html>
<html lang="fr">
    <?php
    include_once '../../database.php';
    $database = new Database();
    $db = $database->getConnection();
    if (isset($_POST['block'])) {
        $q='UPDATE etudiant SET statut="Rejeter" where id='.$_POST["block"];
        $db->exec($q); 
    }
    if (isset($_POST['validate'])) {
        $q='UPDATE etudiant SET statut="Valider" where id='.$_POST["validate"];
        $db->exec($q); 
    }
    ?>
    <body >
        <div class="container-fluid px-4">
            <h1 class="mt-4">Fillieres</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php?page=fillieres">Dashboard</a></li>
                <li class="breadcrumb-item active">Fillieres</li>
            </ol>    
            <div>
                <a href="index.php?page=new_filliere" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Nouvelle Fillieres</a>
            </div>
            
            <div class="row px-3 mb-4"></div>                    
            <div class="card mb-4">                            
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Departement</th>
                                <th>Annee de Creation</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nom</th>
                                <th>Departement</th>
                                <th>Annee de Creation</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        <?php
                            include_once '../../database.php';
                            $database = new Database();
                            $db = $database->getConnection();
                            $rec = $db->query("SELECT * FROM fillieres")->fetchAll(PDO::FETCH_OBJ);
                            $totals = sizeof($rec);
                            for ($x = 0; $x < $totals; $x++) {
                                $dep = $db->query("SELECT * FROM departement where id =".$rec[$x]->departement)->fetchAll(PDO::FETCH_OBJ);
                                echo('<tr class="gradeX">');
                                echo('<td> <strong>'.$rec[$x]->nom.'</strong></td>');
                                echo('<td> '.$dep[0]->nom .'</td>');
                                echo('<td> '.$rec[$x]->Creation.'</td>');
                                echo("<td>");
                                echo('<button type="submit" formaction="index.php?page=editFilliere&ind='.$rec[$x]->id.'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>');
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
