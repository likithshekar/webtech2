<html>
<body>

<?php
    include ('session.php');
    
    $mid = ($_POST['med_id']);
    $mnum = $_POST['med_num'];
    $moid  = $_POST['m_oid'];

    $query = "CALL addCart($moid, $mid, $mnum);";
    $result  = mysqli_query($db, $query) or die (mysqli_error($db));

#    $query = "SELECT quantity FROM stocks WHERE M_ID=$mid";
#    $amt = mysqli_query($db,$query)

#    if ($val>$amt) {
#       die(myqli_error($db));
#    }
#    else {
#        $val = $amt - $mnum;
#    }
#    $query = "UPDATE stock SET quantity=$val WHERE M_ID=$mid";
#    $result2  = mysqli_query($db, $query) or die (mysqli_error($db));
?>

</body>
</html>