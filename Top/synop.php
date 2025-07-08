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
            <label for="StationCode"> رقم المحطة </label>
            <input type="search" class="Select _TOP_" name="StationCode" id="StationCode" oninput="SelectStationName(this.value)" style="max-width: 85px; cursor: pointer;" autocomplete="off" required>
        </div>
        <div class="Information_Item">
            <label for="Station"> اســم الـمـحـطـة </label>
            <div class="ui input">
                <select id="Station" class="Select" name="Station" onchange="{ timech('synop'); STtName('synop'); }" style="min-width: 220px;">
                    <option disabled> اســم الـمـحـطـة</option>
                    <?php Stations('synop'); ?>
                </select>
            </div>
        </div>

        <div class="Information_Item">
            <label for="date"> الـتـاريـخ </label>
            <input type="text" class="_TOP_" placeholder="Date" name="date" id="date" value="<?=_REQUEST_('date',$_SESSION['SelectDate'])?>" style="width: 110px;" onchange="{timech('synop'); STtName('synop');}" readonly/>
        </div>
        <div class="Information_Item">
            <label for="Monitor"> اســم الـراصــد </label>
            <input type="search" class="Select _TOP_" name="name" id="Monitor" data-list="XMonitors" value="<?php echo _REQUEST_('name',_SESSION_('Monitor')); ?>" onchange="Monitors()" style="min-width: 195px; cursor: pointer;" autocomplete="off" required>
            <datalist id="XMonitors">
                <?php /* Monitors();*/ ?>
            </datalist>
        </div>
        <div class="Information_Item">
            <label for="time"> التوقيت </label>
            <div class="ui input">
                <select id="time" class="Select" name="time" onchange="{timech('synop'); }" style="min-width: 100px;">
                    <option value="*" <?= ((_REQUEST_('time'))==='*')?'selected':'' ?>>التوقيتات</option>
                    <?php foreach(['00','03','06','09','12','15','18','21'] as $k => $v){ ?>
                        <option value="<?= $v ?>" <?= ((_REQUEST_('time'))===$v)?'selected':'' ?>><?= $v ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>
