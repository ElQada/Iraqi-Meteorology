/* ---------------------------------------------------------------------------------------------------------------------
==|- All Variables -|==>
--------------------------------------------------------------------------------------------------------------------- */

var elqada =
{
    $X:{$A:[],$O:{},$S:new Set(),$M:new Map()},$Y:{$A:[],$O:{},$S:new Set(),$M:new Map()},$Z:{$A:[],$O:{},$S:new Set(),$M:new Map()},
}
/* --------------------------=[|=>|] Filter Function [|<=|]=-------------------------- */
var Filter = function ($Value, $Length = null, $Content = null, $Include = null, $Equal = null, $IndexOf = null, $Format = null, $CallBack = null, $Edit = null, $NotContent = null, $NotInclude = null, $NotEqual = null, $NotIndexOf = null, $NotEdit = null) {
    /* -----------------------------------------------------------------------------------------------------------------
    == > || Variables
     ---------------------------------------------------------------------------------------------------------------- */
    let $Return = null, $Filter = null, $PlusLength = null;

    /* -----------------------------------------------------------------------------------------------------------------
    == > || Methods [ Property ]
     ---------------------------------------------------------------------------------------------------------------- */
    function _Length_(Length = null) {
        if (parseInt(Length) && typeof Length === 'number') {
            $Length = parseInt(Length);
        } else {
            $Length = null;
        }
        return this;
    }

    // -----------------------------------------------------------------------------------------------------------------
    function _PlusLength_(PlusLength = null) {
        if (typeof PlusLength === 'number' && parseInt(PlusLength)) {
            if ($PlusLength === null) {
                $PlusLength = 0;
            }
            $PlusLength += parseInt(PlusLength);
        } else {
            $PlusLength = null;
        }
        return this;
    }

    // -----------------------------------------------------------------------------------------------------------------
    function _Content_(Content = null, Not = false) {
        if (typeof Content === 'string' && Content.length) {
            Content = Content.toLowerCase();
            if (Not) {
                if ($NotContent === null) {
                    $NotContent = '';
                }
                $NotContent += Content;
            } else {
                if ($Content === null) {
                    $Content = '';
                }
                $Content += Content;
            }
        } else {
            if (Not) {
                $NotContent = null;
            } else {
                $Content = null;
            }
        }
        return this;
    }

    // -----------------------------------------------------------------------------------------------------------------
    function _Include_(Include = null, Not = false) {
        if (typeof Include === 'string')
        {
            Include = [Include];
        }
        if ( Include instanceof Array) {
            if (Not) {
                if ($NotInclude === null) {
                    $NotInclude = [];
                }
                $NotInclude.concat(Include);
            } else {
                if ($Include === null) {
                    $Include = [];
                }
                $Include.concat(Include);
            }
        } else {
            if (Not) {
                $NotInclude = null;
            } else {
                $Include = null;
            }
        }
        return this;
    }

    // -----------------------------------------------------------------------------------------------------------------
    function _Equal_(Equal = null, Not = false) {
        if (typeof Equal === 'string')
        {
            Equal = [Equal];
        }

        if (Equal instanceof Array) {
            if (Not) {
                if ($NotEqual === null) {
                    $NotEqual = [];
                }
                $NotEqual.concat(Equal);
            } else {
                if ($Equal === null) {
                    $Equal = [];
                }
                $Equal.concat(Equal);
            }
        } else {
            if (Not) {
                $NotEqual = null;
            } else {
                $Equal = null;
            }
        }
        return this;
    }

    // -----------------------------------------------------------------------------------------------------------------
    function _IndexOf_(IndexOf = null, Not = false) {
        if (IndexOf !== null && typeof IndexOf === 'object') {
            Object.keys(IndexOf).forEach((Key) => {
                if (Not) {
                    if ($NotIndexOf === null) {
                        $NotIndexOf = {};
                    }
                    if ($NotIndexOf.hasOwnProperty(Key)) {
                        $NotIndexOf[Key] += IndexOf[Key].toString().toLowerCase();
                    } else {
                        $NotIndexOf[Key] = IndexOf[Key].toString().toLowerCase();
                    }
                } else {
                    if ($IndexOf === null) {
                        $IndexOf = {};
                    }
                    if ($IndexOf.hasOwnProperty(Key)) {
                        $IndexOf[Key] += IndexOf[Key].toString().toLowerCase();
                    } else {
                        $IndexOf[Key] = IndexOf[Key].toString().toLowerCase();
                    }
                }
            });
        } else {
            if (Not) {
                $NotIndexOf = null;
            } else {
                $IndexOf = null;
            }
        }
        return this;
    }

    // -----------------------------------------------------------------------------------------------------------------
    function _Format_(Format = null) {
        if (typeof Format === 'string' && Format.length) {
            $Format = Format;
        } else {
            $Format = null;
        }
        return this;
    }

    // -----------------------------------------------------------------------------------------------------------------
    function _CallBack_(CallBack = null) {
        if (typeof CallBack === 'function') {
            $CallBack = CallBack;
        } else {
            $CallBack = null;
        }
        return this;
    }

    // -----------------------------------------------------------------------------------------------------------------
    function _Edit_(Edit = null, Not = false) {
        if (typeof Edit === 'function') {
            if (Not) {
                $NotEdit = Edit;
            } else {
                $Edit = Edit;
            }
        } else {
            if (Not) {
                $NotEdit = function (Char, Index, Class) {
                    return false;
                };
            } else {
                $Edit = function (Char, Index, Class) {
                    return false;
                };
            }
        }
        return this;
    }

    // -----------------------------------------------------------------------------------------------------------------
    function _Clear_(New) {
        $Return = New.toString().toLowerCase();
        $Filter = null;
        $Length = null;
        $PlusLength = null;
        $Edit = function (Char, Index, Class) {
            return false;
        };
        $NotEdit = function (Char, Index, Class) {
            return false;
        };
        $Equal = null;
        $NotEqual = null;
        $Content = null;
        $NotContent = null;
        $Include = null;
        $NotInclude = null;
        $IndexOf = null;
        $NotIndexOf = null;
        $CallBack = null;
        $Format = null;
        return this;
    }

    // -----------------------------------------------------------------------------------------------------------------
    function _Return_($Else = null) {
        $Filter = $Return.toString();
        $Return = '';

        if (typeof $PlusLength !== "number") {
            $PlusLength = 0;
        }


        if (!(($NotEqual !== null && $NotEqual.includes($Filter)) || $NotInclude !== null && $NotInclude.filter((_) => { if (_.indexOf($Filter) === 0) return 1}).length))
        {
            if ( ($Equal !== null && $Equal.includes($Filter)) || ($Include !== null && $Include.filter((Include) => {if (Include.indexOf($Filter) === 0) {return true;} }).length) )
            {
                $Return = $Filter;
            }
            else
            {
                $Return = $Filter.split('').filter((Char, Index) => {
                    if (!($NotEdit(Char, Index, _Class_()) || (typeof $NotContent === 'string' && $NotContent.includes(Char)) || ($NotIndexOf !== null && typeof $NotIndexOf === 'object' && typeof $NotIndexOf[Index + $PlusLength] !== 'undefined' && $NotIndexOf[Index + $PlusLength].includes(Char)))) {
                        if ($Edit(Char, Index, _Class_()) || (typeof $Content === 'string' && $Content.includes(Char)) || ($IndexOf !== null && typeof $IndexOf === 'object' && typeof $IndexOf[Index + $PlusLength] !== 'undefined' && $IndexOf[Index + $PlusLength].includes(Char))) {
                            return true;
                        }
                    }
                }).join('');
            }
        }

        if (typeof $CallBack === 'function') {
            $Return = $CallBack($Return, _Class_());
        }

        if ($Else !== null && ($Return === null || $Return === '')) {
            $Return = $Else;
            $Length = $Return.length;
        }

        if (typeof $Length !== 'number' && $Length < 1) {
            $Length = $Return.length;
        }

        if (typeof $PlusLength === "number") {
            $Length += $PlusLength;
        }

        if ($Return === null) {
            $Return = '';
        }

        if (typeof $Return !== 'string') {
            $Return = $Return.toString();
        }

        $Return = $Return.slice(0, $Length);

        return this;
    }

    // -----------------------------------------------------------------------------------------------------------------
    function Return($Else = null) {
        _Return_($Else);
        return $Return;
    }

    /* -----------------------------------------------------------------------------------------------------------------
    == > || Constructor
     ---------------------------------------------------------------------------------------------------------------- */
    $Return = $Value.toString().toLowerCase();

    _Length_($Length);
    _Content_($Content);
    _Content_($NotContent, true);
    _Include_($Include);
    _Include_($NotInclude, true);
    _Equal_($Equal);
    _Equal_($NotEqual, true);
    _IndexOf_($IndexOf);
    _IndexOf_($NotIndexOf, true);
    _Format_($Format);
    _CallBack_($CallBack);
    _Edit_($Edit);
    _Edit_($NotEdit, true);

    /* -----------------------------------------------------------------------------------------------------------------
    == > || Methods [ Map ]
     ---------------------------------------------------------------------------------------------------------------- */
    function _Class_() {
        return {
            /* ---------------------------------------------------------------------------------------------------------
            == > || Vars
             -------------------------------------------------------------------------------------------------------- */
            $Length: $Length,
            $Content: $Content,
            $NotContent: $NotIndexOf,
            $Include: $Include,
            $NotInclude: $NotInclude,
            $Equal: $Equal,
            $NotEqual: $NotEqual,
            $IndexOf: $IndexOf,
            $NotIndexOf: $NotIndexOf,
            $Format: $Format,
            $CallBack: $CallBack,
            $Edit: $Edit,
            $NotEdit: $NotEdit,
            $Value: $Value,
            $Return: $Return,
            $Filter: $Filter,
            $PlusLength: $PlusLength,

            /* ---------------------------------------------------------------------------------------------------------
            == > || Methods
             -------------------------------------------------------------------------------------------------------- */
            Length: _Length_,
            Content: _Content_,
            Include: _Include_,
            Equal: _Equal_,
            IndexOf: _IndexOf_,
            Format: _Format_,
            CallBack: _CallBack_,
            Edit: _Edit_,
            PlusLength: _PlusLength_,
            Return: Return, /* ---------------------------------------------------------------------------------------------------------
                == > || Additional [ Clear - Return - ReCall - PlusVars ]
                 -------------------------------------------------------------------------------------------------------- */
            _Clear_: _Clear_,
            _Filter_: Filter,
            _Return_: _Return_
        }

    }

    /* -----------------------------------------------------------------------------------------------------------------
    == > || Return [ Class ]
     ---------------------------------------------------------------------------------------------------------------- */
    return _Class_();
};

