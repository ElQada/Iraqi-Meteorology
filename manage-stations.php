<?php
$Title = "ادارة الـمـحـطـات";
$CurrentFile = "manage-stations";
require_once "configuration/Header.php";
$Type = _TYPE_;
$Role = _ROLE_;

if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_REQUEST)) {
    require_once("configuration/Connection.php");

    $stc = _REQUEST_('stc');
    $stn = _REQUEST_('stn');
    $lat = _REQUEST_('Latitude');
    $lon = _REQUEST_('lon');
    $hi = _REQUEST_('hi');

    if (isset($_REQUEST['AddStation']))
    {

        if ($Selected = MySqlX('SELECT `id` FROM `stations` WHERE `StationCode` = ? OR `StationName` = ? AND `id` NOT IN (42,43)',[$stc,strtoupper($stn)],0))
        {
            if (MySqlX("UPDATE `stations` SET `StationName` = ?, `StationCode` = ?,`Latitude` = ?,`Longitude` = ?,`ElevationM` = ? WHERE `StationCode` = ? OR `StationName` = ?", [strtoupper($stn), $stc, $lat, $lon, $hi, $stc, $stn], 'R')) {
                Message(' تم بنجاح تعديل المحطة ');
                SetRecord($Selected['id'], 'UPDATE', 'stations',$Selected['id'],'');
            }
        }
        else if ($StationID = MySqlX("INSERT INTO `stations` (`StationName`, `StationCode`,`Latitude`,`Longitude`,`ElevationM`) VALUES (?,?,?,?,?)", [strtoupper($stn), $stc, $lat, $lon, $hi], 'K',null)) {
            SetRecord($StationID, 'INSERT', 'stations',$StationID,'');
            if ($AccountID = MySqlX("INSERT INTO `accounts` (`user`,`code`,`per`,`Station`,`_Key_`) VALUES (?,?,?,?,?)", [strtoupper($stn), $stc, 'manager', $StationID,password_hash($stc,PASSWORD_DEFAULT)], 'K')) {
                Message(' تم بنجاح اضافة المحطة ومديرها بنفس الاسم وكلمة المرور كود المحطة ');
                SetRecord($StationID, 'INSERT', 'accounts',$AccountID,'');
            }
        }
    }

    if (isset($_REQUEST['DeleteStation']) && false) {
        if (MySqlX("DELETE FROM `stations` WHERE `id` = ? AND `id` != 1  AND `id` NOT IN (42,43)", [$_SESSION['Station']], 'R') || MySqlX("DELETE FROM `accounts` WHERE `Station` = ? AND `id` != 1", [$_SESSION['Station']], 'R')) {
            Message(' تم بنجاح حذف المحطة ومستخدمينها');
            //SetRecord($_REQUEST['Station'], 'INSERT', 'accounts',$AccountID,'');

        } else {
            Message(' لا يمكن حذف المحطة الرئيسية او المستخدم الرئيسي ');
        }
    }
}
?>

    <div class="ui container center aligned">
        <div class="ui segment">
            <div class="Title"> قـائـمـة الـمـحـطـات </div>
            <div class="ui Over">
                <div id="Data-Table-Wait" class="ui segment" style="display: none; width: 120px; height: 120px;">
                    <div class="ui active inverted dimmer">
                        <div class="ui text loader">Loading</div>
                    </div>
                    <p></p>
                </div>
                <div id="Data-Table" class="Data-Table">
                    <div class="Title" style="width: 100%"> لا تــوجــد بــيــانـــات للــعـــرض </div>
                </div>
            </div>
        </div>
        <?php require_once "Top/".$CurrentFile.".php"; ?>

        <form class="ui form" action="" autocomplete="off">
            <div id="stations">
                <div class="ui segment">
                    <div class="Flex-2">
                        <div class="Information_Item">
                            <label for="stc"> رمز المحطة </label>
                            <input type="search" name="stc" id="stc" onchange="{GetStationName(this.value); setTimeout(()=>{ STtName(''); },250);}" placeholder="رمز المحطة"  value="" class="Select _TOP_" style="min-width: 195px; cursor: pointer;" autocomplete="off">
                        </div>

                        <div class="Information_Item">
                            <label for="stn"> اسم المحطة </label>
                            <input type="search" name="stn" id="stn" oninput="this.value = this.value.toUpperCase();" placeholder="اسم المحطة"  value="" class="Select _TOP_" style="min-width: 195px; cursor: pointer;" autocomplete="off">
                        </div>

                        <div class="Information_Item">
                            <label for="$lat"> Latitude </label>
                            <input type="search" name="Latitude" id="$lat" placeholder="Latitude"  value="" class="Select _TOP_" style="min-width: 195px; cursor: pointer;" autocomplete="off">
                        </div>

                        <div class="Information_Item">
                            <label for="lon"> خط الطول </label>
                            <input type="search" name="lon" id="lon" placeholder="خط الطول"  value="" class="Select _TOP_" style="min-width: 195px; cursor: pointer;" autocomplete="off">
                        </div>

                        <div class="Information_Item">
                            <label for="hi"> ارتفاع المحطة </label>
                            <input type="search" name="hi" id="hi" placeholder="ارتفاع المحطة"  value="" class="Select _TOP_" style="min-width: 195px; cursor: pointer;" autocomplete="off">
                        </div>
                    </div>
                    <br><br>
                    <input class="ui red button large" type="submit" id="DeleteStation" name="DeleteStation" value="مسح محطة">
                    <input class="ui orange button large" type="submit" id="AddStation" name="AddStation" value="تعديل المحطة">
                    <input class="ui violet button large" type="submit" id="ResetStation" name="ResetStation" value="تنظيف الحقول" onclick="{event.preventDefault();document.querySelectorAll('#stations input[type=text]').forEach(el=>el.value='');}">
                </div>
            </div>
        </form>
    </div>


    <script>
        var $CurrentStation = <?=json_encode(array_values(GetCurrentStation()))?>;
    </script>

<?php
require_once "configuration/Footer.php";
?>