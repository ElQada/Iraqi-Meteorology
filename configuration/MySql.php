<?php
date_default_timezone_set ('Asia/Baghdad');
date_timezone_set(new DateTime(),timezone_open ('Asia/Baghdad'));
/* ------------------------------------------------------------------------------------------------------------------ */
ini_set('session.gc_maxlifetime', 3600 * 24);
session_set_cookie_params(3600 * 24);
@session_start();
/* ------------------------------------------------------------------------------------------------------------------ */
$Pages = [];
$Redirect = 'index.php';
$Types = ['Else','Local','Online','Offline','LocalInput','LocalOutput'];
$Roles = ['Else','Forecasting','Awos','admin','manager','user'];
$Type = $Types[1];
if (isset($_SESSION['per']))
{
    $Role = $_SESSION['per'];
}
else
{
    $Role = $Roles[0];
}
/* ------------------------------------------------------------------------------------------------------------------ */
if ((isset($_SERVER['HTTP_HOST'])&&in_array($_SERVER['HTTP_HOST'],['localhost','127.0.0.1']))||(isset($_SERVER['REMOTE_ADDR'])&&in_array($_SERVER['REMOTE_ADDR'],['127.0.0.1','::1']))||(isset($_SERVER['SERVER_NAME'])&&in_array($_SERVER['SERVER_NAME'],['localhost','127.0.0.1'])))
{
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    define("DataBase", ["Host" => 'localhost', "Name" => 'u775794793_iraq', "User" => 'root', "Pass" => '', "Port" => 3306]);
}
else
{
    $Type = $Types[2];
    define("DataBase", ["Host" => 'localhost', "Name" => 'u775794793_iraq', "User" => 'u775794793_iraq', "Pass" => 'xC;3^[oYdKak', "Port" => 3306]);
}
$DataBase = DataBase;

function _REQUEST_($Name,$Else = "")
{
    return GetVar($Name,$Else,'R');
}

function _SESSION_($Name,$Else = ""){
    return GetVar($Name,$Else,'S');
}

function _COOKIE_($Name,$Else = ""){
    return GetVar($Name,$Else,'C');
}

function _VAR_(&$Object,$Name,$Else = ""){
    return GetVar($Name,$Else,$Object);
}

function GetVar($Name,$Return = "",$Object = 'R')
{
    if ($Object)
    {
        if (is_string($Object))
        {
            switch (strtoupper($Object))
            {
                case "R": $Object = &$_REQUEST; break;
                case "S": $Object = &$_SESSION; break;
                case "C": $Object = &$_COOKIE;  break;
            }
        }

        if (is_array($Object) && isset($Object[$Name]))
        {
            $Return = $Object[$Name];
        }
        if (is_object($Object) && isset($Object->$Name))
        {
            $Return = $Object->$Name;
        }
    }
    return $Return;
}

function Connection()
{
    $Connection = mysqli_connect(DataBase['Host'], DataBase['User'], DataBase['Pass'], DataBase['Name']);
    mysqli_set_charset($Connection,"utf8mb4");

    if (!$Connection) {
        die("Cannot connect to the database");
    } else {
        return $Connection;
    }
}

function MySqlX($Statement = null,$Execute = [], $Code = null, $Error = false)
{
    if (isset($Execute['File']))
    {
        unset($Execute['File']);
    }

    $DataBase = DataBase;
    $Code = strtoupper($Code);
    try {
        $Connect = new PDO("mysql:host=" . $DataBase['Host'] . ";dbname=" . $DataBase['Name'], $DataBase['User'], $DataBase['Pass'], [1002 => 'SET NAMES utf8']);
        $Connect->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
        if (is_null($Statement))
        {
            return $Connect;
        }
        $Query = $Connect->prepare($Statement);
        $Query->execute($Execute);
        if ($Query->rowCount()) {
            if (is_numeric($Code)) {
                if (!$Code) {
                    $Return = false;
                    $Get = $Query->fetchAll(11);
                    if ($Get && isset($Get[0]))
                    {
                        $Return = $Get[0];
                    }
                } else {
                    $Return = $Query->fetchAll($Code);
                }
            } elseif ($Code == 'K') {
                $Return = $Connect->lastInsertId();
            } elseif ($Code == 'R') {
                $Return = true;
            } else {
                $Return = $Query;
            }
        } else {
            $Return = false;
        }
    } catch (PDOException $Catch) {
        if (is_null($Error)) {
            $Return = $Catch;
        } else {
            $Return = $Error;
        }
    }
    return $Return;
}
/* ------------------------------------------------------------------------------------------------------------------ */
define("_TYPE_", $Type);
define("_ROLE_", $Role);