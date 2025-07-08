<?php
$Title = "عرض الميتار";
$CurrentFile = "Show-Mater";
require_once "configuration/Header.php";

$Keys = ['Airport','Date', 'Mater'];
$limit = 3;
?>

<form id="Show-Mater">
    <?php require_once "Top/".$CurrentFile.".php"; ?>
    <div class="ui container center aligned">
        <div class="ui segment">
            <div class="Flex-1">
                <input type="submit" name="clicked" value="  تـــحــديــث الـمــعــلــومــات " class="ui green button large">
            <?php if (isset($_REQUEST["clicked"])) {

            GetDateFromTo($From,$To);

            $page = _REQUEST_('page',1);
            if (!is_numeric($page)) {
                $page = 1;
            }
            $page = floor($page);

            $limit = _REQUEST_('limit',3);
            if (!is_numeric($limit)) {
                $limit = 3;
            }
            $limit = floor($limit);

            $Start = (($page - 1) * $limit);

            $QUERY_STRING = explode('&', $_SERVER['QUERY_STRING']);
            foreach ($QUERY_STRING as $K => $V) {
                if (in_array(explode('=', $V)[0], ['page', 'limit'])) {
                    unset($QUERY_STRING[$K]);
                }
            }

            $QUERY_STRING = implode('&', $QUERY_STRING);

            if ($_REQUEST['Mater'] !== '*') {
                $Count = MySqlX("SELECT COUNT(`id`) as `Count` FROM `metar` WHERE `Code` = ? AND `Update` BETWEEN ? AND ?", [$_REQUEST['Mater'], $From, $To], 0)['Count'];
                $query = "SELECT `Code` AS `Airport`,`Key` AS `Date`,`Value` AS `Metar` FROM `metar` WHERE `Code` = '{$_REQUEST['Mater']}' AND DATE_FORMAT(`Update`, '%Y-%m-%d') BETWEEN '$From' AND '$To' ORDER BY `ID` DESC LIMIT $Start,$limit";
            } else {
                $limit *= 15;
                $Count = MySqlX("SELECT COUNT(`id`) as `Count` FROM `metar` WHERE `Update` BETWEEN ? AND ?", [$From, $To], 0)['Count'];
                $query = "SELECT `Code` AS `Airport`,`Key` AS `Date`,`Value` AS `Metar` FROM `metar` WHERE DATE_FORMAT(`Update`, '%Y-%m-%d') BETWEEN '$From' AND '$To' ORDER BY `ID` DESC LIMIT $Start,$limit";
            }
            $result = mysqli_query(Connection(), $query);
            ?>
                <div class='ui segment Station_Information Online' style='margin-top: 10px; padding: 5px;'>
                <div class="Information_Item">
                    <label for="CountInPage"> محتوي الصفحة </label>
                    <input type="number" class="_TOP_" id="CountInPage" placeholder="محتوي الصفحة" value="<?= $limit ?>" onchange="{location.search = '?<?= $QUERY_STRING ?>&page=<?= $page ?>&limit='+this.value}" style="min-width: 120px;" readonly />
                </div>
                <div class="Information_Item">
                    <label for="TotalCount"> العدد الكلي للرصدات الساعية </label>
                    <input type="text" class="_TOP_" id="TotalCount" placeholder="العدد الكلي" value="<?= $Count ?>" ondblclick="{location.search = '?<?= $QUERY_STRING ?>&page=<?= $page ?>&limit='+this.value}" style="min-width: 150px;" readonly/>
                </div>
                <div class="Information_Item">
                    <label for="TotalPages"> عدد الصفحات </label>
                    <input type="text" class="_TOP_" placeholder="عدد الصفحات" id="TotalPages" value="<?= ceil($Count / $limit) ?>" style="min-width: 120px;" readonly/>
                </div>
                <div class="Information_Item">
                    <label for="page"> أختر الصفحة </label>
                    <div class="ui input">
                        <select id="page" class="Select" name="page" onchange="{location.search = '?<?= $QUERY_STRING ?>&page='+this.value+'&limit=<?= $limit ?>'}" class="_TOP_" style="min-width: 120px;">
                            <option disabled> رقم الصفحة</option>
                            <?php for ($i = 1; ; $i++) {
                                $selected = ($i == $page) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                                if ($limit >= ($Count / $i)) {
                                    break;
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                    <div class="Information_Item">
                        <label for="page"> أختر الفئة </label>
                        <div class="ui input">
                            <select id="Type" class="Select" name="Type" onchange="ActionType(this.value)" class="_TOP_" style="min-width: 120px;">
                                <option value="*" selected>جميع الميتارات</option>
                                <option value="Error">الميتارات الفارغة</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div id="MainTable" ondblclick="/*this.requestFullscreen()*/">
                <div id="ViewTable">
                    <table class="ui celled collapsing sortable unstackable selectable striped table">
                        <thead>
                        <tr>
                            <?php
                            foreach ($Keys as $key)
                            {
                                echo "<th class='selectable unstackable'>$key</th>";
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $lines = mysqli_fetch_all($result,MYSQLI_BOTH);
                        foreach ($lines as $I => $line)
                        {
                            $TitlePlus = " @ [ Date : ".$line[1]." & Time : ".$line[1]." ] ";
                            if ($line[2] === "NULL")
                            {
                                echo "<tr class='Error' style='color: #ff0000'>";
                            }
                            else
                            {
                                echo "<tr>";
                            }
                            echo "<td class='selectable unstackable' title='".$Keys[0].$TitlePlus."' >" . $line[0] . "</td>";
                            echo "<td class='selectable unstackable' title='".$Keys[1].$TitlePlus."' >" . $line[1] . "</td>";
                            echo "<td class='selectable unstackable' title='".$Keys[2].$TitlePlus."' style='text-align-last: left;'>" . $line[2] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <?php
/*                            foreach ($Keys as $key)
                            {
                                echo "<th class='selectable unstackable' style='".$Style."background-color: #7dc2e4; color: #003055;'>$key</th>";
                            }*/
                            ?>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
         <?php } ?>
        </div>
    </div>
</form>

<?php require_once "configuration/Footer.php"; ?>
<script>
    // $('table').tablesort();
</script>