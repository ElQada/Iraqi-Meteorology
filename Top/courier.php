<div class="ui container center aligned" id="Top">
    <div class="ui segment Station_Information">
        <input type="hidden" value="<?=_SESSION_('Account')?>" name="Account" id="Account">
        <div class="Information_Item">
            <label for="Station"> اســم الـمـحـطـة </label>
            <div class="ui input">
                <select id="Station" class="Select" name="Station" onchange="{ timech('courier'); STtName('courier'); }" style="min-width: 220px;">
                    <option disabled> اســم الـمـحـطـة</option>
                    <?php Stations('courier'); ?>
                </select>
            </div>
        </div>
        <div class="Information_Item">
            <label for="StationCode"> رقم المحطة </label>
            <input type="text" class="_TOP_" placeholder="رقم المحطة" id="StationCode" style="max-width: 75px;" readonly/>
        </div>
        <div class="Information_Item">
            <label for="Longitude"> خــط الـطـول </label>
            <input type="text" class="_TOP_" placeholder="LONG E" id="Longitude" style="max-width: 85px;" readonly/>
        </div>
        <div class="Information_Item">
            <label for="Latitude"> خــط الـعـرض </label>
            <input type="text" class="_TOP_" placeholder="LAT" id="Latitude" style="max-width: 85px;" readonly/>
        </div>
        <div class="Information_Item">
            <label for="ElevationM"> الارتــفــاع </label>
            <input type="text" class="_TOP_" placeholder="ElevationM" id="ElevationM" style="max-width: 75px;" readonly/>
        </div>
        <div class="Information_Item">
            <label for="date"> الـتـاريـخ </label>
            <input type="text" class="_TOP_" placeholder="Date" name="date" id="date" value="<?=_REQUEST_('date',$_SESSION['SelectDate'])?>" style="width: 110px;" onchange="{timech('courier'); STtName('courier');}" readonly/>
        </div>
        <div class="Station_Information">
            <div class="Information_Item">
                <label for="SetTimes"> التوقيتات الغير مسجلة </label>
                <div class="ui input">
                    <select id="SetTimes" onchange="GetCurrentOption(this)" class="Select" style="min-width: 110px;">

                    </select>
                </div>
            </div>
        </div>
        <div class="Station_Information">
            <div class="Information_Item">
                <label for="ErrorTimes"> أخطاء الرصدات الساعية </label>
                <div class="ui input">
                    <select id="ErrorTimes" onchange="GetCurrentOption(this)" class="Select" style="min-width: 120px;">

                    </select>
                </div>
            </div>
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
            <input class="_TOP_" type="text" name="time" id="time" minlength="2" maxlength="2" min="0" max="23" style="min-width: 75px;" onkeyup="{timech('courier');}" required/>
            <datalist id="Times">
                <option value="" disabled selected> التوقيت</option>
                <?php for ($i = 0; $i < 10; $i++) { ?>
                    <option>0<?= $i ?></option>
                <?php } ?>
                <?php for ($i = 10; $i < 24; $i++) { ?>
                    <option><?= $i ?></option>
                <?php } ?>
            </datalist>
        </div>
    </div>
</div>