var $Save = {}, $Next = 222, $Vars = {}, $TimeOut = {}, CurrentDate = new Date(), MinTTT = 0,  Message = [], Search = {};

/* ---------------------------------------------------------------------------------------------------------------------
==|- All Methods -|==>
--------------------------------------------------------------------------------------------------------------------- */

function VarID(ID)
{
    return GetElementValue(ID, (Value) => {
        if (isNaN(parseFloat(Value))) return Value; else return parseFloat(Value);
    });
}

function OnlyContent(ID, Content = "-.+0123456789xX/\\")
{
    let Element = document.getElementById(ID);
    if (Element) {
        Element.addEventListener('keyup', () => {
            Element.value = ((Element.value.split('')).filter((X) => { return Content.includes(X.toString()); })).join('');
            setTimeout(() => {
                Element.value = ((Element.value.split('')).filter((X) => { return Content.includes(X.toString()); })).join('');
            }, 321);
        });
    }
}


function NextFocus(Current, Next, Delay = null)
{
    if ($(Current).val().length === parseInt($(Current).attr("maxlength")) || Current.value === 'trace') {
        Focus(Next, Delay);
    }
}

function Request(URL, Success, Error = (Error) => { console.warn(Error); }, Data = {})
{
    if (typeof URL === 'string' && typeof Success === 'function' && typeof Error === 'function' && typeof Data === 'object')
    {
        $.ajax({
            url: URL, type: 'POST', data: Data, success: (Response) => {
                if (typeof Response !== 'object') {
                    try {
                        Response = JSON.parse(Response);
                    } catch (Error) {
                        console.warn(Error);
                    }
                }
                Success(Response);
            }, error: Error
        });
    }
}

