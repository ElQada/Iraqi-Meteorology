<?php
require_once ( '../configuration/Connection.php' );
if(isset($_REQUEST['Code']))
{
    $Return = ['Name'=>'','Station'=>''];
    $Get = MySqlX("SELECT `id`,`StationName` FROM `stations` WHERE `StationCode` = ?",[$_REQUEST['Code']],0,0);
    if (!$Get)
    {
        $Get = MySqlX("SELECT `user`,`Station` FROM `accounts` WHERE `code` = ?",[$_REQUEST['Code']],0,0);
        if ($Get)
        {
            $Return['Name'] = $Get['user'];
            $Return['Station'] = $Get['Station'];
        }
    }
    else
    {
        $Return['Name'] = $Get['StationName'];
        $Return['Station'] = $Get['id'];
    }
    echo json_encode ($Return);
}