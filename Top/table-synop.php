<div class="ui container center aligned" id="Top">
    <div class="ui segment Station_Information">
        <input type="hidden" value="<?=_SESSION_('Account')?>" name="Account" id="Account">

        <div class="Information_Item">
            <label for="Station"> اســم الـمـحـطـة </label>
            <div class="ui input">
                <select id="Station" class="Select" name="Station" onchange="{ timech('table-synop'); STtName('table-synop'); }" style="min-width: 220px;">
                    <option disabled> اســم الـمـحـطـة</option>
                    <?php if ($_SESSION['per'] === 'Forecasting') { ?>
                        <option value="*"> جـمـيـع الـمـحـطـات</option>
                    <?php } ?>
                    <?php Stations('table-synop'); ?>
                </select>
            </div>
        </div>

        <div class="Information_Item">
            <label for="date"> الـتـاريـخ </label>
            <input type="text" class="_TOP_" placeholder="Date" name="date" id="date" value="<?=_REQUEST_('date',$_SESSION['SelectDate'])?>" style="width: 110px;" onchange="{timech('table-synop'); STtName('table-synop');}" readonly/>
        </div>

        <div class="Information_Item">
            <label for="_date_"> مــن / الـى </label>
            <input type="text" class="_TOP_" name="_date_" value="<?php echo _REQUEST_('_date_',$_SESSION['SelectDate']); ?>" id="_date_" style="width: 110px;" readonly/>
        </div>
        <input type="hidden" name="page" id="Page" value="<?php echo _REQUEST_('page',1); ?>"/>
        <input type="hidden" name="limit" id="Limit" value="<?php echo _REQUEST_('limit',$Limit); ?>"/>
        <div class="Information_Item">
            <label for="time"> التوقيت </label>
            <div class="ui input">
                <select id="time" class="Select" name="time" onchange="{timech('table-synop'); }" style="min-width: 100px;">
                    <option value="*" <?= ((_REQUEST_('time'))==='*')?'selected':'' ?>>التوقيتات</option>
                    <?php foreach(['00','03','06','09','12','15','18','21'] as $k => $v){ ?>
                        <option value="<?= $v ?>" <?= ((_REQUEST_('time'))===$v)?'selected':'' ?>><?= $v ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>