<?php
$Title = "المعدلات الشهرية للرصد اليومى";
$CurrentFile = "month-daily";
require_once "configuration/Header.php";
$Keys  = ['Station','Range','Count','ResultWind50','ResultWind200','ResultRain','ResultEvapration','CannabisTemperature','SunShine','ff','dd','min_day','max_day','Main+5CM','MainSUR','Main-5CM','Main-10CM','Main-20CM','Main-50CM','Main-100CM'];

$_Day_ = ['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];

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
        $Stations = MySqlX("SELECT `ID` FROM `stations` WHERE `id` NOT IN (42,43) ORDER BY `StationCode`",[],7);
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
        $CurrentStation = MySqlX("SELECT * FROM `stations` WHERE `ID` = ? AND `id` NOT IN (42,43) LIMIT 1",[$Station],0);
        if ($CurrentStation)
        {
            foreach ($SetMonth as $Month)
            {
                $Range = $SetYear."-".$Month;
                $Execute = [$Station,$Range.'-%'];
                $From = "$SetYear-$Month-01";
                $To = "$SetYear-$Month-".$_Day_[cal_days_in_month(CAL_GREGORIAN,intval($Month),intval($SetYear))-1];
                $Days = (intval((strtotime($To) - strtotime($From)) / (60 * 60 * 24)) + 1);
                $Records = MySqlX("SELECT * FROM `daily` WHERE `Station` = ? AND `date` LIKE ?",$Execute,11);

                if (!$Records)
                {
                    $Records = [];
                }

                $Data = ['Station'=>$CurrentStation['StationName'],'Range'=>$Range,'Count'=>count($Records),'Days'=>$Days];

                foreach (['ResultWind50','ResultWind200','ResultRain','ResultEvapration','CannabisTemperature','SunShine','ff','dd','min_day','max_day'] as $K)
                { $Data[$K] = 0; }
                foreach (['Main+5CM'=>'_5cm','MainSUR'=>'Sur','Main-5CM'=>'5cm','Main-10CM'=>'10cm','Main-20CM'=>'20cm','Main-50CM'=>'50cm','Main-100CM'=>'100cm'] as $K1 => $V1)
                { $Data[$K1] = 0; }

                foreach ($Records as $Key => $Record)
                {
                    foreach (['ResultWind50','ResultWind200','ResultRain','ResultEvapration','CannabisTemperature','SunShine','ff','dd','min_day','max_day'] as $K) {
                        $Data[$K] += floatval($Record[$K]);
                    }

                    foreach (['Main+5CM'=>'_5cm','MainSUR'=>'Sur','Main-5CM'=>'5cm','Main-10CM'=>'10cm','Main-20CM'=>'20cm','Main-50CM'=>'50cm','Main-100CM'=>'100cm'] as $K1 => $V1)
                    {
                        $Plus = 0;
                        foreach (['00','06','12','18'] as $K2)
                        {
                            $Plus += floatval($Record[$V1.$K2]);
                        }
                        $Data[$K1] += floatval($Plus/4);
                    }
                }

                foreach (['ResultWind50','ResultWind200','ResultRain','ResultEvapration','CannabisTemperature','SunShine','ff','dd','min_day','max_day','Main+5CM','MainSUR','Main-5CM','Main-10CM','Main-20CM','Main-50CM','Main-100CM'] as $K1) {
                    $Data[$K1] = number_format((floatval($Data[$K1])/$Days), 2, '.', '');
                }

                foreach ($Data as $K1 => $V1)
                {
                    if (!$V1 || $V1 === '0.00')
                    {
                        $Data[$K1] = ' ';
                    }
                }

                if (!$Data['Count'])
                {
                    $Data['Count'] = 0;
                }
                $AllStations[] = $Data;
            }
        }
    }
}
?>

    <form id="month-daily">
        <?php require_once "Top/".$CurrentFile.".php"; ?>
        <div class="ui container center aligned">
            <div class="ui segment">
                <input type="submit" name="View" value="  عــــــــــرض الـتـــقــريـــــر " class="ui green button large">
                <div class="ui segment">
                    <div class="Title"> المعدلات الشهرية للرصد اليومي </div>
                    <div class="ui Over">
                        <div id="Month-Daily-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                            <div class="ui active inverted dimmer">
                                <div class="ui text loader">Loading</div>
                            </div>
                            <p></p>
                        </div>
                        <div id="Month-Daily" class="Data-Table">
                            <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        var $AllStations = <?=json_encode($AllStations)?>;
    </script>
<?php require_once "configuration/Footer.php"; ?>