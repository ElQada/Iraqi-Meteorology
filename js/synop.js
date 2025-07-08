var SynopIndex = {X:5,Y:5};

function SetTimesOptions_synop($SetTimesOptions_synop = null)
{
    if ($SetTimesOptions_synop === null)
    {
        $SetTimesOptions_synop = $SetTimesOptions_synop$;
    }
    var Options = '', Count = 0;
    [GetElementValue('date')].forEach((Day)=>{
        if (!$SetTimesOptions_synop[Day] || $SetTimesOptions_synop[Day].length<24)
        {
            Options += `<option disabled value=""> ${Day}</option>`;
        }

        ['00', '03', '06', '09', '12', '15', '18', '21'].forEach((Time) => {
            if ( GetElementValue('date') === PHP.CurrentDate && ( ( parseInt(Time) > (parseInt(PHP.CurrentTime[0])+1) ) || ((parseInt(Time) === (parseInt(PHP.CurrentTime[0])+1)) && (parseInt(PHP.CurrentTime[1])<45)) ))
            {
                Options += `<option disabled value="${Time}"> ${Time}</option>`;
            }
            else if (!$SetTimesOptions_synop[Day] || !$SetTimesOptions_synop[Day].includes(Time)) {
                Options += `<option data-day="${Day}" value="${Time}">${Time}</option>`;
            }
            else
            {
                Options += `<option data-day="${Day}" value="${Time}" style="background-color: #59e632;">${Time}</option>`;
                Count++;
            }
        });
    })

    document.getElementById('time').innerHTML = '<option disabled selected> Count : '+Count+'</option>'+Options;
}

window.addEventListener('DOMContentLoaded',() =>
{
    let Content = '0123456789/\\ ';
    let Element = document.getElementById('synop');
    if (Element)
    {
        Element.addEventListener('keyup', () =>
        {
            let Return = Element.value.replaceAll('  ',' '), Replace = 0;

            if ([41,47].includes(Return.indexOf(' 333 ')) || Return.indexOf(' 333 ') > 30)
            {
                Replace = Return.indexOf(' 333 ');
                Return  = Return.replace(' 333 ',' ');
            }

            SynopIndex = {X:5,Y:5};

            Return = ((Return.split('')).filter((X,I) =>
            {
                if (I>SynopIndex.X&&(I%6) === 5)
                {
                    SynopIndex.X += 6;
                }

                if ([' '," "].includes(X)&&I!==SynopIndex.X)
                {
                    return false;
                }
                else
                {
                    return Content.includes(X.toString());
                }
            }));


            for(let I = 0; I<Return.length; I++)
            {
                if (I>SynopIndex.Y&&(I%6) === 5)
                {
                    SynopIndex.Y += 6;
                }

                if (I === SynopIndex.Y&&![' '," "].includes(Return[I]))
                {
                    Return[I] = ' '+Return[I];
                }
            }

            setTimeout(() =>
            {
                Return = Element.value.replaceAll('  ',' ');
                Replace = 0;

                if ([41,47].includes(Return.indexOf(' 333 ')) || Return.indexOf(' 333 ') > 30)
                {
                    Replace = Return.indexOf(' 333 ');
                    Return  = Return.replace(' 333 ',' ');
                }

                Return = ((Return.split('')).filter((X,I) =>
                {
                    return Content.includes(X.toString());
                }));

                Return = Return.join('');

                if (Replace)
                {
                    Return = Return.substring(0,Replace) + ' 333 ' + Return.substring(Replace);
                }

                Return = Return.replaceAll('  ',' ');
                if ([45,51].includes(Return.length) && Return.endsWith(' 333'))
                {
                    Return += ' ';
                }
                Element.value = Return;

            }, 321);

            Return = Return.join('');

            if (Replace)
            {
                Return = Return.substring(0,Replace) + ' 333 ' + Return.substring(Replace);
            }

            Return = Return.replaceAll('  ',' ');
            if ([45,51].includes(Return.length) && Return.endsWith(' 333'))
            {
                Return += ' ';
            }
            Element.value = Return;
        });

        Element.addEventListener('blur',()=>{
            if (Element.value.length)
            {
                let $Values = Element.value.split(' ');
                $Values.forEach((Slot,Index)=>
                {
                    if(Slot.length !== 5 && (Slot !== '333' || (Index === ($Values.length-1) && Slot === '333')) )
                    {
                        MessageSwal(Slot + " !! ",'error');
                    }
                });
            }
        });
    }

    SetTimesOptions_synop();
    document.getElementById('date').addEventListener('change',()=>{ SetTimesOptions_synop(); });
    setTimeout(()=>{
        if (Search.hasOwnProperty('date'))
        {
            SetElementValue('date',Search.date);
        }

        if (Search.hasOwnProperty('date')&&Search.hasOwnProperty('time')&&Search.hasOwnProperty('Station'))
        {
            let $SelectElement = document.querySelector('option[data-day="'+Search.date+'"][value="'+Search.time+'"]');
            SetElementValue('Station',Search.Station);
            if ($SelectElement)
            {
                $SelectElement.selected = true;
                timech(PHP.CurrentFile);
            }
        }
    },250);
});
function SynopEmpty()
{
    SetElementValue(['synop','RH','Min','Max','RAIN','Notes'],'');
}

