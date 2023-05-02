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
        //echo('<script>alert("ok");</script>');
        if(strlen($year) == 4){
        $q="INSERT INTO fillieres(nom,Creation, departement) VALUES ('$nom','$year',$dep)";
        $db->exec($q);}
        else{$q="INSERT INTO fillieres(nom, departement) VALUES ('$nom',$dep)";
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Ajouter une filliere</h3></div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="text" name="nom" placeholder="TIC par exemple" required/>
                                                <label for="inputEmail">Nom de la Filliere</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="number" name="year" placeholder="l'annee uniquement"/>
                                                <label for="inputPassword">Annee de Creation de la Filliere </label>
                                            </div>
                                            <div class="form-floating mb-3">
                                            <select name="departement" class="form-control"  required>
                                                <?php
                                                    include_once '../../database.php';
                                                    $database = new Database();
                                                    $db = $database->getConnection();
                                                    $rec = $db->query("SELECT * FROM departement")->fetchAll(PDO::FETCH_OBJ);
                                                    foreach ($rec as $item) {
                                                        echo('<option value="'.$item->id.'" >'.$item->nom.'</option>');
                                                    }
                                                ?>
                                                </select>
                                                <label><h6 class="mb-0 text-sm">Departement</h6></label>

                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary btn-xs" name="add">Ajouter</button>;
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small">Si vous ne connaissez pas la date de creation de la filliere, laissez le champ vide il sera par defaut 1993.</div>
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
