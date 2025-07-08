<?php
$Title = "مـطـارات الـعــراق";
$CurrentFile = "show-awos";
require_once "configuration/Header.php";
// $Station = MySqlX("SELECT * FROM `stations` ORDER BY `name` ASC");
require_once "Request/show-awos.php";
$ChartStation =
    [
        [1,"BAGHDAD",650,"ORBI"],
        [31,"NAJAF",670,"ORNI"],
        [29,"BASRA",690,"ORMM"],
        [6,"KIRKUK",624,"ORKK"],
        [42,"ERBEEL",616,"ORER"],
        [43,"SULAIMANIYA",623,"ORSU"],
        [21,"MOSUL",608,"ORBM"],
        // [4,"NASIRIYAH",676,"ORNA"],
    ];
foreach ($ChartStation as &$Station)
{
    $Metar = explode(' ',@file_get_contents('https://aviationweather.gov/api/data/metar?ids='.$Station[3]));
    /* ---------------------------------------------- */
    $TDP = 0;
    if ($Metar && count($Metar)>4)
    {
        foreach ($Metar as $K => $V)
        {
            if ((strlen($V) === 6 || strlen($V) === 5) && strpos($V, 'Q') === 0)
            {
                $TDP = $K;
            }
        }
        if ($TDP === 0)
        {
            if (isset($Metar[5])&&strrpos($Metar[5],'/'))
            {
                $TDP = 6;
            }
            elseif (isset($Metar[6])&&strrpos($Metar[6],'/'))
            {
                $TDP = 7;
            }
            elseif (isset($Metar[7])&&strrpos($Metar[7],'/'))
            {
                $TDP = 8;
            }
        }
        $Station[] = substr($Metar[$TDP],1,4);
    }
    else
    {
        $Get = MySqlX('SELECT `PPPP` FROM `courier` WHERE `Station` = ? AND `date` = ?',[$Station[0],date('Y-m-d')],0);
        if ($Get&&isset($Get['PPPP']))
        {
            $Station[] = round($Get['PPPP']);
        }
        else
        {
            $Station[] = 0;
        }
    }
}
?>

<form>
    <?php require_once "Top/".$CurrentFile.".php"; ?>
</form>

