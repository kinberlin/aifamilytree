<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Bootstrap core CSS -->
  <link href="./js/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="./js/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="cssa/zabuto_calendar.css">
  <link rel="stylesheet" type="text/css" href="./js/lib/gritter/css/jquery.gritter.css" />
  <!-- Custom styles for this template -->
  <link href="cssa/style.css" rel="stylesheet">
  <link href="cssa/style-responsive.css" rel="stylesheet">
  <script src="./js/lib/chart-master/Chart.js"></script>
</head>

<body>
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content" style="margin-left: 60px;">
      <section class="wrapper">
          <?php
              //initialising database
              include_once '../database.php';
              $database = new Database();
              $db = $database->getConnection();
              //initialise finished
          $yy = date('Y');
          $mm =date('m'); 
          //echo($yy.' ' .$mm);
          $vism = $db->query("SELECT COUNT(visitor) as visit FROM activity WHERE month(dates) = $mm and year(dates)= $yy")->fetchAll(PDO::FETCH_OBJ);
          $connexion = $db->query("SELECT COUNT(visitor) as visit FROM activity WHERE month(dates) = $mm and year(dates)= $yy and page=4")->fetchAll(PDO::FETCH_OBJ);
          $newlogin = (($connexion[0]->visit/$vism[0]->visit) * 100);
          $allvisits = $db->query("SELECT COUNT(visitor) as visit FROM activity ")->fetchAll(PDO::FETCH_OBJ);
          $profiles = $db->query("SELECT COUNT(id) as profil FROM user ")->fetchAll(PDO::FETCH_OBJ);
          $completed = $db->query("SELECT COUNT(u.id) as profil FROM user u where (SELECT COUNT(d.id) FROM diagram d where d.user = u.id ) = 5; ")->fetchAll(PDO::FETCH_OBJ);
          $completed_percent = (int)(($completed[0]-> profil/$profiles[0]->profil) * 100);
          $visitors = $db->query("SELECT COUNT(visitor_ip) as visit FROM page_views ")->fetchAll(PDO::FETCH_OBJ);;
          $JAN = $db->query("SELECT COUNT(visitor) as visit, (COUNT(visitor)/2000 *100) as percent FROM activity WHERE month(dates) = 01 and year(dates)= $yy")->fetchAll(PDO::FETCH_OBJ);
          $FEB = $db->query("SELECT COUNT(visitor) as visit, (COUNT(visitor)/2000 *100) as percent FROM activity WHERE month(dates) = 02 and year(dates)= $yy")->fetchAll(PDO::FETCH_OBJ);
          $MAR = $db->query("SELECT COUNT(visitor) as visit, (COUNT(visitor)/2000 *100) as percent FROM activity WHERE month(dates) = 03 and year(dates)= $yy")->fetchAll(PDO::FETCH_OBJ);
          $APR = $db->query("SELECT COUNT(visitor) as visit, (COUNT(visitor)/2000 *100) as percent FROM activity WHERE month(dates) = 04 and year(dates)= $yy")->fetchAll(PDO::FETCH_OBJ);
          $MAY = $db->query("SELECT COUNT(visitor) as visit, (COUNT(visitor)/2000 *100) as percent FROM activity WHERE month(dates) = 05 and year(dates)= $yy")->fetchAll(PDO::FETCH_OBJ);
          $JUN = $db->query("SELECT COUNT(visitor) as visit, (COUNT(visitor)/2000 *100) as percent FROM activity WHERE month(dates) = 06 and year(dates)= $yy")->fetchAll(PDO::FETCH_OBJ);
          $JUL = $db->query("SELECT COUNT(visitor) as visit, (COUNT(visitor)/2000 *100) as percent FROM activity WHERE month(dates) = 07 and year(dates)= $yy")->fetchAll(PDO::FETCH_OBJ);
          $AUG = $db->query("SELECT COUNT(visitor) as visit, (COUNT(visitor)/2000 *100) as percent FROM activity WHERE month(dates) = 08 and year(dates)= $yy")->fetchAll(PDO::FETCH_OBJ);
          $SEP = $db->query("SELECT COUNT(visitor) as visit, (COUNT(visitor)/2000 *100) as percent FROM activity WHERE month(dates) = 09 and year(dates)= $yy")->fetchAll(PDO::FETCH_OBJ);
          $OCT = $db->query("SELECT COUNT(visitor) as visit, (COUNT(visitor)/2000 *100) as percent FROM activity WHERE month(dates) = 10 and year(dates)= $yy")->fetchAll(PDO::FETCH_OBJ);
          $NOV = $db->query("SELECT COUNT(visitor) as visit, (COUNT(visitor)/2000 *100) as percent FROM activity WHERE month(dates) = 11 and year(dates)= $yy")->fetchAll(PDO::FETCH_OBJ);
          $DEC = $db->query("SELECT COUNT(visitor) as visit, (COUNT(visitor)/2000 *100) as percent FROM activity WHERE month(dates) = 12 and year(dates)= $yy")->fetchAll(PDO::FETCH_OBJ);
         // $completed = $db->query("SELECT COUNT(id) as total, (COUNT(visitor)/2000 *100) as percent FROM activity WHERE month(dates) = 12 and year(dates)= $yy")->fetchAll(PDO::FETCH_OBJ);
          
          echo('
          <div class="row">
          <div class="col-lg-9 main-chart">
            <!--CUSTOM CHART START -->
            <div class="border-head">
              <h3>User Visits</h3>
            </div>
            <div class="custom-bar-chart">
              <ul class="y-axis">
                <li><span>2.000</span></li>
                <li><span>1.500</span></li>
                <li><span>1.000</span></li>
                <li><span>5.00</span></li>
                <li><span>1.00</span></li>
                <li><span>0</span></li>
              </ul>');
              if($mm <=6){
              echo('
              <div class="bar">
                <div class="title">JAN</div>
                <div class="value tooltips" data-original-title="'.$JAN[0]->visit.'" data-toggle="tooltip" data-placement="top">'.$JAN[0]->percent.'%</div>
              </div>
              <div class="bar ">
                <div class="title">FEB</div>
                <div class="value tooltips" data-original-title="'.$FEB[0]->visit.'" data-toggle="tooltip" data-placement="top">'.$FEB[0]->percent.'%</div>
              </div>
              <div class="bar ">
                <div class="title">MAR</div>
                <div class="value tooltips" data-original-title="'.$MAR[0]->visit.'" data-toggle="tooltip" data-placement="top">'.$MAR[0]->percent.'%</div>
              </div>
              <div class="bar ">
                <div class="title">APR</div>
                <div class="value tooltips" data-original-title="'.$APR[0]->visit.'" data-toggle="tooltip" data-placement="top">'.$APR[0]->percent.'%</div>
              </div>
              <div class="bar">
                <div class="title">MAY</div>
                <div class="value tooltips" data-original-title="'.$MAY[0]->visit.'" data-toggle="tooltip" data-placement="top">'.$MAY[0]->percent.'%</div>
              </div>
              <div class="bar ">
                <div class="title">JUN</div>
                <div class="value tooltips" data-original-title="'.$JUN[0]->visit.'" data-toggle="tooltip" data-placement="top">'.$JUN[0]->percent.'%</div>
              </div>');
              }else{
              echo('
              <div class="bar">
                <div class="title">JUL</div>
                <div class="value tooltips" data-original-title="'.$JUL[0]->visit.'" data-toggle="tooltip" data-placement="top">'.$JUL[0]->percent.'%</div>
              </div>
              <div class="bar ">
                <div class="title">AUG</div>
                <div class="value tooltips" data-original-title="'.$AUG[0]->visit.'" data-toggle="tooltip" data-placement="top">'.$AUG[0]->percent.'%</div>
              </div>
            <div class="bar ">
              <div class="title">SEP</div>
              <div class="value tooltips" data-original-title="'.$SEP[0]->visit.'" data-toggle="tooltip" data-placement="top">'.$SEP[0]->percent.'%</div>
            </div>
            <div class="bar">
              <div class="title">OCT</div>
              <div class="value tooltips" data-original-title="'.$OCT[0]->visit.'" data-toggle="tooltip" data-placement="top">'.$OCT[0]->percent.'%</div>
            </div>
            <div class="bar ">
              <div class="title">NOV</div>
              <div class="value tooltips" data-original-title="'.$NOV[0]->visit.'" data-toggle="tooltip" data-placement="top">'.$NOV[0]->percent.'%</div>
            </div>
            <div class="bar">
              <div class="title">DEC</div>
              <div class="value tooltips" data-original-title="'.$DEC[0]->visit.'" data-toggle="tooltip" data-placement="top">'.$DEC[0]->percent.'%</div>
            </div>');
              }
              echo('
          </div>
            <!--custom chart end-->
            <div class="row mt">
              <!-- SERVER STATUS PANELS -->
              <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn donut-chart">
                  <div class="grey-header">
                    <h5>Number of SignIn</h5>
                  </div>
                  <canvas id="serverstatus01" height="120" width="120"></canvas>
                  <script>
                    var doughnutData = [{
                        value: '.(100-($newlogin)+1).',
                        color: "#FF6B6B"
                      },
                      {
                        value: '.$newlogin.',
                        color: "#fdfdfd"
                      }
                    ];
                    var myDoughnut = new Chart(document.getElementById("serverstatus01").getContext("2d")).Doughnut(doughnutData);
                  </script>
                  <div class="row">
                    <div class="col-sm-6 col-xs-6 goleft">
                      <p>Signin<br/>This Month:</p>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <h2>'.(int)$newlogin.'%</h2>
                    </div>
                  </div>
                </div>
                <!-- /grey-panel -->
              </div>
              <!-- /col-md-4-->
              <div class="col-md-4 col-sm-4 mb">
                <div class="darkblue-panel pn">
                  <div class="darkblue-header">
                    <h5>NUMBER OF USERS</h5>
                  </div>
                  <canvas id="serverstatus02" height="120" width="120"></canvas>
                  <script>
                    var doughnutData = [{
                        value: '.(100-(($profiles[0]->profil/1000000)*100)).',
                        color: "#1c9ca7"
                      },
                      {
                        value: '.(($profiles[0]->profil/1000000)*100).',
                        color: "#f68275"
                      }
                    ];
                    var myDoughnut = new Chart(document.getElementById("serverstatus02").getContext("2d")).Doughnut(doughnutData);
                  </script>
                  <p>'.date('D-d-M-Y').'</p>
                  <footer>
                    <div class="pull-left">
                      <h8 ><i class="fa fa-hdd-o"></i><strong> 1 000 000 Awaited</strong></h8>
                    </div>
                    <div class="pull-right">
                      <h5>'.$profiles[0]->profil.' Etudiant</h5>
                    </div>
                  </footer>
                </div>
                <!--  /darkblue panel -->
              </div>
              <!-- /col-md-4 -->
              <div class="col-md-4 col-sm-4 mb">
                <!-- REVENUE PANEL -->
                <div class="green-panel pn">
                  <div class="green-header">
                    <h5>VISITS</h5>
                  </div>
                  <div class="chart mt">
                    <div class="sparkline" data-type="line" data-resize="true" data-height="75" data-width="90%" data-line-width="1" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="4" data-data="['.$JAN[0]->visit.','.$FEB[0]->visit.','.$MAR[0]->visit.','.$APR[0]->visit.','.$MAY[0]->visit.','.$JUN[0]->visit.','.$JUL[0]->visit.','.$AUG[0]->visit.','.$SEP[0]->visit.','.$OCT[0]->visit.','.$NOV[0]->visit.','.$DEC[0]->visit.']"></div>
                  </div>
                  <p class="mt"><b>'.$allvisits[0]->visit .'</b><br/>Total Visits<br> Total Visitors : '.$visitors[0]->visit.'</p>
                </div>
              </div>
              <!-- /col-md-4 -->
            </div>
            <!-- /row -->

            <div class="row">
              <!-- TWITTER PANEL -->
              <div class="col-md-4 mb">
                <div class="twitter-panel pn">
                  <i class="fa fa-twitter fa-4x"></i>
                  <p>We are there. How can we help you ? Good Word!.</p>
                  <p class="user">@camaroes_sarl</p>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 mb">
              <div class="green-panel pn">
                <div class="green-header">
                  <h5>USERS WITH 05 Diagrams</h5>
                </div>
                <canvas id="serverstatus03" height="120" width="120"></canvas>
                <script>
                  var doughnutData = [{
                      value: '.(100-($completed_percent)).',
                      color: "#2b2b2b"
                    },
                    {
                      value: '.$completed_percent.',
                      color: "#fffffd"
                    }
                  ];
                  var myDoughnut = new Chart(document.getElementById("serverstatus03").getContext("2d")).Doughnut(doughnutData);
                </script>
                <h3>'.$completed_percent.'% Completed</h3>
              </div>
            </div>
            <!-- /col-md-4 -->
            <!-- /row -->
          </div>
          <!-- /col-lg-9 END SECTION MIDDLE -->
          <!-- **********************************************************************************************************************************************************
              RIGHT SIDEBAR CONTENT
              *********************************************************************************************************************************************************** -->
        </div>
          ');
          echo("");
          echo("");
          echo("");
          echo("");
          echo("");
          echo("");
          echo("");
          ?>

        <!-- /row -->
      </section>
    </section>
    <!--main content end-->
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="./js/lib/jquery/jquery.min.js"></script>

  <script src="./js/lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="./js/lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="./js/lib/jquery.scrollTo.min.js"></script>
  <script src="./js/lib/jquery.nicescroll.js" type="text/javascript"></script>
  <script src="./js/lib/jquery.sparkline.js"></script>
  <!--common script for all pages-->
  <script src="./js/lib/common-scripts.js"></script>
  <script type="text/javascript" src="./js/lib/gritter/js/jquery.gritter.js"></script>
  <script type="text/javascript" src="./js/lib/gritter-conf.js"></script>
  <!--script for this page-->
  <script src="./js/lib/sparkline-chart.js"></script>
  <script src="./js/lib/zabuto_calendar.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      var unique_id = $.gritter.add({
        // (string | mandatory) the heading of the notification
        title: 'Welcome to DANG ANNUAIRE DASHBOARD!',
        // (string | mandatory) the text inside the notification
        text: 'Appreciate our skills and effort to display the most usefull informstions on to you.',
        // (string | optional) the image to display on the left
        image: '../../assets/img/universite.jfif',
        // (bool | optional) if you want it to fade out on its own or just sit there
        sticky: false,
        // (int | optional) the time you want it to be alive for before fading out
        time: 8000,
        // (string | optional) the class name you want to apply to that specific message
        class_name: 'my-sticky-class'
      });

      return false;
    });
  </script>
  <script type="application/javascript">
    $(document).ready(function() {
      $("#date-popover").popover({
        html: true,
        trigger: "manual"
      });
      $("#date-popover").hide();
      $("#date-popover").click(function(e) {
        $(this).hide();
      });

      $("#my-calendar").zabuto_calendar({
        action: function() {
          return myDateFunction(this.id, false);
        },
        action_nav: function() {
          return myNavFunction(this.id);
        },
        ajax: {
          url: "show_data.php?action=1",
          modal: true
        },
        legend: [{
            type: "text",
            label: "Special event",
            badge: "00"
          },
          {
            type: "block",
            label: "Regular event",
          }
        ]
      });
    });

    function myNavFunction(id) {
      $("#date-popover").hide();
      var nav = $("#" + id).data("navigation");
      var to = $("#" + id).data("to");
      console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
    }
  </script>
</body>

</html>
