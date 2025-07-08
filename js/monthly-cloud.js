function timech(File)
{

}
let ByMonth = [], ByDay = [], ByHour = [], CountMonthly = [];
if ($AllData.length)
{
    let Days = [],Record = {Count:0,date:'',Hours:0},Parts =
        [
            {Count:0,date:'',Hours:0},{Count:0,date:'',Hours:0},{Count:0,date:'',Hours:0},{Count:0,date:'',Hours:0},
            {Count:0,date:'',Hours:0},{Count:0,date:'',Hours:0},{Count:0,date:'',Hours:0},{Count:0,date:'',Hours:0}
        ], Part = null;

    $AllData.forEach(($Fetch,$K1)=>{
        $Fetch.ByTime.forEach(($Record)=>{
            [['00','01','02'],['03','04','05'],['06','07','08'],['09','10','11'],['12','13','14'],['15','16','17'],['18','19','20'],['21','22','23']].forEach(($Part,Key)=>{
                if ($Part.includes($Record.time))
                {
                    Part = Key;
                }
            });

            if (!Days.length)
            {
                Days.push($Record.date);
                Record = {Count:0,date:$Record.date,Hours:0};

                Parts = [
                    {Count:0,date:$Record.date,Hours:0},{Count:0,date:$Record.date,Hours:0},{Count:0,date:$Record.date,Hours:0},{Count:0,date:$Record.date,Hours:0},
                    {Count:0,date:$Record.date,Hours:0},{Count:0,date:$Record.date,Hours:0},{Count:0,date:$Record.date,Hours:0},{Count:0,date:$Record.date,Hours:0}
                ];
            }

            if (!Days.includes($Record.date))
            {

                Days.push($Record.date);
                $AllData[$K1].Records.push(Record);
                Parts.forEach(($Part)=>{ $AllData[$K1].Parts.push($Part); });
                Record = {Count:parseInt($Record.N),date:$Record.date,Hours:1};
                Parts = [
                    {Count:0,date:$Record.date,Hours:0},{Count:0,date:$Record.date,Hours:0},{Count:0,date:$Record.date,Hours:0},{Count:0,date:$Record.date,Hours:0},
                    {Count:0,date:$Record.date,Hours:0},{Count:0,date:$Record.date,Hours:0},{Count:0,date:$Record.date,Hours:0},{Count:0,date:$Record.date,Hours:0}
                ];
                Parts[Part].Hours++;
                Parts[Part].Count = parseInt($Record.N);
            }
            else
            {
                Record.Count += parseInt($Record.N);
                Record.Hours++;
                Parts[Part].Hours++;
                Parts[Part].Count = parseInt($Record.N);
            }
        });
    });
    $AllData.forEach(($Fetch)=>{
        let Count = 0,Classification = '',SetCount = 0, _SetCount_ = 0, $SetCount = 0;
        let FEW=0,SCT=0,BKN=0,OVC=0,CAVOK=0;
        $Fetch.Records.forEach(($Record)=>{
            Count += parseInt($Record.Count);

            $SetCount = (parseInt($Record.Count)/24);
            _SetCount_ = parseFloat($SetCount).toFixed(1);
            SetCount = Math.round($SetCount);

            if ([1,2].includes(SetCount))
            {
                Classification = 'FEW';
                FEW++;
            }
            else if ([3,4].includes(SetCount))
            {
                Classification = 'SCT';
                SCT++;
            }
            else if ([5,6,7].includes(SetCount))
            {
                Classification = 'BKN';
                BKN++;
            }
            else if (SetCount === 8)
            {
                Classification = 'OVC';
                OVC++;
            }
            else
            {
                Classification = 'CAVOK';
                CAVOK++;
            }

            ByDay.push({Station:$Fetch.Station,Code:$Fetch.Code,Year:$Fetch.Year,Month:$Fetch.Month,Day:$Record.date.split('-')[2],Count:_SetCount_,'Cloud Classification':Classification});
        });
        $SetCount = (parseInt(Count)/(parseInt($Fetch.Day)*24));
        _SetCount_ = parseFloat($SetCount).toFixed(1);
        SetCount = Math.round($SetCount);
        if ([1,2].includes(SetCount))
        {
            Classification = 'FEW';
        }
        else if ([3,4].includes(SetCount))
        {
            Classification = 'SCT';
        }
        else if ([5,6,7].includes(SetCount))
        {
            Classification = 'BKN';
        }
        else if (SetCount === 8)
        {
            Classification = 'OVC';
        }
        else
        {
            Classification = 'CAVOK';
        }

        CountMonthly.push({Station:$Fetch.Station,Code:$Fetch.Code,Year:$Fetch.Year,Month:$Fetch.Month,Day:$Fetch.Day,Count:FEW,'Cloud Classification':'FEW'});
        CountMonthly.push({Station:$Fetch.Station,Code:$Fetch.Code,Year:$Fetch.Year,Month:$Fetch.Month,Day:$Fetch.Day,Count:SCT,'Cloud Classification':'SCT'});
        CountMonthly.push({Station:$Fetch.Station,Code:$Fetch.Code,Year:$Fetch.Year,Month:$Fetch.Month,Day:$Fetch.Day,Count:BKN,'Cloud Classification':'BKN'});
        CountMonthly.push({Station:$Fetch.Station,Code:$Fetch.Code,Year:$Fetch.Year,Month:$Fetch.Month,Day:$Fetch.Day,Count:OVC,'Cloud Classification':'OVC'});
        CountMonthly.push({Station:$Fetch.Station,Code:$Fetch.Code,Year:$Fetch.Year,Month:$Fetch.Month,Day:$Fetch.Day,Count:CAVOK,'Cloud Classification':'CAVOK'});

        ByMonth.push({Station:$Fetch.Station,Code:$Fetch.Code,Year:$Fetch.Year,Month:$Fetch.Month,Day:$Fetch.Day,Count:_SetCount_,'Cloud Classification':Classification});
    });
    $AllData.forEach(($Fetch)=>{
        let Count = 0,Classification = '',SetCount = 0, _SetCount_ = 0, $SetCount = 0;
        $Fetch.Parts.forEach(($Record)=>{
            Count += parseInt($Record.Count);

            $SetCount = (parseInt($Record.Count)/4);
            _SetCount_ = parseFloat($SetCount).toFixed(1);
            SetCount = Math.round($SetCount);

            if ([1,2].includes(SetCount))
            {
                Classification = 'FEW';
            }
            else if ([3,4].includes(SetCount))
            {
                Classification = 'SCT';
            }
            else if ([5,6,7].includes(SetCount))
            {
                Classification = 'BKN';
            }
            else if (SetCount === 8)
            {
                Classification = 'OVC';
            }
            else
            {
                Classification = 'CAVOK';
            }

            ByHour.push({Station:$Fetch.Station,Code:$Fetch.Code,Year:$Fetch.Year,Month:$Fetch.Month,Day:$Record.date.split('-')[2],Count:_SetCount_,'Cloud Classification':Classification});
        });
    });

    if (ByHour.length)
    {
        ElqadaDataTable.$Page.Size = 'A3';
        ElqadaDataTable.$Page.Orientation = 'portrait';
        ElqadaDataTable.ID('Stations-Hour-Cloud')
            .Name('المعدلات    كل 3 ساعات  للغيوم').Element('Hour-Cloud').Data(ByHour).Rename({Count:"المعدلات كل 3 ساعات"})
            .Keys(['Station','Code','Year','Month','Day','Count','Cloud Classification']).Length({"50":50,"100":100})
            .Set(['Select','Reselect','PDF','Excel','Print']);
    }

    if (ByDay.length)
    {
        ElqadaDataTable.$Page.Size = 'A3';
        ElqadaDataTable.$Page.Orientation = 'portrait';
        ElqadaDataTable.ID('Stations-Day-Cloud')
            .Name('المعدلات اليومية للغيوم').Element('Day-Cloud').Data(ByDay).Rename({Count:"المعدلات اليومية للغيم"})
            .Keys(['Station','Code','Year','Month','Day','Count','Cloud Classification']).Length({"50":50,"100":100})
            .Set(['Select','Reselect','PDF','Excel','Print']);
    }

    if (ByMonth.length)
    {
        ElqadaDataTable.$Page.Size = 'A3';
        ElqadaDataTable.$Page.Orientation = 'portrait';
        ElqadaDataTable.ID('Stations-Monthly-Cloud')
            .Name('المعدلات الشهرية للغيوم').Element('Monthly-Cloud').Data(ByMonth).Rename({Count:"المعدلات الشهرية للغيم",Day:"مجموع أيام الشهر"})
            .Keys(['Station','Code','Year','Month','Day','Count','Cloud Classification']).Length({"50":50,"100":100})
            .Set(['Select','Reselect','PDF','Excel','Print']);
    }

    if (CountMonthly.length)
    {
        ElqadaDataTable.$Page.Size = 'A3';
        ElqadaDataTable.$Page.Orientation = 'portrait';
        ElqadaDataTable.ID('Stations-CountMonthly-Cloud')
            .Name('تكرار المعدلات الشهرية للغيوم').Element('CountMonthly-Cloud').Data(CountMonthly).Rename({Count:"عدد أيام التكرار",Day:"مجموع أيام الشهر"})
            .Keys(['Station','Code','Year','Month','Day','Count','Cloud Classification']).Length({"50":50,"100":100})
            .Set(['Select','Reselect','PDF','Excel','Print']);
    }
}