<?php
require_once ( 'index.php' );
/*
$Return = MySqlX ('SELECT * FROM monitors WHERE `name`= ? LIMIT 1',[$_REQUEST['Monitor']],'0');
if ($Return)
{
    $_SESSION['Monitor'] = $Return['name'];
}
*/
if ($_REQUEST['Monitor'])
{
    $_SESSION['Monitor'] = $_REQUEST['Monitor'];
}
return $_REQUEST['Monitor'];