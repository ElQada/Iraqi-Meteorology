<?php
$Title = "درجات الحرارة اليومية";
$CurrentFile = "show-temperature";
require_once "configuration/Header.php";

$Keys = ["Station","Date","Time","Min","Max","TNTNTN","VV","DD","FF","TTT","TDTDTD","RH"];

$Select = $_SESSION['Station'];

$Stations = [];
$AllStations = [];
$Date = $_SESSION['SelectDate'];
$Time = _VAR_($_REQUEST,'time');
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
    
    foreach ($Stations as $Station)
    {
        $CurrentStation = MySqlX("SELECT * FROM `stations` WHERE `ID` = ?  AND `id` NOT IN (42,43) LIMIT 1",[$Station],0);
        if ($CurrentStation)
        {
            if ($Time != '*')
            {
                $Records = MySqlX("SELECT `time` as 'Time',`VV`,`SN1`,`SN2`,`SN3`,`TDTDTD`,`TNTNTN`,`TTT`,`DD`,`FF`,`RH`,`Max`,`Min` FROM `courier` WHERE `Station` = ? AND `date` = ? AND `time` = ?",[$Station,$Date,$Time],11);
            }
            else
            {
                $Records = MySqlX("SELECT `time` as 'Time',`VV`,`SN1`,`SN2`,`SN3`,`TDTDTD`,`TNTNTN`,`TTT`,`DD`,`FF`,`RH`,`Max`,`Min` FROM `courier` WHERE `Station` = ? AND `date` = ?",[$Station,$Date],11);
            }

            if (!$Records)
            {
                $Records = [];
            }

            $AllStations[] = ['Station'=>$CurrentStation['StationName'],'Code'=>$CurrentStation['StationCode'],'Date'=>$Date,'Records'=>$Records];
        }
    }
    //print_r($AllStations);exit();
}
?>

    <form id="Show-Temperature">
        <?php require_once "Top/".$CurrentFile.".php"; ?>
        <div class="ui container center aligned">
            <div class="ui segment">
                <input type="submit" name="View" value="  عــــــــــرض الـتـــقــريـــــر " class="ui green button large">
                <div class="ui segment">
                    <div class="Title"> درجات الحرارة اليومية </div>
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
            </div>
        </div>
    </form>
    <script>
        var $AllStations = <?=json_encode($AllStations)?>;
    </script>
<?php require_once "configuration/Footer.php"; ?>