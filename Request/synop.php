<?php
require_once('index.php');
$Return = false;
if (isset($_REQUEST['date'], $_REQUEST['time']) && TestDate())
{

    $Return['synop'] = MySqlX("SELECT * FROM `synop` WHERE `Station` = ? AND `date` = ? AND `time` = ? LIMIT 1", [$_SESSION['Station'], _REQUEST_('date'), _REQUEST_('time')], 0);
    if (empty($Return['synop']))
    {
        $Return['courier'] = MySqlX("SELECT * FROM `courier` WHERE `Station` = ? AND `date` = ? AND `time` = ? LIMIT 1", [$_SESSION['Station'], _REQUEST_('date'), _REQUEST_('time')], 0);
    }
}
echo json_encode($Return);