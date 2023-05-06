<!DOCTYPE html>
<html lang="fr">
    <?php
    include_once './database.php';
    $database = new Database();
    $db = $database->getConnection();
    if (isset($_POST['add'])) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $id = $_POST["id"];
        $password = $_POST["password"];
        $em = $_POST["em"];
        //echo('<script>alert("ok");</script>');
        $q="UPDATE user SET nom='$nom', prenom='$prenom', em_recup = '$em' ,password='$password' where id=$id";
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Update your User Informations</h3></div>
                                    <div class="card-body">
                                        <form method="post">
                                        <?php
                                            include_once './database.php';
                                            //$_SESSION["active"] = false;
                                            $l = $_SESSION["userId"];
                                            $database = new Database();
                                            $db = $database->getConnection();
                                            $rec = $db->query("SELECT * FROM user where id=".$l)->fetchAll(PDO::FETCH_OBJ);
                                            echo('
                                            <div class="form-floating mb-3">
                                                <input type="hidden" name="id" value="'.$rec[0]->id.'"/>
                                                <input class="form-control" id="inputEmail" type="text" name="nom" value="'.$rec[0]->nom.'" minlength="2" maxlength="20" required/>
                                                <label for="inputEmail">Name</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="text" name="prenom" value="'.$rec[0]->prenom.'" minlength="2" maxlength="20" required/>
                                                <label for="inputEmail">Surname</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="text" name="em" value="'.$rec[0]->em_recup.'" minlength="2" maxlength="20" required/>
                                                <label for="inputEmail">Recovery Email</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" name="password" value="'.$rec[0]->password.'"/>
                                                <label for="inputPassword">Mot de Passe </label>
                                            </div>
                                            ');
                                            ?>
                                            
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary btn-xs" name="add">Save</button>;
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small">Don't forget to fill in all the entries. They must not be Empty.Note that for functional reasons related with the software, you can't update your login credential.</div>
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
