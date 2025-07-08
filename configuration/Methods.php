<?php
function GetDateFromTo(&$From,&$To,$Else = ['2024-08-01','2025-01-01'])
{
    $Return = true;

    $Date_X = strtotime(_REQUEST_('date',$Else[0]));
    $Date_Y = strtotime(_REQUEST_('_date_',$Else[1]));

    if ($Date_X > $Date_Y)
    {
        $From = _REQUEST_('_date_',$Else[1]);
        $To   = _REQUEST_('date',$Else[0]);
    }
    else
    {
        $From = _REQUEST_('date',$Else[0]);
        $To   = _REQUEST_('_date_',$Else[1]);
    }

    if (strtotime($From) < strtotime($_SESSION['MinDate']))
    {
        $From = $_SESSION['MinDate'];
        $Return = false;
    }

    if (strtotime($To) > strtotime($_SESSION['MaxDate']))
    {
        $To = $_SESSION['MaxDate'];
        $Return = false;
    }
    return $Return;
}

function TestDate()
{
    return (isset($_REQUEST['date'])&&!((strtotime($_REQUEST['date']) < strtotime($_SESSION['MinDate'])) && (strtotime($_REQUEST['date']) > strtotime($_SESSION['MaxDate']))));
}

function Test_Date()
{
    return (isset($_REQUEST['Date'])&&!((strtotime($_REQUEST['Date']) < strtotime($_SESSION['MinDate'])) && (strtotime($_REQUEST['Date']) > strtotime($_SESSION['MaxDate']))));
}
function Test_Date_()
{
    return (isset($_REQUEST['_date_'])&&!((strtotime($_REQUEST['_date_']) < strtotime($_SESSION['MinDate'])) && (strtotime($_REQUEST['_date_']) > strtotime($_SESSION['MaxDate']))));
}

function Get_TNTNTN($date, $time,$Station = null)
{
    if ($Station === null)
    {
        $Station = $_SESSION['Station'];
    }
    if ($time == 18)
    {
        $Return = MySqlX("SELECT `max` FROM `courier` WHERE `Station` = ? AND `date` = ? AND `time` IN('15')", [$Station,$date], 11);
    }
    else
    {
        $Return = MySqlX("SELECT `ttt`, `min` FROM `courier` WHERE `Station` = ? AND `date` = ? AND `time` IN (03,04,05,06)", [$Station,$date], 11);
    }
    $All = [];
    if (is_array($Return)) {
        foreach ($Return as $Value) {
            foreach ($Value as $Item) {
                if (strlen($Item) && $Item != '00.0') {
                    $All[] = $Item;
                }
            }
        }
        if (count($All)) {
            return min($All);
        } else {
            return "";
        }
    } else {
        return "";
    }
}


function Stations($CurrentFile = 'Else')
{
    $Selected = _SESSION_('Station',1);

    if ((($Selected === '*') && !in_array($CurrentFile,['show-courier','show-daily','reports','table-synop','month-courier','monthly-cloud',"monthly-tntntn",'month-daily','daily-rh','monthly-weather','history'])))
    {
        $_SESSION['Station']  = $_SESSION['Save-Station'];
    }

    $Selected = _SESSION_('Station',1);

    if ((in_array($CurrentFile,['synop','table-synop','month-courier','monthly-cloud',"monthly-tntntn",'month-daily','daily-rh','monthly-weather']) && $_SESSION['per'] === "Forecasting") || $_SESSION['per'] === "admin" || in_array($CurrentFile,['']))
    {
        foreach (MySqlX('SELECT * FROM `stations` WHERE `id` NOT IN (42,43) ORDER BY `StationCode`', [], 11) as $Station) {
            if (!in_array($Station['id'],[42,43]))
            {
                if ($Selected == $Station['id'])
                {
                    echo "<option value='$Selected' selected> {$Station['StationName']} </option>";
                }
                else
                {
                    echo "<option value='{$Station['id']}'> {$Station['StationName']} </option>";
                }
            }
        }
    }
    else
    {
        $Get = MySqlX('SELECT `id`,`StationName` FROM `stations` WHERE `id` = ? AND `id` NOT IN (42,43)', [$Selected], 0);
        if (!in_array($Get['id'],[42,43]))
        {
            echo "<option value='$Selected' selected> {$Get['StationName']} </option>";
        }
    }
}