function TestFormatInput3($Value, $Length = 3)
{
    return Filter($Value, $Length, '0123456789').Edit((Char, Index, Class) => {
        if (!Index && "+-".includes(Char) || Index === Class.$Filter.indexOf('.') && Char === '.') {
            Class.PlusLength(1);
            return true;
        }
    }).CallBack((Value, Class) => {
        let Return = Value, Update = '';

        if (Return) {
            Update = Return.toString().replaceAll('+', '').replaceAll('-', '').replaceAll('.', '');

            let Count = Update.length;

            if (Count === 1) {
                Update = '0' + Update + '.0'
            } else if (Count === 2) {
                Update = '0' + Update.charAt(0) + '.' + Update.charAt(1);
            } else if (Count === 3) {
                Update = Update.substr(0, 2) + '.' + Update.charAt(2);
            } else if (Count > 3) {
                if (Update.charAt(0) === '0') {
                    Update = Update.slice(1);
                }
                Update = Update.substr(0, 2) + '.' + Update.charAt(2);
            }

            if (Return.charAt(0) === '-' || Return.charAt(0) === '+') {
                Update = Return.charAt(0) + Update;
            }

            return Update.toString().replaceAll('++', '+').replaceAll('--', '-').replaceAll('..', '.');
        }
        return Return.toString().replaceAll('++', '+').replaceAll('--', '-').replaceAll('..', '.');
    });
}

