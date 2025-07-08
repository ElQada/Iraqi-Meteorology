var CurrentLink = '';
if (location.href.startsWith('https://localhost'))
{
    CurrentLink = "https://localhost";
    if (location.href.includes('/Online/Code'))
    {
        CurrentLink += '/Samer-Iraq/Online/Code';
    }
}
else if (location.href.startsWith('http://localhost'))
{
    CurrentLink = "http://localhost";
    if (location.href.includes('/Online/Code'))
    {
        CurrentLink += '/Samer-Iraq/Online/Code';
    }
}
else
{
    CurrentLink = 'https://metological-iraq.online';
}

window.addEventListener('DOMContentLoaded', () =>
{
    if (PHP.CurrentFile !== 'index')
    {
        ["time", "ir", "ix", "h", "vv", "n", "dd", "ff", "sn1", "ttt", "sn2", "tdtdtd", "p0p0p0p0", "pppp", "a", "ppp", "rrr", "tr", "ww", "w1w2", "nh", "cl", "cm", "ch", "half", "sn3", "tntntn", "e", "sss", "ns1", "c1", "hshs1", "ns2", "c2", "hshs2", "ns3", "c3", "hshs3", "wb", "rh", "vp", "min", "max"].forEach((ID) => {
            OnlyContent(ID);
        });

        $.ajax({
            url: 'Request/timestamp.php', success: function (data) {
                $('#timestamp').html(data);
            }
        });

        setInterval(() => {
            document.getElementById('timestamp').innerHTML = (new Date()).toTimeString().slice(0,8);
        }, 1000);

        setTimeout(() => {
            document.getElementById('CurrentYear').innerHTML = CurrentDate.getFullYear();
            STtName();
            if (PHP.CurrentFile === 'courier')
            {
                Focus('time', 10);
            }
        }, 500);

        if (PHP.CurrentFile === 'courier')
        {
            document.querySelectorAll('form').forEach((Form) => {
                Form.addEventListener('submit', (event) => {
                    var el = document.getElementById('max');
                    var minel = document.getElementById('min');
                    if (event.submitter.id == "InsertCourier" || event.submitter.id == "InsertCourier") {

                        if (!el.hasAttribute('readonly') && el.value == "") {
                            alert("ادخل قيمة max");
                            event.preventDefault();
                            return;
                        }
                        if (!minel.hasAttribute('readonly') && minel.value == "") {
                            alert("ادخل قيمة min");
                            event.preventDefault();
                        }
                    }
                });

                Form.addEventListener('reset', (event) => {
                    let Values = [GetElementValue('StationCode'), GetElementValue('Longitude'), GetElementValue('Latitude'), GetElementValue('ElevationM'), GetElementValue('date')];
                    setTimeout(() => {
                        SetElementValue(['StationCode', 'Longitude', 'Latitude', 'ElevationM', 'date'], Values);
                    }, 500);
                });
            });
        }

        document.querySelectorAll('input[type="text"]').forEach((Input) => {
            Input.title = Input.placeholder;

            if (Input.name !== 'synop')
            {
                Input.addEventListener('dblclick', () => {
                    if (!Input.readOnly && !Input.disabled) {
                        Input.style.backgroundColor = "#ffffff";
                        Input.value = "";
                    }
                });
            }

            Input.addEventListener('change', () => {
                if (Input.value.length)
                {
                    Input.style.backgroundColor = "#ccc";
                }
                else
                {
                    Input.style.backgroundColor = "#ffffff";
                }
            });

            Input.addEventListener('keyup', (event) => {
                // Input.value = Input.value.toUpperCase();
                if (event.keyCode === 13) {
                    if (PHP.CurrentFile === 'courier')
                    {
                        $("#InsertCourier").click();
                    }
                    else if (PHP.CurrentFile === 'synop')
                    {
                        $("#InsertSynop").click();
                    }
                }
            });
        });

        let QuerySelector = document.querySelector("a[href='" + location.pathname.split('/').pop() + "']");
        if (QuerySelector)
        {
            QuerySelector.classList.remove('blue');
            QuerySelector.classList.add('current');
        }

        $(function () {
            if (document.getElementById('date'))
            {
                $("#date").datepicker({
                    changeYear: true,
                    changeMonth: true,
                    dateFormat: 'yy-mm-dd',
                    minDate: PHP.MinDate,
                    maxDate: PHP.MaxDate
                });
            }
        });
    }
    document.querySelectorAll('input[data-content]').forEach((Element)=>{
        Element.addEventListener('keyup', () =>
        {
            let Return = Element.value;

            Return = ((Return.split('')).filter((X,I) =>
            {
                return Element.getAttribute('data-content').toString().includes(X.toString());
            }));

            Element.value = Return.join('');
        });
    });
});

document.addEventListener("contextmenu", function(e){
    if (!CurrentLink.includes('localhost'))
    {
        e.preventDefault();
    }
}, false);