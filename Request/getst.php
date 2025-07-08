<?php
require_once ( 'index.php' );

if($_SESSION['per'] === 'admin' && isset($_REQUEST['Station']) || in_array(_REQUEST_('File'),['show-temperature','synop','table-synop','month-courier','monthly-cloud',"monthly-tntntn",'month-daily','daily-rh','monthly-weather']))
{
    $Station = $_REQUEST['Station'];
}
else
{
    if ((in_array(_REQUEST_('File'),['synop']) && $_SESSION['per'] === "Forecasting") || $_SESSION['per'] === "admin")
    {
        $Station = $_SESSION['Station'];
    }
    else
    {
        $Station = $_SESSION['Save-Station'];
    }
}
$Return = MySqlX ('SELECT * FROM stations WHERE `id`= ? OR `StationCode` = ? LIMIT 1',[$Station,$Station],'0');
if ($Return)
{

    $_SESSION['Station']  = $Return['id'];
    $_SESSION['StationName'] = $Return['StationName'];
    $_SESSION['StationCode'] = $Return['StationCode'];
    $Return['SESSION'] = $_SESSION;
}

if (isset($_REQUEST['Date']) && $_REQUEST['Date'] && isset($_REQUEST['File']) && $_REQUEST['File'] && $_REQUEST['File'] != 'Else')
{
    if ($_REQUEST['File'] == 'daily-monitoring' || $_REQUEST['File'] == 'show-daily')
    {
        $_SESSION['daily']    = $_REQUEST['Date'];
    }
    else
    {
        $_SESSION['Date']     = $_REQUEST['Date'];
    }
    $_SESSION['SelectDate'] = $_REQUEST['Date'];
}

if ($_REQUEST['Station'] === '*' && ( in_array($_REQUEST['File'],['show-courier','show-daily','repeat-clouds','reports','show-temperature','month-courier','monthly-cloud',"monthly-tntntn",'month-daily','daily-rh','monthly-weather','history']) || ( $_SESSION['per'] === 'Forecasting' && in_array($_REQUEST['File'],['table-synop'])) ))
{
    $Return =
        [
            'id' => '*',
            'StationName' => 'جـمـيـع الـمـحـطـات',
            'StationCode' => " [ ".MySqlX ('SELECT COUNT(`id`) as `Count` FROM stations',[],'0')['Count'] . " ] Stations ",
            'Longitude' => 'ALL',
            'Latitude' => 'ALL',
            'ElevationM' => 'ALL',
        ];
    $_SESSION['Station']  = $Return['id'];
    $_SESSION['StationName'] = $Return['StationName'];
    $_SESSION['StationCode'] = $Return['StationCode'];
}
echo json_encode ($Return);