<!DOCTYPE html>
<html lang="fr">
    <?php
    include_once '../../database.php';
    $database = new Database();
    $db = $database->getConnection();
    if (isset($_POST['add'])) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $telephone = $_POST["telephone"];
        $password = $_POST["password"];
        $em = $_POST["em"];
        $q="INSERT INTO  administrateur ( nom ,  prenom ,  login ,  password ,  telephone, em_recup ) 
        VALUES ('$nom','$prenom','$email','$password','$telephone', '$em')";
        //echo($q);echo($q);
        $db->exec($q);
        echo('<script>alert("Enregistrement Effectuer.");</script>');
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Ajouter un Administrateur</h3></div>
                                    <div class="card-body">
                                        <form method="get">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="text" name="nom" placeholder="Nom de l'utilisateur" minlength="2" maxlength="20" required/>
                                                <label for="inputEmail">Nom</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="text" name="prenom" placeholder="Nom de l'utilisateur" minlength="2" maxlength="20" required/>
                                                <label for="inputEmail">Prenom</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="email" placeholder="Email de l'utilisateur"  required/>
                                                <label for="inputEmail">Email</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="em" required/>
                                                <label for="inputEmail">Email de Recuperation de Compte</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="text" name="telephone" placeholder="Telephone de l'utilisateur" minlength="9" maxlength="20" required/>
                                                <label for="inputEmail">Telephone</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Mot de passe"/>
                                                <label for="inputPassword">Mot de Passe </label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary btn-xs" name="add">Enregistrer</button>;
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small">Noubliez pas de renseigner tout les champs. Ils sont obligatoires.Notez bien que pour chaque administrateur creer,<br>vous ne pourrez que consulter son profil et uniquement lui retirer les droits de connexion.</div>
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
