function timech(File)
{

}
window.addEventListener('DOMContentLoaded',()=>{


});
var Stations = {},Tables = {}, ByDay = {NH: [], CL: [], CM: [], CH: []}, ByMonth = {NH: [], CL: [], CM: [], CH: []};


if ($Stations && $Stations.length)
{
    $Stations.forEach(($Station)=>{
        Stations[$Station.id] = $Station;
    });
}

if ($AllStations && $AllStations.length)
{
    $AllStations.forEach((MonthData)=>{
        let Station = MonthData.Station, Range = MonthData.Range;
        if(!Tables.hasOwnProperty(Station))
        {
            Tables[Station] = {};
        }
        if(!Tables[Station].hasOwnProperty(Range))
        {
            Tables[Station][Range] = {};
        }

        MonthData.Records.forEach((Row)=>{
            let Day = Row.date.slice(8);
            if(!Tables[Station][Range].hasOwnProperty(Day))
            {
                Tables[Station][Range][Day] = {NH: {}, CL: {}, CM: {}, CH: {}};
            }
            ['NH','CL','CM','CH'].forEach((Key)=>{
                let Value = Row[Key].toString();
                if (Value.length)
                {
                    if (!Tables[Station][Range][Day][Key].hasOwnProperty(Value))
                    {
                        Tables[Station][Range][Day][Key][Value] = [];
                    }
                    Tables[Station][Range][Day][Key][Value].push(Row.time);
                }
            });
        });
    });
}


Object.keys(Tables).forEach((Station)=>{
    var StationName = Stations[Station].StationName, Code = Stations[Station].StationCode;
    Object.keys(Tables[Station]).forEach((Range)=>{
        var Repeat = {NH: {}, CL: {}, CM: {}, CH: {}}, Year = Range.slice(0,-3) ,Month = Range.slice(5);
        Object.keys(Tables[Station][Range]).forEach((Day)=>{
            ['NH','CL','CM','CH'].forEach((Key)=>{
                Object.keys(Tables[Station][Range][Day][Key]).forEach((Value)=>{
                    let Count = Tables[Station][Range][Day][Key][Value].length;
                    if (!Repeat[Key].hasOwnProperty(Value))
                    {
                        Repeat[Key][Value] = Count;
                    }
                    else
                    {
                        Repeat[Key][Value] += Count;
                    }
                    ByDay[Key].push({Station:StationName,Code,Year,Month,Day,Value,Count});
                });
            });
        });
        ['NH','CL','CM','CH'].forEach((Key)=>{
           Object.keys(Repeat[Key]).forEach((Value)=>{
               ByMonth[Key].push({Station:StationName,Code,Year,Month,Value,Count:Repeat[Key][Value]});
           });
        });
    });
});

ElqadaDataTable.$Page.Size = 'A4';
ElqadaDataTable.$Page.Orientation = 'portrait';

['NH','CL','CM','CH'].forEach((Key)=>{
    if (ByDay[Key].length)
    {
        ElqadaDataTable.ID('Stations-Repeat-Clouds-ByDay-'+Key)
            .Name('تكرارات أرتفاع الغيوم [ اليومي ] ( '+Key+' )').Element('Repeat-Clouds-ByDay-'+Key).Data(ByDay[Key]).Rename({Value : Key, Count : 'عدد التكرار اليومي'})
            .Keys(['Station','Code','Year','Month','Day','Value','Count']).Length({"20":20,"40":40,"60":60,"80":80,"100":100})
            .Set(['Select','Reselect','PDF','Excel','Print']);
    }

    if (ByMonth[Key].length)
    {
        ElqadaDataTable.ID('Stations-Repeat-Clouds-ByMonth-'+Key)
            .Name('تكرارات أرتفاع الغيوم [ اليومي ] ( '+Key+' )').Element('Repeat-Clouds-ByMonth-'+Key).Data(ByMonth[Key]).Rename({Value : Key, Count : 'عدد التكرار الشهرية'})
            .Keys(['Station','Code','Year','Month','Value','Count']).Length({"20":20,"40":40,"60":60,"80":80,"100":100})
            .Set(['Select','Reselect','PDF','Excel','Print']);
    }
});
