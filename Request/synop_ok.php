<?php
require_once ( 'index.php' );

$Return = [];
$R_Time = _REQUEST_('time');
$R_Date = _REQUEST_('date');
$R_M_Time = _REQUEST_('mtime');

$Station = $_SESSION['Station'];

$Time = MySqlX("SELECT `time` FROM `synop` WHERE `Station` = ? AND `date` = ? ORDER BY `date`,`time` DESC LIMIT 1", [$Station, $R_Date], 0);
if ($Time && isset($Time['time'])) {
    $Count = intval($R_Time) - intval($Time['time']);

    $Data = MySqlX("SELECT * FROM `synop` WHERE `Station` = ? AND `date` = ? AND `time` = ? ORDER BY `date`,`time` LIMIT 1", [$Station, $R_Date, $R_Time], 0);

    if (!$Data || !is_array($Data)) {
        $Data = [];
    }

    $Length = count($Data);

    if ($Count == 3) {
        $Return = ["okay"];
    } else if ($Length > 0) {
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