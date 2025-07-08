<?php
require_once ( '../configuration/Connection.php' );
if (!isset($_SESSION['per']))
{
    header ( 'Location: ../index.php' );
}