function timech(File)
{

}

var Monthly = [], Daily = [];
$AllStations.forEach((List)=>{
    let RowMonthly = {Station: List.Station,Range:List.Range,Count:List.Count,Div:List.Div,'H':0, 'N':0, 'DD':0, 'FF':0, 'P0P0P0P0':0, 'PPPP':0, 'A':0, 'PPP':0, 'WB':0, 'RH':0, 'VP':0,'TTT':0,'TDTDTD':0};
    let RowDaily = {Station: List.Station,Range:'',Count:0,Div:24,'H':0, 'N':0, 'DD':0, 'FF':0, 'P0P0P0P0':0, 'PPPP':0, 'A':0, 'PPP':0, 'WB':0, 'RH':0, 'VP':0,'TTT':0,'TDTDTD':0};
    let DateList = [];
    List.Records.forEach((Record)=>{
        if(!DateList.includes(Record.date))
        {
            if (RowDaily['Range'])
            {
                [ 'H', 'N', 'DD', 'FF', 'P0P0P0P0', 'PPPP', 'A', 'PPP', 'WB', 'RH', 'VP','TTT','TDTDTD'].forEach((Key)=>{
                    if (!isNaN(RowDaily[Key]))
                    {
                        RowDaily[Key] = parseFloat(RowDaily[Key]/RowDaily['Div']).toFixed(2);
                    }
                    else
                    {
                        RowDaily[Key] = 0.00;
                    }
                });
                Daily.push(RowDaily);
            }
            DateList.push(Record.date);
            RowDaily = {Station: List.Station,Range:Record.date,Count:0,Div:24,'H':0, 'N':0, 'DD':0, 'FF':0, 'P0P0P0P0':0, 'PPPP':0, 'A':0, 'PPP':0, 'WB':0, 'RH':0, 'VP':0,'TTT':0,'TDTDTD':0};
        }
        RowDaily['Count']++;
        [ 'H', 'N', 'DD', 'FF', 'P0P0P0P0', 'PPPP', 'A', 'PPP', 'WB', 'RH', 'VP'].forEach((Key)=>{
            let Plus = parseInt(Record[Key]);
            if (!isNaN(Plus))
            {
                RowMonthly[Key] += Plus;
                RowDaily[Key] += Plus;
            }
        });
        ['SN1','SN2'].forEach((Key,Index)=>{
            let Set = ['TTT','TDTDTD'][Index], Plus = parseInt(Record[Set]);
            if (!isNaN(Plus))
            {
                if (Record[Key] === '+')
                {
                    RowMonthly[Set] += Plus;
                    RowDaily[Set] += Plus;

                }
                else
                {
                    RowMonthly[Set] -= Plus;
                    RowDaily[Set] -= Plus;
                }
            }
        });
    });
    [ 'H', 'N', 'DD', 'FF', 'P0P0P0P0', 'PPPP', 'A', 'PPP', 'WB', 'RH', 'VP','TTT','TDTDTD'].forEach((Key)=>{
        if (!isNaN(RowMonthly[Key]))
        {
            RowMonthly[Key] = parseFloat(RowMonthly[Key]/RowMonthly['Div']).toFixed(2);
        }
        else
        {
            RowMonthly[Key] = 0.00;
        }
    });
    if (RowDaily['Range'])
    {
        [ 'H', 'N', 'DD', 'FF', 'P0P0P0P0', 'PPPP', 'A', 'PPP', 'WB', 'RH', 'VP','TTT','TDTDTD'].forEach((Key)=>{
            if (!isNaN(RowDaily[Key]))
            {
                RowDaily[Key] = parseFloat(RowDaily[Key]/RowDaily['Div']).toFixed(2);
            }
            else
            {
                RowDaily[Key] = 0.00;
            }
        });
        Daily.push(RowDaily);
    }
    Monthly.push(RowMonthly);
});

if (Daily.length)
{
    ElqadaDataTable.$Page.Size = 'A3';
    ElqadaDataTable.CreatedRow = function (Row,Data,Index) {
        if (Daily[Index]['Div'] !== Daily[Index]['Count'])
        {
            Row.cells.item(0).style.backgroundColor = '#e13232';
            Row.cells.item(2).style.backgroundColor = '#e13232';
        }
    };
    ElqadaDataTable.PDFRow = function (Row,Index,Data) {
        if (Index && Daily[Index-1]['Div'] !== Daily[Index-1]['Count'])
        {
            Row[0].fillColor = "#e13232";
            Row[2].fillColor = "#e13232";
        }
    };
    ElqadaDataTable.ID('Stations-Day-Courier')
        .Name('المعدلات اليومية للرصد الساعي').Element('Day-Courier')
        .Rename({'Range':'الفترة','Days':'عدد الايام','Count':'عدد الرصدات','Div':'معدل القسمة'}).Data(Daily)
        .Keys(['Station','Range','Count','H', 'N', 'DD', 'FF', 'TTT', 'TDTDTD', 'P0P0P0P0', 'PPPP', 'A', 'PPP', 'WB', 'RH', 'VP'])
        .Length({"50":50,"100":100})
        .Set(['Select','Reselect','PDF','Excel','Print']);
}
if (Monthly.length)
{
    ElqadaDataTable.$Page.Size = 'A3';
    ElqadaDataTable.CreatedRow = function (Row,Data,Index) {
        if (Monthly[Index]['Div'] !== Monthly[Index]['Count'])
        {
            Row.cells.item(0).style.backgroundColor = '#e13232';
            Row.cells.item(2).style.backgroundColor = '#e13232';
        }
    };
    ElqadaDataTable.PDFRow = function (Row,Index,Data) {
        if (Index && Monthly[Index-1]['Div'] !== Monthly[Index-1]['Count'])
        {
            Row[0].fillColor = "#e13232";
            Row[2].fillColor = "#e13232";
        }
    };
    ElqadaDataTable.ID('Stations-Month-Courier')
        .Name('المعدلات الشهرية للرصد الساعي').Element('Month-Courier')
        .Rename({'Range':'الفترة','Days':'عدد الايام','Count':'عدد الرصدات','Div':'معدل القسمة'}).Data(Monthly)
        .Keys(['Station','Range','Count','H', 'N', 'DD', 'FF', 'TTT', 'TDTDTD', 'P0P0P0P0', 'PPPP', 'A', 'PPP', 'WB', 'RH', 'VP'])
        .Length({"50":50,"100":100})
        .Set(['Select','Reselect','PDF','Excel','Print']);
}