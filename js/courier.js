function TestCloud() {
    let X = {};
    ['hshs3', 'c3', 'ns3', 'hshs2', 'c2', 'c1', 'ns2', 'hshs1', 'ns1', 'ch', 'cm', 'cl', 'nh'].forEach(($K) => {
        X[$K] = GetElementValue($K);
    });
    let XInput = `${X['nh']}:${X['cl']}:${X['cm']}:${X['ch']}`;
    let XOutput = `${X['ns1']}:${X['c1']}:${X['hshs1']}:${X['ns2']}:${X['c2']}:${X['hshs2']}:${X['ns3']}:${X['c3']}:${X['hshs3']}`;
    if ( (XInput.length < 7 || XOutput.length < 12) || TestCloudsTable.includes(`${XInput}=>${XOutput}`))
    {
        SetElementValue('Message-TestCloud', '');
    }
    else
    {
        SetElementValue('Message-TestCloud', '<div class="ui red message">'+'تأكد من نوع الغيم'+'</div>');
    }
}

function TestWeather() {
    let X = {};
    ['vv', 'ff', 'ww'].forEach(($K) => {
        X[$K] = GetElementValue($K);
    });
    let XInput = `${X['vv']}:${X['ff']}`;
    let XOutput = `${X['ww']}`;

    if ( (XInput.length < 5 || XOutput.length < 2) || TestWeatherTable.includes(`${XInput}=>${XOutput}`))
    {
        SetElementValue('Message-TestWeather', '');
    }
    else
    {
        SetElementValue('Message-TestWeather', '<div class="ui red message">'+'تأكد من الظواهر الجوية'+'</div>');
    }
}

function TestTNTNTN() {
    if (GetElementValue('tntntn').length && [18 , 6].includes(VarID('time')) && GetElementValue('ttt').length)
  {
    if (VarID('time') === 6)
    {
      if (VarID('ttt') < VarID('tntntn'))
      {
        SetElementValue('tntntn' , GetElementValue('ttt'));
      }
    }
    SetElementValue('sn3' , ((VarID('tntntn') < 0) ? '-' : '+'));
  }
}

function IR(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        if ([6, 18].includes(VarID('time'))) {
            if ([1].includes(VarID('ir'))) {
                FNext('ir', 1);
            } else {
                SetElementValue("ir");
                alert("القيمة خارج المدى");
            }
        } else {
            if ([4].includes(VarID('ir'))) {
                FNext('ir', 1);
            } else {
                SetElementValue("ir");
                alert("القيمة خارج المدى");
            }
        }
    }
}

function IX(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        switch (VarID('ix')) {
            case 2:
                ReadOnly(['ww', 'w1w2'], true);
                Focus('h', 1);
                break;
            case 1:
                ReadOnly(['ww', 'w1w2'], false);
                Focus('h', 1);
                break;
            default:
                SetElementValue("ix");
                break;
        }
    }
}

function SSS(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        Focus('ns1', 1);
    }
}

function E(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        Focus('sss', 1);
    }
}

function test_h(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength")))
    {
        if ([0,1,2,8].includes(VarID('h')))
        {
            SetElementValue('h','');
        }
        else
        {
            if (GetElementValue('h') === '/' && GetElementValue('n').length && VarID('n') !== 9)
            {
                Validation(true,'n',"( h = / )"+"فى حالة ان قيمة الــ"+" ( n = 9 )"+"قيمة حقل الـ");
            }
            NextFocus(Selector, 'vv',1);
        }
    }
}

function SendCourier(Event, Run = false)
{
    if ((Run || (ReadOnly('min') && ReadOnly('max'))) && Event.keyCode === 13) {
        $("#InsertCourier").click();
    }
}

function CM(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        if (!VarID('cm') && !VarID('cl') && !VarID('nh')) {

        } else if (!VarID('ch') && !VarID('cl')) {
            ReadOnly(['ns3', 'hshs1'], false);
        } else {
            //SetElementValue('hshs1','',false);
        }
        if (!ReadOnly('ch')) {
            Focus('ch', 1);
        } else {
            Focus('sn3', 1);
        }
    }
}

