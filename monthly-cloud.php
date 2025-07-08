<?php
$Title = "المعدلات اليومية والشهرية للغيوم";
$CurrentFile = "monthly-cloud";
require_once "configuration/Header.php";

$Keys = ['Station','Code','Year','Month','Day', 'Count', 'Cloud Classification'];
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
        $CurrentStation = MySqlX("SELECT * FROM `stations` WHERE `ID` = ?  AND `id` NOT IN (42,43) LIMIT 1",[$Station],0);
        if ($CurrentStation)
        {
            foreach ($SetMonth as $Month)
            {
                $Range = $SetYear."-".$Month;
                $Execute = [$Station,$Range.'-%'];
                $From = "$SetYear-$Month-01";
                $To = "$SetYear-$Month-".$_Day_[cal_days_in_month(CAL_GREGORIAN,intval($Month),intval($SetYear))-1];
                $Days = (intval((strtotime($To) - strtotime($From)) / (60 * 60 * 24)) + 1);
                $Records = MySqlX("SELECT `N`, `date`,`time` FROM `courier` WHERE `Station` = ? AND `date` LIKE ? ORDER BY `date`,`N`;",$Execute,11);

                if (!$Records)
                {
                    $Records = [];
                }

                $AllStations[] = ['Station'=>$CurrentStation['StationName'],'Code'=>$CurrentStation['StationCode'],'Year'=>$SetYear,'Month'=>$Month,'Day'=>$Days,'Count'=>0,'Cloud Classification'=>'','Records'=>[],'Parts'=>[],'ByTime'=>$Records];
            }
        }
    }
}
?>

<form id="monthly-cloud">
    <?php require_once "Top/".$CurrentFile.".php"; ?>
    <div class="ui container center aligned">
        <div class="ui segment">
            <input type="submit" name="View" value="  عــــــــــرض الـتـــقــريـــــر " class="ui green button large">
            <div class="ui segment">
                <div class="Title"> المعدلات    كل 3 ساعات  للغيوم </div>
                <div class="ui Over">
                    <div id="Hour-Cloud-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                        <div class="ui active inverted dimmer">
                            <div class="ui text loader">Loading</div>
                        </div>
                        <p></p>
                    </div>
                    <div id="Hour-Cloud" class="Data-Table">
                        <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                    </div>
                </div>
            </div>
            <div class="ui segment">
                <div class="Title"> المعدلات اليومية للغيوم </div>
                <div class="ui Over">
                    <div id="Day-Cloud-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                        <div class="ui active inverted dimmer">
                            <div class="ui text loader">Loading</div>
                        </div>
                        <p></p>
                    </div>
                    <div id="Day-Cloud" class="Data-Table">
                        <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                    </div>
                </div>
            </div>
            <div class="ui segment">
                <div class="Title"> المعدلات الشهرية للغيوم </div>
                <div class="ui Over">
                    <div id="Monthly-Cloud-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                        <div class="ui active inverted dimmer">
                            <div class="ui text loader">Loading</div>
                        </div>
                        <p></p>
                    </div>
                    <div id="Monthly-Cloud" class="Data-Table">
                        <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                    </div>
                </div>
            </div>
            <div class="ui segment">
                <div class="Title"> تكرارات المعدلات الشهرية للغيوم </div>
                <div class="ui Over">
                    <div id="CountMonthly-Cloud-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                        <div class="ui active inverted dimmer">
                            <div class="ui text loader">Loading</div>
                        </div>
                        <p></p>
                    </div>
                    <div id="CountMonthly-Cloud" class="Data-Table">
                        <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>
<script>
    var $AllData = <?=json_encode($AllStations)?>;
</script>
<?php require_once "configuration/Footer.php"; ?>