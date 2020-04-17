<!DOCTYPE html>
<html lang="en">
<head>

    <title>Medicine Information</title>

    <!-- Metadata -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Pharmacy Website">
    <meta name="author" content="PESU Proj">
    <link rel="icon" href="img/favicon.png">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">

  <!-- Javascript -->
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway|Candal">

  <!-- Additional Styles -->
  <style type="text/css">
      #ad {
          max-width: 800px;
          max-height: 700px;
          height: auto;
          position: relative;
          overflow: auto;
          overflow-x:hidden;
          padding-left: 30px;
          border: solid rgba(0, 0, 255, 0.075) 3px;
      }
  </style>
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
    <!--banner-->
    <section id="banner" class="banner">
        <div class="bg-color">
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="col-md-12">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
                            <a class="navbar-brand" href="#"><img src="img/logo.png" class="img-responsive" style="width: 140px; margin-top: -16px;"></a>
                        </div>
                        <div class="collapse navbar-collapse navbar-right" id="myNavbar">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="#banner">Home</a></li>
                                <li class=""><a href="index.html">Search</a></li>
                                <li class="active"><a href="#service">Medicine Info</a></li>
                                <li class=""><a href="user.html">Sign-Up/Login</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="container">
                <div class="row">
                    <div class="banner-info">
                        <div class="banner-logo text-center">
                            <img src="img/logo.png" class="img-responsive">
                        </div>
                        <div class="overlay-detail text-center">
                            <a href="#service"><i class="fa fa-angle-down"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main WebPage -->
    <div class="jumbotron">
        <h3 id=service class="display-4" align="center">Medicine Info</h3>
      	<br /><br />

        <?php

              $server = 'localhost';
              $username = 'root';
              $password = '';
              $database = 'medicine';


              //$mid = $_POST['mid'];
              $mid = $_GET['mid'];

              $db = mysqli_connect($server, $username, $password, $database)
                    or die('<b>Error Connecting to MySQL Server or Else DB Not Found!</b>');


              $query = "SELECT * FROM medicine m WHERE m.M_ID = $mid";

              $result = mysqli_query($db, $query);

              $row = mysqli_fetch_array($result);

              echo "<h2>".$row['Name']."&trade;</h2> <button class='btn btn-success' style='float: right; margin-right: 50px;'>In Stock</button><br />";
              echo "<h4>Information</h4><br/>";
              echo $row['Info'];
              echo "<br /><br /><br /><h4>Price : </h4> Rs.   ".$row['Price']."/- <br /><br /><br />";
              // Dosage to be Echoed
              ?>

              <div id="ad" style="float: right; margin-top: 50px;">
                <?php

                  $query = "
                            CREATE TEMPORARY TABLE IF NOT EXISTS apricetemp AS (
                            SELECT c.C_ID FROM medicine m, composition c WHERE m.M_ID = c.M_ID AND m.M_ID = $mid);

                              CREATE TEMPORARY TABLE IF NOT EXISTS bpricetemp AS (
                              SELECT c.C_ID FROM medicine m, composition c WHERE m.M_ID = c.M_ID AND m.M_ID = $mid);

                              CREATE TEMPORARY TABLE IF NOT EXISTS cpricetemp AS (
                              SELECT m.M_ID as `M_ID`, m.Name as `Name`, m.Price, c.C_ID FROM medicine m, composition c WHERE m.M_ID = c.M_ID );

                              SELECT * FROM cpricetemp WHERE C_ID IN (SELECT * FROM bpricetemp) GROUP BY M_ID
                               HAVING COUNT(*) = (SELECT count(*) FROM apricetemp) ORDER BY Price;

                               ";


                    echo "<br /><br /><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Other Similar Medicines&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3><br />";

                    if (mysqli_multi_query($db, $query)) {
                     do {
                            if ($result = mysqli_store_result($db)) {
                              if (mysqli_num_rows($result) != 0) {
                                while ($row = mysqli_fetch_row($result)) {
                                    $t = $row[0];
                                    echo "<li><a href='medicine-info.php?mid=$t'>".$row[1]."</a>  Rs. ".$row[2]." /- <br />";
                                }
                              }
                               mysqli_free_result($result);
                            }
                        } while (mysqli_next_result($db));
                    }

                    echo "<br /><br /><br /><br />";
                ?>

              </div>

              <?php
              $query = "SELECT * FROM medicine m, med_type t WHERE m.M_ID = $mid AND m.M_ID = t.M_ID;";
              $result = mysqli_query($db, $query);

              echo "<h4> Type </h4><br />This medication is available as : <br />";

              while ($row = mysqli_fetch_array($result)) {
                  echo "<li>".$row['type']."<br />";
              }


              $query = "SELECT * FROM medicine m, composition cmp, components c WHERE m.M_ID = $mid AND m.M_ID = cmp.M_ID AND cmp.C_ID = c.C_ID";
              $result = mysqli_query($db, $query);

              echo "<br /><br /><br /><h4>Composition</h4>";

              while ($row = mysqli_fetch_array($result)) {
                  $cid = $row['C_ID'];
                  echo "<li><a href='drug-info.php?cid=$cid'>".$row['cname']."</a><br />";
              }

              $query = "SELECT cname, C_ID FROM components WHERE components.C_ID =
                         (SELECT C_ID2 AS `cnamereq` FROM medicine m, composition cmp, components c, contraindication cin

                            WHERE m.M_ID = $mid AND m.M_ID = cmp.M_ID AND cmp.C_ID = c.C_ID AND c.C_ID = cin.C_ID1)

                        UNION

                        SELECT cname, C_ID FROM components WHERE components.C_ID =
                          (SELECT C_ID1 AS `cnamereq` FROM medicine m, composition cmp, components c, contraindication cin

                              WHERE m.M_ID = $mid AND m.M_ID = cmp.M_ID AND cmp.C_ID = c.C_ID AND c.C_ID = cin.C_ID2)";


              $result = mysqli_query($db, $query);

              echo "<br /><br /><h4>Contraindications</h4><br />";

              if (mysqli_num_rows($result) == 0) {
                echo "<font style='color:green'>No Contraindications!</font> <br />";
              } else {
                while ($row = mysqli_fetch_array($result)) {
                  $cid = $row['C_ID'];
                  echo "<li><a href='drug-info.php?cid=$cid' style='color:red'>".$row['cname']."</a></font><br />";
                }
              }

              $query = "SELECT sname FROM medicine m, symptoms s, treats t
                          WHERE
                             m.M_ID = $mid AND m.M_ID = t.M_ID AND t.S_ID = s.S_ID;";
              $result = mysqli_query($db, $query);

              echo "<br /><br /><h4>Treatment and Diagnosis</h4><br />";
              echo "This Medicine is used to treat the following symptoms/Dieases :-<br />";

               while ($row = mysqli_fetch_array($result)) {
                  echo "<li>".$row['sname']."<br />";
                }

              $query = "SELECT sname FROM medicine m, symptoms s, side_effects t
                          WHERE
                             m.M_ID = $mid AND m.M_ID = t.M_ID AND t.S_ID = s.S_ID;";
              $result = mysqli_query($db, $query);

              echo "<br /><br /><h4>Side Effects</h4><br />";

              if (mysqli_num_rows($result) == 0) {
                echo "<font style='color:green'>This Medicine has no known Side Effects. Seek Medical help if you experience any symptoms.</font> <br />";
                } else {
                 echo "This Medicine may cause the following symptoms. Stop using this Drug if any of these symptoms persist or worsen! :-<br /><br />";

                while ($row = mysqli_fetch_array($result)) {

                  echo "<li><font style='color:red'>".$row['sname']."</font><br />";
                }
              }


              $query = "SELECT * FROM medicine m WHERE m.M_ID = $mid";

              $result = mysqli_query($db, $query);

              $row = mysqli_fetch_array($result);
              echo "<br /><br /><h4>Dosage</h4><br />";
              echo $row['Dosage'];

              $query = "SELECT c.Name from medicine m, manufacturer mf, company c
                          WHERE m.M_ID = $mid AND
                          m.M_ID = mf.M_ID AND mf.C_ID = c.C_ID;";
              $result = mysqli_query($db, $query);

              $row = mysqli_fetch_array($result);

              echo "<br /><br /><br /><h4>Manufactured by</h4><br />";
              echo "<b>".$row['Name']." &copy;&trade; </b><br />";

              mysqli_close($db);

        ?>
      <br />
      <br />
    </div>
    <!--footer-->
    <footer id="footer">
        <div class="top-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-4 marb20">
                        <div class="ftr-tle">
                            <h4 class="white no-padding">About Us</h4>
                        </div>
                        <div class="info-sec">
                            <p>We are a pharmaceutical website who aim to make madicine available to all at the click of a button.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 marb20">
                        <div class="ftr-tle">
                            <h4 class="white no-padding">Quick Links</h4>
                        </div>
                        <div class="info-sec">
                            <ul class="quick-info">
                                <li><a href="index.html"><i class="fa fa-circle"></i>Home</a></li>
                                <li><a href="#search"><i class="fa fa-circle"></i>Search</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 marb20">
                        <div class="ftr-tle">
                            <h4 class="white no-padding">Follow us</h4>
                        </div>
                        <div class="info-sec">
                            <ul class="social-icon">
                                <li class="bglight-blue"><i class="fa fa-facebook"></i></li>
                                <li class="bgred"><i class="fa fa-google-plus"></i></li>
                                <li class="bgdark-blue"><i class="fa fa-linkedin"></i></li>
                                <li class="bglight-blue"><i class="fa fa-twitter"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--/ footer-->

    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="contactform/contactform.js"></script>
</body>
</html>