function maxch(Selector, Limit = false)
{
    let Old = Selector.value;
    let New = TestFormatInput3(Old, 3).Return();
    Selector.value = New;
    var Run = Limit, ID = 'maxch';

    /* if (!Limit) {
        if ($TimeOut.hasOwnProperty(ID)) {
            clearTimeout($TimeOut[ID]);
        }
        $TimeOut[ID] = setTimeout(() => {
            maxch(Selector, true);
        }, ($Next * 6));
    } */

    if (New !== Old || Run) {
        Run = false;

        if (New.includes('-') || New.includes('+')) {

            if (New.length === 5) {
                Run = true;
            }
        } else if (New.length === 4) {
            Run = true;
        }

        if (Run) {
            clearTimeout($TimeOut[ID]);
            Selector.value = parseFloat(New).toFixed(1);
            if (VarID('ttt') > VarID('max')) {
                SetElementValue('max', '');
                swal({
                    title: ' الفيمة خارج المدى ',
                    text: ' أدخــل قيمة اكبر من قيمة ال (  ttt  ) ',
                    icon: 'error',
                    button: 'مــوافــق'
                });
            }
        }
    }
}

function tdtdtdch(Selector, Limit = false)
{
    let Old = Selector.value;
    let New = TestFormatInput3(Old, 3).Return();
    Selector.value = New;
    var Run = Limit, ID = 'tdtdtdch';

    // if (!Limit) {
    //     if ($TimeOut.hasOwnProperty(ID)) {
    //         clearTimeout($TimeOut[ID]);
    //     }
    //     $TimeOut[ID] = setTimeout(() => {
    //         tdtdtdch(Selector, true);
    //     }, ($Next * 6));
    // }

    if (New !== Old || Run) {
        Run = false;

        if (New.includes('-') || New.includes('+')) {
            New = New.replaceAll('-', '').replaceAll('+', '')
            Selector.value = New;
        }

        if (New.length === 4) {
            Run = true;
        }

        if (Run) {
            clearTimeout($TimeOut[ID]);
            Selector.value = parseFloat(New).toFixed(1);
            if (VarID('tdtdtd') < 0) {
                Selector.setAttribute('maxLength', 4)
            }
            var v1 = VarID("tdtdtd") * (VarID("sn2") == "-" ? -1 : 1);
            var v2 = VarID("ttt") * (VarID("sn1") == "-" ? -1 : 1);
            if (v1 > v2) {
                alert("القية خارج المدى");
                SetElementValue("tdtdtd");
                return;
            }
            Focus('p0p0p0p0', 1);
        }
    }
}

function minch(Selector, Limit = false)
{
    let Old = Selector.value;
    let New = TestFormatInput3(Old, 3).Return();
    Selector.value = New;
    var Run = Limit, ID = 'minch';

    /* if (!Limit) {
        if ($TimeOut.hasOwnProperty(ID)) {
            clearTimeout($TimeOut[ID]);
        }
        $TimeOut[ID] = setTimeout(() => {
            minch(Selector, true);
        }, ($Next * 6));
    } */

    if (New !== Old || Run) {
        Run = false;

        if (New.includes('-') || New.includes('+')) {

            if (New.length === 5) {
                Run = true;
            }
        } else if (New.length === 4) {
            Run = true;
        }

        if (Run) {
            clearTimeout($TimeOut[ID]);
            Selector.value = parseFloat(New).toFixed(1);
            if (VarID('ttt') < VarID('min')) {
                SetElementValue('min', '');
                swal({
                    title: ' الفيمة خارج المدى ',
                    text: ' أدخــل قيمة اصغر من قيمة ال (  ttt  ) ',
                    icon: 'error',
                    button: 'مــوافــق'
                });
            }
            else {
                Focus('max', 1);
            }
        }
    }
}

function chch(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        FNext('ch', 1);
    }
}

function clch(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        Focus('cm', 1);
    }
}

function sn3ch(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        let Sign = '';
        if (VarID('sn3') === 1) {
            Sign = "-"
        } else if (VarID('sn3') === 0) {
            Sign = "+";
        }
        SetElementValue('sn3', Sign);
        if (Sign) {
            Focus('tntntn', 1);
        }
    }
}

function sn1ch(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        let Sign = '';
        if (VarID('sn1') === 1 || GetElementValue('sn1') === '-') {
            Sign = "-"
        } else if (VarID('sn1') === 0 || GetElementValue('sn1') === '+') {
            Sign = "+";
        }
        SetElementValue('sn1', Sign);
        if (Sign) {
            Focus('ttt', 1);
        }
    }
}

