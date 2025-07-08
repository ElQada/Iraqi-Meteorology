function timech(File)
{
}

if ($AllStations.length)
{
    $Data = [];
    $AllStations.forEach(($Fetch)=>{
        $Fetch.Records.forEach(($Record)=>{
            let SetData = {Station:$Fetch.Station,Date: $Fetch['Date']};
            ["Time","Min","Max","VV","DD","FF","RH","TTT","TDTDTD","TNTNTN"].forEach((K)=>{
                SetData[K] = $Record[K];
            });
            if ($Record.SN1.toString() === '-' && $Record.TTT.length)
            {
                SetData.TTT = '-'+$Record.TTT;
            }
            if ($Record.SN2.toString() === '-' && $Record.TDTDTD.length)
            {
                SetData.TDTDTD = '-'+$Record.TDTDTD;
            }
            if ($Record.SN3.toString() === '-' && $Record.TNTNTN.length)
            {
                SetData.TNTNTN = '-'+$Record.TNTNTN;
            }
            $Data.push(SetData);
        });
    });

    ElqadaDataTable.$Page.Size = 'A3';
    ElqadaDataTable.$Page.Orientation = 'portrait';
    ElqadaDataTable.ID('DataTable')
        .Name('درجات الحرارة اليومية').Element('Data-Table').Data($Data)
        .Keys(["Station","Date","Time","Min","Max","TNTNTN","VV","DD","FF","TTT","TDTDTD","RH"])
        .Set(['Select','Reselect','PDF','Excel','Print']);
}