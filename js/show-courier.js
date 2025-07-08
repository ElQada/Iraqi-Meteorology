function timech(File)
{

}

ElqadaDataTable.ID('DataTable').Name('تقرير الرصد الساعي').Element('Data-Table').Length({"200":200,"400":400}).Rename({
    'Range': 'الفترة',
    'Days': 'عدد الايام',
    'Count': 'عدد الرصدات',
    'Div': 'معدل القسمة',
    'name':'الراصد',
    'create_at':"تاريخ الاجراء",
    'date':'التاريخ',
    'time': 'Time',
    "min": "MIN",
    "max": "MAX"
}).Data($DataTable).Keys(['Station', 'Code', 'name','create_at', 'date', 'time', 'IR', 'IX', 'H', 'VV', 'N', 'DD', 'FF', 'SN1', 'TTT', 'SN2', 'TDTDTD', 'P0P0P0P0', 'PPPP', 'A', 'PPP', 'RRR', 'TR', 'WW', 'W1W2', 'NH', 'CL', 'CM', 'CH', 'HALF', 'SN3', 'TNTNTN', 'E', 'SSS', 'NS1', 'C1', 'HSHS1', 'NS2', 'C2', 'HSHS2', 'NS3', 'C3', 'HSHS3', 'WB', 'RH', 'VP', 'min', 'max', 'Error']);

ElqadaDataTable.CreatedRow = function (Row,Data,Index) {
    Row.addEventListener('dblclick',()=>{ open(`${CurrentLink}/courier.php${ElqadaDataTable.$Data[Index]['Link']}`,"mozillaWindow", "popup"); });
}

if (PHP.Sesstion.per === 'admin')
{
    ElqadaDataTable.Report({
        "$G@0": ['Station', 'Day', 'Month', 'Year', 'time'],
        "$G@1": ['IR', 'IX', 'H', 'VV', 'N', 'DD', 'FF'],
        "$G@2": ['SN1', 'TTT', 'SN2', 'TDTDTD', 'P0P0P0P0', 'PPPP'],
        "$G@3": ['A', 'PPP', 'RRR', 'TR', 'WW', 'W1W2'],
        "$G@4": ['NH', 'CL', 'CM', 'CH', 'HALF', 'SN3'],
        "$G@5": ['TNTNTN', 'E', 'SSS', 'NS1', 'C1', 'HSHS1'],
        "$G@6": ['NS2', 'C2', 'HSHS2', 'NS3', 'C3'],
        "$G@7": ['HSHS3', 'WB', 'RH', 'VP', 'min', 'max'],
    }).Set(['Select', 'Reselect', 'Excel', 'Report', 'Print']);
}
else
{
    ElqadaDataTable.Set(['Select', 'Reselect']);
}