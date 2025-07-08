<?php
/* ------------------------------------------------------------------------------------------------------------------ */
require_once "../configuration/Connection.php";
/* ------------------------------------------------------------------------------------------------------------------ */
$Select = MySqlX('SELECT `id`,`Station`,`P0P0P0P0`,`time` FROM `courier` WHERE `PPPP` = ?',['06'],null);
while ($Row = $Select->fetch(11)) {
    $Get = MySqlX('SELECT `PPPP` FROM `courier` WHERE `Station` = ? AND `PPPP` != "06" AND `time` = ? AND `P0P0P0P0` = ? ORDER BY `date` DESC LIMIT 1',[$Row['Station'],$Row['time'],$Row['P0P0P0P0']],0);
    if (!$Get)
    {
        $Get = MySqlX('SELECT `PPPP` FROM `courier` WHERE `Station` = ? AND `PPPP` != "06" AND `P0P0P0P0` = ? ORDER BY `date` DESC LIMIT 1',[$Row['Station'],$Row['P0P0P0P0']],0);
    }
    if (!$Get)
    {
        $Get = MySqlX('SELECT `PPPP` FROM `courier` WHERE `time` = ? AND `PPPP` != "06" AND `P0P0P0P0` = ? ORDER BY `date` DESC LIMIT 1',[$Row['time'],$Row['P0P0P0P0']],0);
    }
    if (!$Get)
    {
        $Get = MySqlX('SELECT `PPPP` FROM `courier` WHERE `P0P0P0P0` = ? AND `PPPP` != "06" ORDER BY `date` DESC LIMIT 1',[$Row['P0P0P0P0']],0);
    }
    if ($Get) {
       // MySqlX('UPDATE `courier` SET `PPPP` = ? WHERE `id` = ?',[$Get['PPPP'],$Row['id']],0);
    }
}
/* ------------------------------------------------------------------------------------------------------------------ */