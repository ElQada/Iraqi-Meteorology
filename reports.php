<?php
$Title = "التقارير";
$CurrentFile = "reports";
require_once "Components/SimpleXLSXGen.php";
require_once "Components/BackupDB.php";
use Shuchkin\SimpleXLSXGen;
/* ------------------------------------------------------------------------------------------------------------------ */
$DataTable = [];
$TableName = '';
$CurrentStation = GetCurrentStation();
/* ------------------------------------------------------------------------------------------------------------------ */
function SelectData($Table, $CurrentStation, $Records = false)
{
    $Station = $_SESSION['Station'];
    $DateFromTo = '';
    $Get = [];

    if (GetDateFromTo($From,$To))
    {
        if ($Station === '*')
        {
            if ($Records)
            {
                $DateFromTo = "AND `date` BETWEEN '$From' AND '$To'";
            }
            else
            {
                $DateFromTo = "WHERE `date` BETWEEN '$From' AND '$To'";
            }

            if ($Table === 'courier')
            {
                if ($Records)
                {
                    $Get = [];
                    foreach ($CurrentStation as $Key => $Value)
                    {
                        $Get[] = ['Station' => $Value, 'Records' => MySqlX("SELECT CONCAT(`date`,' @ ',`time`) AS `Record` FROM `$Table` WHERE `Station` = ?$DateFromTo ORDER BY `Station`, `date` , `time`", [$Key], 7)];
                    }
                }
                else
                {
                    $Get = MySqlX("SELECT * FROM `$Table` $DateFromTo ORDER BY `Station`, `date` , `time`", [], 11);
                }
            }
            else
            {
                if ($Records)
                {
                    $Get = [];
                    foreach ($CurrentStation as $Key => $Value)
                    {
                        $Get[] = ['Station' => $Value,'Records'=>MySqlX("SELECT `date` FROM `$Table` WHERE `Station` = ?$DateFromTo ORDER BY `Station`, `date`", [$Key], 7)];
                    }
                }
                else
                {
                    $Get = MySqlX("SELECT * FROM `$Table` $DateFromTo ORDER BY `Station`, `date`", [], 11);
                }
            }
        }
        else
        {
            $DateFromTo = "AND `date` BETWEEN '$From' AND '$To'";

            if ($Table === 'courier')
            {
                if ($Records)
                {
                    $Get = [['Station' => $CurrentStation[$Station], 'Records' => MySqlX("SELECT CONCAT(`date`,' @ ',`time`) AS `Record` FROM `$Table` WHERE `Station` = ?$DateFromTo ORDER BY `Station`, `date` , `time`", [$Station], 7)]];
                }
                else
                {
                    $Get = MySqlX("SELECT * FROM `$Table` WHERE `Station` = ?$DateFromTo ORDER BY `Station`, `date` , `time`", [$Station], 11);
                }
            }
            else
            {
                if ($Records)
                {
                    $Get = [['Station' => $CurrentStation[$Station],'Records'=>MySqlX("SELECT `date` FROM `$Table` WHERE `Station` = ?$DateFromTo ORDER BY `Station`, `date`", [$Station], 7)]];
                }
                else
                {
                    $Get = MySqlX("SELECT * FROM `$Table` WHERE `Station` = ?$DateFromTo ORDER BY `Station`, `date`", [$Station], 11);
                }
            }

        }
    }
    return $Get;
}
function EditData($Table, $CurrentStation, $TestError = false)
{
    $Get = SelectData($Table,$CurrentStation,false);
    $G = [];
    $Data = [];
    $Errors = [];
    if ($Get&&is_array($Get))
    {
        foreach ($Get as $Row)
        {
            $R = [];
            foreach ($Row as $K => $V)
            {
                if ($K === 'date')
                {
                    $R['date'] = $V;
                    $Date = explode('-', $V);
                    $R['Year'] = $Date[0];
                    $R['Month'] = $Date[1];
                    $R['Day'] = $Date[2];
                }
                elseif ($K === 'Account')
                {
                    $R['Code'] = $V;
                }
                else
                {
                    $R[$K] = $V;
                }
            }
            $R['Error'] = '';
            $G[] = $R;
        }
    }
    if (isset($G[0]))
    {
        if ($Table === 'courier')
        {
            $TestRange = ['TTT'=>100,'WB'=>100,'RH'=>100,'VP'=>100,'TDTDTD'=>100,'P0P0P0P0'=>100,'PPPP'=>100,'PPP'=>100];
        }
        else
        {
            $TestRange = ["SunShine"=>10,"RetRadiation"=>500,"ResultEvapration"=>30,"CannabisTemperature"=>20,"min_day"=>30,"max_day"=>30,"_5cm00"=>30,"_5cm06"=>30,"_5cm12"=>30,"_5cm18"=>30,"Sur00"=>30,"Sur06"=>30,"Sur12"=>30,"Sur18"=>30,"5cm00"=>30,"5cm06"=>30,"5cm12"=>30,"5cm18"=>30,"10cm00"=>30,"10cm06"=>30,"10cm12"=>30,"10cm18"=>30,"20cm00"=>30,"20cm06"=>30,"20cm12"=>30,"20cm18"=>30,"50cm00"=>30,"50cm06"=>30,"50cm12"=>30,"50cm18"=>30,"100cm00"=>30,"100cm06"=>30,"100cm12"=>30,"100cm18"=>30];
        }

        for ($I=0;$I<count($G);$I++)
        {
            if ($Table === 'daily')
            {
                $G[$I]['Link'] = "?Station=".$G[$I]['Station']."&Date=".$G[$I]['date']."&ID=".$G[$I]['id']."&Action=EditOpen";
            }
            elseif ($Table === 'courier')
            {
                $G[$I]['Link'] = "?Station=".$G[$I]['Station']."&Date=".$G[$I]['date']."&Time=".$G[$I]['time']."&ID=".$G[$I]['id']."&Action=EditOpen";
            }
            $G[$I]['Code'] = $CurrentStation[$G[$I]['Station']]['StationCode'];
            $G[$I]['Station'] = $CurrentStation[$G[$I]['Station']]['StationName'];
            $G[$I]['id'] = $I + 1;

            if ($Table === 'courier')
            {
                $G[$I]['VP'] = number_format(floatval($G[$I]['VP']), 1, '.', '');

                foreach (['TTT','TDTDTD','TNTNTN','min','max'] as $Key)
                {
                    $Test = $G[$I][$Key];
                    if (!empty($Test))
                    {
                        $G[$I][$Key] = number_format(floatval($Test),1,'.','');
                    }
                }

                foreach (['VV','DD','FF','RRR','WW','W1W2','HSHS1','HSHS2','HSHS3'] as $Key)
                {
                    $Test = $G[$I][$Key];
                    if ((strlen($Test)==1)&&$Test<10)
                    {
                        $G[$I][$Key] = '0'.$Test;
                    }
                }
            }
            $Row = [];
            $RowError = [];

            foreach ($G[$I] as $K => $V)
            {
                $Error = false;
                if ($Table === 'courier')
                {

                    if ($K == 'TNTNTN' && in_array($G[$I]['time'],['06','18']) && empty($V))
                    {
                        $Error = true;
                    }

                    foreach (['FF'=>30] as $K1 => $V1)
                    {
                        if($K === $K1 && !in_array(($I-1)."@$K", $Errors) && floatval($V) >= $V1)
                        {
                            $Error = true;
                        }
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
                }
                else if ($Table === 'daily')
                {
                    if (in_array($K,["FirstWind50","FirstWind200","SecondWind50","SecondWind200"]))
                    {
                        if(strlen($V) && strlen($V) !== 7)
                        {
                            $Error = true;
                        }
                    }

                    if($I && !in_array(($I-1)."@$K", $Errors) && isset($TestRange[$K]) && $G[$I-1]['Station'] == $G[$I]['Station'])
                    {
                        $Empty1 = str_replace(' ','',strval($V));
                        $Empty2 = str_replace(' ','',strval($G[$I-1][$K]));
                        $Empty = (empty($Empty1)) || (empty($Empty2));
                        if (!$Empty && (abs(floatval($V) - floatval($G[$I-1][$K])) > $TestRange[$K]))
                        {
                            $RangeDay = abs(strtotime($G[$I-1]['date']) - strtotime($G[$I]['date']))/86400;
                            if (in_array($RangeDay,[1,2]))
                            {
                                $Error = true;
                            }
                        }
                    }
                }
                if ($K != 'date')
                {
                    $Row[$K] = $V;
                    if ($Error)
                    {
                        $RowError[] = $K;
                        $Errors[] = "$I@$K";
                    }
                }
            }

            if (!empty($RowError))
            {
                $Row['id'] = $G[$I]['id'];
                $Row['Error'] = count($RowError)." @ [ ".join('  -  ',$RowError)." ] ";
            }

            if ($TestError && !empty($RowError))
            {
                $Data[] = $Row;
            }
            elseif (!$TestError)
            {
                $Data[] = $Row;
            }
        }
    }

    return $Data;
}
function EmptyData($Table,$CurrentStation)
{
    $Records = SelectData($Table, $CurrentStation,true);
    $Data = [];
    $_Year_ = ['2024','2025'];
    $_Month_ = ['01','02','03','04','05','06','07','08','09','10','11','12'];
    $_Day_ = ['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];
    $_Time_ = ['00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23'];
    if (GetDateFromTo($From,$To))
    {
        $To = strtotime($To);
        $From = strtotime($From);
        foreach ($Records as $Record)
        {
            foreach ($_Year_ as $SelectYear)
            {
                foreach ($_Month_ as $SelectMonth)
                {
                    $MaxDays = cal_days_in_month(CAL_GREGORIAN, intval($SelectMonth), intval($SelectYear));
                    for ($Day = 0; $Day < $MaxDays; $Day++)
                    {
                        $_Test_ = strtotime("$SelectYear-$SelectMonth-{$_Day_[$Day]}");
                        if ($_Test_ >= $From && $_Test_ <= $To)
                        {
                            if ($Table == 'courier')
                            {
                                foreach ($_Time_ as $SelectTime)
                                {
                                    if ( !$Record['Records'] || !in_array("$SelectYear-$SelectMonth-{$_Day_[$Day]} @ $SelectTime",$Record['Records']))
                                    {
                                        $Data[] = ['Station'=>$Record['Station']['StationName'],'Code'=>$Record['Station']['StationCode'],'Year'=>$SelectYear,'Month'=>$SelectMonth,'Day'=>$_Day_[$Day],'Time'=>$SelectTime];
                                    }
                                }
                            }
                            elseif ($Table == 'daily')
                            {
                                if ( !$Record['Records'] || !in_array("$SelectYear-$SelectMonth-{$_Day_[$Day]}",$Record['Records']))
                                {
                                    $Data[] = ['Station'=>$Record['Station']['StationName'],'Code'=>$Record['Station']['StationCode'],'Year'=>$SelectYear,'Month'=>$SelectMonth,'Day'=>$_Day_[$Day]];
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return $Data;
}

function ExportData($Tables)
{
    if (GetDateFromTo($From,$To))
    {
        $Options  = [];
        $Station = $_SESSION['Station'];

        if (is_array($Station))
        {
            $Stations = $Station;
        }
        else
        {
            $Stations = [$Station];
        }

        if (in_array('courier',$Tables)) {
            $Options["courier"] = "Station IN(".join(',',$Stations).") AND `date` BETWEEN '$From' AND '$To'";
        }

        if (in_array('daily',$Tables)){
            $Options['daily'] = "Station IN(".join(',',$Stations).") AND `date` BETWEEN '$From' AND '$To'";
        }

        try
        {
            BackupDB::Export("From_$From@To_$To@".join('@', $Tables)."@Stations_".count($Stations), $Tables,true,$Options);
            exit();
        }
        catch (Exception $e)
        {
            Error($e->getMessage());
        }
    }
    return null;
}
/* ------------------------------------------------------------------------------------------------------------------ */
if (isset($_REQUEST["Courier"])) { $DataTable = EditData( 'courier',$CurrentStation); $TableName = 'تقرير الرصد الساعي'; }
if (isset($_REQUEST["Daily"])) { $DataTable = EditData('daily',$CurrentStation); $TableName = 'تقرير الرصد اليومي'; }
/* ------------------------------------------------------------------------------------------------------------------ */
if (isset($_REQUEST["ExportCourier"])) { ExportData(['courier']); }
if (isset($_REQUEST["ExportDaily"])) {  ExportData(['daily']);}
if (isset($_REQUEST["ExportCourierAndDaily"])) {  ExportData(['daily','courier']);}
/* ------------------------------------------------------------------------------------------------------------------ */
if (isset($_REQUEST["CourierError"])) { $DataTable = EditData( 'courier',$CurrentStation,true); $TableName = 'أخطاء الرصد الساعي'; }
if (isset($_REQUEST["DailyError"])) { $DataTable = EditData('daily',$CurrentStation,true);  $TableName = 'أخطاء الرصد اليومي'; }
/* ------------------------------------------------------------------------------------------------------------------ */
if (isset($_REQUEST["CourierEmpty"])) { $DataTable = EmptyData('courier',$CurrentStation);  $TableName = 'الرصد الساعي الغير مسجلة'; }
if (isset($_REQUEST["DailyEmpty"])) { $DataTable = EmptyData('daily',$CurrentStation); $TableName = 'الرصد اليومية الغير مسجلة';}
/* ------------------------------------------------------------------------------------------------------------------ */
if (isset($_REQUEST["Mater"])) {
    if(date('d') === '02')
    {
        MySqlX('DELETE FROM `metar` WHERE `Update` LIKE ?',[date('Y-m', strtotime('-1 month'))."%"],'R');
    }

    $DateFromTo = '';

    GetDateFromTo($From,$To);

    if ($_REQUEST["Mater"] === 'ALL')
    {
        $DateFromTo = "WHERE DATE_FORMAT(`Update`, '%Y-%m-%d') BETWEEN '$From' AND '$To'";
        $Database = MySqlX("SELECT `Code` AS `Airport`,`Key` AS `Date`,`Value` AS `Metar` FROM `metar` $DateFromTo ORDER BY `Code`, `Key` ASC",[],11,null);
        $Name = "Airport-Mater-All-".substr($From,0,10).'-'.substr($To,0,10);
    }
    else
    {
        $DateFromTo = "AND DATE_FORMAT(`Update`, '%Y-%m-%d') BETWEEN '$From' AND '$To'";
        $Database = MySqlX("SELECT `Code` AS `Airport`,`Key` AS `Date`,`Value` AS `Metar` FROM `metar` WHERE `Code` = ? $DateFromTo ORDER BY `Code`, `Key` ASC",[$_REQUEST['Mater']],11,null);
        $Name = "Airport-Mater-".$_REQUEST['Mater']."-".substr($From,0,10).'-'.substr($To,0,10);
    }
    SimpleXLSXGenEditCellSaveFile($Database,$Name,['Metar'=>95],null,function ($V,$K){ return SimpleXLSXGenEditCell(str_replace("\n",'',$V)); });
    exit();
}
/* ------------------------------------------------------------------------------------------------------------------ */
require_once "configuration/Header.php";
?>
    <form>
        <?php require_once "Top/".$CurrentFile.".php"; ?>
        <div class="ui container center aligned">
            <div class="ui segment">
                <div class="ui segment">
                    <div><h1>عرض التقارير</h1><br></div>
                    <div>
                        <input class="large ui blue button" name="DailyEmpty" type="submit" value="الرصدات اليومية الغير مسجلة">
                        <input class="large ui red button" name="DailyError" type="submit" value="أخطاء الرصد اليومى">
                        <input class="large ui green button" name="Daily" type="submit" value="تقرير الرصد اليومي">
                        <span> <i class="fas fa-arrows-alt-h"></i> </span>
                        <input class="large ui blue button" name="CourierEmpty" type="submit" value="الرصدات الساعية الغير مسجلة">
                        <input class="large ui red button" name="CourierError" type="submit" value="أخطاء الرصد الساعي">
                        <input class="large ui green button" name="Courier" type="submit" value="تقرير الرصد الساعي">
                    </div>
                </div>
                <div class="ui segment">
                    <div><h1>نسخة الأرسال</h1><br></div>
                    <div>
                        <input class="large ui blue button" name="ExportDaily" type="submit" value="نسخة العرض اليوميى">
                        <input class="large ui secondary button" name="ExportCourierAndDaily" type="submit" value="نسخة العرض الساعى واليومى">
                        <input class="large ui green button" name="ExportCourier" type="submit" value="نسخة العرض الساعى">
                    </div>
                </div>
                <?php if ($TableName){ ?>

                    <div class="ui segment">
                        <div class="Title"> <?=$TableName?> </div>
                        <div class="ui Over">
                            <div id="Data-Table-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                                <div class="ui active inverted dimmer">
                                    <div class="ui text loader">Loading</div>
                                </div>
                                <p></p>
                            </div>
                            <div id="Data-Table" class="Data-Table">
                                <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="ui segment" style="display: none;">
                    <div><h1>Mater Reports</h1><br></div>
                    <div>
                        <input class="large ui blue button" name="Mater" type="submit" value="ORBI">
                        <input class="large ui blue button" name="Mater" type="submit" value="ORNI">
                        <input class="large ui blue button" name="Mater" type="submit" value="ORMM">
                        <input class="large ui blue button" name="Mater" type="submit" value="ORKK">
                        <input class="large ui blue button" name="Mater" type="submit" value="ORER">
                        <input class="large ui blue button" name="Mater" type="submit" value="ORSU">
                        <input class="large ui blue button" name="Mater" type="submit" value="ORBM">
                        <input class="large ui secondary button" name="Mater" type="submit" value="ALL">
                    </div>
                </div>

                <div class="ui segment">
                    <div><h1>تفريغ الجدول</h1><br></div>
                    <div>
                        <input type="hidden" id="btnValue" name="">
                        <?php if ($Type != 'Online'){?>
                            <input class="large ui orange button" name="DeleteDaily" type="submit" value="مسح جدول الرصد اليومي" onclick="Delete(event,'هل تريد تفريغ جدول الرصد اليومي');" >
                            <input class="large ui orange button" name="DeleteCourier" type="submit" value="مسح جدول الرصد الساعي" onclick="Delete(event,'هل تريد تفريغ جدول الرصد الساعي');">
                        <?php } else { ?>
                            <input class="large ui orange button" name="DeleteDaily" type="submit" value="مسح جدول الرصد اليومي" onclick="Delete(event,'هل تريد تفريغ جدول الرصد اليومي');" disabled>
                            <input class="large ui orange button" name="DeleteCourier" type="submit" value="مسح جدول الرصد الساعي" onclick="Delete(event,'هل تريد تفريغ جدول الرصد الساعي');" disabled>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </form>
    <script>
        var $DataTable = <?=json_encode($DataTable)?>;
        var $TableName = '<?=$TableName?>';
    </script>
<?php
if (isset($_REQUEST["DeleteCourier"]) && isset($_SESSION['Station']) && $Type != 'Online')
{
    if (GetDateFromTo($From,$To))
    {
        $Station = $_SESSION['Station'];
        if ($Station === '*')
        {
            MySqlX('DELETE FROM `courier` WHERE `date` BETWEEN ? AND ?', [$From,$To], 'R');
        } else {
            MySqlX('DELETE FROM `courier` WHERE `Station` = ? AND `date` BETWEEN ? AND ?', [$Station,$From,$To], 'R');
        }
        Message($_REQUEST["DeleteCourier"]);
    }
}
/* ------------------------------------------------------------------------------------------------------------------ */
if (isset($_REQUEST["DeleteDaily"]) && isset($_SESSION['Station']) && $Type != 'Online')
{
    if (GetDateFromTo($From,$To))
    {
        $Station = $_SESSION['Station'];
        if ($Station === '*')
        {
            MySqlX('DELETE FROM `daily` WHERE `date` BETWEEN ? AND ?', [$From,$To], 'R');
        }
        else
        {
            MySqlX('DELETE FROM `daily` WHERE `Station` = ? AND `date` BETWEEN ? AND ?', [$Station,$From,$To], 'R');
        }
        Message($_REQUEST["DeleteDaily"]);
    }
}

require_once "configuration/Footer.php";
?>