function daily_monitoring_date()
{
    $Selected = _SESSION_('Station',1);
    $Data = _SESSION_('Date',date('Y-m-d'));
    $Dates = [];

    if (_ROLE_ == 'admin' || in_array(_TYPE_,['Offline','Local']))
    {
        $Get = MySqlX('SELECT `date` FROM `daily` WHERE `Station` = ? AND (`date` BETWEEN ? AND ? ) ORDER BY `date`', [$Selected,date('Y-m-d', strtotime("$Data -3 year")),date('Y-m-d', strtotime("$Data +3 year"))], 11);
    }
    else
    {
        $Day = explode('-',date('Y-m-d'));

        if (in_array($Day[2],["26","27","28","29","30","31"]))
        {
            $Get = MySqlX('SELECT `date` FROM `daily` WHERE `Station` = ? AND (`date` BETWEEN ? AND ? ) ORDER BY `date`', [$Selected,"{$Day[0]}-{$Day[1]}-01",join('-',$Day)], 11);
        }
        else
        {
            $Get = MySqlX('SELECT `date` FROM `daily` WHERE `Station` = ? AND (`date` BETWEEN ? AND ? ) ORDER BY `date`', [$Selected,date('Y-m-d', strtotime("$Data -16 day")),date('Y-m-d', strtotime("$Data +16 day"))], 11);
        }
    }

    if ($Get)
    {
        foreach ($Get as $Daily) {
            $Dates[] = $Daily['date'];
        }
    }
    echo json_encode($Dates);
}

function courier_date()
{
    $Selected = _SESSION_('Station',1);
    $Data = _SESSION_('Date',date('Y-m-d'));

    $Dates = [];

    if (_ROLE_ == 'admin' || in_array(_TYPE_,['Offline','Local']))
    {
        $Get = MySqlX('SELECT `date`,`time` FROM `courier` WHERE `Station` = ? AND (`date` BETWEEN ? AND ? ) ORDER BY `date`,`time`', [$Selected,date('Y-m-d', strtotime("$Data -3 year")),date('Y-m-d', strtotime("$Data +3 year"))], 11);
    }
    else
    {
        $Day = explode('-',date('Y-m-d'));

        if (in_array($Day[2],["26","27","28","29","30","31"]))
        {
            $Get = MySqlX('SELECT `date`,`time` FROM `courier` WHERE `Station` = ? AND (`date` BETWEEN ? AND ? ) ORDER BY `date`,`time`', [$Selected,"{$Day[0]}-{$Day[1]}-01",join('-',$Day)], 11);
        }
        else
        {
            $Get = MySqlX('SELECT `date`,`time` FROM `courier` WHERE `Station` = ? AND (`date` BETWEEN ? AND ? ) ORDER BY `date`,`time`', [$Selected,date('Y-m-d', strtotime("$Data -16 day")),date('Y-m-d', strtotime("$Data +16 day"))], 11);
        }
    }


    if ($Get)
    {
        foreach ($Get as $Courier) {
            if (!in_array($Courier['date'],array_keys($Dates)))
            {
                $Dates[$Courier['date']] = [ $Courier['time'] ];
            }
            else
            {
                $Dates[$Courier['date']][] = $Courier['time'];
            }
        }
    }
    echo json_encode($Dates);
}

