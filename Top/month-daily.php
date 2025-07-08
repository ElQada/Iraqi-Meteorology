<div class="ui container center aligned" id="Top">
    <div class="ui segment Station_Information">
        <input type="hidden" value="<?=_SESSION_('Account')?>" name="Account" id="Account">
        <div class="Information_Item">
            <label for="Station"> اســم الـمـحـطـة </label>
            <div class="ui input">
                <select id="Station" class="Select" name="Station" onchange="{ timech('month-daily'); STtName('month-daily'); }" style="min-width: 220px;">
                    <option disabled> اســم الـمـحـطـة</option>
                    <?php if (($_SESSION['per'] === 'admin')) { ?>
                        <option value="*"> جـمـيـع الـمـحـطـات</option>
                    <?php } ?>
                    <?php Stations('month-daily'); ?>
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
        <div class="Station_Information">
            <div class="Information_Item">
                <label for="SetYear"> العام </label>
                <div class="ui input">
                    <select id="SetYear" name="SetYear" class="Select" style="min-width: 110px;">
                        <script>
                            let CurrentYear = CurrentDate.getFullYear();
                            let SetYear = '<?=_REQUEST_('SetYear')?>';
                            if (!SetYear)
                            {
                                SetYear = CurrentYear.toString();
                            }
                            for (let Year = 2024; Year <= CurrentYear; Year++)
                            {
                                if (SetYear === Year.toString())
                                {
                                    document.writeln(`<option value="${Year}" selected>${Year}</option>`);
                                }
                                else
                                {
                                    document.writeln(`<option value="${Year}">${Year}</option>`);
                                }
                            }
                        </script>
                    </select>
                </div>
            </div>
        </div>
        <div class="Station_Information">
            <div class="Information_Item">
                <label for="SetMonthFrom"> من شهر </label>
                <div class="ui input">
                    <select id="SetMonthFrom" name="SetMonthFrom" class="Select" style="min-width: 110px;">
                        <script>
                            let SetMonthFrom = '<?=_REQUEST_('SetMonthFrom')?>';
                            if(!SetMonthFrom)
                            {
                                SetMonthFrom = CurrentDate.getMonth().toString();
                            }
                            ['01','02','03','04','05','06','07','08','09','10','11','12'].forEach((Month)=>{
                                if (SetMonthFrom === Month)
                                {
                                    document.writeln(`<option value="${Month}" selected>${Month}</option>`);
                                }
                                else
                                {
                                    document.writeln(`<option value="${Month}">${Month}</option>`);
                                }
                            });
                        </script>
                    </select>
                </div>
            </div>
        </div>
        <div class="Station_Information">
            <div class="Information_Item">
                <label for="SetMonthTo"> إلى شهر </label>
                <div class="ui input">
                    <select id="SetMonthTo" name="SetMonthTo" class="Select" style="min-width: 110px;">
                        <script>
                            let SetMonthTo = '<?=_REQUEST_('SetMonthTo')?>';
                            if(!SetMonthTo)
                            {
                                SetMonthTo = CurrentDate.getMonth().toString();
                            }
                            ['01','02','03','04','05','06','07','08','09','10','11','12'].forEach((Month)=>{
                                if (SetMonthTo === Month)
                                {
                                    document.writeln(`<option value="${Month}" selected>${Month}</option>`);
                                }
                                else
                                {
                                    document.writeln(`<option value="${Month}">${Month}</option>`);
                                }
                            });
                        </script>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>