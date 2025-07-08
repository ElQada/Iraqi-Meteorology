<?php
require_once ( '../configuration/Connection.php' );
if(isset($_REQUEST['Code']))
{
    $Return = ['Name'=>'','Station'=>''];
    $Code = $_REQUEST['Code'];
    $Get = MySqlX("SELECT `user`,`Station` FROM `accounts` WHERE `code` = ?",[$Code],0,0);
    $Row = null;
    if (!$Get)
    {
        $PDO = MySqlX("SELECT `user`,`Station`,`_key_` FROM `accounts`",[],null,0);
        if ($PDO)
        {
            while (!$Get && $Row = $PDO->Fetch(PDO::FETCH_ASSOC))
            {
                if (password_verify($Code,$Row['_key_']))
                {
                    $Get = $Row;
                    break;
                }
            }
        }
    }

    if ($Get)
    {
        $Return['Name'] = $Get['user'];
        $Return['Station'] = $Get['Station'];
    }
    echo json_encode ($Return);
}