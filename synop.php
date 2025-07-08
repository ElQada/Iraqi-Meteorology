<?php
$Title = "مركز تجميع المعلومات";
$CurrentFile = "synop";
require_once "configuration/Header.php";
?>

<form class="ui form" autocomplete="off" method="get">
    <?php require_once "Top/".$CurrentFile.".php"; ?>

    <table align="center" style="width:96%">
        <tr>
            <td class='tbl_hd'>Synop</td>
        </tr>
        <tr>
            <td>
                <input type="text" name="synop" id="synop" style="width: 100%;text-align: start;text-align-last: start;font-size: 24px;padding: 20px;font-family: monospace;" required/>
            </td>
        </tr>
        <tr>
            <td>
                <div class="ui segment Station_Information" style="justify-content: flex-end;">
                    <div class="Information_Item">
                        <label> RH </label>
                        <input type="text" class="_TOP_"  id="RH" name="RH" maxlength="3" onkeyup="F_RH(this)" style="min-width: 100px;cursor: pointer;" required/>
                    </div>

                    <div class="Information_Item">
                        <label> Min </label>
                        <input type="text" class="_TOP_"  id="Min" name="Min" onkeyup="F_Min(this)" style="min-width: 100px;cursor: pointer;" required/>
                    </div>
                    <div class="Information_Item">
                        <label> Max </label>
                        <input type="text" class="_TOP_" id="Max" name="Max" onkeyup="F_Max(this)"  style="min-width: 100px;cursor: pointer;" required/>
                    </div>
                    <div class="Information_Item">
                        <label> RAIN </label>
                        <input type="text" class="_TOP_" id="RAIN" name="RAIN" onkeyup="F_RAIN()"  style="min-width: 140px;cursor: pointer;"/>
                    </div>
                    <div class="Information_Item">
                        <label> مـــلاحــظــات </label>
                        <input type="text" class="_TOP_" id="Notes" name="Notes" style="min-width: 220px;cursor: pointer;"/>
                    </div>

                    <div class="Information_Item">
                        <label> P0P0P0P0 </label>
                        <input type="text" class="_TOP_" id="P0P0P0P0" name="P0P0P0P0" maxlength="4" style="min-width: 100px;cursor: pointer;"/>
                    </div>

                    <div class="Information_Item">
                        <label> WB </label>
                        <input type="text" class="_TOP_" id="WB" name="WB" style="min-width: 100px;cursor: pointer;"/>
                    </div>
                    <div class="Information_Item">
                        <label> VP </label>
                        <input type="text" class="_TOP_" id="VP" name="VP" style="min-width: 100px;cursor: pointer;"/>
                    </div>

                </div>
            </td>
        </tr>
    </table>
    <div class="Online">
        <input type="hidden" id="btnValue" name="">
        <input type="button" value="تنظيف الحقول" name="ClearSynop" onclick="SynopEmpty();" class="ui violet button">
        <input type="submit" value="مسح من مركز تجميع المعلومات" name="DeleteSynop" id="DeleteSynop" class="ui red button large" disabled onclick="confirmDelete(event,'هل تريد المسح من مركز تجميع المعلومات');">
        <input type="submit" class="ui orange button large" name="UpdateSynop" id="UpdateSynop" value="تعديل على مركز تجميع المعلومات" disabled>
        <input type="submit" value="أرسال الى مركز تجميع المعلومات" class="ui green button large" id="InsertSynop" name="InsertSynop" disabled>
    </div>

</form>

<?php

$Station = $_SESSION['Station'];
$Account = $_SESSION['Account'];
$Monitor = _REQUEST_('name',_SESSION_('Monitor'));

