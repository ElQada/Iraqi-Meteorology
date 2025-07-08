<?php
require_once('index.php');
$Return = [];
$Sorted = [];
$Print = '';
$Time = null;
$Date = null;

if (isset($_REQUEST['date'], $_REQUEST['time']) && TestDate()) {
    $Time = _REQUEST_('time');
    $Date = _REQUEST_('date');


    $CurrentStation = GetCurrentStation();

    $Delete = [];

    $Return = MySqlX("SELECT * FROM `synop` WHERE `date` = ? AND `time` = ?", [$Date, $Time], 11);

    if (is_array($Return))
    {
        foreach ($Return as $K => $V) {
            if (isset($CurrentStation[$V['Station']]))
            {
                $Code = $CurrentStation[$V['Station']]['StationCode'];
                $Sorted[$Code] = "40".$Code." ".$Return[$K]['synop'];
            }
            else
            {
                $Delete[] = $V['id'];
                unset($Return[$K]);
            }
        }
    }

    if (count($Delete))
    {
        MySqlX("DELETE FROM `synop` WHERE `id` IN(" . join(",", $Delete) . ")");
    }

    if ($Sorted) {
        sort($Sorted);
        $ZCZC = ['00'=>'001','03'=>'002','06'=>'003','09'=>'004','12'=>'005','15'=>'006','18'=>'007','21'=>'008'];
        $Print .= "ZCZC ".$ZCZC[$Time]."\n";
        if (in_array($Time,['00','06','12','18']))
        {
            $Print .= "SMIQ01 ORBI ";
        }
        else
        {
            $Print .= "SIIQ20 ORBI ";
        }
        $Print .= (explode('-',$Date)[2]).$Time."00\n";
        $Print .= "AAXX ".(explode('-',$Date)[2]).$Time."1\n";
        foreach ($Sorted as $K => $V) {
            $Print .= trim($V)."=\n";
        }
        $Print .= "NNNN\n";
    }
    else
    {
        $Return = [];
    }
}

echo json_encode(['Print' => $Print,'Count'=>count($Sorted),'SetStationX'=>SetStationX($Date,$Time)]);