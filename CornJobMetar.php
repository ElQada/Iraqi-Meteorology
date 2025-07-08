<?php
require_once "configuration/MySql.php";
/* ---------------------------------------------- */
$Stations = ["BAGHDAD"=>"ORBI","ERBEEL"=>"ORER","MOSUL"=>"ORBM","SULAIMANIYA AIRPORT"=>"ORSU","BASRA AIRPORT"=>"ORMM","NAJAF"=>"ORNI","KIRKUK AIRPORT"=>"ORKK"];
/* ---------------------------------------------- */
foreach ($Stations as $StationName => $StationCode)
{
    $Get = MySqlX("SELECT `id` FROM `stations` WHERE `StationName` = ? AND `id` NOT IN (42,43) LIMIT 1",[$StationName],0);
    $Station = null;

    if ($Get && isset($Get['id']))
    {
        $Station = $Get['id'];
    }

    $Value = @file_get_contents('https://aviationweather.gov/api/data/metar?ids='.$StationCode);
    $Code = date('d').date('H')."00Z";
    /* ---------------------------------------------- */
    if (!$Value || strlen($Value)<15)
    {
        $Value = "NULL";
    };
    /* ---------------------------------------------- */
    $Insert = MySqlX("INSERT INTO `metar` (`Station`,`Code`,`Key`,`Value`) VALUES (?,?,?,?)", [$Station, $StationCode, $Code, $Value], 'K',null);
    if (is_object($Insert))
    {
        $Update = MySqlX("UPDATE `metar` SET `Value` = ? WHERE `Station` = ? AND `Code` = ? AND `Key` = ?", [$Value, $Station, $StationCode, $Code], 'R',null);
    }
}