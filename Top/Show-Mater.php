<div class="ui container center aligned" id="Top">
    <div class="ui segment Station_Information">
        <input type="hidden" value="<?=_SESSION_('Account')?>" name="Account" id="Account">
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
        <div class="Information_Item">
            <label for="date"> الـتـاريـخ </label>
            <input type="text" class="_TOP_" placeholder="Date" name="date" id="date" value="<?=_REQUEST_('date',$_SESSION['SelectDate'])?>" style="width: 110px;" onchange="{timech('Show-Mater'); STtName('Show-Mater');}" readonly/>
        </div>
        <div class="Information_Item">
            <label for="_date_"> مــن / الـى </label>
            <input type="text" class="_TOP_" name="_date_" value="<?php echo _REQUEST_('_date_',$_SESSION['SelectDate']); ?>" id="_date_" style="width: 110px;" readonly/>
        </div>
        <input type="hidden" name="page" id="Page" value="<?php echo _REQUEST_('page',1); ?>"/>
        <input type="hidden" name="limit" id="Limit" value="<?php echo _REQUEST_('limit',$Limit); ?>"/>
    </div>
</div>
