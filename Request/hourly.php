<?php
require_once('index.php');
$Return = [];

if (isset($_REQUEST['date'], $_REQUEST['time'])&&TestDate()) {
    $Old = (MySqlX("SELECT * FROM `courier` WHERE `Station` = ? AND `date` = ? AND `time` = ? LIMIT 1", [$_SESSION['Station'], _REQUEST_('date'), _REQUEST_('time')], 0));
    $Min = (MySqlX("SELECT `ttt` FROM `courier` WHERE `Station` = ? AND `date` = ? AND `time` < ? ORDER BY `id` DESC LIMIT 1", [$_SESSION['Station'], _REQUEST_('date'), _REQUEST_('time')], 0));
    if ($Old) {
        $Old['Monitor'] = $Old['name'];
        $Return['Old'] = $Old;
    }

    if ($Min) {
        $Return['Min'] = $Min;
    }
}

echo json_encode($Return);