function sn2ch(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        let Sign = '';
        if (VarID('sn2') === 1 || GetElementValue('sn2') === '-') {
            Sign = "-"
        } else if (VarID('sn2') === 0 || GetElementValue('sn2') === '+') {
            Sign = "+";
        }
        SetElementValue('sn2', Sign);
        if (Sign) {
            Focus('tdtdtd', 1);
        }
    }
}

function tntntnch(Selector, Limit = false)
{
    let Old = Selector.value;
    let New = TestFormatInput3(Old, 3).Return();
    Selector.value = New;
    var Run = Limit, ID = 'tntntnch';
    if (New !== Old || Run) {
        Run = false;
        if (New.includes('-') || New.includes('+')) {
            New = New.replaceAll('-', '').replaceAll('+', '');
            FNext('tntntn');
        } else if (New.length === 4) {
            Run = true;

        }
        if (Run) {
            clearTimeout($TimeOut[ID]);
            Selector.value = parseFloat(New).toFixed(1);
            FNext('tntntn');
        }

    }
}

function NS1(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        if (VarID('h') === '/' && VarID('n') === 9) {
            if (![8, 9].includes(VarID('ns1'))) {
                SetElementValue('ns1', '');
            }
            else {
                FNext('ns1');
            }
        }
        else {
            FNext('ns1');
        }
    }
}

function rhch(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        if ((VarID('rh') > 100) || (VarID('ttt') <= 40 && VarID('rh') > 100)) {
            SetElementValue('rh');
            swal({ title: ' قيمة مرفوضة ', text: 'القيمة خارج المدى', icon: 'error', button: 'مــوافــق' });
        }
        else {
            SetElementValue('rh', VarID('rh'));
            FNext('rh');
        }
    }
}

function vpch(Selector, Limit = false)
{
    let Old = Selector.value;
    let New = TestFormatInput3(Old, 3).Return();
    Selector.value = New;
    var Run = Limit, ID = 'vpch';

    // if (!Limit) {
    //     if ($TimeOut.hasOwnProperty(ID)) {
    //         clearTimeout($TimeOut[ID]);
    //     }
    //     $TimeOut[ID] = setTimeout(() => {
    //         vpch(Selector, true);
    //     }, ($Next * 6));
    // }
    if (New !== Old || Run) {
        Run = false;

        if (New.includes('-') || New.includes('+')) {
            if (New.length === 5) {
                Run = true;
            }
        } else if (New.length === 4) {
            Run = true;
        }
    }
    if (Run) {
        Selector.value = parseFloat(New).toFixed(1);
        FNext('vp', 10);
    }
}

function ppppch(Selector)
{
    if ($(Selector).val().length === 4) {
        let p = document.getElementById('pppp').value;

        let Value = p.substring(0, 3) + "." + p.charAt(3).toString();

        if (Value.charAt(0).toString() == '0') {
            Value = '1' + Value.substring(0, 3) + "." + p[3];
        }

        if (parseInt(Value) < 10000) {
            Value = Value.substring(0);
        }
        document.getElementById('pppp').value = Value;
        if (VarID('p0p0p0p0') > VarID('pppp')) {
            SetElementValue('pppp')
            alert("القيمة خارج المدى");
            return
        }
        Focus('a', 1);
    }
}

function ach(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        if ($(Selector).val() == "9") {
            SetElementValue("a");
        } else {
            Focus('ppp', 1);
        }

    }
}

function pppch(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        FNext('ppp', 1);
    }
}

function rrrch(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        FNext('rrr');
    }
}

function trch(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        if (VarID('tr') === 2 || VarID('tr') === 1) {
            FNext('tr');
        } else {
            alert("القيمة خارج المدى");
            SetElementValue('tr');
        }
    }
}

function nhch(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        Focus('cl', 1);
    }
}

function ffch(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength")))
    {
        if (VarID('ff') <= 90 || VarID('ff') === 99) {
            Focus('sn1', 1);
        } else {
            //SetElementValue('ff');
        }
    }
}

function popopopoch(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        var po = document.getElementById('p0p0p0p0').value;

        if (po.charAt(0).toString() === '0') {
            po = '1' + po;
            SetElementValue('p0p0p0p0', po.substring(0, 4) + '.' + po.charAt(4).toString());
        } else {
            SetElementValue('p0p0p0p0', po.substring(0, 3) + '.' + po.charAt(3).toString());
        }
        Focus('pppp', 1);
    }
}

