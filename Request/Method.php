<?php
require_once "../configuration/Connection.php";
/* ----------------------------------------------------------------------------------------------------------------- */
if (isset($_REQUEST['Method'])&&$_REQUEST['Method']==='synop_date')
{
    synop_date();
}