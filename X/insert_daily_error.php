<?php
/* ------------------------------------------------------------------------------------------------------------------ */
require_once "../configuration/Connection.php";
/* ------------------------------------------------------------------------------------------------------------------ */
$Keys = ['station','year','month','day','mintemp','xmin','maxtemp','xmax','grastemp','xgras','rain06_18','xrain06','rain18_06','xrain18','raintot24','xrain24','sunshin','xsundur','totrad','evapor2','xevapor2','evapor1','xevapor1','dlyevapor','xdlyevapor','direction','maxwnsp','xmaxwnsp','timespd','hispeed','xhi2','win50c2','xwin50c2','win50c1','xwin50c1','dlywin50','xdlywin50','win20c2','xwin20c2','win20c1','xwin20c1','dlywin20','xdlywin20','sur00','xsur00','sur06','xsur06','sur12','xsur12','sur18','xsur18','t5_00','xt5_00','t5_06','xt5_06','t5_12','xt5_12','t5_18','xt5_18','t10_00','xt10_00','t10_06','xt10_06','t10_12','xt10_12','t10_18','xt10_18','t20_00','xt20_00','t20_06','xt20_06','t20_12','xt20_12','t20_18','xt20_18','t30_00','xt30_00','t30_06','xt30_06','t30_12','xt30_12','t30_18','xt30_18','t50_00','xt50_00','t50_06','xt50_06','t50_12','xt50_12','t50_18','xt50_18','t100_00','xt100_00','t100_06','xt100_06','t100_12','xt100_12','t100_18','xt100_18','max_water','xmax_water','min_water','xmin_water'];
$XK = [];
foreach ($Keys as $K => $V) {
    $XK[$V] = $K;
}
//print_r($XK);
/* ------------------------------------------------------------------------------------------------------------------ */
$Stations = MySqlX("SELECT * FROM `stations`",[],11);
$XS = [];
foreach ($Stations as $Station) {
    $XS[$Station["StationCode"]] = intval($Station["id"]);
}
//print_r($XS);
/* ------------------------------------------------------------------------------------------------------------------ */
function ReFormat($Number,$Before,$After = 0,$Array = [], $Only = false)
{
    $Number = str_replace([" ","+"],"",$Number);
    $Number = str_replace("--","-",$Number);

    $Find = array_search($Number,$Array);
    if (is_int($Find))
    {
        return $Array[$Find];
    }

    if ($After)
    {
        $Number = floatval($Number);
        if ($Before)
        {
            $Before += $After+1;
        }
    }
    else
    {
        $Number = intval($Number);
    }

    $Number = str_pad(number_format($Number,$After,'.',''), $Before, '0', STR_PAD_LEFT);

    $Find = array_search($Number,$Array);
    if (is_int($Find))
    {
        return $Array[$Find];
    }

    if ($Only || $Number == '')
    {
        return '';
    }

    return $Number;
}
// print_r(ReFormat('3',2,2,['2','//'],true));
/* ------------------------------------------------------------------------------------------------------------------ */
function SetData($XD)
{
    global $XK, $XS;
    foreach ($XD as $XR)
    {
		$Success = MySqlX("INSERT INTO `daily`(`Station`, `Account`, `name`, `date`, `FirstWind50`, `SecondWind50`, `FirstWind200`, `SecondWind200`, `ResultWind50`, `ResultWind200`, `Rain06_18`, `Rain18_06`, `ResultRain`, `Sur00`, `Sur06`, `Sur12`, `Sur18`, `_5cm00`, `_5cm06`, `_5cm12`, `_5cm18`, `5cm00`, `5cm06`, `5cm12`, `5cm18`, `10cm00`, `10cm06`, `10cm12`, `10cm18`, `20cm00`, `20cm06`, `20cm12`, `20cm18`, `50cm00`, `50cm06`, `50cm12`, `50cm18`, `100cm00`, `100cm06`, `100cm12`, `100cm18`, `Evapration1`, `Evapration2`, `ResultEvapration`, `CannabisTemperature`, `SunShine`, `RetRadiation`, `ff`, `dd`, `windTime`, `min_day`, `max_day`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",$XR,'R',false);
        if(!$Success)
        {
            file_put_contents('error_daily.txt', "['".join("','",array_values($XR))."'],\n", FILE_APPEND);
        }
    }
}
//SetData($Data);
/* ------------------------------------------------------------------------------------------------------------------ */
$Data = [

];
/* ------------------------------------------------------------------------------------------------------------------ */
SetData($Data);