function courier_Error()
{
    $Selected = _SESSION_('Station',1);
    $Data = _SESSION_('Date',date('Y-m-d'));
    $Dates = [];
    $Errors = [];
    $TestRange = ['TTT'=>100,'WB'=>100,'RH'=>100,'VP'=>100,'TDTDTD'=>100,'P0P0P0P0'=>100,'PPPP'=>100,'PPP'=>100];


    if (_ROLE_ == 'admin' || in_array(_TYPE_,['Offline','Local']))
    {
        $G = MySqlX('SELECT `Station`,`TTT`,`WB`,`RH`,`VP`,`TDTDTD`,`TNTNTN`,`IR`,`IX`,`H`,`VV`,`N`,`DD`,`FF`,`SN1`,`SN2`,`P0P0P0P0`,`PPPP`,`A`,`PPP`,`date`,`time` FROM `courier` WHERE `Station` = ? AND (`date` BETWEEN ? AND ? ) ORDER BY `date`,`time`', [$Selected,date('Y-m-d', strtotime("$Data -3 year")),date('Y-m-d', strtotime("$Data +3 year"))], 11);
    }
    else
    {
        $Day = explode('-',date('Y-m-d'));
        if (in_array($Day[2],["26","27","28","29","30","31"]))
        {
            $G = MySqlX('SELECT `Station`,`TTT`,`WB`,`RH`,`VP`,`TDTDTD`,`TNTNTN`,`IR`,`IX`,`H`,`VV`,`N`,`DD`,`FF`,`SN1`,`SN2`,`P0P0P0P0`,`PPPP`,`A`,`PPP`,`date`,`time` FROM `courier` WHERE `Station` = ? AND (`date` BETWEEN ? AND ? ) ORDER BY `date`,`time`', [$Selected,"{$Day[0]}-{$Day[1]}-01",join('-',$Day)], 11);
        }
        else
        {
            $G = MySqlX('SELECT `Station`,`TTT`,`WB`,`RH`,`VP`,`TDTDTD`,`TNTNTN`,`IR`,`IX`,`H`,`VV`,`N`,`DD`,`FF`,`SN1`,`SN2`,`P0P0P0P0`,`PPPP`,`A`,`PPP`,`date`,`time` FROM `courier` WHERE `Station` = ? AND (`date` BETWEEN ? AND ? ) ORDER BY `date`,`time`', [$Selected,date('Y-m-d', strtotime("$Data -16 day")),date('Y-m-d', strtotime("$Data +16 day"))], 11);
        }
    }

    if ($G)
    {
        for ($I=1;$I<count($G);$I++)
        {
            foreach ($G[$I] as $K => $V)
            {
                $Error = false;

                if ($K == 'TNTNTN' && in_array($G[$I]['time'],['06','18']) && empty($V))
                {
                    $Error = true;
                }

                if($K === 'FF' && !in_array(($I-1)."@$K", $Errors) && floatval($V) >= 30)
                {
                    $Error = true;
                }


                foreach (['P0P0P0P0'=>900,'PPPP'=>900] as $K1 => $V1)
                {
                    if($K === $K1 && !in_array(($I-1)."@$K", $Errors) && floatval($V) <= $V1)
                    {
                        if (!(empty($V) || empty($G[$I-1][$K]) || in_array($G[$I]['Code'],['602','658','642',12,15,19])))
                        {
                            $Error = true;
                        }
                    }
                }

                if ($Error&&in_array($K,['P0P0P0P0','PPPP'])&&(empty($V)||empty($G[$I-1][$K]))&&in_array($G[$I]['Station'],['602','658','642',12,15,19]))
                {
                    $Error = false;
                }

                if($I && !in_array(($I-1)."@$K", $Errors) && isset($TestRange[$K]) && $G[$I-1]['Station'] == $G[$I]['Station'])
                {
                    if ($K === 'TTT')
                    {
                        $Test = (abs(floatval($G[$I]['SN1'].$G[$I][$K]) - floatval($G[$I-1]['SN1'].$G[$I-1][$K])) > $TestRange[$K]);
                    }
                    elseif ($K === 'TDTDTD')
                    {
                        $Test = (abs(floatval($G[$I]['SN2'].$G[$I][$K]) - floatval($G[$I-1]['SN2'].$G[$I-1][$K])) > $TestRange[$K]);
                    }
                    elseif ($K === 'RH' && in_array('100',[$V,$G[$I-1][$K]]))
                    {
                        $Test = false;
                    }
                    elseif (in_array($K,['P0P0P0P0','PPPP']) && (empty($V) || empty($G[$I-1][$K])) )
                    {
                        $Test = false;
                    }
                    else
                    {
                        $Test = (abs(floatval($V) - floatval($G[$I-1][$K])) > $TestRange[$K]);
                    }

                    if ($Test)
                    {
                        $RangeDay  = abs(strtotime($G[$I-1]['date']) - strtotime($G[$I]['date']))/86400;
                        $RangeTime = abs(intval($G[$I-1]['time']) - intval($G[$I]['time']));
                        if (($RangeTime == 1 && $RangeDay == 0) || ($RangeTime == 23 && $RangeDay == 1))
                        {
                            $Error = true;
                        }
                    }
                }

                if ($Error)
                {
                    if (!in_array($G[$I]['date'],array_keys($Dates)))
                    {
                        $Dates[$G[$I]['date']] = [];
                        $Dates[$G[$I]['date']][$G[$I]['time']] = [$K];
                    }
                    elseif (!in_array($G[$I]['time'],array_keys($Dates[$G[$I]['date']])))
                    {
                        $Dates[$G[$I]['date']][$G[$I]['time']] = [$K];
                    }
                    else
                    {
                        $Dates[$G[$I]['date']][$G[$I]['time']][] = $K;
                    }
                    $Errors[] = "$I@$K";
                }
            }
        }
    }
    echo json_encode($Dates);
}

