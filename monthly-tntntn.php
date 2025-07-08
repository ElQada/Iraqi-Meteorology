<?php
$Title = "موجات البرد وموجات الحر";
$CurrentFile = "monthly-tntntn";
require_once "configuration/Header.php";

$Keys = ['Station','Code','Year','Month','Day', 'TNTNTN','Mean','Disunite'];
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
                if (in_array($Month,["01","02","12","06","07","08"]))
                {
                    $Range = $SetYear."-".$Month;
                    $From = "$SetYear-$Month-01";
                    $To = "$SetYear-$Month-".$_Day_[cal_days_in_month(CAL_GREGORIAN,intval($Month),intval($SetYear))-1];
                    $Time = "";
                    if (in_array($Month,["01","02","12"]))
                    {
                        $Time = "06";
                    }
                    else
                    {
                        $Time = "18";
                    }

                    $Execute = [$Time,$Station,$Range.'-%'];
                    $Records = MySqlX("SELECT `TNTNTN`,`date`,`SN3` FROM `courier` WHERE `time` = ? AND `Station` = ? AND `date` LIKE ?",$Execute,11);
                    if (!$Records)
                    {
                        $Records = [];
                    }

                    $AllStations[] = ['Station'=>$CurrentStation['StationName'],'Code'=>$CurrentStation['StationCode'],'Year'=>$SetYear,'Month'=>$Month,'Day'=>count($Records),'Count'=>0,'Cloud Classification'=>'','Records'=>$Records];
                }
            }
        }
    }
}
?>

<form id="monthly-tntntn">
    <?php require_once "Top/".$CurrentFile.".php"; ?>
    <div class="ui container center aligned">
        <div class="ui segment">
            <input type="submit" name="View" value="  عــــــــــرض الـتـــقــريـــــر " class="ui green button large">
            <div class="ui segment">
                <div class="Title"> مــوجــات الـبــرودة </div>
                <div class="ui Over">
                    <div id="Month-SetCold-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                        <div class="ui active inverted dimmer">
                            <div class="ui text loader">Loading</div>
                        </div>
                        <p></p>
                    </div>
                    <div id="Month-SetCold" class="Data-Table">
                        <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                    </div>
                </div>
            </div>
            <div class="ui segment">
                <div class="Title"> مــوجــات الـــحــرارة </div>
                <div class="ui Over">
                    <div id="Month-SetHeat-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                        <div class="ui active inverted dimmer">
                            <div class="ui text loader">Loading</div>
                        </div>
                        <p></p>
                    </div>
                    <div id="Month-SetHeat" class="Data-Table">
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