<div id="All-Slot" class="Slot">

    <div id="Slot-A" class="Slot">

        <div id="Slot-A-1" class="Slot Slot-Block">
            <div class="Information_Item" title="DD">
                <label for="DD"> Wind Direction </label>
                <input type="text" name="DD" id="DD" value="<?=$Values['DD']?>" class="Select _TOP_"  style="min-width: 140px; cursor: pointer;" readonly>
            </div>

            <div class="Information_Item" title="FF">
                <label for="FF"> Wind Speed </label>
                <input type="text" name="FF" id="FF" value="<?=$Values['FF']?>" class="Select _TOP_"  style="min-width: 140px; cursor: pointer;" readonly>
            </div>

            <div class="Information_Item" title="POPOPOPO">
                <label for="POPOPOPO"> QFE </label>
                <input type="text" name="POPOPOPO" id="POPOPOPO" value="<?=$Values['POPOPOPO']?>" class="Select _TOP_"  style="min-width: 140px; cursor: pointer;" readonly>
            </div>

            <div class="Information_Item" title="PPPP">
                <label for="PPPP"> QNH </label>
                <input type="text" name="PPPP" id="PPPP" value="<?=$Values['PPPP']?>" class="Select _TOP_"  style="min-width: 140px; cursor: pointer;" readonly>
            </div>
        </div>

        <div id="Slot-A-2" class="Slot Slot-Block">
            <div class="Information_Item" title="VV">
                <label for="VV"> Visibility </label>
                <input type="text" name="VV" id="VV" value="<?=$Values['VV']?>" class="Select _TOP_"  style="min-width: 185px; cursor: pointer;" readonly>
            </div>

            <div class="Information_Item" title="TTT">
                <label for="TTT"> Dry Temperature </label>
                <input type="text" name="TTT" id="TTT" value="<?=$Values['TTT']?>" class="Select _TOP_"  style="min-width: 185px; cursor: pointer;" readonly>
            </div>

            <div class="Information_Item" title="TDTDTD">
                <label for="TDTDTD"> Dew Point </label>
                <input type="text" name="TDTDTD" id="TDTDTD" value="<?=$Values['TDTDTD']?>" class="Select _TOP_"  style="min-width: 185px; cursor: pointer;" readonly>
            </div>

        </div>
    </div>

    <div id="Slot-B" class="Slot">
        <div id="Slot-B-1" class="Slot Slot-Block">

            <div class="Information_Item" title="Max">
                <label for="Max"> Max Day </label>
                <input type="text" name="Max" id="Max" value="<?=$Values['Max']?>" class="Select _TOP_"  style="min-width: 140px; cursor: pointer;" readonly>
            </div>

            <div class="Information_Item" title="TNTNTN">
                <label for="TNTNTN"> Min Day </label>
                <input type="text" name="TNTNTN" id="TNTNTN" value="<?=$Values['TNTNTN']?>" class="Select _TOP_"  style="min-width: 140px; cursor: pointer;" readonly>
            </div>

            <div class="Information_Item" title="RH">
                <label for="RH"> HUM </label>
                <input type="text" name="RH" id="RH" value="<?=$Values['RH']?>" class="Select _TOP_"  style="min-width: 140px; cursor: pointer;" readonly>
            </div>

            <div class="Information_Item" title="Present">
                <label for="Present"> Present Weather </label>
                <input type="text" name="Present" id="Present" value="<?=$Values['Present']?>" class="Select _TOP_"  style="min-width: 140px; cursor: pointer;" readonly>
            </div>

        </div>
        <div id="Slot-B-2" class="Slot Slot-Block">
            <div class="Information_Item" title="VV">
                <label for="Low"> Low Cloud </label>
                <input type="text" name="Low" id="Low" value="<?=$Values['Low']?>" class="Select _TOP_"  style="min-width: 185px; cursor: pointer;" readonly>
            </div>

            <div class="Information_Item" title="TTT">
                <label for="Medium"> Medium Cloud </label>
                <input type="text" name="Medium" id="Medium" value="<?=$Values['Medium']?>" class="Select _TOP_"  style="min-width: 185px; cursor: pointer;" readonly>
            </div>

            <div class="Information_Item" title="TDTDTD">
                <label for="High"> High Cloud </label>
                <input type="text" name="High" id="High" value="<?=$Values['High']?>" class="Select _TOP_"  style="min-width: 185px; cursor: pointer;" readonly>
            </div>
        </div>
    </div>

    <div id="Chart" class="Slot">
        <div style="width: 100%; max-width: 100%; overflow: auto;" class="OverFlow">
            <div style="width: 95%; max-width: 95%;" id="chart_div" class="OverFlow"></div>
        </div>
    </div>

    <div id="Slot-C" class="Slot">
        <div class="Information_Item" title="Metar">
            <label for="Metar"> Metar </label>
            <div id="Metar"><?=$Values['Metar']?></div>
        </div>
        <div class="Information_Item" title="TAF">
            <label for="TAF"> TAF </label>
            <div id="TAF"><?=$Values['TAF']?></div>
        </div>
    </div>
</div>

<script>
    var $ChartStyle = 'stroke-color: #000000; stroke-width: 3; stroke-opacity: .75; fill-color: #3365ca; fill-opacity: .75; opacity: .75; color: #ffffff';
    var $ChartStation = <?=json_encode($ChartStation)?>;

    var ChartShowAwos = [
        ['Station', 'hpa', { role: 'style' }, { role: 'annotation' } ],
    ];

    $ChartStation.forEach(($Fetch)=>
    {
        if (parseFloat($Fetch[4])>900)
        {
            ChartShowAwos.push([$Fetch[1], parseFloat($Fetch[4]), $ChartStyle,$Fetch[4]+' hpa']);
        }
    })
    window.addEventListener('DOMContentLoaded',()=>{
        SetElementValue('AirportTitle',"<?=$_REQUEST['Station']?>".replaceAll(' AIRPORT','')+" International Airport")
    });
</script>
<?php require_once "configuration/Footer.php"; ?>