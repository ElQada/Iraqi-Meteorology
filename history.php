<?php
$Title = "ســجــل الـعـمـل";
$CurrentFile = "history";
require_once "configuration/Header.php";

$Station = $_SESSION['Station'];
$Limit = 600;
function records($Station, $From, $To, $Start, $End)
{
    // `Type` != 'INSERT' AND `Keys` NOT IN ('synop','test_clouds','test_weather') AND
    if ($Station === '*') {
        $Get = MySqlX("SELECT * FROM `records` WHERE `Created_At` BETWEEN '$From' AND '$To' ORDER BY `Station`, `id` DESC LIMIT $Start,$End", [], 11);
    } else {
        if (!in_array(_ROLE_, ['manager','admin'])) {
            $Get = MySqlX("SELECT * FROM `records` WHERE `User` = ? AND `Station` = ? AND `Created_At` BETWEEN '$From' AND '$To' ORDER BY `Station`, `id` DESC LIMIT $Start,$End", [$_SESSION['Account'],$Station], 11);
        }
        else
        {
            $Get = MySqlX("SELECT * FROM `records` WHERE `Station` = ? AND `Created_At` BETWEEN '$From' AND '$To' ORDER BY `Station`, `id` DESC LIMIT $Start,$End", [$Station], 11);
        }
    }
    return $Get;
}
if (isset($_REQUEST["DeleteRecord"]) && in_array(_ROLE_, ['manager','admin']))
{
    GetDateFromTo($From, $To);

    if ($Station === '*') {
        if (MySqlX("DELETE FROM `records` WHERE `Created_At` BETWEEN '$From' AND '$To'",[],'R',0))
        {
            Message(' تم بنجاح حذف الـسـجـل');
        }
    } else {
        if (MySqlX("DELETE FROM `records` WHERE `Station` = ? AND `Created_At` BETWEEN '$From' AND '$To'",[$Station],'R',0))
        {
            Message(' تم بنجاح حذف الـسـجـل');
        }
    }
}
?>
    <form>
        <?php require_once "Top/".$CurrentFile.".php"; ?>
        <div class="ui container center aligned">
            <div class="ui segment">
                <div class="Flex-1">
                    <input type="submit" id="Submit" name="RefreshData" value="  تـحـديـث المـعلـومات " class="ui green button large">
                    <input type="button" onclick="CurrentDay('Submit')" name="SelectCurrentDay" value="  الـيــوم الـحـالي " class="ui violet button large">
                    <input type="button" onclick="CurrentMonth('Submit')" name="SelectCurrentMonth" value="  الـشـهـر الـحـالي " class="ui orange button large">
                    <input type="submit" id="DeleteRecord" name="DeleteRecord" value=" حذف السجل " class="ui red button large">
                </div>
                <hr>
                <div class="Flex-1">
                    <?php $DataTable = [];  if (isset($_REQUEST["RefreshData"])) {


                    $page = _REQUEST_('page', 1);
                    GetDateFromTo($From, $To);
                    $From .= ' 00:00:00';
                    $To   .= ' 23:59:59';

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

                    // `Type` != 'INSERT' AND `Keys` NOT IN ('synop','test_clouds','test_weather') AND
                    if ($Station !== '*') {
                        if (!in_array(_ROLE_, ['manager','admin'])) {
                            $Count = MySqlX("SELECT COUNT(`ID`) as `Count` FROM `records` WHERE `Station` = ? AND `Created_At` BETWEEN ? AND ?", [$Station, $From, $To], 0)['Count'];
                        }
                        else
                        {
                            $Count = MySqlX("SELECT COUNT(`ID`) as `Count` FROM `records` WHERE `User` = ? AND `Station` = ? AND `Created_At` BETWEEN ? AND ?", [$_SESSION['Account'],$Station, $From, $To], 0)['Count'];
                        }
                    } else {
                        $Count = MySqlX("SELECT COUNT(`ID`) as `Count` FROM `records` WHERE `Created_At` BETWEEN ? AND ?", [$From, $To], 0)['Count'];
                    }
                    $DataTable = records($Station, $From, $To, $Start, $Limit);
                    if ($DataTable && count($DataTable)) {
                        foreach ($DataTable as &$Row) {
                            if (!$Row['Value'])
                            {
                                $Keys = $Row['Keys'];

                                if (in_array($Keys,['courier','synop']))
                                {
                                    $Row['Value'] = json_encode(MySqlX("SELECT `Account`,`name`,`date`,`time` FROM `$Keys` WHERE `id` = ?", [$Row['Reference']], 0),256);
                                }
                                elseif ($Keys == 'daily')
                                {
                                    $Row['Value'] = json_encode(MySqlX("SELECT `Account`,`name`,`date` FROM `$Keys` WHERE `id` = ?", [$Row['Reference']], 0),256);
                                }
                                elseif ($Keys == 'accounts')
                                {
                                    $Row['Value'] = json_encode(MySqlX("SELECT `user`,`code`,`per`,`Station` FROM `$Keys` WHERE `id` = ?", [$Row['Reference']], 0),256);
                                }
                                if ($Row['Value'] === 'false')
                                {
                                    $Row['Value'] = '{"Info":"تم الحذف"}';
                                }
                            }
                        }
                    }
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
                            <label for="TotalCount"> العدد الكلي </label>
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
                            <label for="Users"> الـمـوظــف </label>
                            <div class="ui input">
                                <select id="Users" class="Select _TOP_" onchange="ElqadaDataTable.$Tables[ElqadaDataTable.$ID].Search(3,this.value)" name="Users" style="min-width: 200px;">
                                </select>
                            </div>
                        </div>
                        <div class="Information_Item">
                            <label for="Keys"> الـقـسـم </label>
                            <div class="ui input">
                                <select id="Keys" class="Select _TOP_" onchange="ElqadaDataTable.$Tables[ElqadaDataTable.$ID].Search(1,this.value)" name="Keys" style="min-width: 120px;">
                                </select>
                            </div>
                        </div>
                        <div class="Information_Item">
                            <label for="Type"> الإجــراء </label>
                            <div class="ui input">
                                <select id="Type" class="Select _TOP_" onchange="ElqadaDataTable.$Tables[ElqadaDataTable.$ID].Search(0,this.value)" name="Type" style="min-width: 120px;">

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui segment">
                    <div class="Title"> ســجــل الـعـمـل </div>
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
        var $CurrentStation    = <?=json_encode(GetCurrentStation())?>;
        var $GetCurrentAccount = <?=json_encode(GetCurrentAccount())?>;
        var $DataTable         = <?=json_encode($DataTable)?>;
        var $Users = <?=json_encode(SelectCurrentAccount())?>;
    </script>
<?php require_once "configuration/Footer.php"; ?>