<div class="Station_Information">
    <input type="hidden" value="<?=_SESSION_('Account')?>" name="Account" id="Account">
    <input type="button" onclick="CurrentRange()" name="clicked" value="  الـفـتـره كـامـلـة " class="ui orange button large" style="display: none;">
    <div class="Information_Item">
        <label for="_date_"> إلـى </label>
        <input type="text" class="_TOP_" name="_date_" value="<?php echo _REQUEST_('_date_',$_SESSION['SelectDate']); ?>" id="_date_" style="width: 140px;" readonly/>
    </div>
    <div class="Information_Item">
        <label for="date"> مــن </label>
        <input type="text" class="_TOP_" placeholder="Date" name="date" id="date" value="<?=_REQUEST_('date',$_SESSION['SelectDate'])?>" style="width: 140px;" onchange="{timech('show-daily'); STtName('show-daily');}" readonly/>
    </div>
    <input type="button" onclick="CurrentMonth()" name="clicked" value="  الـشـهـر الـحـالي " class="ui blue button large" style="display: none;">
    <input type="button" onclick="CurrentDay()" name="clicked" value="  الـيــوم الـحـالي " class="ui green button large" style="display: none;">
</div>