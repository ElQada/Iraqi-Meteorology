function timech(File)
{

}

function SelectStationManage(ID,Callback = null) {
    SetElementValue('Station',ID);
    setTimeout(()=>
    {
        STtName('manage-stations');
        if (typeof Callback === 'function')
        {
            setTimeout(Callback,123);
        }
    },123);
}

if ($CurrentStation)
{
    $CurrentStation.forEach((Row)=>{
        Row['Manage'] = `<div class="Flex-2">`;
        Row['Manage'] += `<a target="_self" href="${CurrentLink}/manage-accounts.php?FilterStation=${Row['StationCode']}"> <div class="ui blue button"> الموظفين </div> </a>`;
        Row['Manage'] += `<a target="_self" href="${CurrentLink}/reports.php?SelectStation=${Row['id']}"> <div class="ui orange button"> التقارير </div> </a>`;
        Row['Manage'] += `<a target="_self" href="${CurrentLink}/history.php?SelectStation=${Row['id']}&Account=${PHP.Sesstion.Account}&Station=${Row['Station']}&date=${PHP.MinDate}&_date_=${PHP.MaxDate}&page=1&limit=600&RefreshData=++تـحـديـث+المـعلـومات+&SelectKey=الحضور والإنصراف"> <div class="ui default button">  الـحـضـور  </div> </a>`;
        Row['Manage'] += `<a target="_self" href="${CurrentLink}/history.php?SelectStation=${Row['id']}&Account=${PHP.Sesstion.Account}&Station=${Row['id']}&date=${PHP.MinDate}&_date_=${PHP.MaxDate}&page=1&limit=600&RefreshData=++تـحـديـث+المـعلـومات+"> <div class="ui violet button"> الـسـجـل </div> </a>`;
        if (PHP.Sesstion.Role === 'admin')
        {
            Row['Manage'] += `<a target="_self" href="#Top" onclick="SelectStationManage('${Row['id']}');"> <div class="ui green button"> تـعـديـل </div> </a>`;
        }
        Row['Manage'] += `</div>`;
    });

    ElqadaDataTable.$Page.Order = [0,'DESC'];

    ElqadaDataTable.ID('DataTable').Name('قائمة الـمـحـطـات').Element('Data-Table').Length({"200":200,"400":400}).Rename({
        'StationName':'Station','StationCode':'Code','id':'ID',"Manage":"الإدارة"
    }).KeyValue(true).Data($CurrentStation).Keys(['id','StationName','StationCode','Longitude','Latitude','ElevationM','Manage']);

    ElqadaDataTable.CreatedRow = function (Row,Data,Index) {
        Row.addEventListener('click',()=>{ SelectStationManage($CurrentStation[Index]['id']); });
    }

    ElqadaDataTable.Set(['Select', 'Reselect', 'Excel', 'PDF', 'Pint']);

}

window.addEventListener('DOMContentLoaded',()=>{
    if (PHP.Sesstion.Role != 'admin')
    {
        Disabled(['DeleteStation','AddStation','ResetStation'],true);
    }
});