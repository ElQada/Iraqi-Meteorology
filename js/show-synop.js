function SetStationX($SetStationX = null) {
    if ($SetStationX === null)
    {
        $SetStationX = $SetStationX$;
    }
    var Options = '', Count = 0, Include = [], Times = ['00','03','06','09','12','15','18','21'];

    if (GetElementValue('date') === PHP.CurrentDate)
    {
        Times.forEach((TestTime)=>{
            if ( ( parseInt(TestTime) <= parseInt(PHP.CurrentTime[0]) ) || ( ( parseInt(TestTime) === (parseInt(PHP.CurrentTime[0])+1) ) && (parseInt(PHP.CurrentTime[1])>45) ) )
            {
                Include.push(TestTime);
            }
        })
    }
    else
    {
        Include = Times;
    }

    if ($SetStationX.hasOwnProperty('Stations')&&$SetStationX.hasOwnProperty('Now')&&$SetStationX.hasOwnProperty('Date')&&$SetStationX.hasOwnProperty('Time'))
    {
        if (!$SetStationX.Now)
        {
            $SetStationX.Now = [];
        }

        let Stations = {}, Now = {};
        $SetStationX.Stations.forEach((Station)=>
        {
            Stations['K@'+Station.id] = Station.StationName;
        });

        Object.keys(Stations).forEach((Station)=>
        {
            Now[Station] = [];
        })

        $SetStationX.Now.forEach((Station)=>
        {
            if (!Now.hasOwnProperty('K@'+Station.Station))
            {
                Now['K@'+Station.Station] = [];
            }
            Now['K@'+Station.Station].push(Station.time);
        });

        Object.keys(Stations).forEach((Station)=>
        {
            if (Now[Station].join() === Include.join())
            {
                Options += `<option style="background-color: #59e632;" value="${Station}">${Stations[Station]} [ ${Now[Station].join(' - ')} ] </option>`;
            }
            else
            {
                Options += `<option value="${Station}">${Stations[Station]} [ ${Now[Station].join(' - ')} ] </option>`;
            }
            Count++;
        })
    }
    document.getElementById('SetStationX').innerHTML = '<option disabled selected> Count : '+Count+'</option>'+Options;

    Options = '';
    Count = 0;
    let Selected = 'selected';

    ['00', '03', '06', '09', '12', '15', '18', '21'].forEach((Time) => {
        if (GetElementValue('date') === PHP.CurrentDate && ((parseInt(Time) > (parseInt(PHP.CurrentTime[0])+1)) || ((parseInt(Time) === (parseInt(PHP.CurrentTime[0])+1)) && parseInt(PHP.CurrentTime[1])<45) ))
        {
            Options += `<option disabled value="${Time}"> ${Time}</option>`;
        }
        else
        {
            if ($SetStationX.Time === Time)
            {
                Options += `<option value="${Time}" style="background-color: #0e8c8c;" selected>${Time}</option>`;
                Selected = '';
            }
            else
            {
                Options += `<option value="${Time}">${Time}</option>`;
            }
            Count++;
        }
    });
    document.getElementById('time').innerHTML = `<option disabled ${Selected}> Count : ${Count} </option>`+Options;
}

window.addEventListener('DOMContentLoaded',()=>{
    SetStationX();
});
function timech(File)
{
    let Selector = document.getElementById('time');
    if (Selector)
    {
        var _Date_ = GetElementValue('date');
        var _Time_ = GetElementValue('time');

        if (File === 'show-synop')
        {
            SetElementValue('synop','');
            elqada.$X.$O.Synop = {};
            Request("Request/show-synop.php?date=" + _Date_ + '&time=' + _Time_, (Return) =>
            {
                if (Return)
                {
                    elqada.$X.$O.Synop = Return;
                    SetElementValue('synop',Return['Print']);
                    SetElementValue('StationCount',Return['Count']);
                    SetElementValue('FileName','Synop-ORBI-'+(_Date_.split('-')[2])+_Time_+'00Z.txt');
                    $SetStationX$ = Return['SetStationX'];
                }
                else
                {
                    SetElementValue('synop','');
                    SetElementValue('StationCount','');
                    SetElementValue('FileName','FileName.txt');
                }
                SetStationX();
            });
        }
    }
}