function FormatInput($ID, $Value, $Length = 4, $EndCallBack = null, $Point = 1, $Content = "0123456789", $Include = [])
{
    return Filter($Value, $Length, $Content,$Include).Edit((Char, Index, Class) => {
        if (!Index && "+-".includes(Char) || $Point && (Index === Class.$Filter.indexOf('.') && Char === '.') ) {
            Class.PlusLength(1);
            return true;
        }
    }).CallBack((Value, Class) => {
        let Return = Value, Update = '';

        if (Return) {
            Update = Return.toString();
            Update = parseInt(Update.replaceAll('+', '').replaceAll('-', '').replaceAll('.', '')).toString();

            if (Update === 'NaN') {
                Update = '';
            }

            let Count = Update.length;

            if (Count&&$Point) {
                if (Count < $Point)
                {
                    Update = Array(($Length - $Point)).fill(0).join('') + '.' + Array($Point-Count).fill(0).join('') + Update;
                }
                else if (Count === $Point)
                {
                    Update = Array(($Length - $Point)).fill(0).join('') + '.' + Update;
                }
                else if (Count > $Point && Count <= $Length)
                {
                    Update = Array(($Length - Count)).fill(0).join('') + Update.substring(0,(Count-$Point)) + '.' + Update.substring(Count-$Point);
                }
                else
                {
                    Update = Return.toString().substring(0,$Length+1);
                }
            }
            else
            {
                Update = Return.toString().substring(0,$Length+1);
            }

            if (Return.charAt(0) === '-' || Return.charAt(0) === '+') {
                Update = Return.charAt(0) + Update;
            }

            Update = Update.toString().replaceAll('++', '+').replaceAll('--', '-').replaceAll('..', '.');
        } else {
            Update = Return.toString().replaceAll('++', '+').replaceAll('--', '-').replaceAll('..', '.');
        }

        if (typeof $EndCallBack === 'function') {
            if ($ID) {
                if ($TimeOut.hasOwnProperty($ID)) {
                    clearTimeout($TimeOut[$ID]);
                }
                $TimeOut[$ID] = setTimeout($EndCallBack, ($Next * 2));
            }
        }
        // Plus +1 for ( . )
        if ($Point)
        {
            Class.PlusLength(1);
        }
        return Update;
    });
}

function SetElementValue(ID, Value = "", SetReadOnly = null)
{
    if (typeof ID == "object") {
        ID.forEach((Item, Key) => {
            if (Value && typeof Value === 'object' && typeof Value[Key] !== 'undefined') {
                SetElementValue(Item, Value[Key], SetReadOnly);
            } else {
                SetElementValue(Item, Value, SetReadOnly);
            }
        })
    } else if (typeof ID == 'string' || typeof ID == 'number') {
        let Element = document.getElementById(ID);
        $Vars.Element = Element;
        if (Element) {
            if (Value === null)
            {
                Value = "";
            }
            if (['div'].includes(Element.tagName.toLowerCase()))
            {
                Element.innerHTML = Value.toString();
            }
            else if (['select'].includes(Element.tagName.toLowerCase()))
            {
                for (let $K=0; $K<Element.options.length; $K++)
                {
                    Element.options.item($K).selected = (Element.options.item($K).value === Value.toString());
                }
            }
            else
            {
                Element.value = Value.toString().toUpperCase();
            }
            if (Value === "") {
                Element.style.backgroundColor = "#fff";
            }
            if (SetReadOnly !== null) {
                ReadOnly(ID, SetReadOnly);
            }
            return true;
        }
    } else {
        return false;
    }
}

function GetElementValue(ID, CallBack = null)
{
    if (typeof ID == 'string' || typeof ID == 'number') {
        let Element = document.getElementById(ID);
        if (Element) {
            if (typeof CallBack === 'function') {
                return CallBack(Element.value);
            }
            return Element.value;
        }
    }
    return '';
}


