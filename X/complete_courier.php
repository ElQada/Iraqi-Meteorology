<?php
/* ------------------------------------------------------------------------------------------------------------------ */
require_once "../configuration/Connection.php";
/* ------------------------------------------------------------------------------------------------------------------ */
function SetData($XD)
{
    $Keys = ['Code','Month','Day','Hour'];
    $XK = [];
    foreach ($Keys as $K => $V) {
        $XK[$V] = $K;
    }
    //print_r($XK);
    /* -------------------------------------------------------------------------------------------------------------- */
    $Stations = MySqlX("SELECT * FROM `stations`",[],11);
    $XS = [];
    foreach ($Stations as $Station) {
        $XS[$Station["StationCode"]] = intval($Station["id"]);
    }
    //print_r($XS);
    /* -------------------------------------------------------------------------------------------------------------- */
    $Year = "2020";
	$File = 1;
    /* -------------------------------------------------------------------------------------------------------------- */
    $Insert = fopen("Out/$Year@$File@Insert.sql",'a');
    $Error = fopen("Out/$Year@$File@Error.txt",'a');
    /* -------------------------------------------------------------------------------------------------------------- */
    foreach ($XD as $XR)
    {
        $Station = $XS[$XR[$XK['Code']]];
        $Time    = $XR[$XK['Hour']];
        $Date    = $Year.'-'.$XR[$XK['Month']].'-'.$XR[$XK['Day']];
        $Get = MySqlX("SELECT `IR`, `IX`, `H`, `VV`, `N`, `DD`, `FF`, `SN1`, `TTT`, `SN2`, `TDTDTD`, `P0P0P0P0`, `PPPP`, `A`, `PPP`, `RRR`, `TR`, `WW`, `W1W2`, `NH`, `CL`, `CM`, `CH`, `HALF`, `SN3`, `TNTNTN`, `E`, `SSS`, `NS1`, `C1`, `HSHS1`, `NS2`, `C2`, `HSHS2`, `NS3`, `C3`, `HSHS3`, `WB`, `RH`, `VP`, `min`, `max` FROM `courier` WHERE `Station` = $Station AND `time` = '$Time' AND `date` < '$Date' ORDER BY `date` DESC LIMIT 1",[],0);
		if(!$Get)
		{
			$Get = MySqlX("SELECT `IR`, `IX`, `H`, `VV`, `N`, `DD`, `FF`, `SN1`, `TTT`, `SN2`, `TDTDTD`, `P0P0P0P0`, `PPPP`, `A`, `PPP`, `RRR`, `TR`, `WW`, `W1W2`, `NH`, `CL`, `CM`, `CH`, `HALF`, `SN3`, `TNTNTN`, `E`, `SSS`, `NS1`, `C1`, `HSHS1`, `NS2`, `C2`, `HSHS2`, `NS3`, `C3`, `HSHS3`, `WB`, `RH`, `VP`, `min`, `max` FROM `courier` WHERE `Station` = $Station AND `time` = '$Time' LIMIT 1",[],0);
		}
		if ($Get)
        {
            fwrite($Insert,"INSERT IGNORE INTO `courier` VALUES(NULL,$Station,1,'Admin','$Date','$Time','".join("','",array_values($Get))."',NULL,NULL);\n");
        }
        else
        {
            fwrite($Error,"['".join("','",array_values($XR))."']\n");
        }
    }
    /* -------------------------------------------------------------------------------------------------------------- */
    fclose($Insert);
    fclose($Error);
}
/* ------------------------------------------------------------------------------------------------------------------ */
$Data = [

];
/* ------------------------------------------------------------------------------------------------------------------ */
SetData($Data);