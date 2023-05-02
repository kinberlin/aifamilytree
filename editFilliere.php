<!DOCTYPE html>
<html lang="fr">
<html lang="en">
    <?php
    include_once '../../database.php';
    $database = new Database();
    $db = $database->getConnection();
    if (isset($_POST['add'])) {
        $nom = $_POST["nom"];
        $year = $_POST["year"];
        $dep = $_POST["departement"];
        $fil = $_POST["fil"];
        //echo('<script>alert("ok");</script>');
        if(strlen($year) == 4){
        $q="UPDATE fillieres set nom = '$nom' ,Creation = '$year' , departement = $dep where id=$fil";
        $db->exec($q);  }
        else{$q="UPDATE fillieres set nom = '$nom' , departement = $dep where id=$fil";
            $db->exec($q);}
    }
    ?>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Mettre a jour une filliere</h3></div>
                                    <div class="card-body">
                                        <form method="post">
                                        <?php
                                            include_once '../../database.php';
                                            $database = new Database();
                                            $db = $database->getConnection();
                                            $l = $_GET["ind"];
                                            $rec = $db->query("SELECT * FROM fillieres where id=".$l)->fetchAll(PDO::FETCH_OBJ);
                                            $dep = $db->query("SELECT * FROM departement")->fetchAll(PDO::FETCH_OBJ);
                                            echo('
                                            <input type="hidden" name="fil" value="'.$l.'" required/>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="text" name="nom" placeholder="TIC par exemple" value="'.$rec[0]->nom.'" required/>
                                                <label for="inputEmail">Nom de la Filliere</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="number" name="year" value="'.$rec[0]->Creation.'" placeholder="lannee uniquement"/>
                                                <label for="inputPassword">Annee de Creation de la Filliere </label>
                                            </div>
                                            <div class="form-floating mb-3">
                                            <select name="departement" class="form-control"  required>
                                            ');
                                            foreach ($dep as $item) {
                                                if($item->id == $rec[$x]->departement){
                                                echo('<option value="'.$item->id.'" selected>'.$item->nom.'</option>');}
                                                else{echo('<option value="'.$item->id.'">'.$item->nom.'</option>');}
                                            }
                                            echo('
                                            </select>
                                            <label><h6 class="mb-0 text-sm">Departement</h6></label>

                                        </div>
                                            ');
                                            ?>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary btn-xs" name="add">Enregistrer</button>;
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small">Si vous ne vous rappellez plus de la date de creation de la filliere, laissez le champ vide. L'ancienne date sera conserver.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>            
        </div>
    </body>
</html>
