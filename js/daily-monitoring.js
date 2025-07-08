function windTimech(Selector)
{
    var v = $(Selector).val();
    if (v.length === parseInt($(Selector).attr("maxlength"))) {
        $(Selector).val(v.substr(0, 2) + ":" + v.substr(2, 2));
        FNext('windTime');
    }
}

function Daily(name,date)
{
  Request("Request/getst.php?Station=" + name,(Response) =>
  {
    if (Response) {
      SetElementValue(["StationCode", "Longitude", 'ElevationM'], [Response['StationCode'], Response['Longitude'], Response['ElevationM']]);
      SetElementValue(["stc", "stn", "Latitude", "$lat", "lon", 'hi'], [Response['StationCode'], Response['StationName'], Response['Latitude'], Response['Latitude'], Response['Longitude'], Response['ElevationM']]);
    }
    else
    {
      SetElementValue("StationCode");
    }

    $Save.Daily = {Response : Response, Name : name , Date : date};

    Request("Request/daily.php?Station=" + name+'&date='+date,(Response) =>
    {
      if (Response)
      {
        delete Response['date'];
        SetElementValue(Object.keys(Response),Object.values(Response),false);
        Disabled(['Delete','Edit'], false);
        Disabled(['Add'], true);
      }
      else
      {
        document.forms[0].reset.click();
        Disabled(['Delete','Edit'], true);
        Disabled(['Add'], false);
        if ($Save.Daily && $Save.Daily.Response)
        {
          SetElementValue(["Station","StationCode", "Longitude", 'ElevationM'], [$Save.Daily.Name, $Save.Daily.Response['StationCode'], $Save.Daily.Response['Longitude'], $Save.Daily.Response['ElevationM']]);
        }
      }
    });
  });
}

function $SetResultWind200(MSec = 1){
    setTimeout(()=>{
        SetElementValue('ResultWind200',parseFloat((parseInt(Math.abs(VarID('SecondWind200')-VarID('FirstWind200')).toString().substring(0,5))/10).toString()).toFixed(1));
    },MSec);
}
function SetResultWind200(Selector)
{
    if ($(Selector).val().length === 7) {
        if (VarID('FirstWind200') > VarID('SecondWind200')) {
            alert("خارج المدى");
            SetElementValue('FirstWind200');
            return;
        }
    }
    $SetResultWind200(10);
    $SetResultWind200(100);
    $SetResultWind200(1000);
}

function $SetResultWind50(MSec = 1){
    setTimeout(()=>{
        SetElementValue('ResultWind50',parseFloat((parseInt(Math.abs(VarID('SecondWind50')-VarID('FirstWind50')).toString().substring(0,5))/10).toString()).toFixed(1));
    },MSec);
}
function SetResultWind50(Selector)
{
    if ($(Selector).val().length === 7) {
        if (VarID('SecondWind50') < VarID('FirstWind50')) {
            alert("خارج المدى");
            SetElementValue("FirstWind50");
            return;
        }
    }
    $SetResultWind50(10);
    $SetResultWind50(100);
    $SetResultWind50(1000);
}

function matar()
{
    SetElementValue('ResultRain', (parseFloat((VarID('Rain18_06') + VarID('Rain06_18'))).toFixed(2).toString()).substring(0,5));
    Focus('_5cm00');
}

function mindaych(Selector, Limit = false)
{
    let Old = Selector.value;
    let New = TestFormatInput3(Old, 3).Return();
    Selector.value = New;
    var Run = Limit, ID = 'mindaych';

    if (!Limit) {
        if ($TimeOut.hasOwnProperty(ID)) {
            clearTimeout($TimeOut[ID]);
        }
        $TimeOut[ID] = setTimeout(() => {
            mindaych(Selector, true);
        }, ($Next * 6));
    }

    if (New !== Old || Run) {
        Run = false;

        if (New.includes('-') || New.includes('+')) {

            if (New.length === 5) {
                Run = true;
            }
        } else if (New.length === 4) {
            Run = true;
        }

        if (Run) {
            clearTimeout($TimeOut[ID]);
            Selector.value = parseFloat(New).toFixed(1);
            if (VarID('min_day') > 60 || VarID('min_day') < -20) {
                SetElementValue('min_day', '');
                swal({
                    title: ' الفيمة خارج المدى ',
                    // text: ' أدخــل قيمة اصغر من قيمة ال (  ttt  ) ',
                    icon: 'error',
                    button: 'مــوافــق'
                });
            }
            else {
                Focus('max_day', 1);
            }
        }
    }
}

