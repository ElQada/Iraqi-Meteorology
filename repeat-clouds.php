<?php
$Title = "تكرارات أرتفاع الغيوم";
$CurrentFile = "repeat-clouds";
require_once "configuration/Header.php";

$Keys = ['Station','Range','Count','H', 'N', 'DD', 'FF', 'TTT', 'TDTDTD', 'P0P0P0P0', 'PPPP', 'A', 'PPP', 'WB', 'RH', 'VP'];
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
        foreach ($SetMonth as $Month)
        {
            $Range = $SetYear."-".$Month;
            $Execute = [$Station,$Range.'-%'];
            $From = "$SetYear-$Month-01";
            $To = "$SetYear-$Month-".$_Day_[cal_days_in_month(CAL_GREGORIAN,intval($Month),intval($SetYear))-1];
            $Records = MySqlX("SELECT `date`,`time`,`NH`,`CL`,`CM`,`CH` FROM `courier` WHERE `Station` = ? AND `date` LIKE ?",$Execute,11);

            if (!$Records)
            {
                $Records = [];
            }

            $Data = ['Station'=>$Station,'Range'=>$Range,'Count'=>count($Records),'Records'=>$Records];

            $AllStations[] = $Data;
        }
    }
}
?>

<form id="repeat-clouds">
    <?php require_once "Top/".$CurrentFile.".php"; ?>
    <div class="ui container center aligned">
        <div class="ui segment">
            <input type="submit" name="View" value="  عــــــــــرض الـتـــقــريـــــر " class="ui green button large">
            <div class="ui segment">
                <div class="Title"> تكرارات أرتفاع الغيوم [ اليومي ]  ( NH )   </div>
                <div class="ui Over">
                    <div id="Repeat-Clouds-ByDay-NH-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                        <div class="ui active inverted dimmer">
                            <div class="ui text loader">Loading</div>
                        </div>
                        <p></p>
                    </div>
                    <div id="Repeat-Clouds-ByDay-NH" class="Data-Table">
                        <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                    </div>
                </div>
            </div>
            <div class="ui segment">
                <div class="Title"> تكرارات أرتفاع الغيوم [ الشهرية ]  ( NH )   </div>
                <div class="ui Over">
                    <div id="Repeat-Clouds-ByMonth-NH-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                        <div class="ui active inverted dimmer">
                            <div class="ui text loader">Loading</div>
                        </div>
                        <p></p>
                    </div>
                    <div id="Repeat-Clouds-ByMonth-NH" class="Data-Table">
                        <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                    </div>
                </div>
            </div>

            <div class="ui segment">
                <div class="Title"> تكرارات أرتفاع الغيوم [ اليومي ]  ( CL )   </div>
                <div class="ui Over">
                    <div id="Repeat-Clouds-ByDay-CL-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                        <div class="ui active inverted dimmer">
                            <div class="ui text loader">Loading</div>
                        </div>
                        <p></p>
                    </div>
                    <div id="Repeat-Clouds-ByDay-CL" class="Data-Table">
                        <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                    </div>
                </div>
            </div>
            <div class="ui segment">
                <div class="Title"> تكرارات أرتفاع الغيوم [ الشهرية ]  ( CL )   </div>
                <div class="ui Over">
                    <div id="Repeat-Clouds-ByMonth-CL-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                        <div class="ui active inverted dimmer">
                            <div class="ui text loader">Loading</div>
                        </div>
                        <p></p>
                    </div>
                    <div id="Repeat-Clouds-ByMonth-CL" class="Data-Table">
                        <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                    </div>
                </div>
            </div>

            <div class="ui segment">
                <div class="Title"> تكرارات أرتفاع الغيوم [ اليومي ]  ( CM )   </div>
                <div class="ui Over">
                    <div id="Repeat-Clouds-ByDay-CM-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                        <div class="ui active inverted dimmer">
                            <div class="ui text loader">Loading</div>
                        </div>
                        <p></p>
                    </div>
                    <div id="Repeat-Clouds-ByDay-CM" class="Data-Table">
                        <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                    </div>
                </div>
            </div>
            <div class="ui segment">
                <div class="Title"> تكرارات أرتفاع الغيوم [ الشهرية ]  ( CM )   </div>
                <div class="ui Over">
                    <div id="Repeat-Clouds-ByMonth-CM-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                        <div class="ui active inverted dimmer">
                            <div class="ui text loader">Loading</div>
                        </div>
                        <p></p>
                    </div>
                    <div id="Repeat-Clouds-ByMonth-CM" class="Data-Table">
                        <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                    </div>
                </div>
            </div>

            <div class="ui segment">
                <div class="Title"> تكرارات أرتفاع الغيوم [ اليومي ]  ( CH )   </div>
                <div class="ui Over">
                    <div id="Repeat-Clouds-ByDay-CH-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                        <div class="ui active inverted dimmer">
                            <div class="ui text loader">Loading</div>
                        </div>
                        <p></p>
                    </div>
                    <div id="Repeat-Clouds-ByDay-CH" class="Data-Table">
                        <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                    </div>
                </div>
            </div>
            <div class="ui segment">
                <div class="Title"> تكرارات أرتفاع الغيوم [ الشهرية ]  ( CH )   </div>
                <div class="ui Over">
                    <div id="Repeat-Clouds-ByMonth-CH-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                        <div class="ui active inverted dimmer">
                            <div class="ui text loader">Loading</div>
                        </div>
                        <p></p>
                    </div>
                    <div id="Repeat-Clouds-ByMonth-CH" class="Data-Table">
                        <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    var $AllStations = <?=json_encode($AllStations)?>;
    var $Stations = <?=json_encode(MySqlX('SELECT * FROM `stations` WHERE `id` NOT IN (42,43)',[],11))?>;
</script>
<?php require_once "configuration/Footer.php"; ?>


