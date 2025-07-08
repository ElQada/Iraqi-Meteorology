<?php
require_once "../configuration/Connection.php";
$message = "";

foreach ($_SESSION as $Key => $Value)
{
    unset($_SESSION[$Key]);
}

header ( 'Location: ../index.php' );

exit();