<div class="ui container center aligned" id="Top">
    <div class="ui segment Station_Information">
        <input type="hidden" value="<?=_SESSION_('Account')?>" name="Account" id="Account">
        <div class="Information_Item">
            <label for="Station"> اســم الـمـحـطـة </label>
            <div class="ui input">
                <select id="Station" class="Select" name="Station" onchange="{ timech('reports'); STtName('reports'); }" style="min-width: 220px;">
                    <option disabled> اســم الـمـحـطـة</option>
                    <?php if (($_SESSION['per'] === 'admin')) { ?>
                        <option value="*"> جـمـيـع الـمـحـطـات</option>
                    <?php } ?>
                    <?php Stations('reports'); ?>
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
            <input type="text" class="_TOP_" placeholder="Date" name="date" id="date" value="<?=_REQUEST_('date',$_SESSION['SelectDate'])?>" style="width: 110px;" onchange="{timech('reports'); STtName('reports');}" readonly/>
        </div>
        <div class="Information_Item">
            <label for="_date_"> مــن / الـى </label>
            <input type="text" class="_TOP_" name="_date_" value="<?php echo _REQUEST_('_date_',$_SESSION['SelectDate']); ?>" id="_date_" style="width: 110px;" readonly/>
        </div>
    </div>
</div>