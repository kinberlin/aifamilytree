<!DOCTYPE html>
<html lang="fr">
    <?php
    include_once '../database.php';
    $database = new Database();
    $db = $database->getConnection();
    if (isset($_POST['add'])) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $em = $_POST["em"];
        $id = $_POST["id"];
        $telephone = $_POST["telephone"];
        $password = $_POST["password"];
        //echo('<script>alert("ok");</script>');
        $q="UPDATE administrateur SET name='$nom', surname='$prenom' ,em_recup='$em', password='$password',telephone='$telephone' where id=$id";
        //echo($q);echo($q);
        $db->exec($q);  
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Mettre a Jour vos Informations</h3></div>
                                    <div class="card-body">
                                        <form method="post">
                                        <?php
                                            include_once '../database.php';
                                            //$_SESSION["active"] = false;
                                            $l = $_SESSION["auserId"];
                                            $database = new Database();
                                            $db = $database->getConnection();
                                            $rec = $db->query("SELECT * FROM administrateur where id=".$l)->fetchAll(PDO::FETCH_OBJ);
                                            echo('
                                            <div class="form-floating mb-3">
                                                <input type="hidden" name="id" value="'.$rec[0]->id.'"/>
                                                <input class="form-control" id="inputEmail" type="text" name="nom" value="'.$rec[0]->name.'" minlength="2" maxlength="20" required/>
                                                <label for="inputEmail">Nom</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="text" name="prenom" value="'.$rec[0]->surname.'" minlength="2" maxlength="20" required/>
                                                <label for="inputEmail">Prenom</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="em" value="'.$rec[0]->em_recup.'" required/>
                                                <label for="inputEmail">Email de Recuperation de Compte</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="text" name="telephone" value="'.$rec[0]->telephone.'" minlength="9" maxlength="20" required/>
                                                <label for="inputEmail">Telephone</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" name="password" value="'.$rec[0]->password.'"/>
                                                <label for="inputPassword">Mot de Passe </label>
                                            </div>
                                            ');
                                            ?>
                                            
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary btn-xs" name="add">Enregistrer</button>;
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small">Noubliez pas de renseigner tout les champs. Ils sont obligatoires.Notez bien qu'il vous est impossible de mettre a jour votre email de login pour des raisons fonctionnels.<br> <strong>Par contre, vous pouvez mettre a jour votre adresse mail de recuperation de compte.</strong> </div>
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
