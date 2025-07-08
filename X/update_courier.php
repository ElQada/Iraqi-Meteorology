<?php
/* ------------------------------------------------------------------------------------------------------------------ */
require_once "../configuration/Connection.php";
/* ------------------------------------------------------------------------------------------------------------------ */
$Stations = [10,34,24,27,14,32,23,13,8,26,1,28,29,20,42,39,11,45,17,5,25,30,7,6,38,21,31,15,4,19,37,9,12,43,40,22,33]; // 0 => 36 :: [37]
//$Stations = [10];
//$Keys     = ["P0P0P0P0","PPPP","TTT","TDTDTD","PPP","WW","W1W2","RH","WB","VP"]; // 0 => 9 :: [10]
$Keys     = ["PPPP"];
$Years    = ['2020','2021','2022','2023','2024','2025']; // 0 => 5 :: [6]
//$Years    = ['2020'];
$Months   = ['01','02','03','04','05','06','07','08','09','10','11','12']; // 0 => 11 :: [12]
//$Months   = ['01'];
/* ------------------------------------------------------------------------------------------------------------------ */
for ($XStation = 0; $XStation < count($Stations); $XStation++)
{
    for($XKey = 0; $XKey < count($Keys); $XKey++)
    {
        for($XYear = 0; $XYear < count($Years); $XYear++)
        {
            for($XMonth = 0; $XMonth < count($Months); $XMonth++)
            {
                $Station  = $Stations[$XStation];    // 0 => 36 :: [37]
                $Key      = $Keys[$XKey];            // 0 => 9 :: [10]
                $Year     = $Years[$XYear];          // 0 => 5 :: [6]
                $Month    = $Months[$XMonth];        // 0 => 11 :: [12]
                /* ------------------------------------------------------------------------------------------------------------------ */
                $Empty = MySqlX("SELECT `id`,`time` FROM `courier` WHERE `Station` = $Station AND `$Key` = '' AND `date` LIKE '%$Year-$Month-%'",[],null);
                /* ------------------------------------------------------------------------------------------------------------------ */
                $Run = true;
                /* ------------------------------------------------------------------------------------------------------------------ */
                if ($Run && $Empty)
                {
                    $Error  = 0;
                    $Update = 0;
                    /* ------------------------------------------------------------------------------------------------------------------ */
                    while ($Row = $Empty->fetch(PDO::FETCH_ASSOC))
                    {
                        $Set = MySqlX("SELECT `$Key` FROM `courier` WHERE `Station` = $Station AND `$Key` != '' AND `date` LIKE '%$Year-$Month-%' LIMIT 1",[],0);
                        if (!$Set)
                        {
                            if ($XMonth<11)
                            {
                                $Set = MySqlX("SELECT `$Key` FROM `courier` WHERE `Station` = $Station AND `$Key` != '' AND `date` BETWEEN '$Year-$Month-01' AND '$Year-".$Months[$XMonth+1]."-01' LIMIT 1",[],0);
                            }
                            elseif($XYear<5)
                            {
                                $Set = MySqlX("SELECT `$Key` FROM `courier` WHERE `Station` = $Station AND `$Key` != '' AND `date` BETWEEN '$Year-$Month-01' AND '".$Years[$XYear+1]."-$Months-01' LIMIT 1",[],0);
                            }

                        }
                        if (!$Set)
                        {
                            if ($XMonth<10)
                            {
                                $Set = MySqlX("SELECT `$Key` FROM `courier` WHERE `Station` = $Station AND `$Key` != '' AND `date` BETWEEN '$Year-$Month-01' AND '$Year-".$Months[$XMonth+2]."-01' LIMIT 1",[],0);
                            }
                        }
                        if (!$Set)
                        {
                            if ($XMonth<9)
                            {
                                $Set = MySqlX("SELECT `$Key` FROM `courier` WHERE `Station` = $Station AND `$Key` != '' AND `date` BETWEEN '$Year-$Month-01' AND '$Year-".$Months[$XMonth+3]."-01' LIMIT 1",[],0);
                            }
                        }
                        if (!$Set)
                        {
                            if ($XMonth<8)
                            {
                                $Set = MySqlX("SELECT `$Key` FROM `courier` WHERE `Station` = $Station AND `$Key` != '' AND `date` BETWEEN '$Year-$Month-01' AND '$Year-".$Months[$XMonth+4]."-01' LIMIT 1",[],0);
                            }
                        }
                        if (!$Set)
                        {
                            if ($XMonth<7)
                            {
                                $Set = MySqlX("SELECT `$Key` FROM `courier` WHERE `Station` = $Station AND `$Key` != '' AND `date` BETWEEN '$Year-$Month-01' AND '$Year-".$Months[$XMonth+5]."-01' LIMIT 1",[],0);
                            }
                        }
                        if (!$Set)
                        {
                            if ($XMonth<6)
                            {
                                $Set = MySqlX("SELECT `$Key` FROM `courier` WHERE `Station` = $Station AND `$Key` != '' AND `date` BETWEEN '$Year-$Month-01' AND '$Year-".$Months[$XMonth+6]."-01' LIMIT 1",[],0);
                            }
                        }
                        if (!$Set)
                        {
                            if ($XYear<5)
                            {
                                $Set = MySqlX("SELECT `$Key` FROM `courier` WHERE `Station` = $Station AND `$Key` != '' AND `date` BETWEEN '$Year-$Month-01' AND '".$Years[$XYear+1]."-$Months-01' LIMIT 1",[],0);
                            }
                        }
                        if (!$Set)
                        {
                            $Set = MySqlX("SELECT `$Key` FROM `courier` WHERE `Station` = $Station AND `time` = ? AND `$Key` != '' LIMIT 1",[$Row['time']],0);
                        }

                        if ($Set)
                        {
                            MySqlX("UPDATE `courier` SET `$Key` = ? WHERE `id` = ?",[$Set[$Key],$Row['id']],'R');
                            $Update++;
                        }
                        else {$Error++;}
                    }
                    echo " Station : $Station __ Key : $Key __ Year : $Year __ Month : $Month __ Updated => $Update  __ Error => $Error <hr>";
                }
            }
        }
    }
}