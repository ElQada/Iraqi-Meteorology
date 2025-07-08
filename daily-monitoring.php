<?php
  $Title = "الرصد اليومي";
  $CurrentFile = "daily-monitoring";
  require_once "configuration/Header.php";
  $Station = $_SESSION['Station'];
  $Account = $_SESSION['Account'];
  $Monitor = _REQUEST_('name',_SESSION_('Monitor'));

  if (intval($Station) && strval($Monitor)) {
      if ( isset( $_REQUEST[ 'Add' ] ) && TestDate())
      {
          $Execute = [_REQUEST_ ( 'FirstWind50' ) , _REQUEST_ ( 'SecondWind50' ) , _REQUEST_ ( 'FirstWind200' ) , _REQUEST_ ( 'SecondWind200' ) , _REQUEST_ ( 'ResultWind50' ) , _REQUEST_ ( 'ResultWind200' ) , _REQUEST_ ( 'Rain06_18' ) , _REQUEST_ ( 'Rain18_06' ) , _REQUEST_ ( 'ResultRain' ) , _REQUEST_ ( 'Sur00' ) , _REQUEST_ ( "Sur06" ) , _REQUEST_ ( "Sur12" ) , _REQUEST_ ( "Sur18" ) , _REQUEST_ ( '_5cm00' ) , _REQUEST_ ( '_5cm06' ) , _REQUEST_ ( '_5cm12' ) , _REQUEST_ ( '_5cm18' ) , _REQUEST_ ( '5cm00' ) , _REQUEST_ ( '5cm06' ) , _REQUEST_ ( '5cm12' ) , _REQUEST_ ( '5cm18' ) , _REQUEST_ ( '10cm00' ) , _REQUEST_ ( '10cm06' ) , _REQUEST_ ( '10cm12' ) , _REQUEST_ ( '10cm18' ) , _REQUEST_ ( '20cm00' ) , _REQUEST_ ( '20cm06' ) , _REQUEST_ ( '20cm12' ) , _REQUEST_ ( '20cm18' ) , _REQUEST_ ( '50cm00' ) , _REQUEST_ ( '50cm06' ) , _REQUEST_ ( '50cm12' ) , _REQUEST_ ( '50cm18' ) , _REQUEST_ ( '100cm00' ) , _REQUEST_ ( '100cm06' ) , _REQUEST_ ( '100cm12' ) , _REQUEST_ ( '100cm18' ) , _REQUEST_ ( 'Evapration1' ) , _REQUEST_ ( 'Evapration2' ) , _REQUEST_ ( 'ResultEvapration' ) , _REQUEST_ ( 'CannabisTemperature' ) , _REQUEST_ ( 'SunShine' ) , _REQUEST_ ( 'RetRadiation' ) , $Station , $Account , $Monitor , $_REQUEST['date'] , _REQUEST_ ( 'ff' ) , _REQUEST_ ( 'dd' ) , _REQUEST_ ( 'windTime' ) , _REQUEST_ ( 'min_day' ) , _REQUEST_ ( 'max_day' )];
          $Get = MySqlX ( "INSERT INTO `daily` (FirstWind50 ,  SecondWind50 ,  FirstWind200 ,  SecondWind200 ,  ResultWind50 , ResultWind200 ,  rain06_18 ,  rain18_06 ,  ResultRain ,  sur00 ,  sur06 ,  sur12 ,  sur18 ,  _5cm00 ,  _5cm06 ,  _5cm12 ,  _5cm18 , 5cm00 ,  5cm06 ,  5cm12 ,  5cm18 ,  10cm00 ,  10cm06 ,  10cm12 ,  10cm18 , 20cm00 ,  20cm06 ,  20cm12 ,  20cm18 , 50cm00 ,  50cm06 ,  50cm12 ,  50cm18 ,   100cm00 ,  100cm06 ,  100cm12 ,  100cm18 , Evapration1 ,  Evapration2 ,  ResultEvapration ,  CannabisTemperature ,  SunShine ,  RetRadiation,Station,Account,name,date ,ff,dd,windTime,min_day,max_day) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)" , $Execute , 'K' );
          if ($Get)
          {
              Message ( 'تم حفظ الرصدة اليومية' );
              SetRecord($Station, 'INSERT', 'daily',$Get,'');
          }
      }
      else if ( isset( $_REQUEST[ 'Edit' ] ) && TestDate() )
      {
          $Execute = [_REQUEST_ ( 'FirstWind50' ) , _REQUEST_ ( 'SecondWind50' ) , _REQUEST_ ( 'FirstWind200' ) , _REQUEST_ ( 'SecondWind200' ) , _REQUEST_ ( 'ResultWind50' ) , _REQUEST_ ( 'ResultWind200' ) , _REQUEST_ ( 'Rain06_18' ) , _REQUEST_ ( 'Rain18_06' ) , _REQUEST_ ( 'ResultRain' ) , _REQUEST_ ( 'Sur00' ) , _REQUEST_ ( "Sur06" ) , _REQUEST_ ( "Sur12" ) , _REQUEST_ ( "Sur18" ) , _REQUEST_ ( '_5cm00' ) , _REQUEST_ ( '_5cm06' ) , _REQUEST_ ( '_5cm12' ) , _REQUEST_ ( '_5cm18' ) , _REQUEST_ ( '5cm00' ) , _REQUEST_ ( '5cm06' ) , _REQUEST_ ( '5cm12' ) , _REQUEST_ ( '5cm18' ) , _REQUEST_ ( '10cm00' ) , _REQUEST_ ( '10cm06' ) , _REQUEST_ ( '10cm12' ) , _REQUEST_ ( '10cm18' ) , _REQUEST_ ( '20cm00' ) , _REQUEST_ ( '20cm06' ) , _REQUEST_ ( '20cm12' ) , _REQUEST_ ( '20cm18' ) , _REQUEST_ ( '50cm00' ) , _REQUEST_ ( '50cm06' ) , _REQUEST_ ( '50cm12' ) , _REQUEST_ ( '50cm18' ) , _REQUEST_ ( '100cm00' ) , _REQUEST_ ( '100cm06' ) , _REQUEST_ ( '100cm12' ) , _REQUEST_ ( '100cm18' ) , _REQUEST_ ( 'Evapration1' ) , _REQUEST_ ( 'Evapration2' ) , _REQUEST_ ( 'ResultEvapration' ) , _REQUEST_ ( 'CannabisTemperature' ) , _REQUEST_ ( 'SunShine' ) , _REQUEST_ ( 'RetRadiation' ) , _REQUEST_ ( 'ff' ) , _REQUEST_ ( 'dd' ) , _REQUEST_ ( 'windTime' ) , _REQUEST_ ( 'min_day' ) , _REQUEST_ ( 'max_day' ) , $Monitor , $Station,  $_REQUEST['date']];
          $Get     = MySqlX ( "UPDATE `daily` SET `FirstWind50` = ? , `SecondWind50` = ? , `FirstWind200` = ? , `SecondWind200` = ? , `ResultWind50` = ? , `ResultWind200` = ? , `rain06_18` = ? , `rain18_06` = ? , `ResultRain` = ? , `sur00` = ? , `sur06` = ? , `sur12` = ? , `sur18` = ? , `_5cm00` = ? , `_5cm06` = ? , `_5cm12` = ? , `_5cm18` = ? , `5cm00` = ? , `5cm06` = ? , `5cm12` = ? , `5cm18` = ? , `10cm00` = ? , `10cm06` = ? , `10cm12` = ? , `10cm18` = ? , `20cm00` = ? , `20cm06` = ? , `20cm12` = ? , `20cm18` = ? , `50cm00` = ? , `50cm06` = ? , `50cm12` = ? , `50cm18` = ? , `100cm00` = ? , `100cm06` = ? , `100cm12` = ? , `100cm18` = ? , `Evapration1` = ? , `Evapration2` = ? , `ResultEvapration` = ? , `CannabisTemperature` = ? , `SunShine` = ? , `RetRadiation` = ? , `ff` = ? , `dd` = ? , `windTime` = ?, `min_day` = ? , `max_day` = ? , `name` = ? WHERE `Station` = ? AND `date` = ? LIMIT 1" , $Execute , 'R' );
          if ( $Get )
          {
              Message ( 'تم تعديل الرصدة اليومية' );
              SetRecord($Station, 'UPDATE', 'daily',MySqlX("SELECT `id` FROM `daily` WHERE `Station` = ? AND `date` = ?", [$Station, $_REQUEST['date']], 0)['id'],'');
          }
      }
      else if ( isset( $_REQUEST[ 'Delete' ] ) && TestDate() )
      {
          $Value = MySqlX("SELECT * FROM `daily` WHERE `Station` = ? AND `date` = ? LIMIT 1", [$Station, $_REQUEST['date']], 0);
          $Get = MySqlX ( "DELETE FROM `daily` WHERE `Station` = ? AND `date` = ? LIMIT 1" , [ $Station ,$_REQUEST['date'] ] , 'R' );
          if ( $Get )
          {
              Message ( 'تم مسح الرصدة اليومية' );
              SetRecord($Station, 'DELETE', 'daily', $Value['id'], json_encode($Value,256));
          }
      }
  }
