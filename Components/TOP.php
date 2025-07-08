<?php
if (in_array($CurrentFile,['synop','show-synop','show-temperature']))
{
    $_SESSION['MinDate'] = date('Y-m-d', strtotime('-3 day'));
    if ($_SESSION['SelectDate'] < $_SESSION['MinDate'])
    {
        $Date = date('Y-m-d', $EditTime);
    }
    if ($CurrentFile === 'show-synop')
    {
        $Return = (MySqlX("DELETE FROM `synop` WHERE `date` NOT BETWEEN ? AND ?", [date('Y-m-d', strtotime("$CurrentDate -4 day")), date('Y-m-d', strtotime("$CurrentDate +1 day"))], 0));
    }
}
?>
<?php if (!in_array($CurrentFile,['Test-Clouds'])) { ?>
    <div class="ui container center aligned" id="Top">
        <div class="ui segment Station_Information">
            <input type="hidden" value="<?=_SESSION_('Account')?>" name="Account" id="Account">

            <?php if (in_array($CurrentFile,['synop'])) { ?>
                <div class="Information_Item">
                    <label for="StationCode"> رقم المحطة </label>
                    <input type="search" class="Select _TOP_" name="StationCode" id="StationCode" oninput="SelectStationName(this.value)" style="max-width: 85px; cursor: pointer;" autocomplete="off" required>
                </div>
            <?php } ?>

            <!--|____[( Last of Stations )]____|-->
            <?php if (!in_array($CurrentFile, ['show-synop','show-awos','Show-Mater','Mater-Reports','Test-Clouds','phenomena-weather'])) { ?>
                <div class="Information_Item">
                    <label for="Station"> اســم الـمـحـطـة </label>
                    <div class="ui input">
                        <select id="Station" class="Select" name="Station" onchange="{ timech('<?= $CurrentFile ?>'); STtName('<?= $CurrentFile ?>'); }" style="min-width: 220px;">
                            <option disabled> اســم الـمـحـطـة</option>
                            <?php if ((in_array($CurrentFile, ['show-courier', 'show-daily', 'table-synop', 'reports','month-courier','monthly-cloud',"monthly-tntntn",'month-daily','monthly-weather']) && $_SESSION['per'] === 'admin') || ( $_SESSION['per'] === 'Forecasting' && in_array($CurrentFile,['table-synop']) ) || in_array($CurrentFile,['show-temperature']) ) { ?>
                                <option value="*"> جـمـيـع الـمـحـطـات</option>
                            <?php } ?>
                            <?php Stations($CurrentFile); ?>
                        </select>
                    </div>
                </div>
            <?php } ?>

            <?php if (!in_array($CurrentFile,['synop','show-synop','show-temperature','show-awos','table-synop','show-courier','show-daily','Show-Mater','Mater-Reports','Test-Clouds','phenomena-weather'] )) { ?>
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
            <?php } ?>

            <?php if (in_array($CurrentFile,['show-synop'])) { ?>
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
            <?php } ?>

            <?php if (in_array($CurrentFile, ['Show-Mater'])) {?>
                <div class="Information_Item" >
                    <label for="Mater"> رمـز الـمـطـار </label>
                    <div class="ui input">
                        <select id="Mater" class="Select" name="Mater" style="min-width: 333px;">
                            <option disabled> رمـز الـمـطـار </option>
                            <?php foreach (["BAGHDAD"=>"ORBI","BASRA AIRPORT"=>"ORMM","NAJAF"=>"ORNI","ERBEEL"=>"ORER","SULAIMANIYA AIRPORT"=>"ORSU","KIRKUK AIRPORT"=>"ORKK"] as $Key => $Value) {
                                if (isset($_REQUEST['Mater'])&&$_REQUEST['Mater'] === $Value)
                                {
                                    echo '<option value="'.$Value.'" selected>'."$Value [ $Key ]".'</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$Value.'">'."$Value [ $Key ]".'</option>';
                                }
                            }?>
                        </select>
                    </div>
                </div>
            <?php } ?>

            <?php if (!in_array($CurrentFile, ['show-awos','Test-Clouds','monthly-weather','phenomena-weather','month-courier','monthly-cloud',"monthly-tntntn",'month-daily'])) { ?>
                <div class="Information_Item">
                    <label for="date"> الـتـاريـخ </label>
                    <input type="text" class="_TOP_" placeholder="Date" name="date" id="date" value="<?=_REQUEST_('date',$_SESSION['SelectDate'])?>" style="width: 110px;" onchange="{timech('<?= $CurrentFile ?>'); STtName('<?= $CurrentFile ?>');}" readonly/>
                </div>
            <?php } ?>
            <?php if (in_array($CurrentFile, ['monthly-weather','month-courier','monthly-cloud',"monthly-tntntn",'month-daily'])) { ?>
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

            <?php } ?>

            <?php if (in_array($CurrentFile, ['show-courier', 'table-synop', 'show-daily', 'reports','Mater-Reports','Show-Mater'])) { ?>
                <div class="Information_Item">
                    <label for="_date_"> مــن / الـى </label>
                    <input type="text" class="_TOP_" name="_date_" value="<?php echo _REQUEST_('_date_',$_SESSION['SelectDate']); ?>" id="_date_" style="width: 110px;" readonly/>
                </div>
            <?php } ?>

            <?php if (in_array($CurrentFile, ['show-courier', 'table-synop', 'show-daily','Show-Mater'])) { ?>
                <input type="hidden" name="page" id="Page" value="<?php echo _REQUEST_('page',1); ?>"/>
                <input type="hidden" name="limit" id="Limit" value="<?php echo _REQUEST_('limit',$limit); ?>"/>
            <?php } ?>

            <?php if ($CurrentFile === 'daily-monitoring') { ?>
                <div class="Information_Item">
                    <label for="daily_monitoring_date"> التواريخ الغير مسجلة </label>
                    <input type="text" id="daily_monitoring_date" onchange="GetCurrentOption(this)" style="width: 120px;" readonly/>
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

            <?php } ?>

            <?php if (in_array($CurrentFile,['courier'] )) { ?>
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
            <?php } ?>

            <?php if (in_array($CurrentFile, ['daily-monitoring', 'courier','synop'])) { ?>
                <div class="Information_Item">
                    <label for="Monitor"> اســم الـراصــد </label>
                    <input type="search" class="Select _TOP_" name="name" id="Monitor" data-list="XMonitors" value="<?php echo _REQUEST_('name',_SESSION_('Monitor')); ?>" onchange="Monitors()" style="min-width: 195px; cursor: pointer;" autocomplete="off" required>
                    <datalist id="XMonitors">
                        <?php /* Monitors();*/ ?>
                    </datalist>
                </div>
            <?php } ?>

            <?php if (in_array($CurrentFile,['courier'] )) { ?>
                <div class="Information_Item">
                    <label for="time"> التوقيت </label>
                    <input class="_TOP_" type="text" name="time" id="time" minlength="2" maxlength="2" min="0" max="23" style="min-width: 75px;" onkeyup="{timech('<?= $CurrentFile ?>');}" required/>
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
            <?php } ?>


            <?php if (in_array($CurrentFile,['synop','show-synop','table-synop','show-temperature'])) { ?>
                <div class="Information_Item">
                    <label for="time"> التوقيت </label>
                    <div class="ui input">
                        <select id="time" class="Select" name="time" onchange="{timech('<?= $CurrentFile ?>'); }" style="min-width: 100px;">
                            <option value="*" <?= ((_REQUEST_('time'))==='*')?'selected':'' ?>>التوقيتات</option>
                            <?php foreach(['00','03','06','09','12','15','18','21'] as $k => $v){ ?>
                                <option value="<?= $v ?>" <?= ((_REQUEST_('time'))===$v)?'selected':'' ?>><?= $v ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            <?php } ?>

            <?php if (in_array($CurrentFile, ['show-awos'])) {?>
                <div class="Information_Item" >
                    <label for="Station"> رمـز الـمـطـار </label>
                    <div class="ui input">
                        <select id="Station" class="Select" name="Station" onchange="{ Awos() }" style="min-width: 110px;">
                            <option disabled> رمـز الـمـطـار </option>
                            <?php foreach (["BAGHDAD"=>"ORBI","ERBEEL"=>"ORER","MOSUL"=>"ORBM","SULAIMANIYA AIRPORT"=>"ORSU","BASRA AIRPORT"=>"ORMM","NAJAF"=>"ORNI","KIRKUK AIRPORT"=>"ORKK"] as $Key => $Value) {
                                if (isset($_REQUEST['Station'])&&$_REQUEST['Station'] === $Key)
                                {
                                    echo '<option value="'.$Key.'" selected>'.$Value.'</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$Key.'">'.$Value.'</option>';
                                }
                            }?>
                        </select>
                    </div>
                </div>
                <div class="" title="Airport Title">
                    <label for="AirportTitle" style="display: none;"> Airport Title </label>
                    <input type="text" name="AirportTitle" id="AirportTitle" value="WAIT DATA IS PROCESSING NOW ..." class="Select _TOP_" style="min-width: 300px; cursor: pointer;" readonly>
                </div>
                <div class="ui">
                    <input type="button" name="clicked" onclick="Awos()" value="  تـــحــديــث الـمــعــلــومــات " class="ui green button large">
                    <div class="ui Over">
                        <div style="overflow: auto;">
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>

        <?php if (in_array($CurrentFile,['show-synop'])) { ?>
            <div>
                <div onclick="CopyText(GetElementValue('synop'))" id="Data-Send" class="large ui blue button"> Data Copy </div>
                <input type="button" name="clicked" value="  تـــحــديــث الـمــعــلــومــات " onclick="{ timech(PHP.CurrentFile); }" class="ui green button large">
            </div>
        <?php } ?>
    </div>
<?php } ?>