function maxdaych(Selector, Limit = false)
{
    let Old = Selector.value;
    let New = TestFormatInput3(Old, 3).Return();
    Selector.value = New;
    var Run = Limit, ID = 'maxdaych';

    if (!Limit) {
        if ($TimeOut.hasOwnProperty(ID)) {
            clearTimeout($TimeOut[ID]);
        }
        $TimeOut[ID] = setTimeout(() => {
            maxdaych(Selector, true);
        }, ($Next * 6));
    }

    if (New !== Old || Run) {
        Run = false;

        if (New.includes('-') || New.includes('+')) {

            if (New.length === 5) {
                Run = true;
            }
        } else if (New.length === 4) {
            Run = true;
        }

        if (Run) {
            clearTimeout($TimeOut[ID]);
            Selector.value = parseFloat(New).toFixed(1);
            if (VarID('max_day') > 60 || VarID('max_day') < -20) {
                SetElementValue('max_day', '');
                swal({
                    title: ' الفيمة خارج المدى ',
                    // text: ' أدخــل قيمة اصغر من قيمة ال (  ttt  ) ',
                    icon: 'error',
                    button: 'مــوافــق'
                });
            }
            else {
                Focus('CannabisTemperature', 1);
            }
        }
    }
}

function DisableDates_daily(date) {
    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);

    return [$SetTimesOptions_daily.indexOf(string) == -1];
}

function ErrorTimesOptions_daily() {
    var Options = '',Count = 0;
    Object.keys($ErrorTimesOptions_daily).forEach((Day)=>{
        Options += `<option data-day="${Day}" value="${Day}">${Day}</option>`;
        Count++;
    })

    document.getElementById('ErrorDays').innerHTML = '<option disabled selected> Count : '+Count+'</option>'+Options;
}
function SetTimesOptions_daily() {
    var Options = '', Count = 0;

    let CurrentDate = PHP.CurrentDate.split('-'),DateFrom = PHP.MinDate, DateTo = PHP.MaxDate;

    if (PHP.Sesstion.per !== 'admin')
    {
        if (["26","27","28","29","30","31"].includes(CurrentDate[2]))
        {
            DateFrom = CurrentDate[0]+"-"+CurrentDate[1]+"-01";
            DateTo = CurrentDate;
        }
    }
    let List = DateFromTo(DateFrom,DateTo);
    List.pop();
    List.forEach((Day)=>{
        if (!$SetTimesOptions_daily.includes(Day))
        {
            Count++;
            Options += `<option data-day="${Day}" value="${Day}">${Day}</option>`;
        }
    });
    document.getElementById('SetTimes').innerHTML = '<option disabled selected> Count : '+Count+'</option>'+Options;

    if (PHP.Sesstion.per !== 'admin')
    {
        if (!Count)
        {
            SetElementValue('Message-TestMonth', '');
        }
        else
        {
            SetElementValue('Message-TestMonth', '<div class="ui red message">'+' تأكد من اكمال السجل الالكتروني لهذا الشهر '+'</div>');
        }
    }
}

window.addEventListener('DOMContentLoaded',()=>
{
    SetTimesOptions_daily();

    ErrorTimesOptions_daily();

    if ($ErrorTimesOptions_daily.hasOwnProperty(GetElementValue('date')))
    {
        $ErrorTimesOptions_daily[GetElementValue('date')].forEach(($Key)=>{
            document.getElementById($Key.toString()).style.backgroundColor = "#f19292";
        });
    }

    InputFormating('SunShine',3,1,null,'16',3,6,null,(ID,$Error,$Message)=> {
       if (!$Error)
       {
           let SunShine = parseFloat(GetElementValue('SunShine')).toFixed(1);
           if (SunShine.startsWith('0.'))
           {
               SunShine = parseFloat((parseInt(SunShine.substring(2))/10).toString()).toFixed(1);
           }
           SetElementValue('SunShine', SunShine);
       }
    });

    $Next = 350;
    ["_5cm00","_5cm06","_5cm12","_5cm18","Sur00","Sur06","Sur12","Sur18","5cm00","5cm06","5cm12","5cm18","10cm00","10cm06","10cm12","10cm18","20cm00","20cm06","20cm12","20cm18","50cm00","50cm06","50cm12","50cm18","100cm00","100cm06","100cm12","100cm18"].forEach((Key)=>{
        InputFormating(Key,3,1,null,70,2,null,null,(ID,$Error,$Message)=> {
            if (!$Error)
            {
                let $New = parseFloat(GetElementValue(Key)).toFixed(1);
                if ($New.startsWith('0.'))
                {
                    $New = parseFloat((parseInt($New.substring(2))/10).toString()).toFixed(1);
                }
                if (isNaN($New))
                {
                    $New = 0.0;
                }
                SetElementValue(Key, $New);
            }
        });
    });

    InputFormating('dd',3,0,null,'360');



        ['Station','date'].forEach((ID)=>{
            document.getElementById(ID).addEventListener('change',()=>{
                Daily(GetElementValue('Station'),GetElementValue('date'));
            });
        });

        setTimeout(() =>
        {
            Daily(GetElementValue('Station'),GetElementValue('date'));
        },500);

        document.querySelectorAll('input').forEach((Element)=>{
            if (!Element.classList.contains('_TOP_'))
            {
                Element.addEventListener('keyup',()=>{
                    Element.value = Filter(Element.value,null,'x.X/-:+0123456789trace').Return();
                });
            }
        });

    ReloadFromPath();
    });

function timech(File)
{
    //  التواريخ الغير مسجلة
}