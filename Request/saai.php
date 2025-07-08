<?php
require_once ( 'index.php' );

$Return = [];
$R_Time = _REQUEST_('time');
$R_Date = _REQUEST_('date');

$Station = $_SESSION['Station'];

$Time = MySqlX("SELECT `time` FROM `courier` WHERE `Station` = ? AND `date` = ? ORDER BY `date`,`time` DESC LIMIT 1", [$Station, $R_Date], 0);
if ($Time && isset($Time['time'])) {
    $Count = intval($R_Time) - intval($Time['time']);

    $Data = MySqlX("SELECT * FROM `courier` WHERE `Station` = ?  AND `date` = ? AND `time` = ? ORDER BY `date`,`time` LIMIT 1", [$Station, $R_Date, $R_Time], 0);

    if (!$Data || !is_array($Data)) {
        $Data = [];
    }else{
        if (in_array($R_Time, ["06", "18"])) {
            $TNTNTN = Get_TNTNTN($R_Date, $R_Time);
            $Data["TNTNTN"] = $TNTNTN;
            $Data["SN3"] = strpos($TNTNTN, "-") ? '-' : '+';
        } else {
            unset($Data['TNTNTN']);
        }
    }

    $Length = count($Data);

    if ($Count == 1) {
        $Return = ["okay"];
    } else if ($Length > 0) {
        unset($Data['ElevationM']);
        if (isset($Data["FF"]) && strlen($Data["FF"]) < 2) {
            $Data["FF"] = "0" . $Data["FF"];
        }
        $Return = $Data;
    } else {
        $Return = [$Time];
    }
} else if ($R_Time == "00") {
    $Return = ["okay"];
} else if (intval($R_Time) > 0) {
    $Return = ["-1"];
}

echo strtolower(json_encode($Return));