?>
  <form class="ui form" autocomplete="off" action="" method="POST">
      <?php require_once "Top/".$CurrentFile.".php"; ?>
    <div id="daily-body">
    <div id="Set_1" class="ui segment">
      <div class="ui container center aligned">
        <div class="ui segment">
          <h1 class="ui header">عدادات الرياح</h1>
          <table align="center">
            <tr>
              <td class="tbl_hd">القراءة الثانية 50</td>
              <td class="tbl_hd">القراءة الثانية 200</td>
            </tr>
            <tr>
              <td>
                <input type="text" pattern="[0-9]{7}" onkeyup="{FocusNext(this,7,'FirstWind50'); SetResultWind50(this);}" ondblclick="SetResultWind50(this);" maxlength="7" id="SecondWind50" name="SecondWind50" autocomplete="off"/>
              </td>
              <td>
                <input type="text" pattern="[0-9]{7}" id="SecondWind200" onkeyup="{FocusNext(this,7,'FirstWind200'); SetResultWind200(this);}"  ondblclick="SetResultWind200(this);" maxlength="7" name="SecondWind200" autocomplete="off"/>
              </td>
            </tr>
            <tr>
              <td class="tbl_hd">القراءة الاولى 50</td>
              <td class="tbl_hd">القراءة الاولى 200</td>
            </tr>
            <tr>
              <td>
                <input type="text" pattern="[0-9]{7}" id="FirstWind50" name="FirstWind50" maxlength="7" onkeyup="{FocusNext(this,7,'SecondWind200'); SetResultWind50(this); }" ondblclick="SetResultWind50(this);" autocomplete="off"/>
              </td>
              <td>
                <input type="text" pattern="[0-9]{7}" id="FirstWind200" name="FirstWind200" maxlength="7" onkeyup="{FocusNext(this,7,'Rain06_18'); SetResultWind200(this); }" ondblclick="SetResultWind200(this);" autocomplete="off"/>
              </td>
            </tr>
            <tr>
              <td class="tbl_hd">القراءة اليومية 50</td>
              <td class="tbl_hd">القراءة اليومية 200</td>
            </tr>
            <tr>
              <td><input type="text" id="ResultWind50" name="ResultWind50" autocomplete="off"/></td>
              <td><input type="text" id="ResultWind200" name="ResultWind200" autocomplete="off"/></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="ui container center aligned">
        <div class="ui segment">
          <h1 class="ui header">قياسات المطر</h1>
          <table align="center">
            <tr>
              <td class="tbl_hd">كمية المطر 18 - 06</td>
              <td class="tbl_hd">كمية المطر 06 - 18</td>
              <td class="tbl_hd">مجموع المطر 24 ساعة</td>
            </tr>
            <tr>
              <td>
                <input type="text" id="Rain06_18" name="Rain06_18" onkeyup="{if(!WriteTrace(event,this.id)){ this.value = FormatInput(this.id,this.value,3,()=>{ this.value = parseFloat(this.value); matar(); FNext(this.id);  }, 1).Return(); }}" autocomplete="off"/>
              </td>
              <td>
                <input type="text" id='Rain18_06' name='Rain18_06' onkeyup="{if(!WriteTrace(event,this.id)){ this.value = FormatInput(this.id,this.value,3,()=>{ this.value = parseFloat(this.value); matar(); },1).Return(); }}" autocomplete="off"/>
              </td>
              <td><input type="text" id="ResultRain" name="ResultRain" onkeyup="WriteTrace(event,this.id);" autocomplete="off"/></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="ui container center aligned">
      <div class="ui segment">

        <h1 class="ui header">قياسات اعماق التربة</h1>

        <h4>+5CM</h4>
        <table align="center">
          <tr>
            <td class="tbl_hd">00</td>
            <td class="tbl_hd">06</td>
            <td class="tbl_hd">12</td>
            <td class="tbl_hd">18</td>
          </tr>
          <tr>
            <td>
              <input type="text" id="_5cm00" name="_5cm00" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="_5cm06" name="_5cm06" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="_5cm12" name="_5cm12" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="_5cm18" name="_5cm18" autocomplete="off"/>
            </td>
          </tr>
        </table>
        <h4>SUR</h4>
        <table align="center">
          <tr>
            <td class="tbl_hd">00</td>
            <td class="tbl_hd">06</td>
            <td class="tbl_hd">12</td>
            <td class="tbl_hd">18</td>
          </tr>
          <tr>
            <td>
              <input type="text" id="Sur00" name="Sur00" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="Sur06" name="Sur06" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="Sur12" name="Sur12" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="Sur18" name="Sur18" autocomplete="off"/>
            </td>
          </tr>
        </table>
        <h4>-5CM</h4>
        <table align="center">
          <tr>
            <td class="tbl_hd">00</td>
            <td class="tbl_hd">06</td>
            <td class="tbl_hd">12</td>
            <td class="tbl_hd">18</td>
          </tr>
          <tr>
            <td>
              <input type="text" id="5cm00" name="5cm00" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="5cm06" name="5cm06" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="5cm12" name="5cm12" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="5cm18" name="5cm18" autocomplete="off"/>
            </td>
          </tr>
        </table>
        <h4>-10CM</h4>
        <table align="center">
          <tr>
            <td class="tbl_hd">00</td>
            <td class="tbl_hd">06</td>
            <td class="tbl_hd">12</td>
            <td class="tbl_hd">18</td>
          </tr>
          <tr>
            <td>
              <input type="text" id="10cm00" name="10cm00" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="10cm06" name="10cm06" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="10cm12" name="10cm12" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="10cm18" name="10cm18" autocomplete="off"/>
            </td>
          </tr>
        </table>
        <h4>-20CM</h4>
        <table align="center">
          <tr>
            <td class="tbl_hd">00</td>
            <td class="tbl_hd">06</td>
            <td class="tbl_hd">12</td>
            <td class="tbl_hd">18</td>
          </tr>
          <tr>
            <td>
              <input type="text" id="20cm00" name="20cm00" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="20cm06" name="20cm06" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="20cm12" name="20cm12" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="20cm18" name="20cm18" autocomplete="off"/>
            </td>
          </tr>
        </table>
        <h4>-50CM</h4>
        <table align="center">
          <tr>
            <td class="tbl_hd">00</td>
            <td class="tbl_hd">06</td>
            <td class="tbl_hd">12</td>
            <td class="tbl_hd">18</td>
          </tr>
          <tr>
            <td>
              <input type="text" id="50cm00" name="50cm00" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="50cm06" name="50cm06" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="50cm12" name="50cm12" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="50cm18" name="50cm18" autocomplete="off"/>
            </td>
          </tr>
        </table>
        <h4>-100CM</h4>
        <table align="center">
          <tr>
            <td class="tbl_hd">00</td>
            <td class="tbl_hd">06</td>
            <td class="tbl_hd">12</td>
            <td class="tbl_hd">18</td>
          </tr>
          <tr>
            <td>
              <input type="text" id="100cm00" name="100cm00" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="100cm06" name="100cm06" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="100cm12" name="100cm12" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="100cm18" name="100cm18" autocomplete="off"/>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div id="Set_2" class="ui segment">
      <div class="ui container center aligned">
        <div class="ui segment">

          <h1 class="ui header">التبخر اليومي</h1>
          <table align="center">
            <tr>
              <td class="tbl_hd">القراءة الثانية للتبخر</td>
              <td class="tbl_hd">القراءة الاولى للتبخر</td>
              <td class="tbl_hd">القراءة اليومية للتبخر</td>
            </tr>
            <tr>
              <td>
                <input type="text" id="Evapration2" name="Evapration2" onkeyup="{this.value=FormatInput('Evapration1',this.value,4,()=>{Focus('Evapration1',650); SetElementValue('Evapration2',parseFloat(VarID('Evapration2')).toFixed(1));}).Return();  }" autocomplete="off"/>
              </td>
              <td>
                <input type="text" id="Evapration1" name="Evapration1" onkeyup="{ this.value = FormatInput('ResultEvapration',this.value,4,()=>{ Focus('dd',650); SetElementValue('Evapration1',VarID('Evapration1'));}).Return(); SetElementValue('ResultEvapration',Math.abs((VarID('Evapration2') - VarID('Evapration1'))).toFixed(1)); } " autocomplete="off"/>
              </td>
              <td><input type="text" id="ResultEvapration" name="ResultEvapration" autocomplete="off"/></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="ui container center aligned">
        <div class="ui segment">
          <h1 class="ui header"> <small>  GMT  </small>  <span>  أعلى سرعة رياح اليومية  </span> </h1>
          <table align="center">
            <tr>
              <td class="tbl_hd">DD</td>
              <td class="tbl_hd">Time GMT</td>
              <td class="tbl_hd">FF</td>
            </tr>
            <tr>
              <td>
                <input type="text" id="dd" name="dd" autocomplete="off"/>
              </td>

              <td>
                <input type="text" id="windTime" name="windTime" maxlength="4" onkeyup="windTimech(this);" autocomplete="off"/>
              </td>

              <td>
                <input type="text" id="ff" name="ff" onkeyup="{this.value=FormatInput('ff',this.value,3,()=>{Focus('RetRadiation',1000);SetElementValue('ff',parseFloat(VarID('ff')).toFixed(1));}).Return();}" autocomplete="off"/>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="ui container center aligned">
      
      <div class="ui segment">
      <h1 class="ui header">قـيــاســات الـعـنـاصـر الـطـقـسـيـة الـيـومـيـة</h1>
        <table align="center">
          <tr>
            <td class="tbl_hd">الاشعاع الوارد</td>
            <td class="tbl_hd">سطوع الشمس (الساعة)</td>
            <td class="tbl_hd">درجة الحرارة الصغرى </td>
            <td class="tbl_hd">درجة الحرارى العظمى </td>
            <td class="tbl_hd">درجة حرارة الحشيش</td>
          </tr>
          <tr>
            <td>
              <input type="text" onkeyup="{this.value=FormatInput('RetRadiation',this.value,4,()=>{Focus('SunShine',1000);SetElementValue('RetRadiation',parseFloat(VarID('RetRadiation')).toFixed(1));}).Return();}" id="RetRadiation" name="RetRadiation" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="SunShine" name="SunShine" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="min_day" name="min_day" onkeyup="mindaych(this)" onblur="Validation( ( ( VarID('min_day') > VarID('max_day')) && VarID('max_day') !== '' ), 'min_day', 'ادخل قيمة اقل من القيمة العظمى')" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id="max_day" name="max_day" onkeyup="maxdaych(this)" onblur="Validation( ( ( VarID('min_day') > VarID('max_day')) && VarID('min_day') !== '' ), 'max_day', 'ادخل درجة الحرارة العظمي اعلى من درجة الحرارة الصغري')" autocomplete="off"/>
            </td>
            <td>
              <input type="text" id='CannabisTemperature' name='CannabisTemperature' onkeyup="{this.value=FormatInput('CannabisTemperature',this.value,3).Return(); if (this.value && this.value !== '-' ) SetElementValue('CannabisTemperature',parseFloat(VarID('CannabisTemperature')).toFixed(1)); }" autocomplete="off"/>
            </td>
          </tr>
        </table>
      </div>
    </div>
    </div>
      <div class="Online">
          <input type="hidden" id="btnValue" name="">
          <input type="reset" value="تنظيف الحقول" id="reset" onclick="{document.querySelectorAll('#daily-body input[type=text]').forEach((e)=>{e.style.backgroundColor='#fff'})}" class="ui violet button">
          <input type="submit" value="مسح الرصد اليومي" name="Delete" id="Delete" class="ui red button large" onclick="confirmDelete(event,'هل تريد مسح الرصد اليومي');" disabled>
          <input type="submit" value="تعديل الرصد اليومي" name="Edit" id="Edit" class="ui orange button large" disabled>
          <input type="submit" value="أرسال الرصد اليومي" name="Add" id="Add" class="ui green button large">
      </div>
  </form>
<?php

  require_once "configuration/Footer.php";
?>