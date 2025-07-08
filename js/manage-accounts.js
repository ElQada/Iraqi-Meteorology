let $UsersID = $Users.map((User)=>{ return User.id; })
let $UsersCode = $Users.map((User)=>{ return User.code; })

function timech() {

}

function TestID(User) {
    if (User == PHP.Sesstion.Account)
    {
        Disabled('DeleteAccounts',true);
        ReadOnly('AccountCode',true);
        SetElementValue('AddAccounts','تـعـديـل بـيـنـاتـى الان');
    }
    else
    {
        Disabled('DeleteAccounts',false);
        ReadOnly('AccountCode',false);
    }
    SetElementValue('AccountKey','');
}

function TestCode(Code) {
    if ($UsersCode.includes(Code))
    {
        SetElementValue('AddAccounts','تـعـديـل الـبـيـانـات');
        Disabled('DeleteAccounts',false);
    }
    else
    {
        Disabled('DeleteAccounts',true);
        SetElementValue('AddAccounts','أضافة الـبـيـانـات');
    }
}

function SelectUser(User = null)
{
    if (User == null)
    {
        User = VarID('User');
    }

    $Users.forEach(($User)=>{
        if ($User['id']==User)
        {
            SetElementValue(['AccountType','AccountName','AccountCode','Station'],[$User['per'],$User['user'],$User['code'],$User['StationID']]);
            timech('manage-stations');
            SetElementValue('Station',$User['StationID']);
            console.info($User);
            STtName('manage-stations');
            TestCode($User['code']);
            TestID(User);
        }
    });
}

if ($Users)
{
    $Users.forEach((Row)=>{
        let User = Row['id'];
        Row['StationID'] = Row['Station'];
        let SelectStation = '', Station = '';

        if (['Forecasting','Awos','admin'].includes(Row['per']))
        {
            Row['Station'] = Row['per'];
            Station = '*';
        }
        else if ($CurrentStation.hasOwnProperty(Row['Station']))
        {
            Station = Row['Station'];
            SelectStation = Station;
            Row['Station'] = $CurrentStation[Row['Station']]['StationName']+' @ '+$CurrentStation[Row['Station']]['StationCode'];
        }
        else
        {
            Station = Row['Station'];
            Row['Station'] = " المحطة غير مفعلة حاليا ";
        }

        Row['Manage'] = `<div class="Flex-2">`;
        Row['Manage'] += `<a target="_self" href="${CurrentLink}/history.php?UserCode=${Row['code']}&SelectStation=${SelectStation}&Account=${PHP.Sesstion.Account}&Station=${Station}&date=${PHP.MinDate}&_date_=${PHP.MaxDate}&page=1&limit=600&RefreshData=++تـحـديـث+المـعلـومات+&SelectType=تعديل"> <div class="ui orange button">  الـتـعـديـلات  </div> </a>`;
        Row['Manage'] += `<a target="_self" href="${CurrentLink}/history.php?UserCode=${Row['code']}&SelectStation=${SelectStation}&Account=${PHP.Sesstion.Account}&Station=${Station}&date=${PHP.MinDate}&_date_=${PHP.MaxDate}&page=1&limit=600&RefreshData=++تـحـديـث+المـعلـومات+&SelectType=حذف"> <div class="ui red button">  المحذوفات  </div> </a>`;
        Row['Manage'] += `<a target="_self" href="${CurrentLink}/history.php?UserCode=${Row['code']}&SelectStation=${SelectStation}&Account=${PHP.Sesstion.Account}&Station=${Station}&date=${PHP.MinDate}&_date_=${PHP.MaxDate}&page=1&limit=600&RefreshData=++تـحـديـث+المـعلـومات+"> <div class="ui default button">  الـسـجـل  </div> </a>`;
        Row['Manage'] += `<a target="_self" href="${CurrentLink}/history.php?UserCode=${Row['code']}&SelectStation=${SelectStation}&Account=${PHP.Sesstion.Account}&Station=${Station}&date=${PHP.MinDate}&_date_=${PHP.MaxDate}&page=1&limit=600&RefreshData=++تـحـديـث+المـعلـومات+&SelectKey=الحضور والإنصراف"> <div class="ui violet button">  الـحـضـور  </div> </a>`;
        Row['Manage'] += `<a target="_self" href="#Form" onclick="SelectUser('${Row['id']}');"> <div class="ui green button"> تـعـديـل </div> </a>`;
        Row['Manage'] += `</div>`;

        Row['per'] = '';

        if ($GetCurrentAccount.hasOwnProperty(User))
        {
            Row['per'] = ($GetCurrentAccount[User].replaceAll(' @ user',' @  مـوظـف ').replaceAll(' @ manager',' @  مـديـر ')).split('@').pop();
        }
        else if ($CurrentStation.hasOwnProperty(User)&&Row['per'] === '')
        {
            Row['per'] = $CurrentStation[User]['StationName'];
        }

    });

    ElqadaDataTable.$Page.Order = [0,'DESC'];

    ElqadaDataTable.ID('DataTable').Name('قائمة الـمـوظـفـيـن').Element('Data-Table').Length({"200":200,"400":400}).Rename({
        'user':'الأســــم','code':'Code','id':'ID','per':"الوظيفة","Manage":"الإدارة"
    }).KeyValue(true).Data($Users).Keys(['id','user','Station','code','per','Manage']);
    ElqadaDataTable.CreatedRow = function (Row,Data,Index) {
        Row.addEventListener('click',()=>{ SetElementValue('User',$Users[Index]['id']); setTimeout(()=>{ SelectUser(); },123); });
    }

    ElqadaDataTable.Set(['Select', 'Reselect', 'Excel', 'PDF', 'Pint']);
}


window.addEventListener('DOMContentLoaded',()=>{
    if (PHP.Sesstion.Role == 'user')
    {
        SetElementValue('User',PHP.Sesstion.Account); setTimeout(()=>{ SelectUser(); },123);
    }

    setTimeout(()=>{
        if (PHP.Request.hasOwnProperty('FilterStation'))
        {
            ElqadaDataTable.$Tables[ElqadaDataTable.$ID].Search(2,PHP.Request.FilterStation);
        }
    },250);


    document.getElementById('AccountCode').addEventListener('keyup',(Event)=>{
        TestCode(Event.target.value);
    });
});
// SelectStationManage