<div class="ui container center aligned" id="Top">
    <div class="ui segment Station_Information">
        <input type="hidden" value="<?=_SESSION_('Account')?>" name="Account" id="Account">
        <div class="Information_Item">
            <label for="Station"> اســم الـمـحـطـة </label>
            <div class="ui input">
                <select id="Station" class="Select" name="Station" onchange="{ timech('daily-monitoring'); STtName('daily-monitoring'); }" style="min-width: 220px;">
                    <option disabled> اســم الـمـحـطـة</option>
                    <?php Stations('daily-monitoring'); ?>
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
            <input type="text" class="_TOP_" placeholder="Date" name="date" id="date" value="<?=_REQUEST_('date',$_SESSION['SelectDate'])?>" style="width: 110px;" onchange="{timech('daily-monitoring'); STtName('daily-monitoring');}" readonly/>
        </div>
        <div class="Station_Information">
            <div class="Information_Item">
                <label for="SetTimes"> التواريخ الغير مسجلة </label>
                <div class="ui input">
                    <select id="SetTimes" onchange="GetCurrentOption(this)" class="Select" style="min-width: 110px;">

                    </select>
                </div>
            </div>
        </div>
        <div class="Station_Information">
            <div class="Information_Item">
                <label for="ErrorDays"> أخطاء الرصدات اليومى </label>
                <div class="ui input">
                    <select id="ErrorDays" onchange="GetCurrentOption(this)" class="Select" style="min-width: 120px;">

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
    </div>
</div>