function F_RH(Element,Run = true) {
    Element.value = ((Element.value.split('')).filter((X) => { return '0123456789'.includes(X.toString()); })).join('');
    if (Element.value === "100" )
    {
        FNext('RH');
    }
    else if(Element.value.toString().length > 1)
    {
        Element.value = Element.value.substring(0,2);
        FNext('RH');
    }

    if (Run)
    {
        setTimeout(() => {
            F_RH(Element,false);
        }, 123);
    }
}

function F_Min(Selector, Limit = false) {
    let Old = Selector.value;
    let New = TestFormatInput3(Old, 3).Return();
    Selector.value = New;

    var Run = Limit, ID = 'F_Min';

    if (!Limit)
    {
        if ($TimeOut.hasOwnProperty(ID)) {
            clearTimeout($TimeOut[ID]);
        }
        $TimeOut[ID] = setTimeout(() => {
            wbch(Selector, true);
        }, ($Next * 2));
    }

    if (New !== Old || Run)
    {
        Run = false;

        if (New.includes('-') || New.includes('+')) {
            if (New.length === 5) {
                Run = true;
            }
        } else if (New.length === 4) {
            Run = true;
        }

        if (Run) {
            Selector.value = parseFloat(New).toFixed(1);
            clearTimeout($TimeOut[ID]);
            FNext('Min');
        }
    }
}



function F_Max(Selector, Limit = false) {
    let Old = Selector.value;
    let New = TestFormatInput3(Old, 3).Return();
    Selector.value = New;

    var Run = Limit, ID = 'F_Max';

    if (!Limit)
    {
        if ($TimeOut.hasOwnProperty(ID)) {
            clearTimeout($TimeOut[ID]);
        }
        $TimeOut[ID] = setTimeout(() => {
            wbch(Selector, true);
        }, ($Next * 2));
    }

    if (New !== Old || Run)
    {
        Run = false;

        if (New.includes('-') || New.includes('+')) {
            if (New.length === 5) {
                Run = true;
            }
        } else if (New.length === 4) {
            Run = true;
        }

        if (Run) {
            Selector.value = parseFloat(New).toFixed(1);
            clearTimeout($TimeOut[ID]);
            FNext('Max');
        }
    }
}

function F_RAIN() {
    if(!WriteTrace(event,'RAIN'))
    {
        InputFormating('RAIN',3,1,null,null,2,null,null,(ID,$Error,$Message)=> {
            if (!$Error)
            {
                let RAIN = parseFloat(GetElementValue('RAIN')).toFixed(1);
                if (RAIN.startsWith('0.'))
                {
                    RAIN = parseFloat((parseInt(RAIN.substring(2))/10).toString()).toFixed(1);
                }
                SetElementValue('RAIN', RAIN);
            }
        },false,'0123456789trace',['trace'])
    }
}

