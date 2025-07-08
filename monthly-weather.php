<?php
$Title = "تكرارات الظواهر الجوية";
$CurrentFile = "monthly-weather";
require_once "configuration/Header.php";
function SelectWeather($Key, $Execute = [], $Filed = false)
{
    if ($Filed === 'DD')
    {
        // $DD = MySqlX("SELECT `DD`,COUNT(`DD`) as `Counter` FROM `daily` WHERE `Station` = ? AND `date` LIKE ? GROUP BY `DD`",$Execute,11);

        $DD = MySqlX("SELECT `DD`,COUNT(`DD`) as `Counter` FROM `courier` WHERE `Station` = ? AND `date` LIKE ? GROUP BY `DD`",$Execute,11);
        $_Day_ = ['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];
        $SelectRange = str_replace('-%', '', $Execute[1] );
        $From = "$SelectRange-01";
        $To = "$SelectRange-".$_Day_[cal_days_in_month(CAL_GREGORIAN,intval(explode('-',$SelectRange)[1]),intval(explode('-',$SelectRange)[0]))-1];
        $Days = (intval((strtotime($To) - strtotime($From)) / (60 * 60 * 24)) + 1);

        if (!is_array($DD))
        {
            $DD = [];
        }

        $Set = ['From' => _REQUEST_('SetYear','2024')."-"._REQUEST_('SetMonthFrom','01')."-01",'To' => _REQUEST_('SetYear','2025')."-"._REQUEST_('SetMonthTo','12')."-01","Total"=>0,'Northern'=>0,'Northeast'=>0,'East'=>0,'Southeast'=>0,'Southern'=>0,'Southwest'=>0,'Western'=>0,'Northwest'=>0,'Sleep'=>0,'Days'=>($Days*24)];

        foreach ($DD as $V)
        {
            $V['DD'] = intval($V['DD']);

            if (!$V['DD'])
            {
                $Set['Sleep'] += $V['Counter'];
            }
            elseif (($V['DD']>330 && $V['DD']<=360) || ($V['DD']>=10 && $V['DD']<=20))
            {
                $Set['Northern'] += $V['Counter'];
            }
            elseif ($V['DD']>20 && $V['DD']<=60)
            {
                $Set['Northeast'] += $V['Counter'];
            }
            elseif ($V['DD']>60 && $V['DD']<=110)
            {
                $Set['East'] += $V['Counter'];
            }
            elseif ($V['DD']>110 && $V['DD']<=150)
            {
                $Set['Southeast'] += $V['Counter'];
            }
            elseif ($V['DD']>150 && $V['DD']<=200)
            {
                $Set['Southern'] += $V['Counter'];
            }
            elseif ($V['DD']>200 && $V['DD']<=240)
            {
                $Set['Southwest'] += $V['Counter'];
            }
            elseif ($V['DD']>240 && $V['DD']<=290)
            {
                $Set['Western'] += $V['Counter'];
            }
            elseif ($V['DD']>290 && $V['DD']<=330)
            {
                $Set['Northwest'] += $V['Counter'];
            }
            $Set['Total'] += $V['Counter'];
        }

        $Total = $Set['Total']/100;
        if ($Total)
        {
            foreach (['Northern','Northeast','East','Southeast','Southern','Southwest','Western','Northwest','Sleep'] as $K)
            {
                //$Value = $Set[$K];
                $Set[$K] .= "<br> [".ceil($Set[$K]/$Total)."%] ";
            }
        }
        $Return = [$Set];
    }
    elseif ($Filed === 'CannabisTemperature')
    {
        $CannabisTemperature = MySqlX("SELECT `CannabisTemperature`,COUNT(`CannabisTemperature`) as `Counter` FROM `daily` WHERE `Station` = ? AND `date` LIKE ? GROUP BY `CannabisTemperature`",$Execute,11);
        if (!is_array($CannabisTemperature))
        {
            $CannabisTemperature = [];
        }
        $Set = ['CannabisTemperature'=>'','Counter'=>0];
        foreach ($CannabisTemperature as $V)
        {
            if (floatval($V['CannabisTemperature'])<=-0.9)
            {
                $Set['CannabisTemperature'] .= " [ ".$V['CannabisTemperature']." ] ";
                $Set['Counter'] += intval($V['Counter']);
            }
        }

        if ($Set['Counter'])
        {
            $Return = [$Set];
        }
        else
        {
            $Return = [];
        }
    }
    elseif ($Filed === 'WW')
    {
        $WW = MySqlX("SELECT `WW`,COUNT(`WW`) AS `Count`,`date` AS `Date` FROM `courier` WHERE `WW` != '' AND `Station` = ? AND `date` LIKE ? GROUP BY `WW`,`date` ORDER BY `date`",$Execute,11);
        if (!is_array($WW))
        {
            $WW = [];
        }
        $Return = $WW;
    }
    elseif ($Filed === 'W1W2')
    {
        $W1W2 = MySqlX("SELECT `W1W2`,COUNT(`W1W2`) AS `Count`,`date` AS `Date` FROM `courier` WHERE `W1W2` != '' AND `Station` = ? AND `date` LIKE ? GROUP BY `W1W2`,`date` ORDER BY `date`",$Execute,11);
        if (!is_array($W1W2))
        {
            $W1W2 = [];
        }
        $Return = $W1W2;
    }
    elseif ($Filed === 'min')
    {
        $Min = MySqlX("SELECT `min` FROM `courier` WHERE `min` != '' AND `time` = '03' AND `Station` = ? AND `date` LIKE ?",$Execute,7);
        if (!is_array($Min))
        {
            $Min = [0];
        }
        $Return = $Min;
    }
    elseif ($Filed === 'max')
    {
        $Max = MySqlX("SELECT `max` FROM `courier` WHERE `max` != '' AND `time` = '15' AND `Station` = ? AND `date` LIKE ?",$Execute,7);
        if (!is_array($Max))
        {
            $Max = [0];
        }
        $Return = $Max;
    }
    elseif (in_array($Filed,['min_day','max_day','ff'],true))
    {

        $Return = MySqlX("SELECT `$Filed` FROM `daily` WHERE `$Filed` != '' AND `Station` = ? AND `date` LIKE ? GROUP BY `$Filed`",$Execute,7);
        if (!is_array($Return))
        {
            $Return = [0];
        }
    }
    elseif($Key==='SN1TTT')
    {
        $Return = MySqlX("SELECT CONCAT(`SN1`,`TTT`) as `SN1TTT` FROM `courier` WHERE `TTT` != '' AND `Station` = ? AND `date` LIKE ? GROUP BY `SN1TTT`",$Execute,7);
        if (!is_array($Return))
        {
            $Return = [0];
        }
    }
    elseif($Key==='CannabisTemperature')
    {
        $Return = MySqlX("SELECT `CannabisTemperature` FROM `daily` WHERE `CannabisTemperature` != '' AND `Station` = ? AND `date` LIKE ?",$Execute,7);
        if (!is_array($Return))
        {
            $Return = [0];
        }
    }
    else
    {
        $Return = MySqlX("SELECT `$Key` FROM `courier` WHERE `$Key` != '' AND `Station` = ? AND `date` LIKE ? GROUP BY `$Key`",$Execute,7);
        if (!is_array($Return))
        {
            $Return = [0];
        }
    }
    return $Return;
}

$Select = $_SESSION['Station'];
$Stations = [];
$AllStations = [];
$PlusData = [];

if (isset($_REQUEST['Station']))
{
    if ($Select !== '*')
    {
        $Stations = [$Select];
    }
    else
    {
        // $Stations = MySqlX("SELECT `ID` FROM `stations` WHERE `id` NOT IN (42,43) ORDER BY `StationCode`",[],7);
    }

    $SetYear  = _REQUEST_('SetYear','2024');
    $SetMonthFrom = _REQUEST_('SetMonthFrom','01');
    $SetMonthTo   = _REQUEST_('SetMonthTo','12');
    if (intval($SetMonthFrom) > intval($SetMonthTo))
    {
        $Swap = $SetMonthFrom;
        $SetMonthFrom = $SetMonthTo;
        $SetMonthTo = $Swap;
    }

    $SetMonth = ['01','02','03','04','05','06','07','08','09','10','11','12'];
    $SetMonth = array_reverse(array_splice($SetMonth,array_search($SetMonthFrom,$SetMonth)));
    $SetMonth = array_reverse(array_splice($SetMonth,array_search($SetMonthTo,$SetMonth)));

    $PlusData =
        [
            'Year' => $SetYear,
            'From' => $SetMonthFrom,
            'To'   => $SetMonthTo,
        ];
    foreach ($Stations as $Station)
    {
        $AllStations[$Station]  = MySqlX("SELECT * FROM `stations` WHERE `ID` = ? AND `id` NOT IN (42,43) LIMIT 1",[$Station],0);
        $AllStations[$Station]['Range'] = [];

        foreach ($SetMonth as $Month)
        {
            $Range = $SetYear."-".$Month;
            $Execute = [$Station,$Range.'-%'];
            $AllStations[$Station]['Range'][$Range] = [];
            /* ---------------------------------------------------------------------------------------------------------- */
            $TTT = SelectWeather('SN1TTT',$Execute);
            $Min_TTT = min($TTT);
            $SN1Min = '+';
            $Max_TTT = max($TTT);
            $SN1Max = '+';

            if ($Min_TTT<0)
            {
                $SN1Min = '-';
            }

            if ($Max_TTT<0)
            {
                $SN1Max = '-';
            }

            $AllStations[$Station]['Range'][$Range]['Min-TTT'] = $Min_TTT. ' C';
            $AllStations[$Station]['Range'][$Range]['Min-TTT-Date-Time'] = MySqlX("SELECT `date`,`time` FROM `courier` WHERE `TTT` = ? AND `Station` = ? AND `date` LIKE ? AND `SN1` = ?",[str_replace('+','',str_replace('-','',$Min_TTT)),$Station,$Range.'-%',$SN1Min],11);
            $AllStations[$Station]['Range'][$Range]['Max-TTT'] = $Max_TTT. ' C';
            $AllStations[$Station]['Range'][$Range]['Max-TTT-Date-Time'] = MySqlX("SELECT `date`,`time` FROM `courier` WHERE `TTT` = ? AND `Station` = ? AND `date` LIKE ? AND `SN1` = ?",[str_replace('+','',str_replace('-','',$Max_TTT)),$Station,$Range.'-%',$SN1Max],11);
            /* ---------------------------------------------------------------------------------------------------------- */
            $Min_Day = min(SelectWeather('min_day',$Execute,'min_day'));
            $Max_Day = max(SelectWeather('max_day',$Execute,'max_day'));
            $AllStations[$Station]['Range'][$Range]['Min-Day'] = $Min_Day . ' C';
            $AllStations[$Station]['Range'][$Range]['Min-Day-Date'] = MySqlX("SELECT `date` FROM `daily` WHERE `min_day` = ? AND `Station` = ? AND `date` LIKE ?",[$Min_Day,$Station,$Range.'-%'],7);
            $AllStations[$Station]['Range'][$Range]['Max-Day'] = $Max_Day. ' C';
            $AllStations[$Station]['Range'][$Range]['Max-Day-Date'] = MySqlX("SELECT `date` FROM `daily` WHERE `max_day` = ? AND `Station` = ? AND `date` LIKE ?",[$Max_Day,$Station,$Range.'-%'],7);
            /* ---------------------------------------------------------------------------------------------------------- */
            $CannabisTemperature = SelectWeather('CannabisTemperature',$Execute);
            $CannabisTemperature_Min = min($CannabisTemperature);
            $CannabisTemperature_Max = max($CannabisTemperature);
            $AllStations[$Station]['Range'][$Range]['CannabisTemperature-Min'] = $CannabisTemperature_Min . ' C';
            $AllStations[$Station]['Range'][$Range]['CannabisTemperature-Min-Date'] = MySqlX("SELECT `date` FROM `daily` WHERE `CannabisTemperature` = ? AND `Station` = ? AND `date` LIKE ?",[$CannabisTemperature_Min,$Station,$Range.'-%'],7);
            $AllStations[$Station]['Range'][$Range]['CannabisTemperature-Max'] = $CannabisTemperature_Max. ' C';
            $AllStations[$Station]['Range'][$Range]['CannabisTemperature-Max-Date'] = MySqlX("SELECT `date` FROM `daily` WHERE `CannabisTemperature` = ? AND `Station` = ? AND `date` LIKE ?",[$CannabisTemperature_Max,$Station,$Range.'-%'],7);
            /* ---------------------------------------------------------------------------------------------------------- */
            $Min_Hour = min(SelectWeather('min',$Execute,'min'));
            $Max_Hour = max(SelectWeather('max',$Execute,'max'));
            $AllStations[$Station]['Range'][$Range]['Min-Hour'] = $Min_Hour . ' C';
            $AllStations[$Station]['Range'][$Range]['Min-Hour-Date'] = MySqlX("SELECT `date` FROM `courier` WHERE `min` = ? AND `Station` = ? AND `date` LIKE ?",[$Min_Hour,$Station,$Range.'-%'],7);
            $AllStations[$Station]['Range'][$Range]['Max-Hour'] = $Max_Hour. ' C';
            $AllStations[$Station]['Range'][$Range]['Max-Hour-Date'] = MySqlX("SELECT `date` FROM `courier` WHERE `max` = ? AND `Station` = ? AND `date` LIKE ?",[$Max_Hour,$Station,$Range.'-%'],7);
            /* ---------------------------------------------------------------------------------------------------------- */
            $Hour_FF = SelectWeather('FF',$Execute,'FF');
            $Min_Hour_FF = min($Hour_FF);
            $Max_Hour_FF = max($Hour_FF);
            $AllStations[$Station]['Range'][$Range]['Min-Hour-FF'] = $Min_Hour_FF. ' M / Sec';
            $AllStations[$Station]['Range'][$Range]['Min-Hour-FF-Date-Time'] = MySqlX("SELECT `date`,`time` FROM `courier` WHERE `FF` = ? AND `Station` = ? AND `date` LIKE ?",[$Min_Hour_FF,$Station,$Range.'-%'],11);
            $AllStations[$Station]['Range'][$Range]['Max-Hour-FF'] = $Max_Hour_FF. ' M / Sec';
            $AllStations[$Station]['Range'][$Range]['Max-Hour-FF-Date-Time'] = MySqlX("SELECT `date`,`time` FROM `courier` WHERE `FF` = ? AND `Station` = ? AND `date` LIKE ?",[$Max_Hour_FF,$Station,$Range.'-%'],11);
            /* ---------------------------------------------------------------------------------------------------------- */
            $FF = SelectWeather('ff',$Execute,'ff');
            $Min_FF = min($FF);
            $Max_FF = max($FF);
            $AllStations[$Station]['Range'][$Range]['Min-FF'] = $Min_FF. ' M / Sec';
            $AllStations[$Station]['Range'][$Range]['Min-FF-Date'] = MySqlX("SELECT `date` FROM `daily` WHERE `ff` = ? AND `Station` = ? AND `date` LIKE ?",[$Min_FF,$Station,$Range.'-%'],7);
            $AllStations[$Station]['Range'][$Range]['Max-FF'] = $Max_FF. ' M / Sec';
            $AllStations[$Station]['Range'][$Range]['Max-FF-Date'] = MySqlX("SELECT `date` FROM `daily` WHERE `ff` = ? AND `Station` = ? AND `date` LIKE ?",[$Max_FF,$Station,$Range.'-%'],7);
            /* ---------------------------------------------------------------------------------------------------------- */
            $RH  = SelectWeather('RH',$Execute);
            $Min_RH = min($RH);
            $Max_RH = max($RH);
            $AllStations[$Station]['Range'][$Range]['Min-RH'] = $Min_RH. ' %';
            $AllStations[$Station]['Range'][$Range]['Min-RH-Date-Time'] = MySqlX("SELECT `date`,`time` FROM `courier` WHERE `RH` = ? AND `Station` = ? AND `date` LIKE ?",[$Min_RH,$Station,$Range.'-%'],11);
            $AllStations[$Station]['Range'][$Range]['Max-RH'] = $Max_RH. ' %';
            $AllStations[$Station]['Range'][$Range]['Max-RH-Date-Time'] = MySqlX("SELECT `date`,`time` FROM `courier` WHERE `RH` = ? AND `Station` = ? AND `date` LIKE ?",[$Max_RH,$Station,$Range.'-%'],11);
            /* ---------------------------------------------------------------------------------------------------------- */
            $AllStations[$Station]['Range'][$Range]['DD'] = SelectWeather('DD',$Execute,'DD');
            $AllStations[$Station]['Range'][$Range]['WW'] = SelectWeather('WW',$Execute,'WW');
            $AllStations[$Station]['Range'][$Range]['W1W2'] = SelectWeather('W1W2',$Execute,'W1W2');
            $AllStations[$Station]['Range'][$Range]['CannabisTemperature'] = SelectWeather('CannabisTemperature',$Execute,'CannabisTemperature');
        }
    }
}
?>

<form id="monthly-weather">
    <?php require_once "Top/".$CurrentFile.".php"; ?>
    <div class="ui container center aligned">
        <div class="ui segment">
            <input type="submit" name="View" value="  عــــــــــرض الـتـــقــريـــــر " class="ui green button large">
        </div>
    </div>
    <hr>
    <div class="ui container center aligned" style="width: 100%;">
        <div class="ui segment">
            <div class="Title">قيمة التكرارات اليومية لاتجاه الرياح بالرصد الساعى</div>
            <div class="ui Over">
                <div id="Key-DD-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                    <div class="ui active inverted dimmer">
                        <div class="ui text loader">Loading</div>
                    </div>
                    <p></p>
                </div>
                <div id="Key-DD" class="Data-Table">
                    <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="ui segment">
            <div class="Title"> قيمة التكرارات اليومية للجو الحاضر بالرصد الساعى </div>
            <div class="ui Over">
                <div id="Day-WW-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                    <div class="ui active inverted dimmer">
                        <div class="ui text loader">Loading</div>
                    </div>
                    <p></p>
                </div>
                <div id="Day-WW" class="Data-Table">
                    <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="ui segment">
            <div class="Title">قيمة التكرارات الشهرية للجو الحاضر بالرصد الساعى </div>
            <div class="ui Over">
                <div id="Month-WW-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                    <div class="ui active inverted dimmer">
                        <div class="ui text loader">Loading</div>
                    </div>
                    <p></p>
                </div>
                <div id="Month-WW" class="Data-Table">
                    <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="ui segment">
            <div class="Title"> قيمة التكرارات اليومية للجو الماضى بالرصد الساعى </div>
            <div class="ui Over">
                <div id="Day-W1W2-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                    <div class="ui active inverted dimmer">
                        <div class="ui text loader">Loading</div>
                    </div>
                    <p></p>
                </div>
                <div id="Day-W1W2" class="Data-Table">
                    <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="ui segment">
            <div class="Title">قيمة التكرارات الشهرية للجو الماضى بالرصد الساعى </div>
            <div class="ui Over">
                <div id="Month-W1W2-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                    <div class="ui active inverted dimmer">
                        <div class="ui text loader">Loading</div>
                    </div>
                    <p></p>
                </div>
                <div id="Month-W1W2" class="Data-Table">
                    <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="ui segment">
            <div class="Title"> قيم العناصر الطقسية </div>
            <div class="ui Over">
                <div id="Key-Value-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                    <div class="ui active inverted dimmer">
                        <div class="ui text loader">Loading</div>
                    </div>
                    <p></p>
                </div>
                <div id="Key-Value" class="Data-Table">
                    <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="ui segment">
            <div class="Title"> قيمة التكرارات لدرجة حرارة الحشيش </div>
            <div class="ui Over">
                <div id="Key-CannabisTemperature-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                    <div class="ui active inverted dimmer">
                        <div class="ui text loader">Loading</div>
                    </div>
                    <p></p>
                </div>
                <div id="Key-CannabisTemperature" class="Data-Table">
                    <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                </div>
            </div>
        </div>
    </div>
</form>

    <script>
        var $AllStations = <?=json_encode($AllStations)?>;
        var $PlusData = <?=json_encode($PlusData)?>;
    </script>

<?php require_once "configuration/Footer.php"; ?>