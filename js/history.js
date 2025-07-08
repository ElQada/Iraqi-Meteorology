function timech(File)
{

}

var
    $Keys =
        {
            daily: "الرصد اليومي",
            courier: "الرصد الساعي",
            //synop : "Synop",
            //test_clouds: "أطلس الغيوم",
            //test_weather : "الظواهر الجوية",
            accounts : "إدارة الـمـوظـفـيـن",
            stations : "إدارة الـمـحـطـات",
            accounts_ : "الحضور والإنصراف",

        },
    $Type =
        {
            UPDATE : 'تعديل',
            DELETE : 'حذف',
            INSERT : 'أضافة',
            LOGIN : "تـسـجـيـل دخــول" ,
            //ERROR : "خـطـأ مـا !!",
            ABSENT : "تــسـجـيـل غـــيــاب",
            LOGOUT: "تـسـجـيـل خـــروج"
        };

if ($DataTable)
{
    //  - "الرصد اليومي""الرصد الساعي""Synop""أطلس الغيوم""الظواهر الجوية"
    // Type != 'INSERT' AND Keys NOT IN ('synop','test_clouds','test_weather')
    $DataTable.forEach((Row)=>{
        let Value = '';
        Row['Keys'] = $Keys[Row['Keys']];

        if (Row['Value'])
        {
            let Values = {Data:""};
            try {
                Values = JSON.parse(Row['Value']);
            }
            catch (e) {
                Values = {Message:Row['Value']};
            }


            if (['LOGOUT','LOGIN'].includes(Row['Type']))
            {
                Row['Keys'] = $Keys.accounts_;
            }

            Object.keys(Values).forEach((Key)=>{
                if (!['id','ID','Station','Image','Account','name','NameOrCode','per','user','code','File','Info','Message','create_at','update_at'].includes(Key)&&Values[Key]&&Values[Key].toString().length)
                {
                    Value += ' '+Key+' : '+Values[Key]+' <br> ';
                }
                else
                {
                    if (Key === 'name')
                    {
                        Row['Name'] = Values[Key];
                    }
                    else if (['Image','Info','Message','NameOrCode'].includes(Key))
                    {
                        Value += "<div>"+Values[Key]+"</div>";
                    }
                    else if (Key === 'File')
                    {
                        Value += "<object data='"+Values[Key]+"'></object>";
                    }
                }
            });
        }
        Row['Value'] = Value;
        Row['Type'] = $Type[Row['Type']];

        let User = Row['User'];
        Row['User'] = '';

        if ($GetCurrentAccount.hasOwnProperty(User))
        {
            if ($GetCurrentAccount[User].endsWith('@ admin'))
            {
                Row['Station'] = "مدير عام";
            }
            else if ($GetCurrentAccount[User].endsWith('@ Forecasting'))
            {
                Row['Station'] = "Forecasting";
            }
            else if ($GetCurrentAccount[User].endsWith('@ Awos'))
            {
                Row['Station'] = "Awos";
            }
            else if ($CurrentStation.hasOwnProperty(Row['Station']))
            {
                Row['Station'] = $CurrentStation[Row['Station']]['StationName']+' @ '+$CurrentStation[Row['Station']]['StationCode'];
            }
            else
            {
                Row['Station'] = " المحطة غير موجودة او مفعلة حاليا ";
            }
            Row['User'] = $GetCurrentAccount[User].replaceAll(' @ user',' @  مـوظـف ').replaceAll(' @ manager',' @  مـديـر ');
        }
        else
        {
            if ($CurrentStation.hasOwnProperty(Row['Station']))
            {
                Row['Station'] = $CurrentStation[Row['Station']]['StationName']+' @ '+$CurrentStation[Row['Station']]['StationCode'];
            }
            else
            {
                Row['Station'] = " المحطة غير موجودة او مفعلة حاليا ";
            }

            if ($CurrentStation.hasOwnProperty(User)&&Row['User'] === '')
            {
                Row['User'] = $CurrentStation[User]['StationName'];

            }
            else
            {
                Row['User'] = 'زائـــر';
            }
        }

        Row['User'] = Row['User'].replaceAll('@',' <br> ');
        Row['Created_At'] = Row['Created_At'].replaceAll(' ',' <br> ');
    });

    let Keys = ['Type','Keys','Station','User','Created_At','Value'];
    if (!['admin','manager'].includes(PHP.Sesstion.Role))
    {
        Keys = ['Type','Keys','Created_At','Value'];
    }
    ElqadaDataTable.$Page.Order = [0,'DESC'];
    ElqadaDataTable.ID('DataTable').Name('تقرير الرصد اليومي').Element('Data-Table').Length({"200":200,"400":400}).Rename({
        'Type':'الأجراء','Keys':'القسم','Station':'المحطة','User':'بيانات الموظف','Created_At':'تاريخ الأجراء','Value':'البيانات'
    }).KeyValue(true).Data($DataTable).Keys(Keys);

    ElqadaDataTable.Set(['Select', 'Reselect', 'Excel', 'PDF', 'Pint']);
    // ElqadaDataTable.Set([]);
}

window.addEventListener('DOMContentLoaded',()=>{
    if (PHP.Request.hasOwnProperty('RefreshData'))
    {
        let KeyOptions = ['<option value="" selected >الـكـل</option>'];
        Object.values($Keys).forEach((Key)=>{
            KeyOptions.push(`<option value="${Key}">${Key}</option>`);
        });
        document.getElementById('Keys').innerHTML = KeyOptions.join("\n");

        let TypeOptions = ['<option value="" selected >الـكـل</option>'];
        Object.values($Type).forEach((Type)=>{
            TypeOptions.push(`<option value="${Type}">${Type}</option>`);
        });
        document.getElementById('Type').innerHTML = TypeOptions.join("\n");

        let UsersOptions = ['<option value="" selected >الـكـل</option>'];
        Object.values($Users).forEach((User)=>{
            UsersOptions.push(`<option value="${User['code']}">${User['user']} @ ${$CurrentStation[User['Station']]['StationCode']}</option>`);
        });
        document.getElementById('Users').innerHTML = UsersOptions.join("\n");
    }

    if (PHP.Request.hasOwnProperty('SelectStation'))
    {
        let Search = 'SelectStation='+PHP.Request.SelectStation;
        SetElementValue('Station',PHP.Request.SelectStation);
        timech('reports');
        STtName('reports');
        setTimeout(()=>{ window.location.href = window.location.href.replace('&'+Search,'').replace(Search,''); },123);
    }

    setTimeout(()=>{
        setTimeout(()=>{
            if (PHP.Request.hasOwnProperty('SelectType'))
            {
                SetElementValue('Type',PHP.Request.SelectType);
                ElqadaDataTable.$Tables[ElqadaDataTable.$ID].Search(0,PHP.Request.SelectType);
            }

            if (PHP.Request.hasOwnProperty('SelectKey'))
            {
                SetElementValue('Keys',PHP.Request.SelectKey);
                ElqadaDataTable.$Tables[ElqadaDataTable.$ID].Search(1,PHP.Request.SelectKey);
            }

            if (PHP.Request.hasOwnProperty('StationCode'))
            {
                ElqadaDataTable.$Tables[ElqadaDataTable.$ID].Search(2,PHP.Request.StationCode);
            }

            if (PHP.Request.hasOwnProperty('UserCode'))
            {
                ElqadaDataTable.$Tables[ElqadaDataTable.$ID].Search(3,PHP.Request.UserCode);
            }
        },210);
    },210);
});
