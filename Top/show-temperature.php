<?php
$_SESSION['MinDate'] = date('Y-m-d', strtotime('-3 day'));
if ($_SESSION['SelectDate'] < $_SESSION['MinDate'])
{
    $Date = date('Y-m-d', $EditTime);
}
?>
<div class="ui container center aligned" id="Top">
    <div class="ui segment Station_Information">
        <input type="hidden" value="<?=_SESSION_('Account')?>" name="Account" id="Account">
        <div class="Information_Item">
            <label for="Station"> اســم الـمـحـطـة </label>
            <div class="ui input">
                <select id="Station" class="Select" name="Station" onchange="{ timech('show-temperature'); STtName('show-temperature'); }" style="min-width: 220px;">
                    <option disabled> اســم الـمـحـطـة</option>
                    <option value="*"> جـمـيـع الـمـحـطـات</option>
                    <?php Stations('show-temperature'); ?>
                </select>
            </div>
        </div>
        <div class="Information_Item">
            <label for="date"> الـتـاريـخ </label>
            <input type="text" class="_TOP_" placeholder="Date" name="date" id="date" value="<?=_REQUEST_('date',$_SESSION['SelectDate'])?>" style="width: 110px;" onchange="{timech('show-temperature'); STtName('show-temperature');}" readonly/>
        </div>
        <div class="Information_Item">
            <label for="time"> التوقيت </label>
            <div class="ui input">
                <select id="time" class="Select" name="time" onchange="{timech('show-temperature'); }" style="min-width: 100px;">
                    <option value="*" <?= ((_REQUEST_('time'))==='*')?'selected':'' ?>>التوقيتات</option>
                    <?php foreach(['00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23'] as $k => $v){ ?>
                        <option value="<?= $v ?>" <?= ((_REQUEST_('time'))===$v)?'selected':'' ?>><?= $v ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>