function ElementAttribute(ID, Value = null, Attribute = '')
{
    if (typeof ID == "object") {
        ID.forEach((Item, Key) => {
            if (Value && typeof Value === 'object' && Value.length && typeof Value[Key] !== 'undefined') {
                ElementAttribute(Item, Value[Key], Attribute);
            } else {
                ElementAttribute(Item, Value, Attribute);
            }
        })
    } else if (typeof ID == 'string' || typeof ID == 'number') {
        let Element = document.getElementById(ID);
        if (Element) {
            if (Value !== null) {
                if (['readOnly', 'disabled'].includes(Attribute) && Value === false) {
                    Element.removeAttribute(Attribute);
                } else {
                    Element.setAttribute(Attribute, Value);
                }
                return true;
            } else {
                if (Element.hasAttribute(Attribute)) {
                    return Element.getAttribute(Attribute);
                } else if (Element.hasOwnProperty(Attribute)) {
                    return Element[Attribute];
                } else {
                    return null;
                }
            }
        }
    } else {
        return false;
    }
}

function Disabled(ID, Value = null)
{
    return ElementAttribute(ID, Value, 'disabled');
}

function ReadOnly(ID, Value = null)
{
    return ElementAttribute(ID, Value, 'readOnly');
}

function Focus(ID, Delay = null)
{
    var Del = Delay ? Delay : $Next;
    setTimeout(() => {
        $('#' + ID).focus();
    }, (Del));
}

function ReloadFromPath()
{
    setTimeout(()=>
    {
      if (Search.hasOwnProperty('Action')&&Search.Action === 'EditOpen'){
          if (Search.hasOwnProperty('Date')&&GetElementValue('date')!==Search.Date)
          {
              SetElementValue('date',Search.Date);
              setTimeout(()=>{
                  STtName('Else');
              },100);
          }
          if (Search.hasOwnProperty('Time')&&GetElementValue('time')!==Search.Time)
          {
              SetElementValue('time',Search.Time);
              setTimeout(()=>{
                  timech(PHP.CurrentFile);
              },150);
          }
      }
    },100);
}

function STtName(File = 'Else')
{
   if (File)
   {
       let
           Station = VarID('Station'),
           Date = GetElementValue('date');

       Request(`Request/getst.php?Station=${Station}&Date=${Date}&File=${File}`, (Response) => {
           if (Response) {
               SetElementValue(["StationCode", "Longitude", 'ElevationM'], [Response['StationCode'], Response['Longitude'], Response['ElevationM']]);
               SetElementValue(["stc", "stn", "Latitude", "$lat", "lon", 'hi'], [Response['StationCode'], Response['StationName'], Response['Latitude'], Response['Latitude'], Response['Longitude'], Response['ElevationM']]);
           }
           if (['daily-monitoring','courier','synop'].includes(File))
           {
               if (GetElementValue('Station'))
               {
                   location.href = Search.Path+'?File='+File+'&Station='+GetElementValue('Station');
               }
               else
               {
                   location.href = Search.Path+'?File='+File;
               }
           }
           else
           {
               if (File === 'Else' && Search.hasOwnProperty('File'))
               {
                   File = Search.File;
                   if (Search.hasOwnProperty('Station'))
                   {
                       Station = Search.Station;
                       SetElementValue('Station',Search.Station);
                   }
                   if (Search.hasOwnProperty('Date'))
                   {
                       Date = Search.Date;
                       SetElementValue('date',Search.Date);
                   }
               }
               Request(`Request/getst.php?Station=${Station}&Date=${Date}&File=${File}`, (Response) => {
                   if (Response) {
                       SetElementValue(["StationCode", "Longitude", 'ElevationM'], [Response['StationCode'], Response['Longitude'], Response['ElevationM']]);
                       SetElementValue(["stc", "stn", "Latitude", "$lat", "lon", 'hi'], [Response['StationCode'], Response['StationName'], Response['Latitude'], Response['Latitude'], Response['Longitude'], Response['ElevationM']]);
                   }
               });
           }
       });
       Focus('time');
   }
}

function Monitors()
{
    Request("Request/Monitors.php?Monitor=" + GetElementValue('Monitor'), (Response) => { });
}

