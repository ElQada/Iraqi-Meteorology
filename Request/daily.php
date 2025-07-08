<?php
 require_once ( 'index.php' );
 if ($_REQUEST['date'] && TestDate())
 {
     $Result = MySqlX ( "SELECT * FROM `daily` WHERE `Station` = ? AND `date` = ? LIMIT 1" , [  $_SESSION['Station'] , $_REQUEST['date']  ] , 0 );
     if (isset($Result['name']))
     {
         $Result['Monitor'] = $Result['name'];
     }
     echo json_encode ($Result);
 }