function daily_Error()
{
    $Selected = _SESSION_('Station',1);
    $Data = _SESSION_('Date',date('Y-m-d'));
    $Dates = [];
    $Errors = [];
    $TestRange = ["SunShine"=>10,"RetRadiation"=>500,"ResultEvapration"=>30,"CannabisTemperature"=>20,"min_day"=>30,"max_day"=>30,"_5cm00"=>30,"_5cm06"=>30,"_5cm12"=>30,"_5cm18"=>30,"Sur00"=>30,"Sur06"=>30,"Sur12"=>30,"Sur18"=>30,"5cm00"=>30,"5cm06"=>30,"5cm12"=>30,"5cm18"=>30,"10cm00"=>30,"10cm06"=>30,"10cm12"=>30,"10cm18"=>30,"20cm00"=>30,"20cm06"=>30,"20cm12"=>30,"20cm18"=>30,"50cm00"=>30,"50cm06"=>30,"50cm12"=>30,"50cm18"=>30,"100cm00"=>30,"100cm06"=>30,"100cm12"=>30,"100cm18"=>30];

    if (_ROLE_ == 'admin' || in_array(_TYPE_,['Offline','Local']))
    {
        $G = MySqlX('SELECT `Station`,`FirstWind50`,`FirstWind200`,`SecondWind50`,`SecondWind200`,`SunShine`,`RetRadiation`,`ResultEvapration`,`CannabisTemperature`,`min_day`,`max_day`,`_5cm00`,`_5cm06`,`_5cm12`,`_5cm18`,`Sur00`,`Sur06`,`Sur12`,`Sur18`,`5cm00`,`5cm06`,`5cm12`,`5cm18`,`10cm00`,`10cm06`,`10cm12`,`10cm18`,`20cm00`,`20cm06`,`20cm12`,`20cm18`,`50cm00`,`50cm06`,`50cm12`,`50cm18`,`100cm00`,`100cm06`,`100cm12`,`100cm18`,`date` FROM `daily` WHERE `Station` = ? AND (`date` BETWEEN ? AND ? ) ORDER BY `date`', [$Selected,date('Y-m-d', strtotime("$Data -12 month")),date('Y-m-d', strtotime("$Data +12 month"))], 11);
    }
    else
    {
        $Day = explode('-',date('Y-m-d'));
        if (in_array($Day[2],["26","27","28","29","30","31"]))
        {
            $G = MySqlX('SELECT `Station`,`FirstWind50`,`FirstWind200`,`SecondWind50`,`SecondWind200`,`SunShine`,`RetRadiation`,`ResultEvapration`,`CannabisTemperature`,`min_day`,`max_day`,`_5cm00`,`_5cm06`,`_5cm12`,`_5cm18`,`Sur00`,`Sur06`,`Sur12`,`Sur18`,`5cm00`,`5cm06`,`5cm12`,`5cm18`,`10cm00`,`10cm06`,`10cm12`,`10cm18`,`20cm00`,`20cm06`,`20cm12`,`20cm18`,`50cm00`,`50cm06`,`50cm12`,`50cm18`,`100cm00`,`100cm06`,`100cm12`,`100cm18`,`date` FROM `daily` WHERE `Station` = ? AND (`date` BETWEEN ? AND ? ) ORDER BY `date`', [$Selected,"{$Day[0]}-{$Day[1]}-01",join('-',$Day)], 11);
        }
        else
        {
            $G = MySqlX('SELECT `Station`,`FirstWind50`,`FirstWind200`,`SecondWind50`,`SecondWind200`,`SunShine`,`RetRadiation`,`ResultEvapration`,`CannabisTemperature`,`min_day`,`max_day`,`_5cm00`,`_5cm06`,`_5cm12`,`_5cm18`,`Sur00`,`Sur06`,`Sur12`,`Sur18`,`5cm00`,`5cm06`,`5cm12`,`5cm18`,`10cm00`,`10cm06`,`10cm12`,`10cm18`,`20cm00`,`20cm06`,`20cm12`,`20cm18`,`50cm00`,`50cm06`,`50cm12`,`50cm18`,`100cm00`,`100cm06`,`100cm12`,`100cm18`,`date` FROM `daily` WHERE `Station` = ? AND (`date` BETWEEN ? AND ? ) ORDER BY `date`', [$Selected,date('Y-m-d', strtotime("$Data -16 day")),date('Y-m-d', strtotime("$Data +16 day"))], 11);
        }
    }
    if ($G)
    {
        for ($I=1;$I<count($G);$I++)
        {
            foreach ($G[$I] as $K => $V)
            {
                if (in_array($K,["FirstWind50","FirstWind200","SecondWind50","SecondWind200"]))
                {
                    if(strlen($V) && strlen($V) !== 7)
                    {
                        if (!in_array($G[$I]['date'],array_keys($Dates)))
                        {
                            $Dates[$G[$I]['date']] = [$K];
                        }
                        else
                        {
                            $Dates[$G[$I]['date']][] = $K;
                        }
                        $Errors[] = "$I@$K";
                    }
                }

                if (!in_array(($I-1)."@$K", $Errors) && in_array($K,["date"]))
                {
                    $Empty = str_replace(' ','',strval($V));
                    if (empty($Empty) && $Empty!='0')
                    {
                        if (!in_array($G[$I]['date'],array_keys($Dates)))
                        {
                            $Dates[$G[$I]['date']] = [$K];
                        }
                        else
                        {
                            $Dates[$G[$I]['date']][] = $K;
                        }
                        $Errors[] = "$I@$K";
                    }
                }

                if(!in_array(($I-1)."@$K", $Errors) && isset($TestRange[$K]) && $G[$I-1]['Station'] == $G[$I]['Station'])
                {
                    $Empty1 = str_replace(' ','',strval($V));
                    $Empty2 = str_replace(' ','',strval($G[$I-1][$K]));
                    // $Empty = ($Empty1!='0' && empty($Empty1)) && ($Empty2!='0' && empty($Empty2));
                    $Empty = (empty($Empty1)) || (empty($Empty2));
                    if (!$Empty && (abs(floatval($V) - floatval($G[$I-1][$K])) > $TestRange[$K]))
                    {
                        $RangeDay = abs(strtotime($G[$I-1]['date']) - strtotime($G[$I]['date']))/86400;
                        // $RangeTime = abs(intval($lines[$I-1]['time']) - intval($line['time']));
                        if (in_array($RangeDay,[1,2]))
                        {
                            if (!in_array($G[$I]['date'],array_keys($Dates)))
                            {
                                $Dates[$G[$I]['date']] = [$K];
                            }
                            else
                            {
                                $Dates[$G[$I]['date']][] = $K;
                            }
                            $Errors[] = "$I@$K";
                        }
                    }
                }
            }
        }
    }
    echo json_encode($Dates);
}