function InputFormating(ID,$Length,$Point,$Min=null,$Max= null,$MinLength = null, $MaxLength = null,$Message= null,CallBack = null,Error = false, $Content = "0123456789", $Include = [])
{
    let Element = document.getElementById(ID);
    let $CallBack = ()=>
    {
        let $Error = !InputCorrect(ID,$Message,$Min,$Max,$MinLength,$MaxLength,Error);
        if ($Error)
        {
            SetElementValue(ID);
        }
        if(typeof CallBack === 'function')
        {
            CallBack(ID,$Error,$Message);
        }
    }

    if (Element)
    {
        if ($MinLength === null)
        {
            if ($Point)
            {
                $MinLength = $Length+2;
            }
            else
            {
                $MinLength = $Length+1;
            }
        }

        if ($MaxLength === null)
        {
            if ($Point)
            {
                $MaxLength = $Length+3;
            }
            else
            {
                $MaxLength = $Length+2;
            }
        }
        Element.setAttribute('minlength',$MinLength);
        Element.setAttribute('maxlength',$MaxLength);

        if ($Min !== null)
        {
            Element.setAttribute('min',$Min);
        }

        if ($Max !== null)
        {
            Element.setAttribute('max',$Max);
        }

        Element.addEventListener('blur',()=>
        {
            Element.placeholder = Element.getAttribute('data-placeholder')??' ';
            InputCorrect(ID,$Message,$Min,$Max,$MinLength,$MaxLength,Error);
        });

        Element.addEventListener('keyup',()=>
        {
            Element.value = FormatInput(ID,Element.value,$Length,$CallBack,$Point,$Content,$Include).Return();
        });
    }
}

function InputCorrect($ID,$Message = null,$Min = null,$Max = null,$MinLength = null,$MaxLength = null, Error = false)
{
    let Element = document.getElementById($ID);
    if (Element)
    {
        let Value = Element.value;
        if (typeof Error === "function")
        {
            Error = Error($ID,Value,$Message);
        }
        if ($Min === null && Element.hasAttribute('min'))
        {
            $Min = parseFloat(Element.getAttribute('min'));
        }

        if (!Error && $Min !== null && parseFloat(Value) < $Min)
        {
            Error = true;
        }

        if ($Max === null && Element.hasAttribute('max'))
        {
            $Max = parseFloat(Element.getAttribute('max'));
        }
        if (!Error && $Max !== null && parseFloat(Value) > $Max)
        {
            Error = true;
        }

        if ($MinLength === null && Element.hasAttribute('minlength'))
        {
            $MinLength = parseInt(Element.getAttribute('minlength'));
        }

        if (!Error && $MinLength !== null && Value.toString().length < ($MinLength-1))
        {
            Error = true;
        }

        if ($MaxLength === null && Element.hasAttribute('maxlength'))
        {
            $MaxLength = parseInt(Element.getAttribute('maxlength'));
        }

        if ($MaxLength)
        {
            if (Value.toString().startsWith('-') || Value.toString().startsWith('+'))
            {
                $MaxLength--;
            }
            else
            {
                $MaxLength -= 2;
            }
        }

        if (!Error && $MaxLength && Value.toString().length > $MaxLength)
        {
            Error = true;
        }

        return Validation(Error,$ID,$Message);
    }
}

function Validation(Error,Action,Message)
{
    let Element = null;

    if (typeof Action === 'string')
    {
        Element = document.getElementById(Action);
        Element.addEventListener('focus',()=>
        {
            Element.setAttribute('data-placeholder',Element.getAttribute('placeholder')??' ');
            Element.placeholder = '';
        });

        Element.addEventListener('blur',()=>
        {
            Element.placeholder = Element.getAttribute('data-placeholder')??' ';
        });
    }

    if (Error)
    {
        if (Message)
        {
            MessageSwal(Message,'error','خــطــأ فــى الـبـيـانــات');
        }
        if (typeof Action === 'function')
        {
            Action();
        }
        else if (Element&&Element.value.toString().length)
        {
            Element.value = '';
            Element.style.backgroundColor = "#f19292";
            Element.placeholder = 'Error';
            if (typeof Action === 'string')
            {
                Focus(Action,400);
            }
        }

        return false;
    }
    else
    {
        if (Element&&Element.value.toString().length)
        {
            Element.style.backgroundColor = "#cccccc";
            Element.placeholder = '';
            if (typeof Action === 'string')
            {
                FNext(Action);
            }
            return true;
        }
    }
}
function FNext(ID, Delay = null)
{
    let Inputs = Array.from(document.querySelectorAll("input:not([readonly])"));

    ['e', 'sss', 'half'].forEach(($ID) => {
        let Index = Inputs.findIndex(Input => Input.id === $ID);
        if (Index >= 0) Inputs.splice(Index, 1);
    });

    let Index_Next_Input = Inputs.findIndex(x => x.id === ID) + 1;

    setTimeout(() => {
        if (!['button', 'rest', 'submit'].includes(Inputs[Index_Next_Input].type)) {
            if(Inputs[Index_Next_Input].value.toString().replaceAll(' ','').length<1)
            {
                Inputs[Index_Next_Input].focus();
            }
        }
    }, (Delay ? Delay : $Next));
}

