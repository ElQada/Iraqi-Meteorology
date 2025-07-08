<?php
$Title = "الرصد الساعي والميتار";
$CurrentFile = "courier";
require_once "configuration/Header.php";
?>

<script>
    var TestCloudsTable = <?=json_encode(MySqlX("SELECT CONCAT(`NH`,':',`CL`,':',`CM`,':',`CH`,'=>',`NS1`,':',`C1`,':',`HSHS1`,':',`NS2`,':',`C2`,':',`HSHS2`,':',`NS3`,':',`C3`,':',`HSHS3`) FROM `test_clouds`",[],7))?>;
    var TestWeatherTable = <?=json_encode(MySqlX("SELECT CONCAT(`VV`,':',`FF`,'=>',`WW`) FROM `test_weather`",[],7))?>;
</script>

<form class="ui form" autocomplete="off" method="POST">
    <?php require_once "Top/".$CurrentFile.".php"; ?>
    <div class="ui container center aligned ">
        <div class="ui segment">
            <h1 class="ui header"> الرصد الساعي السطحي </h1>
            <div style="padding-top: 7px" class="center _Center_">
                <table align="center">
                    <tr>
                        <td class="tbl_hd">IR</td>
                        <td class="tbl_hd">IX</td>
                        <td class="tbl_hd">h</td>
                        <td class="tbl_hd">VV</td>
                        <td class="tbl_hd">N</td>
                        <td class="tbl_hd">DD</td>
                        <td class="tbl_hd">FF</td>
                        <td class="tbl_hd">SN</td>
                        <td class="tbl_hd">TTT</td>
                        <td class="tbl_hd">SN</td>
                        <td class="tbl_hd">TDTDTD</td>
                        <td class="tbl_hd">P0P0P0P0</td>
                        <td class="tbl_hd">PPPP</td>
                        <td class="tbl_hd">a</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="ir" id="ir" maxlength="1" onkeyup="IR(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                        <td>
                            <input type="text" name="ix" id="ix" maxlength="1" onkeyup="IX(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                        <td>
                            <input type="text" name="h" id="h" maxlength="1" onkeyup="test_h(this)"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                        <td>
                            <input type="text" name="vv" id="vv" style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                        <td>
                            <input type="text" name="n" id="n" maxlength="1" onkeyup="nch(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                        <td>
                            <input type="text" name="dd" id="dd" maxlength="2" onkeyup="ddch(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                        <td>
                            <input type="text" name="ff" id="ff" maxlength="2" onkeyup="ffch(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                        <td>
                            <input type="text" name="sn1" id="sn1" maxlength="1" onkeyup="{sn1ch(this);}"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                        <td>
                            <input type="text" name="ttt" id="ttt" onkeyup="tttch(this);" onblur="TestTNTNTN()"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                        <td>
                            <input type="text" name="sn2" id="sn2" maxlength="1" onkeyup="{sn2ch(this);}"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                        <td>
                            <input type="text" name="tdtdtd" id="tdtdtd" onkeyup="tdtdtdch(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                        <td>
                            <!--  -->
                            <input type="text" name="p0p0p0p0" id="p0p0p0p0" maxlength="4" onkeyup="popopopoch(this);" style="border-top-left-radius: 0px;border-top-right-radius: 0px;  width: 102px;" required/>
                        </td>
                        <td>
                            <input type="text" name="pppp" id="pppp" maxlength="5" onkeyup="ppppch(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                        <td>
                            <input type="text" name="a" id="a" maxlength="1" onkeyup="ach(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                    </tr>
                    <tr>
                        <td class="tbl_hd">PPP</td>
                        <td class="tbl_hd">RRR</td>
                        <td class="tbl_hd">TR</td>
                        <td class="tbl_hd">WW</td>
                        <td class="tbl_hd">W1W2</td>
                        <td class="tbl_hd">NH</td>
                        <td class="tbl_hd">CL</td>
                        <td class="tbl_hd">CM</td>
                        <td class="tbl_hd">CH</td>
                        <td class="tbl_hd">1/2</td>
                        <td class="tbl_hd">SN</td>
                        <td class="tbl_hd" style="font-size: 10px; font-weight: 900;">TNTNTN / TXTXTX</td>
                        <td class="tbl_hd">E</td>
                        <td class="tbl_hd">SSS</td>

                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="ppp" id="ppp" maxlength="3" onkeyup="pppch(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                        <td>
                            <input type="text" name="rrr" id="rrr" maxlength="3" onkeyup="rrrch(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="tr" id="tr" maxlength="1" onkeyup="trch(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="ww" id="ww" style="border-top-left-radius: 0;border-top-right-radius: 0;" />
                        </td>
                        <td>
                            <input type="text" name="w1w2" id="w1w2" style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="nh" id="nh" maxlength="1" onkeyup="nhch(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="cl" id="cl" maxlength="1" onkeyup="clch(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="cm" id="cm" maxlength="1" onkeyup="CM(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="ch" id="ch" maxlength="1" onkeyup="chch(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="half" id="half" maxlength="1" onkeyup="NextFocus(this,'sn3',1);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="sn3" id="sn3" maxlength="1" onkeyup="sn3ch(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="tntntn" id="tntntn" onkeyup="tntntnch(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px; width: 102px;" />
                        </td>
                        <td>
                            <input type="text" name="e" maxlength="1" id="e" onkeyup="E(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="sss" id="sss" maxlength="3" onkeyup="SSS(this);"
                                style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                    </tr>
                    <tr>
                        <td class="tbl_hd">NS</td>
                        <td class="tbl_hd">C</td>
                        <td class="tbl_hd">HSHS</td>
                        <td class="tbl_hd">NS</td>
                        <td class="tbl_hd">C</td>
                        <td class="tbl_hd">HSHS</td>
                        <td class="tbl_hd">NS</td>
                        <td class="tbl_hd">C</td>
                        <td class="tbl_hd">HSHS</td>
                        <td class="tbl_hd">WB</td>
                        <td class="tbl_hd">RH</td>
                        <td class="tbl_hd">VP</td>
                        <td class="tbl_hd">MIN</td>
                        <td class="tbl_hd">MAX</td>

                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="ns1" id="ns1" maxlength="1" onkeyup="NS1(this)" style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="c1" id="c1" maxlength="1" onkeyup="{if(VarID('n') === 9 && VarID('h')==='/'){if(VarID('c1')!='/'){SetElementValue('c1')}else{NextFocus(this,'hshs1',1);}}else{NextFocus(this,'hshs1',1);}}" style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="hshs1" id="hshs1" onfocus="CX_HSHSX(1)" style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="ns2" id="ns2" maxlength="1" onkeyup="NextFocus(this,'c2',1);" style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="c2" id="c2" maxlength="1" onkeyup="NextFocus(this,'hshs2',1);" style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="hshs2" id="hshs2" onfocus="CX_HSHSX(2)" style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="ns3" id="ns3" maxlength="1" onkeyup="NextFocus(this,'c3',1);" style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>

                        <td>
                            <input type="text" name="c3" id="c3" maxlength="1" onkeyup="NextFocus(this,'hshs3',1);" style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="hshs3" id="hshs3" onfocus="CX_HSHSX(3)" style="border-top-left-radius: 0px;border-top-right-radius: 0px;" />
                        </td>
                        <td>
                            <input type="text" name="wb" id="wb" onkeyup="wbch(this);" style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                        <td>
                            <input type="text" name="rh" id="rh" maxlength="2" onkeyup="rhch(this);" style="border-top-left-radius: 0px;border-top-right-radius: 0px;" required/>
                        </td>
                        <td>
                            <input type="text" name="vp" id='vp' onkeyup="{vpch(this); SendCourier(event);}" style="border-top-left-radius: 0px;border-top-right-radius: 0px; width: 102px;" required/>
                        </td>
                        <td>
                            <input type="text" name="min" id="min" onkeyup="{minch(this); SendCourier(event,true);}" style="border-top-left-radius: 0px;border-top-right-radius: 0px;">
                        </td>
                        <td>
                            <input type="text" name="max" id="max" onkeyup="{maxch(this); SendCourier(event,true);}" style="border-top-left-radius: 0px;border-top-right-radius: 0px;">
                        </td>
                    </tr>
                </table>
                <div class="Online">
                    <input type="hidden" id="btnValue" name="">
                    <input type="button" value="تنظيف الحقول" name="ClearCourier" onclick="EmptyAll()" class="ui violet button">
                    <input type="submit" value="مسح الرصدة الساعية" name="DeleteCourier" id="DeleteCourier" class="ui red button large" disabled onclick="confirmDelete(event,'هل تريد مسح الرصد الساعي');">
                    <input type="submit" class="ui orange button large" name="UpdateCourier" id="UpdateCourier" value="تعديل الرصدة الساعية " disabled>
                    <input type="submit" value="أرسال الرصدة الساعية" class="ui green button large" id="InsertCourier" name="InsertCourier" disabled>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
if (isset($_REQUEST['File']))
{
    unset($_REQUEST['File']);
}
if (isset($_REQUEST['InsertCourier'])&&TestDate()) {
    unset($_REQUEST['InsertCourier']);
    if (isset($_REQUEST['Action']))
    {
        unset($_REQUEST['Action']);
    }
    if ( ((strlen(strval($_REQUEST['time']))===2)&&(strlen(strval($_REQUEST['date']))===10)&&(intval(strval($_REQUEST['time']))>=0)&&(intval(strval($_REQUEST['time']))<24)) && (($_REQUEST['date'] < date('Y-m-d')) || ($_REQUEST['date'] === date('Y-m-d') && intval($_REQUEST['time']) <= intval(date('H', strtotime('+15 minutes'))) ))){
        if ($ID = MySqlX("INSERT INTO `courier` ( " . join(',', array_keys($_REQUEST)) . " ) VALUES ( '" . join("','", array_values($_REQUEST)) . "')", [], 'K')) {
            Message(' تـم بـنـجـاح ارســـال الـرصــدة الـسـاعـيـة مـن الـمـحـطـة ');
            SetRecord($_REQUEST['Station'], 'INSERT', 'courier',$ID,'');
        }
    }
} elseif (isset($_REQUEST['UpdateCourier'])&&TestDate()) {
    unset($_REQUEST['UpdateCourier']);
    if (isset($_REQUEST['Action']))
    {
        unset($_REQUEST['Action']);
    }
    if (MySqlX("UPDATE `courier` SET " . join(' = ? , ', array_keys($_REQUEST)) . " = ? WHERE `Station` = ? AND `date` = ? AND `time` = ?", array_merge(array_values($_REQUEST), [$_REQUEST['Station'], $_REQUEST['date'], $_REQUEST['time']]), 'R')) {
        Message(' تـم بـنـجـاح تـعـديـل الـرصــدة الـسـاعـيـة فـى الـمـحـطـة ');
        SetRecord($_REQUEST['Station'], 'UPDATE', 'courier',MySqlX("SELECT `id` FROM `courier` WHERE `Station` = ? AND `date` = ? AND `time` = ?", [$_REQUEST['Station'], $_REQUEST['date'], $_REQUEST['time']], 0)['id'],'');
    }
} elseif (isset($_REQUEST['DeleteCourier'])&&TestDate()) {
    $Value = MySqlX("SELECT * FROM `courier` WHERE `Station` = ? AND `date` = ? AND `time` = ? LIMIT 1",[$_REQUEST['Station'], $_REQUEST['date'], $_REQUEST['time']], 0);
    if (MySqlX("DELETE FROM `courier` WHERE `Station` = ? AND `date` = ? AND `time` = ?", [$_REQUEST['Station'], $_REQUEST['date'], $_REQUEST['time']], 'R')) {
        Message(' تـم بـنـجـاح حــذف الـرصــدة الـسـاعـيـة مـن الـمـحـطـة ');
        SetRecord($_REQUEST['Station'], 'DELETE', 'courier',$Value['id'],json_encode($Value,256));
    }
}
require_once "configuration/Footer.php";
?>