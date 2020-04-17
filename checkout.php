<?php
    include ('session.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome!</title>

    <!-- Metadata -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="User Welcome Page">
    <meta name="author" content="PESU Project">
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
        #responsecontainer {
          max-width: 1000px;
          max-height: 700px;
          height: auto;
          align-content: center;
          align-items: center;
          text-align: center;
          position: relative;
          overflow: auto;
          overflow-x:hidden;
          margin: 0 auto;
        }
        #responsecontainer2 {
          max-width: 1000px;
          max-height: 700px;
          height: auto;
          align-content: center;
          align-items: center;
          text-align: center;
          position: relative;
          overflow: auto;
          overflow-x:hidden;
          margin: 0 auto;
          margin-bottom: 50px;
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
                                <li class=""><a href="welcome.php">User</a></li>
                                <li class=""><a href="logout.php">Logout</a></li>
                                <li class=""><a href="#footer">Contact Us</a></li>
                                <li class="nav-item disabled"><b>Welcome <?php echo $login_session_first . " " . $login_session_last ?></b></li>
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
        <h3 class="display-4" align="center">Your Cart</h3>
      	<br /><br />

  <?php
    //Get Order ID
    $oid = -1;
    $query = "SELECT O_ID FROM `order` ORDER BY `O_ID` DESC LIMIT 1";
    $result  = mysqli_query($db, $query);
    $row = mysqli_fetch_array($result);
    $oid = $row['O_ID'];
    $sum = 0;
    $sum2 = 0;

    $query = "SELECT om.M_ID, m.Name as `Mname`, c.Name as `Cname`, Price, quantity 
    FROM `order_medicine` AS om, `medicine` AS m, `company` as c, `manufacturer` as mf 
    WHERE om.M_ID = m.M_ID AND mf.M_ID = om.M_ID AND mf.C_ID = c.C_ID AND O_ID = $oid;";
    $result  = mysqli_query($db, $query);
    echo
    "<div id='responsecontainer'><table border='1' class='table table-striped table-hover'>
    <thead>
      <tr>
        <th class='btn-primary'><center>#ID</center></th>
        <th class='btn-primary'><center>Medicine</center></th>
        <th class='btn-primary'><center>Company</center></th>
        <th class='btn-primary'><center>Price</center></th>
        <th class='btn-primary'><center>Qty</center></th>
      </tr>
    </thead>
    <tbody>";
    while ($row = mysqli_fetch_array($result))
    {
      echo "<tr>";
      echo "<td>" . $row['M_ID'] . "</td>";
      echo "<td>" . $row['Mname'] . "</td>";
      echo "<td>" . $row['Cname'] . "</td>";
      echo "<td>" . $row['Price'] . "</td>";
      echo "<td>" . $row['quantity'] . "</td>";
      echo "</tr>";
      $sum += $row['Price'] * $row['quantity'];
      $sum2 += $row['quantity'];
    }
    $query = "SELECT om.M_ID, s.quantity
    FROM `order_medicine` AS om, `medicine` AS m, `company` as c, `manufacturer` as mf, stock as s
    WHERE om.M_ID = m.M_ID AND m.M_ID = s.M_ID AND O_ID = $oid;";
    $result  = mysqli_query($db, $query);
    echo "</tbody><tfoot><tr><td colspan=3><center>Proceed to Payment!</center></td>
      <td class='btn-info disabled'><b> &#8377; ".$sum." </b></td>
      <td> ".$sum2."</td>
      </tr></tfoot></table></div>";
  ?>
    <br />
    <br />
    </div>
    <script type="text/javascript">

    $(document).ready(function() {
      $("#pay").click(function() {
        var total = <?php echo $sum; ?>;
        $.ajax({
          type: "POST",
          url: "ret_balance.php",
          dataType: "html",
          data: {
            total
          },
          cache: false,
          success: function(data) {
              $("#responsecontainer2").html(data);
          }
        });
        this.disabled = true;
    });
    });
    </script>
      <button class="btn btn-success" id="pay" name="pay" style="float: right; margin-right: 150px;">Proceed to Payment!</button>
    <div id="responsecontainer2"> </div>
    <br />
    <br />
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>
