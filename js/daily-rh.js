function timech(File)
{

}

ElqadaDataTable.$Page.Size = 'A3';
ElqadaDataTable.$Page.Orientation = 'portrait';
var $RH = [];
var $Day = {}, $CurrentDay = '', $Values = [];
Object.keys($AllStations).forEach((Station)=>{
    let Year = $AllStations[Station]['Range'].split('-')[0];
    let Month = $AllStations[Station]['Range'].split('-')[1];
    $AllStations[Station]['Records'].forEach((Record)=>
    {
        let Row = {};
        Row['Station'] = $AllStations[Station]['StationName'];
        Row['Code']    = $AllStations[Station]['StationCode'];
        Row['Year']  = Year;
        Row['Month'] = Month;
        Row['Day'] = Record['date'].split('-')[2];
        Row['Hour'] = Record['time'];
        Row['RH'] = Record['RH'];
        Row['Description'] = '';
        if (!$Day.hasOwnProperty(Row['Station']))
        {
            $Day[Row['Station']] = {};
        }
        if (!$Day[Row['Station']].hasOwnProperty(Record['date']))
        {
            $Day[Row['Station']][Record['date']] = {Values:[],Records:[]};
        }
        $Day[Row['Station']][Record['date']].Values.push(Record['RH']);
        $Day[Row['Station']][Record['date']].Records.push(Row);
    });
});

Object.keys($Day).forEach((Station)=>{
    Object.keys($Day[Station]).forEach((Day)=>{
        let Length = $Day[Station][Day].Values.length;
        if (Length)
        {
            $Day[Station][Day].Values.sort();
            let Min = $Day[Station][Day].Values[0];
            let Max = $Day[Station][Day].Values[Length-1];
            $Day[Station][Day].Records.forEach((Row)=>{
                if (Row.RH.toString() === Min.toString())
                {
                    Row.Description = 'Min-RH-Daily';
                    $RH.push(Row);
                }
                else if((Min!==Max) && (Row.RH.toString() === Max.toString()))
                {
                    Row.Description = 'Max-RH-Daily';
                    $RH.push(Row);
                }
            });
        }
    });
});

ElqadaDataTable.ID('Stations-Daily-RH')
    .Name('المعدلات الشهرية للرصد اليومي').Element('Daily-RH')
    .Rename({'Year':'السنة','Month':'الشهر','Day':'اليوم'}).Data($RH)
    .Keys(['Station','Code','Year','Month','Day','Description','Hour','RH'])
    .Length({"50":50,"100":100})
    .Set(['Select','Reselect','PDF','Excel','Print']);