if (isset($_REQUEST['InsertSynop'])&&TestDate())
{
    unset($_REQUEST['InsertSynop']);
    if ($ID = MySqlX("INSERT INTO `synop` (`synop`,`rh`,`min`,`max`,`RAIN`,`Notes`,`Station`,`name`,`Account`,`date`,`time`) VALUES (?,?,?,?,?,?,?,?,?,?,?)", [$_REQUEST['synop'],$_REQUEST['RH'],$_REQUEST['Min'],$_REQUEST['Max'],$_REQUEST['RAIN'],$_REQUEST['Notes'],$Station, $Monitor, $Account, $_REQUEST['date'], $_REQUEST['time']], 'K')) {
        Message(' تـم بـنـجـاح ارســـال البيانات الى مركز تجميع المعلومات ');
        $Synop = explode(' ',$_REQUEST['synop']);
        $Courier = [
            'Station'=>$Station, 'Account'=>$Account, 'name'=>"$Monitor@Synop", 'date'=>$_REQUEST['date'], 'time'=>$_REQUEST['time'],
            'P0P0P0P0'=>$_REQUEST['P0P0P0P0'],'WB'=>$_REQUEST['WB'],'VP'=>$_REQUEST['VP'],
            'E'=>'','SSS'=>'','IR'=>'','IX'=>'','H'=>'','VV'=>'','N'=>'','DD'=>'','FF'=>'','SN1'=>'','TTT'=>'','SN2'=>'', 'TDTDTD'=>'', 'PPPP'=>'','A'=>'', 'PPP'=>'',
            'RH'=>$_REQUEST['RH'],'min'=>$_REQUEST['Min'], 'max'=>$_REQUEST['Max'],

            'RRR'=>'', 'TR'=>'',
            'WW'=>'', 'W1W2'=>'',
            'NH'=>'', 'CL'=>'', 'CM'=>'', 'CH'=>'',
            'HALF'=>'', 'SN3'=>'', 'TNTNTN'=>'',
            'NS1'=>'', 'C1'=>'', 'HSHS1'=>'',
            'NS2'=>'', 'C2'=>'', 'HSHS2'=>'',
            'NS3'=>'', 'C3'=>'', 'HSHS3'=>'',
        ];
        /* -----------------------------------------------------------------------------------------------------------*/
        $Set  = [];
        $List = [];
        /* -----------------------------------------------------------------------------------------------------------*/
        if (isset($Synop[0]))
        {
            $Slot = $Synop[0];
            $Set[] = '-IR-IX-H-VV-';
            $Courier['IR'] = substr($Slot, 0, 1);
            $Courier['IX'] = substr($Slot, 1, 1);
            $Courier['H'] = substr($Slot, 2, 1);
            $Courier['VV'] = substr($Slot, 3, 2);
        }
        if (isset($Synop[1]))
        {
            $Slot = $Synop[1];
            $Set[] = '-N-DD-FF-';
            $Courier['N'] = substr($Slot, 0, 1);
            $Courier['DD'] = substr($Slot, 1, 2);
            $Courier['FF'] = substr($Slot, 3, 2);
        }
        if (isset($Synop[2])&&'1'==substr($Synop[2], 0, 1))
        {
            $Slot = $Synop[2];
            $Set[] = '-1-SN1-TTT-';
            $Courier['SN1'] = ((substr($Slot, 1, 1)=='0')?'+':'-');
            $Courier['TTT'] =  str_pad(number_format((intval(substr($Slot, 2, 3))/10),1,'.',''), 4, '0', STR_PAD_LEFT);
        }
        if (isset($Synop[3])&&'2'==substr($Synop[3], 0, 1))
        {
            $Slot = $Synop[3];
            $Set[] = '-2-SN2-TDTDTD-';
            $Courier['SN2'] = ((substr($Slot, 1, 1)=='0')?'+':'-');
            $Courier['TDTDTD'] =  str_pad(number_format((intval(substr($Slot, 2, 3))/10),1,'.',''), 4, '0', STR_PAD_LEFT);
        }
        if (isset($Synop[4])&&'4'==substr($Synop[4], 0, 1))
        {
            $Slot = $Synop[4];
            $Set[] = '-4-PPPP-';
            $Courier['PPPP'] =  str_pad(number_format((intval(str_replace('00','100',substr($Slot, 1, 2)).substr($Slot, 3, 2))/10),1,'.',''), 6, '0', STR_PAD_LEFT);
        }
        if (isset($Synop[5])&&'5'==substr($Synop[5], 0, 1))
        {
            $Slot = $Synop[5];
            $Set[] = '-5-A-PPP';
            $Courier['A'] = substr($Slot, 1, 1);
            $Courier['PPP'] = substr($Slot, 2, 3);
        }
        /* -----------------------------------------------------------------------------------------------------------*/
        if (in_array($_REQUEST['time'],['06','18',6,18]))
        {
            $List = [];
            if (isset($Synop[6])&&'6'==substr($Synop[6], 0, 1))
            {
                $Slot = $Synop[6];
                $Set[] = '-6-RRR-TR';
                $Courier['RRR'] = substr($Slot, 1, 3);
                $Courier['TR'] = substr($Slot, 4, 1);
                $List = [7];
            }
            else
            {
                $List = [6,7];
            }

            foreach ($List as $Index)
            {
                if ($Courier['IX'] == '1'&&isset($Synop[$Index])&&'7'==substr($Synop[$Index], 0, 1))
                {
                    $Slot = $Synop[$Index];
                    $Set[] = '-7-WW-W1W2';
                    $Courier['WW'] = substr($Slot, 1, 2);
                    $Courier['W1W2'] = substr($Slot, 3, 2);
                }
            }

            $Last = 5;
            if ($Courier['N'] != '0')
            {
                $_333_ = 5;
                foreach ([6,7,8,9,10,11,12,13,14] as $Index)
                {
                    if (isset($Synop[$Index])&&$Synop[$Index] == '333')
                    {
                        $Set[] = '-333';
                        $_333_ = $Index;
                    }
                }

                foreach ([6,7,8,9,10,11,12,13,14] as $Index)
                {
                    if ($Index < $_333_ && isset($Synop[$Index])&&'8'==substr($Synop[$Index], 0, 1))
                    {
                        $Slot = $Synop[$Index];
                        $Set[] = '-8-NH-CL-CM-CH';
                        $Courier['NH'] = substr($Slot, 1, 1);
                        $Courier['CL'] = substr($Slot, 2, 1);
                        $Courier['CM'] = substr($Slot, 3, 1);
                        $Courier['CH'] = substr($Slot, 4, 1);
                    }
                }

                foreach ([6,7,8,9,10,11,12,13,14] as $Index)
                {
                    if ($Index > $_333_ && isset($Synop[$Index])&&'8'==substr($Synop[$Index], 0, 1))
                    {
                        $Slot = $Synop[$Index];
                        $Set[] = '-8-NH-CL-CM-CH';
                        $Courier['NH'] = substr($Slot, 1, 1);
                        $Courier['CL'] = substr($Slot, 2, 1);
                        $Courier['CM'] = substr($Slot, 3, 1);
                        $Courier['CH'] = substr($Slot, 4, 1);
                    }
                }

                $Last = $_333_;
                $S1   = false;
                $S2   = false;
                $S3   = false;
                foreach ([6,7,8,9,10,11,12,13,14] as $Index)
                {
                    if ($Index > $Last && !$S1 && isset($Synop[$Index])&&'8'==substr($Synop[$Index], 0, 1))
                    {
                        $Slot = $Synop[$Index];
                        $Set[] = '-8-NS1-C1-HSHS1';
                        $Courier['NS1'] = substr($Slot, 1, 1);
                        $Courier['C1'] = substr($Slot, 2, 1);
                        $Courier['HSHS1'] = substr($Slot, 3, 2);
                        $Last = $Index;
                        $S1   = true;
                    }
                }

                foreach ([6,7,8,9,10,11,12,13,14] as $Index)
                {
                    if ($Index > $Last && $S1 && !$S2 && isset($Synop[$Index])&&'8'==substr($Synop[$Index], 0, 1))
                    {
                        $Slot = $Synop[$Index];
                        $Set[] = '-8-NS2-C2-HSHS2';
                        $Courier['NS2'] = substr($Slot, 1, 1);
                        $Courier['C2'] = substr($Slot, 2, 1);
                        $Courier['HSHS2'] = substr($Slot, 3, 2);
                        $Last = $Index;
                        $S2   = true;
                    }
                }

                foreach ([6,7,8,9,10,11,12,13,14] as $Index)
                {
                    if ($Index > $Last && $S1 && $S2 && !$S3 && isset($Synop[$Index])&&'8'==substr($Synop[$Index], 0, 1))
                    {
                        $Slot = $Synop[$Index];
                        $Set[] = '-8-NS13-C3-HSHS3';
                        $Courier['NS3'] = substr($Slot, 1, 1);
                        $Courier['C3'] = substr($Slot, 2, 1);
                        $Courier['HSHS3'] = substr($Slot, 3, 2);
                        $Last = $Index;
                        $S3   = true;
                    }
                }
            }

            foreach ([6,7,8,9,10,11,12,13,14] as $Index)
            {
                if ($Index > $Last && isset($Synop[$Index]) && in_array(substr($Synop[$Index], 0, 1),['1','2',1,2]) && in_array(substr($Synop[$Index], 1, 1),['0','1',0,1]))
                {
                    $Slot = $Synop[$Index];
                    $Set[] = '-HALF-SN3-TNTNTN';
                    $Courier['HALF'] = substr($Slot, 0, 1);
                    $Courier['SN3'] = ((substr($Slot, 1, 1)=='0')?'+':'-');
                    $Courier['TNTNTN'] =  str_pad(number_format((intval(substr($Slot, 2, 3))/10),1,'.',''), 4, '0', STR_PAD_LEFT);
                }
            }
        }
        else
        {
            foreach ([6,7,8,9,10,11,12,13,14] as $Index)
            {
                if ($Courier['IX'] == '1'&&isset($Synop[$Index])&&'7'==substr($Synop[$Index], 0, 1))
                {
                    $Slot = $Synop[$Index];
                    $Set[] = '-7-WW-W1W2';
                    $Courier['WW'] = substr($Slot, 1, 2);
                    $Courier['W1W2'] = substr($Slot, 3, 2);
                }

                if (isset($Synop[$Index])&&'8'==substr($Synop[$Index], 0, 1))
                {
                    $Slot = $Synop[$Index];
                    $Set[] = '-8-NH-CL-CM-CH';
                    $Courier['NH'] = substr($Slot, 1, 1);
                    $Courier['CL'] = substr($Slot, 2, 1);
                    $Courier['CM'] = substr($Slot, 3, 1);
                    $Courier['CH'] = substr($Slot, 4, 1);
                }
            }
        }

        if ($ID = MySqlX("INSERT INTO `courier` ( " . join(',', array_keys($Courier)) . " ) VALUES ( '" . join("','", array_values($Courier)) . "')", [], 'K')) {
            SetRecord($_REQUEST['Station'], 'INSERT', 'courier',$ID,'');
        }

        SetRecord($Station, 'INSERT', 'synop',$ID,'');

    }
}
elseif (isset($_REQUEST['UpdateSynop'])&&TestDate())
{
    unset($_REQUEST['UpdateSynop']);
    if (MySqlX("UPDATE `synop` SET `synop` = ?, `rh` = ?, `min` = ?, `max` = ?, `RAIN` = ?, `Notes` = ?, `name` = ? WHERE `Station` = ? AND `date` = ? AND `time` = ?", [$_REQUEST['synop'],$_REQUEST['RH'],$_REQUEST['Min'],$_REQUEST['Max'],$_REQUEST['RAIN'],$_REQUEST['Notes'], $Monitor, $Station, $_REQUEST['date'], $_REQUEST['time']], 'R')) {
        Message(' تـم بـنـجـاح تـعـديـل البيانات داخل مركز تجميع المعلومات ');
        SetRecord($Station, 'UPDATE', 'synop',MySqlX("SELECT `id` FROM `synop` WHERE `Station` = ? AND `date` = ? AND `time` = ?", [$Station, $_REQUEST['date'], $_REQUEST['time']], 0)['id'],'');
    }
} elseif (isset($_REQUEST['DeleteSynop'])&&TestDate()) {
    $Value = MySqlX("SELECT * FROM `synop` WHERE `Station` = ? AND `date` = ? AND `time` = ? LIMIT 1", [$Station, $_REQUEST['date'], $_REQUEST['time']], 0);
    if (MySqlX("DELETE FROM `synop` WHERE `Station` = ? AND `date` = ? AND `time` = ?", [$Station, $_REQUEST['date'], $_REQUEST['time']], 'R')) {
        Message(' تـم بـنـجـاح حــذف البيانات من مركز تجميع المعلومات ');
        SetRecord($Station, 'DELETE', 'synop', $Value['id'], json_encode($Value,256));
    }
}
?>


<?php
require_once "configuration/Footer.php";
?>