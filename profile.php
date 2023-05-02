<!DOCTYPE html>
<html lang="fr">
<head>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">

  <link href="../../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="../../assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/profile.css">
</head>
<body>
  <div class="container emp-profile shadow-lg p-3 mb-5 bg-white rounded">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-img">
                  <?php
                      include_once '../../database.php';
                      //$_SESSION["active"] = false;
                      $l = $_GET["ind"];
                      $database = new Database();
                      $db = $database->getConnection();
                      $rec = $db->query("SELECT * FROM etudiant where id=".$l)->fetchAll(PDO::FETCH_OBJ);
                      $fill = $db->query("SELECT * FROM fillieres where id=".$rec[0]->fillieres)->fetchAll(PDO::FETCH_OBJ);
                      $etu = $db->query("SELECT * FROM etude where id=".$rec[0]->niveau_etude)->fetchAll(PDO::FETCH_OBJ);
                      $totals = sizeof($rec);
                  echo('
                  <a href="'.$rec[0]->photo.'"><img src="'.$rec[0]->photo.'" alt="" i/></a>
                  ');
                  echo('</div> </div>');
                echo('
                <div class="col-md-6">
                <div class="profile-head">
                    <h5>
                        '.$rec[0]->nom. ' '.$rec[0]->prenom.'
                    </h5>
                    <h6>
                        '.$rec[0]->metier.'
                    </h6>
                    <p ><strong>Fillieres : </strong><span>'.$fill[0]->nom.'</span></p>
                    <p ><strong>Promotion : </strong><span>'.$rec[0]->promotion.'-'.($rec[0]->promotion+1).'</span></p>
                    <p ><strong>Niveau : </strong><span>'.$etu[0]->nom.'</span></p>
                    <p ><strong>Profile Professionnel : </strong><a href="'.$rec[0]->linkedin.'">Linked<i class="bi bi-linkedin"></i></a></p>
                    <p><a href="'.$rec[0]->cv.'">Voir mon CV</a></p>
                    <p class="proile-rating" ><strong>Etat du Profile : </strong><span style="color: #009900">'.$rec[0]->statut.' </span> par l\'administration</p>
                    <p ><strong>Niveau : </strong><span>'.$etu[0]->nom.'</span></p>
                    <p ><strong>Date dInscription sur la plateforme : </strong><span>'.$rec[0]->CreatedAt.'</span></p>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                        </li>
                    </ul>
                </div>
                </div>
                ');
                /*echo(' <div class="col-md-2">
                <a href="./editProfile.php"><input type="submit" class="profile-edit-btn" style="color: #009900" name="valider" value="Valider"/></a>
                <a href="./editProfile.php"><input type="submit" class="profile-edit-btn" style="color: red" name="douteux" value="Douteux"/></a>
                </div>');*/
                echo('
                <div class="row">
                <div class="col-md-4">
                    <div class="profile-work">
                        <p>COMPETENCES</p>');
                        $ch = '';
                        $jb = $db->query("SELECT * FROM job where id =".$rec[0]->job)->fetchAll(PDO::FETCH_OBJ);
                        $comp = $db->query("SELECT * FROM competences  where etudiant =".$l)->fetchAll(PDO::FETCH_OBJ);
                        for($y = 0; $y < sizeof($comp); $y++){
                            $ch .= '<strong>'. $comp[$y]->intitule . '</strong><br>';
                          }
                echo($ch.'
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Nom</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>'.$rec[0]->nom.'</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Prenom</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>'.$rec[0]->prenom.'</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Email</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>'.$rec[0]->email.'</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Telehone</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>'.$rec[0]->telephone.'</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Profession</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>'.$rec[0]->metier.'</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Occupation</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>'.$jb[0]->nom.'</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Ville</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>'.$rec[0]->ville.'</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Pays</label>
                                        </div>
                                        <div class="col-md-6">
                                            <p>'.$rec[0]->pays.'</p>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
                ');
                echo('');

                ?>
        </div>          
    </div>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->

  <script src="../../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../../assets/vendor/aos/aos.js"></script>
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/js/glightbox/glightbox.min.js"></script>
  <script src="../../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../../assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="../../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../../assets/js/main.js"></script>
  <script>
    const image_input = document.querySelector("#image-input");image_input.addEventListener("change", function() {
  const reader = new FileReader();
  reader.addEventListener("load", () => {
    const uploaded_image = reader.result;
    document.querySelector("#display-image").style.backgroundImage = `url(${uploaded_image})`;
  });
  reader.readAsDataURL(this.files[0]);
});
  </script>
</body>

</html>