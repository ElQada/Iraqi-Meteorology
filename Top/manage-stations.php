<div class="ui container center aligned" id="Top">
    <div class="ui segment Station_Information">
        <input type="hidden" value="<?=_SESSION_('Account')?>" name="Account" id="Account">

        <div class="Information_Item">
            <label for="Station"> اســم الـمـحـطـة </label>
            <div class="ui input">
                <select id="Station" class="Select" name="Station" onchange="{ STtName('manage-stations'); }" style="min-width: 220px;">
                    <option disabled> اســم الـمـحـطـة</option>
                    <?php Stations('manage-stations'); ?>
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
    </div>
</div>