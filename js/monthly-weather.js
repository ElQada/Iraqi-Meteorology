function timech(File)
{

}
/* ------------------------------------------------------------------------------------------------------------------ */
['WW'].forEach((Filed)=>{
    let $Day = [], $Month = {}, CurrentKey = '';
    Object.keys($AllStations).forEach((Station)=>{
        Object.keys($AllStations[Station]['Range']).forEach((Range)=>
        {
            let Year = Range.split('-')[0];
            let Month = Range.split('-')[1];
            let Days = new Set(), WW = new Set();
            $AllStations[Station]['Range'][Range][Filed].forEach((Row)=>{
                Row['Year']  = Year;
                Row['Month'] = Month;
                Row['Day'] = Row['Date'].split('-')[2];
                Row['Station'] = $AllStations[Station]['StationName'];
                Row['Code']    = $AllStations[Station]['StationCode'];
                Row['Daily'] = Row['Count'];
                Row['Monthly']    = 1;
                CurrentKey =  Range+"@"+Row['WW'];
                if (!$Month.hasOwnProperty(CurrentKey))
                {
                    $Month[CurrentKey] = {Station:$AllStations[Station]['StationName'],Code:$AllStations[Station]['StationCode'],Year,Month,'WW':Row['WW'],'Monthly':Row['Count'],'ByMonth':1};
                }
                else
                {
                    $Month[CurrentKey]['Monthly'] += Row['Count'];
                    $Month[CurrentKey]['ByMonth']++;
                }
                $Day.push(Row);
            });
        });
    });
    if ($Day.length)
    {
        ElqadaDataTable.$Page.Size = 'A3';
        ElqadaDataTable.$Page.Orientation = 'portrait';

        ElqadaDataTable.ID('Stations-Day-WW')
            .Name('قيمة التكرارات اليومية للجو الحاضر بالرصد الساعى').Element('Day-WW')
            .Rename({'Year':'السنة','Daily':"كم ساعة تكررت خلال اليوم",'Monthly':"عدد التكرارات اليومية",'Month':'الشهر','Day':'اليوم'}).Data($Day)
            .Keys(['Station','Code','Year','Month','Day','WW','Daily']) /* 'Monthly' */
            .Length({"50":50,"100":100})
            .Set(['Select','Reselect','PDF','Excel','Print']);

        ElqadaDataTable.ID('Stations-Month-WW')
            .Name('قيمة التكرارات الشهرية للجو الحاضر بالرصد الساعى').Element('Month-WW')
            .Rename({'Year':'السنة','Daily':"كم ساعة تكررت خلال اليوم",'Monthly':"كم ساعة تكررت خلال الشهر",'ByMonth':'كم يوم تكررت خلال الشهر','Month':'الشهر'}).Data(Object.values($Month))
            .Keys(['Station','Code','Year','Month','WW','Monthly','ByMonth'])
            .Length({"50":50,"100":100})
            .Set(['Select','Reselect','PDF','Excel','Print']);
    }
});
/* ------------------------------------------------------------------------------------------------------------------ */
['W1W2'].forEach((Filed)=>{
    let $Day = [], $Month = {}, CurrentKey = '';
    Object.keys($AllStations).forEach((Station)=>{
        Object.keys($AllStations[Station]['Range']).forEach((Range)=>
        {
            let Year = Range.split('-')[0];
            let Month = Range.split('-')[1];
            let Days = new Set(), W1W2 = new Set();
            $AllStations[Station]['Range'][Range][Filed].forEach((Row)=>{
                Row['Year']  = Year;
                Row['Month'] = Month;
                Row['Day'] = Row['Date'].split('-')[2];
                Row['Station'] = $AllStations[Station]['StationName'];
                Row['Code']    = $AllStations[Station]['StationCode'];
                Row['Daily'] = Row['Count'];
                Row['Monthly']    = 1;
                CurrentKey =  Range+"@"+Row['W1W2'];
                if (!$Month.hasOwnProperty(CurrentKey))
                {
                    $Month[CurrentKey] = {Station:$AllStations[Station]['StationName'],Code:$AllStations[Station]['StationCode'],Year,Month,'W1W2':Row['W1W2'],'Monthly':Row['Count'],'ByMonth':1};
                }
                else
                {
                    $Month[CurrentKey]['Monthly'] += Row['Count'];
                    $Month[CurrentKey]['ByMonth']++;
                }
                $Day.push(Row);
            });
        });
    });
    if ($Day.length)
    {
        ElqadaDataTable.$Page.Size = 'A3';
        ElqadaDataTable.$Page.Orientation = 'portrait';

        ElqadaDataTable.ID('Stations-Day-W1W2')
            .Name('قيمة التكرارات اليومية للجو الحاضر بالرصد الساعى').Element('Day-W1W2')
            .Rename({'Year':'السنة','Daily':"كم ساعة تكررت خلال اليوم",'Monthly':"عدد التكرارات اليومية",'Month':'الشهر','Day':'اليوم'}).Data($Day)
            .Keys(['Station','Code','Year','Month','Day','W1W2','Daily']) /* 'Monthly' */
            .Length({"50":50,"100":100})
            .Set(['Select','Reselect','PDF','Excel','Print']);

        ElqadaDataTable.ID('Stations-Month-W1W2')
            .Name('قيمة التكرارات الشهرية للجو الحاضر بالرصد الساعى').Element('Month-W1W2')
            .Rename({'Year':'السنة','Daily':"كم ساعة تكررت خلال اليوم",'Monthly':"كم ساعة تكررت خلال الشهر",'ByMonth':'كم يوم تكررت خلال الشهر','Month':'الشهر'}).Data(Object.values($Month))
            .Keys(['Station','Code','Year','Month','W1W2','Monthly','ByMonth'])
            .Length({"50":50,"100":100})
            .Set(['Select','Reselect','PDF','Excel','Print']);
    }
});
/* ------------------------------------------------------------------------------------------------------------------ */
['CannabisTemperature'].forEach((Filed)=>{
    let $Data = [];
    Object.keys($AllStations).forEach((Station)=>{
        Object.keys($AllStations[Station]['Range']).forEach((Range)=>{
            let Year = Range.split('-')[0];
            let Month = Range.split('-')[1];
            $AllStations[Station]['Range'][Range][Filed].forEach((Row)=>{
                Row['Year']  = Year;
                Row['Month'] = Month;
                Row['Station'] = $AllStations[Station]['StationName'];
                Row['Code']    = $AllStations[Station]['StationCode'];
                $Data.push(Row);
            });
        });
    });
    if ($Data.length)
    {
        ElqadaDataTable.$Page.Size = 'A4';
        ElqadaDataTable.$Page.Orientation = 'landscape';
        ElqadaDataTable.ID('Stations-Key-CannabisTemperature')
            .Name('قيمة التكرارات لدرجة حرارة الحشيش').Element('Key-CannabisTemperature')
            .Rename({'Range':'الفترة','Year':'السنة','Month':'الشهر','CannabisTemperature':'درجة حرارة الحشيش','Counter':'عدد التكرارات'}).Data($Data)
            .Keys(['Station','Code','Year','Month','CannabisTemperature','Counter'])
            .Length({"50":50,"100":100})
            .Set(['Select','Reselect','PDF','Excel','Print']);
    }
});
/* ------------------------------------------------------------------------------------------------------------------ */
let $Data = [];
['Min-TTT','Max-TTT','Min-Hour','Max-Hour','Min-Day','Max-Day','Min-RH','Max-RH','Min-Hour-FF','Max-Hour-FF','Min-FF','Max-FF','CannabisTemperature-Min','CannabisTemperature-Max'].forEach((Filed)=>{
    let $Keys =
        {
            'Min-TTT':'Lowest Monthly Dry Temperature','Max-TTT':'Highest Monthly Dry Temperature',
            'Min-FF':'Min-Daily-FF','Max-FF':'Max-Daily-FF',
            'Min-Day':'Min-Daily','Max-Day':'Max-Daily',
            'CannabisTemperature-Min':"Min-Daily-CannabisTemperature",
            'CannabisTemperature-Max':"Max-Daily-CannabisTemperature",
        };
    Object.keys($AllStations).forEach((Station) => {
        Object.keys($AllStations[Station]['Range']).forEach((Range)=>{
            let $Key = Filed;
            if ($Keys.hasOwnProperty(Filed))
            {
                $Key = $Keys[Filed];
            }
            let Row = {};
            Row['Station'] = $AllStations[Station]['StationName'];
            Row['Code'] = $AllStations[Station]['StationCode'];
            Row['Key'] = $Key;
            Row['Value'] = $AllStations[Station]['Range'][Range][Filed];
            if ($AllStations[Station]['Range'][Range].hasOwnProperty(Filed+'-Date'))
            {
                let $Timing = '<ul>';
                if ($AllStations[Station]['Range'][Range][Filed+'-Date'] instanceof Array)
                {
                    $AllStations[Station]['Range'][Range][Filed+'-Date'].forEach((_Date_)=>{
                        $Timing += "<br>\n"+`<li> | ${_Date_} | </li>`;
                    });
                }
                Row['Date And Time'] = $Timing + '<ul>';
            }
            else if ($AllStations[Station]['Range'][Range].hasOwnProperty(Filed+'-Date-Time'))
            {
                let $Timing = '<ul>';
                if ($AllStations[Station]['Range'][Range][Filed+'-Date-Time'] instanceof Array)
                {
                    $AllStations[Station]['Range'][Range][Filed+'-Date-Time'].forEach((_Data_)=>{
                        $Timing += "<br>\n"+`<li> | ${_Data_['date']} @ ${_Data_['time']} | </li>`;
                    });
                }
                Row['Date And Time'] = $Timing + '<ul>';
            }
            Row['Range'] = Range;
            $Data.push(Row);
        });
    });
});
if ($Data.length)
{
    ElqadaDataTable.$Page.Size = 'A3';
    ElqadaDataTable.$Page.Orientation = 'portrait';

    ElqadaDataTable.ID('Stations-Key-Value')
        .Name('قيم العناصر الطقسية').Element('Key-Value')
        .Rename({'Range':'الفترة','Year':'السنة','Key':'العناصر الطقسية','Value':'القيمة'}).Data($Data)
        .Keys(['Station','Code','Range','Key','Value','Date And Time'])
        .Length({"50":50,"100":100})
        .Set(['Select','Reselect','PDF','Excel','Print']);
}
/* ------------------------------------------------------------------------------------------------------------------ */
['DD'].forEach((Filed)=>{
    let $Data = [];
    Object.keys($AllStations).forEach((Station)=>{
        let $Total = {'Station':"Total @ "+$AllStations[Station]['StationName'],'Code':$AllStations[Station]['StationCode'],'Year':$PlusData.Year,'Month':$PlusData.From+' : '+$PlusData.To,'Northern':0,'Northeast':0,'East':0,'Southeast':0,'Southern':0,'Southwest':0,'Western':0,'Northwest':0,'Sleep':0,'Total':0};
        Object.keys($AllStations[Station]['Range']).forEach((Range)=>
        {
            let Year = Range.split('-')[0];
            let Month = Range.split('-')[1];
            $AllStations[Station]['Range'][Range][Filed].forEach((Row)=>{
                Row['Year']  = Year;
                Row['Month'] = Month;
                Row['Station'] = $AllStations[Station]['StationName'];
                Row['Code']    = $AllStations[Station]['StationCode'];
                ['Northern','Northeast','East','Southeast','Southern','Southwest','Western','Northwest','Sleep','Total'].forEach((K)=>{
                    $Total[K] += parseInt(Row[K]);
                });
                $Data.push(Row);
            });
        })
        if (Object.keys($AllStations[Station]['Range']).length > 1)
        {
            ['Northern','Northeast','East','Southeast','Southern','Southwest','Western','Northwest','Sleep'].forEach((K)=>{
                if ($Total[K])
                {
                    $Total[K] += " ["+Math.ceil((parseInt($Total[K])/parseInt($Total['Total'])*100))+"%] ";
                }
                else
                {
                    $Total[K] += " [00%] ";
                }
            });
            $Data.push($Total);
        }
    });
    if ($Data.length)
    {
        ElqadaDataTable.$Page.Size = 'A3';
        ElqadaDataTable.$Page.Orientation = 'landscape';
        ElqadaDataTable.CreatedRow = function (Row,Data,Index)
        {
            let Max = 0;
            for (let I = 0; I < Row.childElementCount-1; I++)
            {
                if (I>3&&I<13&&parseInt(Row.cells.item(I).innerText)>Max)
                {
                    Max = parseInt(Row.cells.item(I).innerText);
                }
            }

            for (let I = 0; I < Row.childElementCount-1; I++)
            {
                if (Max && parseInt(Row.cells.item(I).innerText)===Max)
                {
                    //row.cells.item(I).style.color = "#0a4eb1";
                    Row.cells.item(I).style.backgroundColor = "#83d997";
                }
            }

            if (ElqadaDataTable.$Tables['Stations-Key-DD'].$Data[Index]['Days'] !== ElqadaDataTable.$Tables['Stations-Key-DD'].$Data[Index]['Total'])
            {
                Row.cells.item(0).style.backgroundColor = '#e13232';
                Row.cells.item(13).style.backgroundColor = '#e13232';
            }
        }

        ElqadaDataTable.PDFRow = function (Row,RowIndex,Data)
        {
            let Max = 0;

            if (RowIndex)
            {
                if (ElqadaDataTable.$Tables['Stations-Key-DD'].$Data[RowIndex-1]['Days'] !== ElqadaDataTable.$Tables['Stations-Key-DD'].$Data[RowIndex-1]['Total'])
                {
                    Row[0].fillColor = '#e13232';
                    Row[13].fillColor = '#e13232';
                }
                Row.forEach(function (Cell,CellIndex) {
                    if (CellIndex>3&&CellIndex<13&&parseInt(Cell.text)>Max)
                    {
                        Max = parseInt(Cell.text);
                    }
                });
            }

            Row.forEach(function (Cell,CellIndex) {
                if (Max)
                {
                    if (parseInt(Cell.text)===Max)
                    {
                        Cell.fillColor = "#83d997";
                    }
                }
            });
        }

        ElqadaDataTable.ID('Stations-Key-DD')
            .Name('قيمة التكرارات اليومية لاتجاه الرياح بالرصد الساعى').Element('Key-DD')
            .Rename({'Year':'السنة','Month':'الشهر','Northern':'شمالي','Northeast':'شمالي شرقي','East':'شرقي','Southeast':'جنوبي شرقي','Southern':'جنوبي','Southwest':'جنوبى غربي','Western':'غربي','Northwest':'شمالي غربي','Sleep':'سكون'}).Data($Data)
            .Keys(['Station','Code','Year','Month','Northern','Northeast','East','Southeast','Southern','Southwest','Western','Northwest','Sleep','Total'])
            .Length({"50":50,"100":100})
            .Set(['Select','Reselect','PDF','Excel','Print']);
    }
});