<?php
$_SESSION['MinDate'] = date('Y-m-d', strtotime('-3 day'));
if ($_SESSION['SelectDate'] < $_SESSION['MinDate'])
{
    $Date = date('Y-m-d', $EditTime);
}
$Return = (MySqlX("DELETE FROM `synop` WHERE `date` NOT BETWEEN ? AND ?", [date('Y-m-d', strtotime("$CurrentDate -4 day")), date('Y-m-d', strtotime("$CurrentDate +1 day"))], 0));

?>
<div class="ui container center aligned" id="Top">
    <div class="ui segment Station_Information">
        <input type="hidden" value="<?=_SESSION_('Account')?>" name="Account" id="Account">
        <div class="Station_Information">
            <div class="Information_Item">
                <label for="SetStationX"> الاوقات المرسلة للمحطات </label>
                <div class="ui input">
                    <select id="SetStationX" class="Select" style="min-width: 333px;">

                    </select>
                </div>
            </div>
        </div>
        <div class="Information_Item">
            <label for="StationCount"> المحطات المرسلة </label>
            <input type="text" class="_TOP_" placeholder="-" id="StationCount" style="min-width: 100px;color: #ff0000;font-size: x-large;font-weight: 900;font-family: sans-serif;" readonly/>
        </div>
        <div class="Information_Item">
            <label for="date"> الـتـاريـخ </label>
            <input type="text" class="_TOP_" placeholder="Date" name="date" id="date" value="<?=_REQUEST_('date',$_SESSION['SelectDate'])?>" style="width: 110px;" onchange="{timech('show-synop'); STtName('show-synop');}" readonly/>
        </div>
        <div class="Information_Item">
            <label for="time"> التوقيت </label>
            <div class="ui input">
                <select id="time" class="Select" name="time" onchange="{timech('show-synop'); }" style="min-width: 100px;">
                    <option value="*" <?= ((_REQUEST_('time'))==='*')?'selected':'' ?>>التوقيتات</option>
                    <?php foreach(['00','03','06','09','12','15','18','21'] as $k => $v){ ?>
                        <option value="<?= $v ?>" <?= ((_REQUEST_('time'))===$v)?'selected':'' ?>><?= $v ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div>
        <div onclick="CopyText(GetElementValue('synop'))" id="Data-Send" class="large ui blue button"> Data Copy </div>
        <input type="button" name="clicked" value="  تـــحــديــث الـمــعــلــومــات " onclick="{ timech(PHP.CurrentFile); }" class="ui green button large">
    </div>
</div>
