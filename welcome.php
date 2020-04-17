<?php
include('session.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <title>Welcome!</title>

  <!-- Metadata -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="User Welcome Page">
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
    #responsecontainer {
      max-width: 1000px;
      max-height: 700px;
      height: auto;
      align-content: center;
      align-items: center;
      text-align: center;
      position: relative;
      overflow: auto;
      overflow-x: hidden;
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
      overflow-x: hidden;
      margin: 0 auto;
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
                                <li class=""><a href="index.html">About</a></li>
                                <li class=""><a href="logout.php">Logout</a></li>
                                <li class=""><a href="#footer">Contact Us</a></li>
                                <li class="active"><b>Welcome <?php echo $login_session_first . " " . $login_session_last ?></b></li>
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
    <h3 class="display-4" align="center">Welcome!</h3>
    <br /><br />

    <?php
    //Get Order ID
    $oid = -1;
    $query = "CALL Insert_User_OrderId();";
    $result  = mysqli_query($db, $query);
    $query = "SELECT O_ID FROM `order` ORDER BY `O_ID` DESC LIMIT 1";
    $result  = mysqli_query($db, $query);
    $row = mysqli_fetch_array($result);
    $oid = $row['O_ID'];
    $uid = $_SESSION['login_id'];
    $query = "CALL order_insert($oid, $uid);";
    $result = mysqli_query($db, $query);
    $query = "SELECT m.M_ID as `#ID`, m.Name as `Medicine`, c.Name as `Company`, m.Price, s.quantity as 'Stock'
    FROM medicine m, company c, manufacturer mf, stock as s
    WHERE m.M_ID = mf.M_ID AND s.M_ID = m.M_ID AND mf.C_ID = c.C_ID ORDER BY m.M_ID;";
    $result  = mysqli_query($db, $query);

    echo"<div id='responsecontainer'><table border='1' class='table table-striped table-hover'>
    <thead>
      <tr>
        <th class='btn-primary'><center>#ID</center></th>
        <th class='btn-primary'><center>Medicine</center></th>
        <th class='btn-primary'><center>Company</center></th>
        <th class='btn-primary'><center>Price</center></th>
        <th class='btn-primary'><center>Check</center></th>
        <th class='btn-primary'><center>Qty</center></th>
        <th class='btn-primary'><center>Stock</center></th>
      </tr>
    </thead>
    <tbody>";

    echo '<form id="myform" name="myform" class="myform" method="post">';
    while ($row = mysqli_fetch_array($result)) {
      $id = $row['#ID'];
      $idcheck = $id . 'check';
      $idnum = $id . 'num';

      //JAVASCRIPT
      echo '<script type="text/javascript">
            $(document).ready(function () {
              $(".clickable-row' . $id . '").click(function() {
                document.getElementById("' . $idcheck . '").click();
                if (document.getElementById("' . $idnum . '").value == 0) {
                  document.getElementById("' . $idnum . '").value = "1";
                }
                });
            });
            </script>';

      echo '<script type="text/javascript">
        $(document).ready(function () {
        $("#' . $idcheck . '").change(function() {
          if($(this).is(":checked")) {
            var med_id = ' . $id . ';
            var med_num = document.getElementById("' . $idnum . '").value;
            var m_oid = ' . $oid . ';
            $.ajax({
              type: "POST",
              url: "add_cart.php",
              dataType: "html",
              data: {
                med_id,
                med_num,
                m_oid
              },
              cache: false,
              success: function(data) {
                $("#responsecontainer2").html(data);
              }
            });
            $.ajax({
              type: "POST",
              url: "stock_dec.php",
              dataType: "html",
              data: {
                med_id,
                med_num,
                m_oid
              },
              cache: false,
              success: function(data) {
                $("#responsecontainer2").html(data);
              }
            });
          }
          else {
            var med_id = ' . $id . ';
            var med_num = document.getElementById("' . $idnum . '").value;
            var m_oid = ' . $oid . ';
            $.ajax({
              type: "POST",
              url: "del_cart.php",
              dataType: "html",
              data: {
                med_id,
                med_num,
                m_oid
              },
              cache: false,
              success: function(data) {
                $("#responsecontainer2").html(data);
            }
            });
            $.ajax({
              type: "POST",
              url: "stock_inc.php",
              dataType: "html",
              data: {
                med_id,
                med_num,
                m_oid
              },
              cache: false,
              success: function(data) {
                $("#responsecontainer2").html(data);
              }
            });
          }
        });
        });
        </script>';

      echo "<tr class='clickable-row$id' style='cursor: pointer;'>";
      echo "<td>" . $row['#ID'] . "</td>";
      echo "<td>" . $row['Medicine'] . "</td>";
      echo "<td>" . $row['Company'] . "</td>";
      echo "<td>" . $row['Price'] . "</td>";
      echo "<td><div class='checkbox' style='margin-top: auto; margin-bottom: auto; margin-left: auto; padding-left: 50px;'>
                <label>
                    <input type='checkbox' name='addcheck[]' value=$id  id='$idcheck'><i class='helper'></i></label>
                </div>";

      echo "<td><select name='addqty' id=$idnum>
                  <option selected='selected' disabled='disabled' value='0'></option>
                  <option value=1>&nbsp;&nbsp;1&nbsp;&nbsp;&nbsp;</option>
                  <option value=2>&nbsp;&nbsp;2&nbsp;&nbsp;&nbsp;</option>
                  <option value=3>&nbsp;&nbsp;3&nbsp;&nbsp;&nbsp;</option>
                  <option value=4>&nbsp;&nbsp;4&nbsp;&nbsp;&nbsp;</option>
                  <option value=5>&nbsp;&nbsp;5&nbsp;&nbsp;&nbsp;</option>
                </select>
            </td>";
      echo "<td>" . $row['Stock'] . "</td>";
      echo "</tr>";
    }

    echo "</tbody>
          <tfoot>
          <tr>
            <td colspan=7><center>Click on the link to proceed to payment</center></td>
          </tr>
          </tfoot>
          </table>
    </div>";
    echo '</form>';
    ?>
    <br />
    <br />
    <button class="btn btn-danger" id="checkout" name="checkout" style="float: right; margin-right: 150px;" onclick="window.location.href='checkout.php'">Check Out!</button>
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
                                <li><a href="#service"><i class="fa fa-circle"></i>Search</a></li>
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
</body>

</html>
