<?php
$Title = "العرض الساعي";
$CurrentFile = "show-courier";
require_once "configuration/Header.php";

$Station = $_SESSION['Station'];
$Limit = 200;

function CourierData($Station, $From, $To, $Start, $End)
{
    $CurrentStation = GetCurrentStation();
    if ($Station === '*') {
        $Get = MySqlX("SELECT * FROM `courier` WHERE `date` BETWEEN '$From' AND '$To' ORDER BY `Station`, `date` , `time` LIMIT $Start,$End", [], 11);
    } else {
        $Get = MySqlX("SELECT * FROM `courier` WHERE `Station` = ? AND `date` BETWEEN '$From' AND '$To' ORDER BY `Station`, `date` , `time` LIMIT $Start,$End", [$Station], 11);
    }

    $G = [];
    $Data = [];
    $Errors = [];
    if ($Get && is_array($Get)) {
        foreach ($Get as $Row) {
            $R = [];
            foreach ($Row as $K => $V) {
                if ($K === 'date') {
                    $R['date'] = $V;
                    $Date = explode('-', $V);
                    $R['Year'] = $Date[0];
                    $R['Month'] = $Date[1];
                    $R['Day'] = $Date[2];
                } elseif ($K === 'Account') {
                    $R['Code'] = $V;
                } else {
                    $R[$K] = $V;
                }
            }
            $R['Error'] = '';
            $G[] = $R;
        }
    }
    if (isset($G[0])) {
        $TestRange = ['TTT' => 40, 'WB' => 40, 'RH' => 50, 'VP' => 40, 'TDTDTD' => 40, 'P0P0P0P0' => 40, 'PPPP' => 40, 'PPP' => 40];

        for ($I = 0; $I < count($G); $I++) {
            $G[$I]['Link'] = "?Station=".$G[$I]['Station']."&Date=".$G[$I]['date']."&Time=".$G[$I]['time']."&ID=".$G[$I]['id']."&Action=EditOpen";
            $G[$I]['Code'] = $CurrentStation[$G[$I]['Station']]['StationCode'];
            $G[$I]['Station'] = $CurrentStation[$G[$I]['Station']]['StationName'];
            $G[$I]['id'] = $I + 1;

            $G[$I]['VP'] = number_format(floatval($G[$I]['VP']), 1, '.', '');

            foreach (['TTT', 'TDTDTD', 'TNTNTN', 'min', 'max'] as $Key) {
                $Test = $G[$I][$Key];
                if (!empty($Test)) {
                    $G[$I][$Key] = number_format(floatval($Test), 1, '.', '');
                }
            }

            foreach (['VV', 'DD', 'FF', 'RRR', 'WW', 'W1W2', 'HSHS1', 'HSHS2', 'HSHS3'] as $Key) {
                $Test = $G[$I][$Key];
                if ((strlen($Test) == 1) && $Test < 10) {
                    $G[$I][$Key] = '0' . $Test;
                }
            }

            $Row = [];
            $RowError = [];

            foreach ($G[$I] as $K => $V) {
                $Error = false;

                if ($K == 'TNTNTN' && in_array($G[$I]['time'], ['06', '18']) && empty($V)) {
                    $Error = true;
                }

                foreach (['FF' => 30] as $K1 => $V1) {
                    if ($K === $K1 && !in_array(($I - 1) . "@$K", $Errors) && floatval($V) >= $V1) {
                        $Error = true;
                    }
                }

                foreach (['P0P0P0P0'=>900,'PPPP'=>900] as $K1 => $V1)
                {
                    if($K === $K1 && !in_array(($I-1)."@$K", $Errors) && floatval($V) <= $V1)
                    {
                        $Error = true;

                    }
                }

                if ($Error&&in_array($K,['P0P0P0P0','PPPP'])&&(empty($V)||empty($G[$I-1][$K]))&&in_array($G[$I]['Code'],['602','658','642',12,15,19]))
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

                $Row[$K] = $V;
                if ($Error) {
                    $RowError[] = $K;
                    $Errors[] = "$I@$K";
                }
            }
            if (!empty($RowError)) {
                $Row['id'] = $G[$I]['id'];
                $Row['Error'] = count($RowError) . " @ [ " . join('  -  ', $RowError) . " ] ";
            }
            $Data[] = $Row;
        }
    }
    return $Data;
}

