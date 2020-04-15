<html>
<body>

<?php
    include ('session.php');
    
    $mid = $_POST['med_id'];
    $mnum = $_POST['med_num'];
    $moid  = $_POST['m_oid'];

    $query = "UPDATE stock SET quantity=quantity+$mnum WHERE M_ID=$mid;";
    $result  = mysqli_query($db, $query) or die (mysqli_error($db));
?>

</body>
</html>