function tttch(Selector, Limit = false)
{
    let Old = Selector.value;
    let New = TestFormatInput3(Old, 3).Return();
    Selector.value = New;
    var Run = Limit, ID = 'tttch';
    // if (!Limit) {
    //     if ($TimeOut.hasOwnProperty(ID)) {
    //         clearTimeout($TimeOut[ID]);
    //     }
    //     $TimeOut[ID] = setTimeout(() => {
    //         tttch(Selector, true);
    //     }, ($Next * 6));
    // }

    if (New !== Old || Run) {
        Run = false;

        if (New.includes('-') || New.includes('+')) {
            New = New.replaceAll('-', '').replaceAll('+', '');
            Selector.value = New;
        }
        if (New.length === 4) {
            clearTimeout($TimeOut[ID]);
            Selector.value = parseFloat(New).toFixed(1);
            if (VarID('ttt') < 0) {
                Selector.setAttribute('maxLength', 4)
            }

            if (VarID('ttt') > 60) {
                SetElementValue('ttt')
                alert("القيمة خارج المدى");
                return
            }

            setTimeout(() => {
                if (MinTTT && !(VarID('ttt') > (MinTTT - 9) && VarID('ttt') < (MinTTT + 9))) {
                    SetElementValue('ttt')
                    alert("القيمة خارج المدى");
                }
            }, 1000);

            if ([6, 18].includes(VarID('time'))) {
                ReadOnly(['tntntn', 'sn3', 'half'], false);
            } else {
                ReadOnly(['tntntn', 'sn3', 'half'], true);
            }
            Focus('sn2', 1);
        }
    }
}

function nch(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        if (!VarID('n')) {
            ReadOnly(['hshs3', 'c3', 'ns3', 'hshs2', 'c2', 'c1', 'ns2', 'hshs1', 'ns1', 'ch', 'cm', 'cl', 'nh'], true);
        }
        else if (VarID('n') <= 2 ) {
            ReadOnly(["ns2", "c2", "hshs2", "ns3", "c3", "hshs3"], true);
            ReadOnly(["nh", "cl", "cm", "ch", "ns1", "c1", "hshs1"], false);
        } else if (VarID('n') > 2 && VarID('n') <= 9) {
            ReadOnly(["nh", "cl", "cm", "ch", "ns1", "c1", "hshs1", "ns2", "c2", "hshs2", "ns3", "c3", "hshs3"], false);
        }
        if (GetElementValue('h') === '/' && VarID('n') !== 9)
        {
            Validation(true,'n',"( h = / )"+"فى حالة ان قيمة الــ"+" ( n = 9 )"+"قيمة حقل الـ");
        }
        Focus('dd', 1);
    }

}

function ddch(Selector)
{
    if ($(Selector).val().length === parseInt($(Selector).attr("maxlength"))) {
        if ((VarID('dd') >= 0 && VarID('dd') <= 36) || VarID('dd') === 99) {
            let Value = VarID('dd') * 10;
            if (!Value) {
                Value = "000";
            } else if (Value < 100) {
                Value = '0' + Value.toString();
            }
            SetElementValue('mdd', Value);
            SetElementValue('dd', Value);
            Focus('ff', 1);
        } else {
            SetElementValue('dd');
            // Focus('dd');
        }
    }
}

function wbch(Selector, Limit = false)
{
    let Old = Selector.value;
    let New = TestFormatInput3(Old, 3).Return();
    Selector.value = New;

    var Run = Limit, ID = 'wbch';

    // if (!Limit) {
    //     if ($TimeOut.hasOwnProperty(ID)) {
    //         clearTimeout($TimeOut[ID]);
    //     }
    //     $TimeOut[ID] = setTimeout(() => {
    //         wbch(Selector, true);
    //     }, ($Next * 6));
    // }

    if (New !== Old || Run) {
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

            if (VarID('ttt').toString().charAt(0) === '-') {
                Focus('wb', 1);
            } else {
                if (VarID('wb') > 1) {
                    Focus('wb', 1);
                }
            }
            var v = VarID("ttt") * (VarID("sn1") == "-" ? -1 : 1);
            if (v >= VarID('wb')) {

            } else {
                alert("القيمة خارج المدي");
                SetElementValue('wb');
                Focus('wb', 1);
                return;
            }

            if (VarID('wb') === VarID('ttt')) {
                SetElementValue('rh', 100);
                Focus('vp', 1);
                return;
            }
            Focus('rh', 1)
        }
    }
}

