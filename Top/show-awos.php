<div class="ui container center aligned" id="Top">
    <div class="ui segment Station_Information">
        <input type="hidden" value="<?=_SESSION_('Account')?>" name="Account" id="Account">
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
    </div>
</div>