function synop_date()
{
    $Selected = _SESSION_('Station',1);
    $Dates = [];
    $Get = MySqlX('SELECT `date`,`time` FROM `synop` WHERE `Station` = ? ORDER BY `date`,`time`', [$Selected], 11);
    if ($Get)
    {
        foreach ($Get as $Courier) {
            if (!in_array($Courier['date'],array_keys($Dates)))
            {
                $Dates[$Courier['date']] = [ $Courier['time'] ];
            }
            else
            {
                $Dates[$Courier['date']][] = $Courier['time'];
            }
        }
    }
    echo json_encode($Dates);
}

function Monitors()
{
    foreach (MySqlX('SELECT * FROM `monitors`', [], 11) as $Monitor) {
        echo "<option value='{$Monitor['name']}'/>";
    }
}

function Message($Body, $Title = 'تــم تـنـفـيـذ الامـــر بـنـجـاح', $Button = 'مــوافـــق', $Icon = 'success')
{
    $_SESSION['Message'][] = ['Title' => $Title, 'Body' => $Body, 'Icon' => $Icon, 'Button' => $Button];
}

function Success($Body, $Title = 'تــم تـنـفـيـذ الامـــر بـنـجـاح', $Button = 'جــيـــد', $Icon = 'success')
{
    return Message($Body, $Title, $Button, $Icon);
}

