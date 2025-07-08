function timech(File)
{

}

ElqadaDataTable.ID('DataTable').Name('تقرير الرصد اليومي').Element('Data-Table').Length({"200":200,"400":400}).Rename({
    'Range': 'الفترة',
    'Days': 'عدد الايام',
    'Count': 'عدد الرصدات',
    'Div': 'معدل القسمة',
    'name':'الراصد',
    'create_at':"تاريخ الاجراء",
    'date':'التاريخ',
    'ff': 'FF',
    'dd': 'DD',
    'windTime': 'WinTime',
    'min_day': 'MinDay',
    'max_day': 'MaxDay',
    'time':'Time',
}).KeyValue(true).Data($DataTable).Keys(['Station', 'Code', 'name', 'create_at','date', 'FirstWind50', 'SecondWind50', 'FirstWind200', 'SecondWind200', 'ResultWind50', 'ResultWind200', 'Rain06_18', 'Rain18_06', 'ResultRain', 'Sur00', 'Sur06', 'Sur12', 'Sur18', '_5cm00', '_5cm06', '_5cm12', '_5cm18', '5cm00', '5cm06', '5cm12', '5cm18', '10cm00', '10cm06', '10cm12', '10cm18', '20cm00', '20cm06', '20cm12', '20cm18', '50cm00', '50cm06', '50cm12', '50cm18', '100cm00', '100cm06', '100cm12', '100cm18', 'Evapration1', 'Evapration2', 'ResultEvapration', 'CannabisTemperature', 'SunShine', 'RetRadiation', 'ff', 'dd', 'windTime', 'min_day', 'max_day', 'Error']);

ElqadaDataTable.CreatedRow = function (Row,Data,Index) {
    Row.addEventListener('dblclick',()=>{ open(`${CurrentLink}/daily-monitoring.php${ElqadaDataTable.$Data[Index]['Link']}`,"mozillaWindow", "popup"); });
}

if (PHP.Sesstion.per === 'admin')
{
    ElqadaDataTable.Report({
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
    }).Set(['Select', 'Reselect', 'Excel', 'Report', 'Pint']);
}
else
{
    ElqadaDataTable.Set(['Select', 'Reselect']);
}