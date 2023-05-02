

<!DOCTYPE html>
<html lang="fr">
<?php
session_start();
if($_SESSION["aactive"] == null){
  header("Location: ../asignin.php");
  exit();
}
elseif($_SESSION["aactive"] == false){
    header("Location: ../asignin.php");
  exit();
}
if (isset($_POST['edit'])) {
$_SESSION["auserId"] = $_POST['edit'];
header("Location: ../homePage/profile.php");
exit();}
?>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Plateforme d'annuaire de l'universite de Ngaoundere" />
        <meta name="title" content="DANG / Annnuaire" />
        <meta name="author" content="Camaroes Sarl" />
        <title>Annuaire /Panel</title>
        <link href="./css/datatables.css" rel="stylesheet" />
        <link href="./css/style.css" rel="stylesheet" />
        <script src="./js/fontawesome_all.js" crossorigin="anonymous"></script>
          <!-- Favicons -->
  <link href="../../assets/img/universite.jfif" rel="icon">
  <link href="../../assets/img/universite.jfif" rel="apple-touch-icon">
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="homeAdmin.html">Start Aministrator Page</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                           
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <?php
                            if($_SESSION["auserId"]=="1"){
                            echo('
                            <a class="nav-link" href="index.php?page=adminlist">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Administrateurs
                            </a>
                            ');}
                            ?>
                            <div class="sb-sidenav-menu-heading">Services</div>
                            <a class="nav-link collapsed" href="index.php?page=users">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                    Manage Users
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>                          
                            <div class="sb-sidenav-menu-heading">Profile</div>
                            <a class="nav-link" href="index.php?page=aprofile">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                My Profile
                            </a>
                            <a class="nav-link" href="../asignin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Signout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Administrator <br><?php  echo($_SESSION["auserName"]);?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <form method="post">
                        <?php
                        @$page="./".$_GET["page"];
                        if($page!="./")
                        $page =$page.".php";
                        else
                        $page="./welcome.php";
                        include_once($page);
                        ?>
                    </form>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Annuaire 2022</div>                           
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="./js/bootstrap_bundle_min.js"></script>
        <script src="./js/scripts.js"></script>
        <script src="./js/datatable_last.js"></script>
        <script src="./js/datatables-simple-demo.js"></script>
    </body>
</html>