function Error($Body, $Title = 'لــم يــتــم تـنـفـيـذ الامـــر بــنـجــاح', $Button = 'فــهـمــت', $Icon = 'error')
{
    return Message($Body, $Title, $Button, $Icon);
}

function SetStationX($Date = null, $Time = null)
{
    $CurrentDate = date('Y-m-d');
    if ($Date === null)
    {
        $Date = _SESSION_('Date',$CurrentDate);
    }

    if ($Time === null && $CurrentDate === $Date)
    {
        $Time = intval(date('H'));
    }

    if ($Time === null)
    {
        $Time = _REQUEST_('time');
    }

    $Stations =  MySqlX('SELECT `id`,`StationName` FROM `stations` WHERE `id` NOT IN (42,43) ORDER BY `StationCode`', [],11);
    $Data = MySqlX('SELECT `time`,`Station` FROM `synop` WHERE `date` = ? ORDER BY `time`', [$Date],11);

    return ['Now'=>$Data,'Stations'=>$Stations,'Date'=>$Date,'Time'=>$Time];
}


function FindXY(&$Array,$Find,&$Else='')
{
    if (is_array($Array) && array_key_exists($Find,$Array))
    {
        return $Array[$Find];
    }
    else
    {
        return $Else;
    }
}



function SelectCurrentStation()
{
    if (_ROLE_ === 'admin'){
        $Return = MySqlX('SELECT * FROM `stations` WHERE `id` NOT IN (42,43)', [], 11);
    }
    else
    {
        $Return = MySqlX('SELECT * FROM `stations` WHERE `id` = ?', [$_SESSION['Save-Station']], 11);
    }
    if (!$Return)
    {
        $Return = [];
    }
    return $Return;
}

function SelectCurrentAccount()
{
    if (_ROLE_ === 'admin'){
        $Return = MySqlX('SELECT * FROM `accounts`', [], 11);
    }
    elseif (_ROLE_ === 'manager'){
        $Return = MySqlX("SELECT * FROM `accounts` WHERE `Station` = ? AND `per` NOT IN('Forecasting','Awos','admin')", [$_SESSION['Save-Station']], 11);
    }
    else
    {
        $Return = MySqlX('SELECT * FROM `accounts` WHERE `id` = ?', [$_SESSION['Account']], 11);
    }
    if (!$Return)
    {
        $Return = [];
    }
    return $Return;
}

function GetCurrentStation()
{
    $CurrentStation = [];
    foreach (SelectCurrentStation() as $_Station_) {
        $CurrentStation[$_Station_['id']] = $_Station_;
    }
    return $CurrentStation;
}

function GetCurrentAccount()
{
    $CurrentAccount = [];
    foreach ( SelectCurrentAccount() as $_Account_) {
        $CurrentAccount[$_Account_['id']] = $_Account_['user'].' @ Code : '.$_Account_['code'].' @ Station : '.$_Account_['Station'].' @ '.$_Account_['per'];
    }
    return $CurrentAccount;
}

function SetRecord($Station, $Type, $Keys, $Reference, $Value = '',$Account = null,$Unique = null)
{
    if (is_null($Account))
    {
        $User = _SESSION_('Account',$Account);

    }
    else
    {
        $User = $Account;
    }
   if (is_null($Station))
   {
       $Station = _SESSION_('Station','0');
   }
   return MySqlX("INSERT INTO `records`(`User`, `Station`, `Type`, `Keys`, `Reference`, `Value`,`_Unique_`) VALUES (?,?,?,?,?,?,?)",[$User, $Station, $Type, $Keys, $Reference, $Value,$Unique],'K');
}