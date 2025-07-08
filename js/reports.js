var Rename = {},Report = {},Keys = {};

function timech(File)
{

}
/* -----------------------------------------------=[|=>|]  [|<=|]=--------------------------------------------------- */
function Delete(event,$Message)
{
    let Station = document.querySelector('#Station option[selected]').innerText;
    if (GetElementValue("StationCode").includes('['))
    {
        Station = GetElementValue("StationCode");
    }
    doubleConfirmDelete(event,$Message,[" Station : "+Station , " Date : "+GetElementValue('date')+" < = > "+GetElementValue('_date_')," Code : "+GetElementValue('StationCode')]);
}

if ($DataTable.length)
{
    Keys = Object.keys($DataTable[0]);
    ['Link'].forEach((Item)=>{
        let Index = Keys.indexOf(Item);
       if (Index>-1)
       {
           Keys.splice(Index,1);
       }
    });

    if (PHP.Request.hasOwnProperty('Courier') || PHP.Request.hasOwnProperty('CourierError'))
    {
        Rename = {
            'Range': 'الفترة',
            'Days': 'عدد الايام',
            'Count': 'عدد الرصدات',
            'Div': 'معدل القسمة',
            'name':'الراصد',
            'create_at':"تاريخ الاجراء",
            'update_at':"تاريخ التعديل",
            'date':'التاريخ',
            'time': 'Time',
            "min": "MIN",
            "max": "MAX"
        };

        Report = {
            "$G@0": ['Station', 'Day', 'Month', 'Year', 'time'],
            "$G@1": ['IR', 'IX', 'H', 'VV', 'N', 'DD', 'FF'],
            "$G@2": ['SN1', 'TTT', 'SN2', 'TDTDTD', 'P0P0P0P0', 'PPPP'],
            "$G@3": ['A', 'PPP', 'RRR', 'TR', 'WW', 'W1W2'],
            "$G@4": ['NH', 'CL', 'CM', 'CH', 'HALF', 'SN3'],
            "$G@5": ['TNTNTN', 'E', 'SSS', 'NS1', 'C1', 'HSHS1'],
            "$G@6": ['NS2', 'C2', 'HSHS2', 'NS3', 'C3'],
            "$G@7": ['HSHS3', 'WB', 'RH', 'VP', 'min', 'max'],
        };
        ElqadaDataTable.CreatedRow = function (Row,Data,Index) {
            Row.addEventListener('dblclick',()=>{ open(`${CurrentLink}/courier.php${ElqadaDataTable.$Data[Index]['Link']}`,"mozillaWindow", "popup"); });
        }
    }

    if (PHP.Request.hasOwnProperty('Daily') || PHP.Request.hasOwnProperty('DailyError'))
    {
        Rename = {
            'Range': 'الفترة',
            'Days': 'عدد الايام',
            'Count': 'عدد الرصدات',
            'Div': 'معدل القسمة',
            'name':'الراصد',
            'create_at':"تاريخ الاجراء",
            'update_at':"تاريخ التعديل",
            'date':'التاريخ',
            'ff': 'FF',
            'dd': 'DD',
            'windTime': 'WinTime',
            'min_day': 'MinDay',
            'max_day': 'MaxDay',
            'time':'Time',
        };

        Report = {
            "Info":['Station','Day','Month','Year'],
            "Wind50":['SecondWind50','FirstWind50','ResultWind50'],
            "Wind200":['SecondWind200','FirstWind200','ResultWind200'],
            "Rain":['Rain06_18', 'Rain18_06', 'ResultRain'],
            "+5CM":['_5cm00', '_5cm06', '_5cm12', '_5cm18'],
            "SUR" :['Sur00', 'Sur06', 'Sur12', 'Sur18'],
            "-5CM":['5cm00', '5cm06', '5cm12', '5cm18'],
            "-10CM":['10cm00', '10cm06', '10cm12', '10cm18'],
            "-20CM":['20cm00', '20cm06', '20cm12', '20cm18'],
            "-50CM":['50cm00', '50cm06', '50cm12', '50cm18'],
            "-100CM":['100cm00', '100cm06', '100cm12', '100cm18'],
            "Wind":['dd', 'windTime','ff'],
            "Evapration":['Evapration2','Evapration1', 'ResultEvapration'],
            "Result":['CannabisTemperature', 'SunShine', 'RetRadiation', 'min_day', 'max_day']
        };
        ElqadaDataTable.CreatedRow = function (Row,Data,Index) {
            Row.addEventListener('dblclick',()=>{ open(`${CurrentLink}/daily-monitoring.php${ElqadaDataTable.$Data[Index]['Link']}`,"mozillaWindow", "popup"); });
        }
    }

    ElqadaDataTable
        .ID('DataTable')
        .Data($DataTable)
        .Name($TableName)
        .Element('Data-Table')
        .Length({"200":200,"400":400})
        .Rename(Rename)
        .Keys(Keys)
    ;

    if(Object.keys(Report).length)
    {
        ElqadaDataTable.Report(Report).Set(['Select', 'Reselect', 'Excel', 'Report', 'Print']);
    }
    else
    {
        ElqadaDataTable.Report(Report).Set(['Select', 'Reselect', 'Excel', 'PDF', 'Print']);
    }
}

window.addEventListener('DOMContentLoaded',()=>{
    setTimeout(()=>{
        if (PHP.Request.hasOwnProperty('SelectStation'))
        {
            SetElementValue('Station',PHP.Request.SelectStation);
            timech('reports');
            STtName('reports');
        }
    },250);
});