?>
    <form>
        <?php require_once "Top/".$CurrentFile.".php"; ?>
        <div class="ui container center aligned">
            <div class="ui segment">
                <div class="Flex-1">
                    <input type="submit" id="Submit" name="clicked" value="  تـحـديـث المـعلـومات " class="ui green button large">
                    <input type="button" onclick="CurrentDay('Submit')" name="clicked" value="  الـيــوم الـحـالي " class="ui violet button large">
                    <input type="button" onclick="CurrentMonth('Submit')" name="clicked" value="  الـشـهـر الـحـالي " class="ui orange button large">
                </div>
                <hr>
                <div class="Flex-1">
                    <?php $DataTable = []; if (isset($_REQUEST["clicked"])) {


                    $page = _REQUEST_('page', 1);
                    GetDateFromTo($From, $To);

                    if (!is_numeric($page)) {
                        $page = 1;
                    }
                    $page = floor($page);

                    $Limit = _REQUEST_('limit', 200);
                    if (!is_numeric($Limit)) {
                        $Limit = 200;
                    }
                    $Limit = floor($Limit);

                    $Start = (($page - 1) * $Limit);

                    $QUERY_STRING = explode('&', $_SERVER['QUERY_STRING']);
                    foreach ($QUERY_STRING as $K => $V) {
                        if (in_array(explode('=', $V)[0], ['page', 'limit'])) {
                            unset($QUERY_STRING[$K]);
                        }
                    }
                    $QUERY_STRING = implode('&', $QUERY_STRING);

                    if ($Station !== '*') {
                        $Count = MySqlX("SELECT COUNT(`id`) as `Count` FROM `courier` WHERE `Station` = ? AND `date` BETWEEN ? AND ?", [$Station, $From, $To], 0)['Count'];
                    } else {
                        $Count = MySqlX("SELECT COUNT(`id`) as `Count` FROM `courier` WHERE `date` BETWEEN ? AND ?", [$From, $To], 0)['Count'];
                    }
                    $DataTable = CourierData($Station, $From, $To, $Start, $Limit);
                    $Delete = [];
                    ?>
                    <div class='ui segment Station_Information Online' style='margin-top: 10px; padding: 5px;'>
                        <div class="Information_Item">
                            <label for="CountInPage"> محتوي الصفحة </label>
                            <input type="number" class="_TOP_" id="CountInPage" placeholder="محتوي الصفحة"
                                   value="<?= $Limit ?>"
                                   onchange="{location.search = '?<?= $QUERY_STRING ?>&page=<?= $page ?>&limit='+this.value}"
                                   style="min-width: 120px;" readonly/>
                        </div>
                        <div class="Information_Item">
                            <label for="TotalCount"> العدد الكلي للرصدات الساعية </label>
                            <input type="text" class="_TOP_" id="TotalCount" placeholder="العدد الكلي"
                                   value="<?= $Count ?>"
                                   ondblclick="{location.search = '?<?= $QUERY_STRING ?>&page=<?= $page ?>&limit='+this.value}"
                                   style="min-width: fit-content;" readonly/>
                        </div>
                        <div class="Information_Item">
                            <label for="TotalPages"> عدد الصفحات </label>
                            <input type="text" class="_TOP_" placeholder="عدد الصفحات" id="TotalPages"
                                   value="<?= ceil($Count / $Limit) ?>" style="min-width: 120px;" readonly/>
                        </div>
                        <div class="Information_Item">
                            <label for="page"> أختر الصفحة </label>
                            <div class="ui input">
                                <select id="page" class="Select" name="page"
                                        onchange="{location.search = '?<?= $QUERY_STRING ?>&page='+this.value+'&limit=<?= $Limit ?>'}"
                                        class="_TOP_" style="min-width: 120px;">
                                    <option disabled> رقم الصفحة</option>
                                    <?php for ($i = 1; ; $i++) {
                                        $selected = ($i == $page) ? 'selected' : '';
                                        echo "<option value='$i' $selected>$i</option>";
                                        if ($Limit >= ($Count / $i)) {
                                            break;
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="Information_Item">
                            <label for="page"> أختر الفئة </label>
                            <div class="ui input">
                                <select id="Type" class="Select _TOP_" onchange="ElqadaDataTable.$Tables[ElqadaDataTable.$ID].Search(48,this.value)" name="Type" style="min-width: 120px;">
                                    <option value="" selected >جميع الرصدات</option>
                                    <option value="@">الرصدات الخطأ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui segment">
                    <div class="Title"> العرض الساعى </div>
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
            </div>
        </div>
    </form>
    <script>
        var $DataTable = <?=json_encode($DataTable)?>;
    </script>
<?php require_once "configuration/Footer.php"; ?>