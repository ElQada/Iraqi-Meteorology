<?php
$Title = "متابعة المحطات";
$CurrentFile = "table-synop";
require_once "configuration/Header.php";

$Station = $_SESSION['Station'];
$Account = $_SESSION['Account'];
$Keys = ['اسم المحظة','التاربخ','التوقبت','وقت العملية','وقت التعديل','الراصد','Synop'];
$limit = 200;
$CurrentStation = GetCurrentStation();
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
                <?php if (isset($_REQUEST["clicked"])) {
                $Station = mysqli_real_escape_string(Connection(), $_SESSION['Station']);
                $Account = mysqli_real_escape_string(Connection(), $_SESSION['Account']);
                $Time = _REQUEST_('time','*');

                GetDateFromTo($From,$To);

                $page = _REQUEST_('page',1);
                if (!is_numeric($page)) {
                    $page = 1;
                }
                $page = floor($page);

                $limit = _REQUEST_('limit',200);
                if (!is_numeric($limit)) {
                    $limit = 200;
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

                if ($Time !== '*')
                {
                    if ($Station !== '*')
                    {
                        $Count = MySqlX("SELECT COUNT(`id`) as `Count` FROM `synop` WHERE `Station` = ? AND `date` BETWEEN ? AND ? AND `time` = ? ", [$Station, $From, $To,$Time], 0)['Count'];
                        $query = "select * from synop WHERE `Station` = '$Station' AND `date` BETWEEN '$From' AND '$To' AND `time` = '$Time' ORDER BY `Station`, `date` , `time` LIMIT $Start,$limit";
                    }
                    else
                    {
                        $Count = MySqlX("SELECT COUNT(`id`) as `Count` FROM `synop` WHERE `date` BETWEEN ? AND ? AND `time` = ? ", [$From, $To,$Time], 0)['Count'];
                        $query = "select * from synop WHERE `date` BETWEEN '$From' AND '$To' AND `time` = '$Time' ORDER BY `Station`, `date` , `time` LIMIT $Start,$limit";
                    }
                }
                else
                {
                    if ($Station !== '*')
                    {
                        $Count = MySqlX("SELECT COUNT(`id`) as `Count` FROM `synop` WHERE `Station` = ? AND `date` BETWEEN ? AND ?", [$Station, $From, $To], 0)['Count'];
                        $query = "select * from synop WHERE `Station` = '$Station' AND `date` BETWEEN '$From' AND '$To' ORDER BY `Station`, `date` , `time` LIMIT $Start,$limit";
                    }
                    else
                    {
                        $Count = MySqlX("SELECT COUNT(`id`) as `Count` FROM `synop` WHERE `date` BETWEEN ? AND ?", [$From, $To], 0)['Count'];
                        $query = "select * from synop WHERE `date` BETWEEN '$From' AND '$To' ORDER BY `Station`, `date` , `time` LIMIT $Start,$limit";
                    }
                }

                $Delete = [];
                $result = mysqli_query(Connection(), $query);
                ?>
                <div class='ui segment Station_Information Online' style='margin-top: 10px; padding: 5px;'>
                    <div class="Information_Item">
                        <label for="CountInPage"> محتوي الصفحة </label>
                        <input type="number" class="_TOP_" id="CountInPage" placeholder="محتوي الصفحة" value="<?= $limit ?>" onchange="{location.search = '?<?= $QUERY_STRING ?>&page=<?= $page ?>&limit='+this.value}" style="min-width: 120px;" readonly />
                    </div>
                    <div class="Information_Item">
                        <label for="TotalCount"> العدد الكلي للرصدات </label>
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
                            <select id="Type" class="Select _TOP_" name="Type" onchange="ActionType(this.value)" style="min-width: 120px;">
                                <option value="*" selected>جميع الرصدات</option>
                                <option value="After">الرصدات المتاخرة</option>
                                <option value="Update">الرصدات المعدلة</option>
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
                        while ($line = mysqli_fetch_array($result,MYSQLI_BOTH))
                        {
                            $Update = 0;
                            $After  = 0;

                            $UpdateAfter = (strtotime($line[13]) - strtotime($line[12])) / 60;

                            if ($UpdateAfter)
                            {
                                $Update = 1;
                            }

                            $AddAfter = (strtotime($line[12]) - strtotime($line[4]." ".$line[5].":00:00")) / 60;
                            if ($AddAfter > 5)
                            {
                                $After = 1;
                            }

                            $TitlePlus = " @ [ Station : ".($CurrentStation[$line[1]]['StationName'])." & Date : ".$line[4]." & Time : ".$line[5]." ] ";
                            if (!isset($CurrentStation[$line['Station']])) {
                                $Delete[] = $line[0];
                                continue;
                            }
                            $line[6] = "40".$CurrentStation[$line[1]]['StationCode']." AAXX ".(explode('-',$line[4])[2]).$line[5]."1 ".$line[6];

                            if ($Update)
                            {
                                echo "<tr class='Update'>";
                            }
                            elseif ($After)
                            {
                                echo "<tr class='After'>";
                            }
                            elseif ($line['Account']=== '87')
                            {
                                echo "<tr class='After Edit'>";
                            }
                            else
                            {
                                echo "<tr class='Right'>";
                            }
                            echo "<td class='selectable unstackable' title='".$Keys[0].$TitlePlus."' >" . $CurrentStation[$line[1]]['StationName'] . "</td>";
                            echo "<td class='selectable unstackable' title='".$Keys[1].$TitlePlus."' >" . $line[4] . "</td>";
                            echo "<td class='selectable unstackable' title='".$Keys[2].$TitlePlus."' >" . $line[5] . "</td>";
                            echo "<td class='selectable unstackable' title='".$Keys[5].$TitlePlus."' >".substr($line[12],11)."</td>";
                            echo "<td class='selectable unstackable' title='".$Keys[6].$TitlePlus."' >".substr($line[13],11)."</td>";
                            echo "<td class='selectable unstackable' title='".$Keys[3].$TitlePlus."' >" . $line[3] . "</td>";
                            echo "<td class='selectable unstackable' style='text-align-last: start;' title='".$Keys[4].$TitlePlus."' >" .$line[6]. "</td>";
                            echo "</tr>";
                        }
                        if (count($Delete))
                        {
                            MySqlX("DELETE FROM `synop` WHERE `id` IN(" . join(",", $Delete) . ")");
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</form>

<?php require_once "configuration/Footer.php"; ?>