function TestSlot($Value)
{
    if ($Value.toString().length === 6)
    {
        return $Value;
    }
    else
    {
        return '';
    }
}

function timech(File)
{
    let Selector = document.getElementById('time');
    if (Selector)
    {
        var _Name_ = GetElementValue('Station');
        var _Date_ = GetElementValue('date');
        var _Time_ = GetElementValue('time');

        if (File === 'synop')
        {
            SetElementValue(['synop','RH','Min','Max','RAIN','Notes'],'');
            Disabled(['DeleteSynop', 'InsertSynop', 'UpdateSynop'], true);
            ReadOnly("Min", (_Time_!=="03"));
            ReadOnly("Max", (!['12','15'].includes(_Time_)));
            ReadOnly("RAIN", (!['06','18'].includes(_Time_)));

            if (!['00','03','06','09','12','15','18','21'].includes(Selector.value)) {
                SetElementValue("time");
            }
            else
            {
                Focus('synop');
                /*
                  Station , Date , Time
                 */
                Request("Request/synop.php?Station=" + _Name_ + '&date=' + _Date_ + '&time=' + _Time_, (Return) =>
                {
                    if (Return && Return.hasOwnProperty('synop') && Return.synop && Return.synop.hasOwnProperty('synop'))
                    {
                        Disabled(['DeleteSynop', 'UpdateSynop'], false);
                        SetElementValue('synop',Return['synop']['synop']);
                        SetElementValue('Monitor',Return['synop']['name']);
                        /*
                        RH , MIN , MAX , (RRR.TR) => RAIN
                         */
                        SetElementValue('RH',Return['synop']['rh']);
                        SetElementValue('Min',Return['synop']['min']);
                        SetElementValue('Max',Return['synop']['max']);
                        SetElementValue('RAIN',Return['synop']['RAIN']);
                        SetElementValue('Notes',Return['synop']['Notes']);
                    }
                    else
                    {
                        if (Return && Return.hasOwnProperty('courier') && Return.courier && Return.courier.hasOwnProperty('Station'))
                        {
                            /*
                            SN1 & SN2 & SN3 : [1,0][-,+]
                            */
                            ['SN1','SN2','SN3'].forEach((Key)=>{
                                if (Return['courier'][Key] === '-')
                                {
                                    Return['courier'][Key] = '1';
                                }
                                else if (Return['courier'][Key] === '+')
                                {
                                    Return['courier'][Key] = '0';
                                }
                            });
                            /* --------------------------=[|=>|]  [|<=|]=-------------------------- */
                            /*
                            IR , IX , H , VV
                             */
                            let $Value = `${Return['courier']['IR']}${Return['courier']['IX']}${Return['courier']['H']}${Return['courier']['VV']}`;
                            /* --------------------------=[|=>|]  [|<=|]=-------------------------- */
                            Return['courier']['PPPP'] = Return['courier']['PPPP'].replaceAll('.','');
                            if (Return['courier']['PPPP'].length > 4)
                            {
                                Return['courier']['PPPP'] = Return['courier']['PPPP'].substring(1);
                            }
                            /* --------------------------=[|=>|]  [|<=|]=-------------------------- */
                            ['TTT','TDTDTD','TNTNTN'].forEach((Key)=>{
                                Return['courier'][Key] = Return['courier'][Key].replaceAll('.','');
                                if (Return['courier'][Key].length===1)
                                {
                                    Return['courier'][Key] = '00'+Return['courier'][Key];
                                }
                                else if (Return['courier'][Key].length===2)
                                {
                                    Return['courier'][Key] = '0'+Return['courier'][Key];
                                }
                            });
                            /* --------------------------=[|=>|]  [|<=|]=-------------------------- */
                            /*
                            N , DD , FF
                             */
                            $Value += TestSlot(` ${Return['courier']['N']}${Return['courier']['DD'].substring(0,2)}${Return['courier']['FF']}`);
                            /*
                            1 , SN1 , TTT
                             */
                            $Value += TestSlot(` 1${Return['courier']['SN1']}${Return['courier']['TTT']}`);
                            /*
                            2 , SN2 , TDTDTD
                             */
                            $Value += TestSlot(` 2${Return['courier']['SN2']}${Return['courier']['TDTDTD']}`);
                            /*
                            4 , PPPP
                             */
                            $Value += TestSlot(` 4${Return['courier']['PPPP']}`);
                            /*
                            5 , A , PPP
                             */
                            $Value += TestSlot(` 5${Return['courier']['A']}${Return['courier']['PPP']}`);
                            /* time@06||18    6 , RRR , TR*/
                            if (['06','18'].includes(Return['courier']['time']))
                            {
                                $Value += TestSlot(` 6${Return['courier']['RRR']}${Return['courier']['TR']}`);
                            }
                            /* IX@1    7 , WW , W1W2 */
                            if (Return['courier']['IX'] === '1')
                            {
                                $Value += TestSlot(` 7${Return['courier']['WW']}${Return['courier']['W1W2']}`);
                            }
                            /* N!0    8 , NH , CL, CM, CH */
                            if (Return['courier']['N'] !== '0')
                            {
                                $Value += TestSlot(` 8${Return['courier']['NH']}${Return['courier']['CL']}${Return['courier']['CM']}${Return['courier']['CH']}`);
                            }
                            /* time@06||18 & N!0  333 */
                            if (['06','18'].includes(Return['courier']['time'])||Return['courier']['N'] !== '0')
                            {
                                $Value += ` 333`;
                            }
                            /* time@06||18 HALF , SN3 ,  TNTNTN */
                            if (['06','18'].includes(Return['courier']['time']))
                            {
                                $Value += TestSlot(` ${Return['courier']['HALF']}${Return['courier']['SN3']}${Return['courier']['TNTNTN']}`);
                            }
                            /* N!0 8 , NS1 ,  C1 , HSHS1*/
							/* N!0 8 , NS2 ,  C2 , HSHS2*/
                            if (Return['courier']['N'] !== '0')
                            {
                                $Value += TestSlot(` 8${Return['courier']['NS1']}${Return['courier']['C1']}${Return['courier']['HSHS1']}`);
                                $Value += TestSlot(` 8${Return['courier']['NS2']}${Return['courier']['C2']}${Return['courier']['HSHS2']}`);
                            }
							/* NS3 ,  C3 , HSHS3*/
                            $Value += TestSlot(` 8${Return['courier']['NS3']}${Return['courier']['C3']}${Return['courier']['HSHS3']}`);

                            SetElementValue('synop',$Value);
                            SetElementValue('Monitor',Return['courier']['name']);
                            SetElementValue('RH',Return['courier']['RH']);
                            SetElementValue('Min',Return['courier']['min']);
                            SetElementValue('Max',Return['courier']['max']);

                            SetElementValue('WB',Return['courier']['WB']);
                            SetElementValue('VP',Return['courier']['VP']);
                            SetElementValue('POPOPOPO',Return['courier']['POPOPOPO']);
                        }
                        Disabled(['InsertSynop'], false);
                    }
                });
            }
        }
    }
}

function SelectStationName(Code)
{
    Request('Request/GetStationName.php?Code='+Code,(Response)=>{
        if(Response&&Response.hasOwnProperty('id'))
        {
            SetElementValue('Station',Response['id']);
            setTimeout(()=>{
                STtName(PHP.CurrentFile);
                setTimeout(()=>{
                    timech(PHP.CurrentFile);
                },123);
            },123);
        }
    });
}