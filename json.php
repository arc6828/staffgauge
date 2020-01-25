<?php
    header('Content-Type: application/json');
    $objConnect = mysql_connect("localhost","root","");
    $objDB = mysql_select_db("ocrs");
    mysql_query("SET NAMES UTF8");
 
    $strSQL = "SELECT * FROM locations ";
 
    $objQuery = mysql_query($strSQL);
    $resultArray = array();
    while($obResult = mysql_fetch_array($objQuery))
    {
        array_push($resultArray,$obResult);
    }
 
    mysql_close($objConnect);
 
    echo json_encode($resultArray);
?>