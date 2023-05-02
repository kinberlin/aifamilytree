

<!DOCTYPE html>
<html lang="fr">
        <?php
            // Start the session
            session_start();
            if($_SESSION["active"] == null){
                header("Location: signin.php");
                exit();
            }
            elseif($_SESSION["active"] == false){
                header("Location: signin.php");
                exit();
            }
        ?>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Plateforme d'annuaire de l'universite de Ngaoundere" />
        <meta name="title" content="DANG / Annnuaire" />
        <meta name="author" content="Camaroes Sarl" />
        <title>Familly Tree | App</title>
        <link href="./css/datatables.css" rel="stylesheet" />
        <link href="./css/style.css" rel="stylesheet" />

        <link href="./css/font-awesome.css" rel="stylesheet" />
          <!-- Favicons -->
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="homeAdmin.html">My Familly Tree Page</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fa fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav" >
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" >
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                           
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-tachometer"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Services</div>
                            <a class="nav-link collapsed" href="index.php?page=fmtlist">
                                <div class="sb-nav-link-icon"><i class="fa fa-group"></i></div>
                                    View Family Trees
                                <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                            </a>
                            <a class="nav-link collapsed" href="index.php?page=aprofile">
                                <div class="sb-nav-link-icon"><i class="fa fa-gears"></i></div>
                                    My Profile
                                <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                            </a>                            
                            <a class="nav-link" href="signin.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-sign-out"></i></div>
                                Déconnexion
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php  echo($_SESSION["userName"]);?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                        <?php
                        @$page="./".$_GET["page"];
                        if($page!="./")
                        $page =$page.".php";
                        else
                        $page="./welcome.php";
                        include_once($page);
                        ?>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright@2023; FamilyTreeApp</div>                           
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