function EmptyAll()
{
    SetElementValue(["ir", "ix", "h", "vv", "n", "dd", "ff", "sn1", "ttt", "sn2", "tdtdtd", "p0p0p0p0", "pppp", "a", "ppp", "rrr", "tr", "ww", "w1w2", "nh", "cl", "cm", "ch", "half", "sn3", "tntntn", "e", "sss", "ns1", "c1", "hshs1", "ns2", "c2", "hshs2", "ns3", "c3", "hshs3", "wb", "rh", "vp", "min", "max"]);
    SetElementValue('Message-TestCloud', '');
}

function timech(File)
{
    let Selector = document.getElementById('time');
    if (Selector)
    {
        var _Name_ = GetElementValue('Station');
        var _Date_ = GetElementValue('date');
        var _Time_ = GetElementValue('time');
        var _Code_ = GetElementValue('StationCode');

        if (File === 'courier')
        {
            if ($(Selector).val().length === parseInt($(Selector).attr("maxlength")))
            {
                EmptyAll();
                Disabled(['DeleteCourier', 'InsertCourier', 'UpdateCourier'], false);
                let $Date = (new Date()).toISOString().substring(0,13).split('T');

                if (
                    (parseInt(_Time_) > 23)
                    ||
                    (
                        _Date_ === PHP.CurrentDate
                        &&
                        (
                            (parseInt(_Time_) > (parseInt(PHP.CurrentTime[0])+1))
                            ||
                            (parseInt(_Time_) === (parseInt(PHP.CurrentTime[0])+1) && (parseInt(PHP.CurrentTime[1]) < 45) )
                        )
                    )
                ) {
                    SetElementValue("time");
                    Disabled(['DeleteCourier', 'InsertCourier', 'UpdateCourier'], true);
                } else {
                    Request("Request/hourly.php?Station=" + _Name_ + '&date=' + _Date_ + '&time=' + _Time_, (Return) => {
                        if (Return.hasOwnProperty('Old')) {
                            let Response = Return.Old;
                            var keys = Object.keys(Response).map(x => x.toLowerCase());
                            Response['FF'] = ('0' + Response['FF']).substr(-2);
                            SetElementValue(keys, Object.values(Response), false);
                            if ($ErrorTimesOptions_courier.hasOwnProperty(Return.Old.date)&&$ErrorTimesOptions_courier[Return.Old.date].hasOwnProperty(Return.Old.time))
                            {
                                $ErrorTimesOptions_courier[Return.Old.date][Return.Old.time].forEach(($Key)=>{
                                    console.info($Key.toString().toLowerCase());
                                    document.getElementById($Key.toString().toLowerCase()).style.backgroundColor = "#f19292";
                                });
                            }
                            if (!VarID('n'))
                            {
                                ReadOnly(['hshs3', 'c3', 'ns3', 'hshs2', 'c2', 'c1', 'ns2', 'hshs1', 'ns1', 'ch', 'cm', 'cl', 'nh'], true);
                            }
                            else if (VarID('n') <= 2)
                            {
                                ReadOnly(["ns2", "c2", "hshs2", "ns3", "c3", "hshs3"], true);
                                ReadOnly(["nh", "cl", "cm", "ch", "ns1", "c1", "hshs1"], false);
                            }
                            else if (VarID('n') > 2 && VarID('n') <= 9) {
                                ReadOnly(["nh", "cl", "cm", "ch", "ns1", "c1", "hshs1", "ns2", "c2", "hshs2", "ns3", "c3", "hshs3"], false);
                            }

                            Disabled(['DeleteCourier', 'UpdateCourier'], false);
                            Disabled(['InsertCourier'], true);
                            SetElementValue('Monitor', Response['Monitor']);

                        } else {
                            Disabled(['DeleteCourier', 'UpdateCourier'], true);
                            Disabled(['InsertCourier'], false);
                        }

                        if (Return.hasOwnProperty('Min')) {
                            MinTTT = 0;
                            //parseInt(Return.Min['ttt']);
                        }
                        else {
                            MinTTT = 0;
                        }
                        ReadOnly(['max', 'min'], true);
                        if (VarID('time') === 3) {
                            ReadOnly('min', false);
                        } else if ([12, 15].includes(VarID('time'))) {
                            ReadOnly('max', false);
                        }

                        if ([6, 18].includes(VarID('time'))) {
                            ReadOnly(['tntntn', 'half', 'sn3'], false);
                            Focus('ir', 0);
                            Request("Request/tn.php?" + "time=" + _Time_ + "&date=" + _Date_ + "&code=" + _Code_ + "&ttt=" + GetElementValue('ttt'), (Response) => {
                                if (Response.toString().length) {}
                            });
                            ReadOnly(['tntntn', 'rrr', 'tr', 'half', 'sn3'], false);
                        } else {
                            ReadOnly(['tntntn', 'rrr', 'tr', 'half', 'sn3'], true);
                        }

                        if (VarID('time') === 6) {
                            SetElementValue('half', "2", true);

                        } else if (VarID('time') === 18) {
                            SetElementValue('half', "1", true);
                        }

                        var req = "Request/saai.php?time=" + _Time_ + "&date=" + _Date_ + "&stcode=" + _Code_;
                        Request(req, (Response) => {
                            if (Response !== null && typeof Response === 'object')
                            {
                                if (Response[0] === "okay")
                                {
                                    Disabled(['DeleteCourier', 'UpdateCourier'], true);
                                }
                                else if (Response.hasOwnProperty(0))
                                {
                                    let iop = parseInt(Response[0]['time']) + 1;

                                    if (iop < 10)
                                    {
                                        iop = "0" + iop;
                                    }

                                    if (isNaN(iop)) {
                                        iop = '00';
                                    }
                                    if (iop < 24)
                                    {
                                        // RUTBA || NAKAIB
                                        if (!['658','642'].includes(PHP.Sesstion.StationCode) && ![12,15].includes(PHP.Sesstion.Station))
                                        {
                                            swal({ title: ' أدخــل الـرصــدة ', text: iop.toString(), icon: 'error', button: 'مــوافــق' });
                                        }
                                    }
                                    Disabled(['DeleteCourier', 'UpdateCourier'], true);
                                }
                                else
                                {
                                    if (Response)
                                    {
                                        Disabled(['DeleteCourier', 'InsertCourier', 'UpdateCourier'], false);
                                        if (Object.keys(Response).length > 4)
                                        {
                                            Disabled('InsertCourier', true);
                                        }
                                    }
                                }
                            }
                        });
                        FNext('time', 200);
                    });
                }
            }
        }
    }
}