function FocusNext(Selector, Length, Next)
{
    if ($(Selector).val().length === Length) {
        Focus(Next);
    }
}

function GetStationName(Code)
{
    Request('Request/GetStationName.php?Code='+Code,(Response)=>{
        if(Response&&Response.hasOwnProperty('Station'))
        {
            SetElementValue('username',Response['Name']);
            SetElementValue('Station',Response['Station'])
        }
    });
}

function CopyText(Text)
{
    navigator.clipboard.writeText(Text).then(r =>
    {
        MessageSwal('تم النسخ بنجاح');
    } );
}

function SendEmail($Subject,$Body)
{
    fetch('https://api.brevo.com/v3/smtp/email', {
        method: 'POST',
        headers: {
            'accept': 'application/json',
            'api-key': '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',
            'content-type': 'application/json'
        },
        body: JSON.stringify({
            'sender': {
                'name': 'ElQada',
                'email': 'makexapps@gmail.com'
            },
            'to': [
                {
                    'email': 'orbi@ftp13.irimo.ir',
                    'name': 'orbi'
                }
            ],
            'subject': $Subject,
            'htmlContent': $Body
        })
    }).then(function (message) {
        MessageSwal("Mail has been sent successfully");
    });
    if (0)
    {
        X = {
            Host: "smtp.gmail.com",
            // To: 'orbi@ftp13.irimo.ir',
            //To: 'makeXapps@gmail.com',
            To: 'samershuaa54@gmail.com',
            From: "samershuaa54@gmail.com",
            Subject: $Subject,
            Body: $Body
        }
    }
}

function SentEmailLink(Email,Subject,Body)
{
    SendEmail(Subject,Body);
    //CopyText(GetElementValue('synop'));
    //open(decodeURIComponent(`mailto:${Email}?subject=${Subject}&body=${Body}`));
}

function MessageSwal($Text,$Icon = 'success',$Title = null,$Button = null)
{
    swal({ title: $Title, text: $Text, icon: $Icon, button: $Button });
}

function Download(FileName, Data, MimeType = 'text/plain')
{
    let link = document.createElement('a');
    link.setAttribute('download', FileName);
    link.setAttribute('href', 'data:' + MimeType + ';charset=utf-8,' + encodeURIComponent(Data));
    link.click();
}

function InputsValue()
{
    let Inputs = Array.from(document.querySelectorAll("input, select"));
    let Data = {};
    Inputs.forEach((Element) => {
        if (Element.hasAttribute('id'))
        {
            Data[Element.id] = GetElementValue(Element.id);
        }
        else if (Element.hasAttribute('name'))
        {
            Data[Element.name] = Element.value;
        }
    });
    return Data;
}

function confirmDelete(event, Message, Body = [])
{
    event.preventDefault();
    swal({
        title: Message,
        text : (Body.map((Value)=>{ return Value+"\n"; })).join(' '),
        icon: 'warning',
        buttons: true,
    }).then((result) => {
        if (result) {
            document.getElementById('btnValue').name = event.target.name;
            event.target.closest('form').submit();
        }
    });
}

