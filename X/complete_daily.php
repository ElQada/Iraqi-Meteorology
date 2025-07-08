<?php
/* ------------------------------------------------------------------------------------------------------------------ */
require_once "../configuration/Connection.php";
/* ------------------------------------------------------------------------------------------------------------------ */
function SetData($XD)
{
    $Keys = ['Code','Year','Month','Day'];
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
    $Insert = fopen("Out/Insert.sql",'a');
    $Error = fopen("Out/Error.txt",'a');
    /* -------------------------------------------------------------------------------------------------------------- */
    foreach ($XD as $XR)
    {
        $Station = $XS[$XR[$XK['Code']]];
		$Year    = $XR[$XK['Year']];
		$Month   = $XR[$XK['Month']];
		$Day     = $XR[$XK['Day']];
        $SlotD   = '-'.$Month.'-'.$Day;
        $Date    = $Year.$SlotD;
        $Dates   = [$Date];
        foreach (['2020','2021','2022','2023','2024','2025'] as $Select)
        {
            if ($Select != $Year)
            {
                $Dates[] = $Select.$SlotD;
            }
        }
        $Get = false;
        foreach ($Dates as $DateX)
        {
            if(!$Get)
            {
                $From = date('Y-m-d',strtotime('-8 day',strtotime($DateX)));
                $To = date('Y-m-d',strtotime('+8 day',strtotime($DateX)));

                $Get = MySqlX("SELECT `FirstWind50`, `SecondWind50`, `FirstWind200`, `SecondWind200`, `ResultWind50`, `ResultWind200`, `Rain06_18`, `Rain18_06`, `ResultRain`, `Sur00`, `Sur06`, `Sur12`, `Sur18`, `_5cm00`, `_5cm06`, `_5cm12`, `_5cm18`, `5cm00`, `5cm06`, `5cm12`, `5cm18`, `10cm00`, `10cm06`, `10cm12`, `10cm18`, `20cm00`, `20cm06`, `20cm12`, `20cm18`, `50cm00`, `50cm06`, `50cm12`, `50cm18`, `100cm00`, `100cm06`, `100cm12`, `100cm18`, `Evapration1`, `Evapration2`, `ResultEvapration`, `CannabisTemperature`, `SunShine`, `RetRadiation`, `ff`, `dd`, `windTime`, `min_day`, `max_day` FROM `daily` WHERE `Station` = $Station AND `date` BETWEEN '$From' AND '$DateX' ORDER BY `date` DESC LIMIT 1",[],0);

                if(!$Get)
                {
                    $Get = MySqlX("SELECT `FirstWind50`, `SecondWind50`, `FirstWind200`, `SecondWind200`, `ResultWind50`, `ResultWind200`, `Rain06_18`, `Rain18_06`, `ResultRain`, `Sur00`, `Sur06`, `Sur12`, `Sur18`, `_5cm00`, `_5cm06`, `_5cm12`, `_5cm18`, `5cm00`, `5cm06`, `5cm12`, `5cm18`, `10cm00`, `10cm06`, `10cm12`, `10cm18`, `20cm00`, `20cm06`, `20cm12`, `20cm18`, `50cm00`, `50cm06`, `50cm12`, `50cm18`, `100cm00`, `100cm06`, `100cm12`, `100cm18`, `Evapration1`, `Evapration2`, `ResultEvapration`, `CannabisTemperature`, `SunShine`, `RetRadiation`, `ff`, `dd`, `windTime`, `min_day`, `max_day` FROM `daily` WHERE `Station` = $Station AND `date` BETWEEN '$DateX' AND '$To' ORDER BY `date` LIMIT 1",[],0);
                }
            }
        }
        if ($Get)
        {
			// `FirstWind50`, `SecondWind50`, `FirstWind200`, `SecondWind200`, `ResultWind50`, `ResultWind200`,
            // `Rain06_18`, `Rain18_06`, `ResultRain`,
            // `Sur00`, `Sur06`, `Sur12`, `Sur18`, `_5cm00`, `_5cm06`, `_5cm12`, `_5cm18`, `5cm00`, `5cm06`, `5cm12`, `5cm18`, `10cm00`, `10cm06`, `10cm12`, `10cm18`, `20cm00`, `20cm06`, `20cm12`, `20cm18`, `50cm00`, `50cm06`, `50cm12`, `50cm18`, `100cm00`, `100cm06`, `100cm12`, `100cm18`,
            // `Evapration1`, `Evapration2`, `ResultEvapration`, `CannabisTemperature`, `SunShine`, `RetRadiation`, `ff`, `dd`, `windTime`, `min_day`, `max_day`
            fwrite($Insert,"INSERT IGNORE INTO `daily` VALUES(NULL,$Station,1,'Admin','$Date','".join("','",array_values($Get))."',NULL,NULL);\n");
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