function CX_HSHSX($X)
{
    let CX = document.getElementById('c'+$X),
        HSHSX = document.getElementById('hshs'+$X);
    if (!CX.disabled && CX.value.toString().length)
    {
        HSHSX.required = true;
    }
    else
    {
        HSHSX.required = false;
    }
}

function SetTimesOptions_courier() {
    var Options = '', Count = 0;
    let CurrentDate = PHP.CurrentDate.split('-'),DateFrom = PHP.MinDate, DateTo = PHP.MaxDate;

    if (PHP.Sesstion.per !== 'admin')
    {
        if (["26","27","28","29","30","31"].includes(CurrentDate[2]))
        {
            DateFrom = CurrentDate[0]+"-"+CurrentDate[1]+"-01";
            DateTo = CurrentDate;
        }
    }

    DateFromTo(DateFrom,DateTo).forEach((Day)=>{
        if (!$SetTimesOptions_courier.hasOwnProperty(Day) || $SetTimesOptions_courier[Day].length<24)
        {
            Options += `<option disabled> ${Day}</option>`;
        }

        ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'].forEach((Time) => {
            if ((!$SetTimesOptions_courier.hasOwnProperty(Day) || !$SetTimesOptions_courier[Day].includes(Time)) && ( (PHP.MaxDate !== Day) || ( parseInt(Time) < (parseInt(PHP.CurrentTime[0])+1) )  || (( parseInt(Time) === (parseInt(PHP.CurrentTime[0])+1) ) && parseInt(PHP.CurrentTime[1]) > 45) ) ) {
                Options += `<option data-day="${Day}" value="${Time}">${Time}</option>`;
                Count++;
            }
        });
    });
    document.getElementById('SetTimes').innerHTML = '<option disabled selected> Count : '+Count+'</option>'+Options;
    if (PHP.Sesstion.per !== 'admin')
    {
        if (!Count)
        {
            SetElementValue('Message-TestMonth', '');
        }
        else
        {
            SetElementValue('Message-TestMonth', '<div class="ui red message">'+' تأكد من اكمال السجل الالكتروني لهذا الشهر '+'</div>');
        }
    }
}