function doubleConfirmDelete(event, Message,Body = [])
{
    event.preventDefault();
    swal({
        title: Message,
        text : (Body.map((Value)=>{ return Value+"\n"; })).join(' '),
        icon: 'warning',
        buttons: true,
    }).then((result) =>
    {
        if (result)
        {
            swal({
                title: Message,
                text : (Body.map((Value)=>{ return Value+"\n"; })).join(' '),
                icon: 'warning',
                buttons: true,
            }).then((res) =>
            {
                if (res)
                {
                    document.getElementById('btnValue').name = event.target.name;
                    event.target.closest('form').submit();
                }
            });
        }
    });
}
function CurrentDay(Submit = null)
{
    SetElementValue('_date_',PHP.MaxDate);
    SetElementValue('date',PHP.MaxDate);
    if (Submit != null)
    {
        document.getElementById(Submit).click();
    }
}
function CurrentRange(Submit = null)
{
    SetElementValue('_date_',PHP.MaxDate);
    SetElementValue('date',PHP.MinDate);
    if (Submit != null)
    {
        document.getElementById(Submit).click();
    }
}
function CurrentMonth(Submit = null)
{
    SetElementValue('_date_',PHP.MaxDate);
    SetElementValue('date',(PHP.MaxDate.slice(0,-2)+'01'));
    if (Submit != null)
    {
        document.getElementById(Submit).click();
    }
}
/* ---------------------------------------------------------------------------------------------------------------------
==|- Print and matchMedia -|==>
--------------------------------------------------------------------------------------------------------------------- */
if (typeof CurrentLink !== 'undefined' && !CurrentLink.includes('localhost'))
{
    if ('matchMedia' in window)
    {
        window.matchMedia('print').addListener(function(media) {
            if (media.matches) {
                beforePrint();
            } else {
                $(document).one('mouseover', afterPrint);
            }
        });
    }
    else
    {
        $(window).on('beforeprint', beforePrint);
        $(window).on('afterprint', afterPrint);
    }

    function beforePrint()
    {
        $("body").hide();
    }

    function afterPrint()
    {
        $("body").show();
    }

    $(document).on('keydown', function(e)
    {
        if((e.ctrlKey || e.metaKey) && (e.key == "p" || e.charCode == 16 || e.charCode == 112 || e.keyCode == 80) ){
            e.cancelBubble = true;
            e.preventDefault();
            e.stopImmediatePropagation();
        }
    });
}

function GetCurrentOption(Element)
{
    if (Element.selectedOptions.length)
    {
        let CurrentOptions = Element.selectedOptions.item(0);
        SetDateTime(CurrentOptions.getAttribute('data-day'),CurrentOptions.value);
    }
}

function WriteTrace (event, id)
{
    if (['z','Z','F2'].includes(event.key) || ['KeyZ','F2'].includes(event.code))
    {
        document.getElementById(id).value = "trace";
        FNext(id);
        return true;
    }
    return false;
}

function EnterLogin (event, Form,Submit = false)
{
    //console.info([event,Form,event.key,event.code])
/*    if (['z','Z','F2'].includes(event.key) || ['KeyZ','F2'].includes(event.code))
    {
        return true;
    }*/
    if (Submit)
    {
        //Form.submit();
    }
}
function SetDateTime($Date,$Time,$Delay=123)
{
    SetElementValue('date', $Date);
    if (PHP.CurrentFile === 'daily-monitoring' || PHP.CurrentFile === 'show-daily') {

        STtName(PHP.CurrentFile);
    }
    setTimeout(()=>
    {
        SetElementValue('time',$Time);
        setTimeout(()=>{
            timech(PHP.CurrentFile);
        },$Delay);
    },$Delay);
}

function ActionType($Select)
{

    if ($Select !== '*')
    {
        $("tbody tr").css("display", "none");
        $("tbody tr").filter("."+$Select).css("display", "table-row");
    }
    else
    {
        $("tbody tr").css("display", "table-row");
    }
}

function ActionTypeDataTable($Select)
{

    if ($Select !== '*')
    {

    }
    else
    {

    }
}

window.addEventListener('DOMContentLoaded',()=>
{
    Search.Path = window.location.origin+window.location.pathname;
    Search.File = PHP.CurrentFile;
    if (window.location.search.length>1)
    {
        decodeURI(window.location.search.substring(1)).split('&').forEach(($Item)=>{
           if ($Item.length)
           {
               let Item = $Item.split('=');
               if (Item.length === 2)
               {
                   Search[Item[0]] = Item[1];
               }
           }
        });
    }

    setTimeout(()=>{
        if (Search.hasOwnProperty('Type'))
        {
            SetElementValue('Type',Search.Type);
            ActionType(Search.Type);
        }
        },125);
});


function DateFromTo(StartDate,EndDate) {
    let Dates = [],$StartDate = new Date(StartDate);
    while ($StartDate < new Date(EndDate))
    {
        Dates.push($StartDate.toISOString().slice(0,10));
        $StartDate.setDate($StartDate.getDate() + 1);
    }
    return Dates;
}


function StringIsArabic(Text)
{
   return (new RegExp(/[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF]/).test(Text));
}