function ErrorTimesOptions_courier() {
    var Options = '',Count = 0;
    Object.keys($ErrorTimesOptions_courier).forEach((Day)=>{
        Options += `<option disabled> ${Day}</option>`;
        Object.keys($ErrorTimesOptions_courier[Day]).forEach((Time)=>{
            Options += `<option data-day="${Day}" value="${Time}">${Time}</option>`;
            Count++;
        });
    })
    document.getElementById('ErrorTimes').innerHTML = '<option disabled selected> Count : '+Count+'</option>'+Options;
}

function DisableDates_courier(date) {
    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
    return [Object.keys($SetTimesOptions_courier).indexOf(string) == -1];
}

window.addEventListener('DOMContentLoaded',()=>
{
    SetTimesOptions_courier();
    ErrorTimesOptions_courier();

    ['p0p0p0p0','pppp','ppp'].forEach((Element)=>
    {
        let Selector = document.getElementById(Element);
        if (Selector)
        {
            Selector.addEventListener('keyup',(Key)=>{
                Selector.value = Selector.value.replaceAll('-','');
            });
        }
    });

    InputFormating('ww',2,0,0,99,3,4,null,null,(ID,Value,Message)=>{

    },'0123456789',[]);

    InputFormating('vv',2,0,0,99,3,4,null,null,(ID,Value,Message)=>{
        Value = parseInt(Value);
        return (Value <= 55 && Value >= 51 || Value>60);
    },'0123456789',[]);

    InputFormating('w1w2',2,0,0,99);

    InputFormating('hshs1',2,0,0,99,3,4,null,null,(ID,Value,Message)=>{

        // return ((VarID('n') === 9 && VarID('h') === '/') && !['00', '01', '02', '03', '04', '05', '06', '07', '08', '09'].includes(Value) || ['51', '52', '53', '54'].includes(Value) );
    },'0123456789/',['//']);

    InputFormating('hshs2',2,0,0,99,3,4,null,null,(ID,Value,Message)=>{

        // return (!['//','XX','01','02','03','04','05','12', '14', '16', '18', '20', '25', '30', '35', '40', '45', '50', '60','61','62','63', '65', '43', '42', '33', '32','56','57','58','59'].includes(Value.toUpperCase()));
    },'0123456789/',['//']);

    InputFormating('hshs3',2,0,0,99,3,4,null,null,(ID,Value,Message)=>{

        // return (['51', '52', '53', '54'].includes(Value));
    },'0123456789/',['//']);

    InputFormating('p0p0p0p0X',5,1,900,null,5,8,null,null,(ID,Value,Message)=>{
        Value = parseFloat(Value).toFixed(1);
        SetElementValue(ID,Value);
    });

    ['hshs3', 'c3', 'ns3', 'hshs2', 'c2', 'c1', 'ns2', 'hshs1', 'ns1', 'ch', 'cm', 'cl', 'nh'].forEach(($K)=>{
       document.getElementById($K).addEventListener('change',TestCloud);
    });
    ['vv', 'ff', 'ww'].forEach(($K) => {
        document.getElementById($K).addEventListener('change',TestWeather);
    });

    document.getElementById('ff').addEventListener('change',()=>{
        setTimeout(()=>{
            if (VarID('ff')>=30)
            {
                document.getElementById('ff').style.backgroundColor = "#f19292";
            }
            else
            {
                document.getElementById('ff').style.backgroundColor = "#cccccc";
            }
        },100);
    });

    ['pppp','p0p0p0p0'].forEach((Key)=>{
        document.getElementById(Key).addEventListener('change',()=>{
            setTimeout(()=>{
                if (VarID(Key)<=900)
                {
                    document.getElementById(Key).style.backgroundColor = "#f19292";
                }
                else
                {
                    document.getElementById(Key).style.backgroundColor = "#cccccc";
                }
            },100);
        });
    });

    ReloadFromPath();
    TestCloud();
    TestWeather();

    // RABIAH
    if (['602'].includes(PHP.Sesstion.StationCode) || [19].includes(PHP.Sesstion.Station))
    {
        ['pppp','p0p0p0p0'].forEach((Key)=>{
            document.getElementById(Key).required = false;
        });
    }
});